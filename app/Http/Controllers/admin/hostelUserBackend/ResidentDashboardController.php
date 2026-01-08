<?php

namespace App\Http\Controllers\admin\hostelUserBackend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hostel;

class ResidentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $resident = $user->resident->load([
            'bed.room.floor.block.hostel',
            'bedTransfers.fromBed.room.floor.block.hostel',
            'bedTransfers.toBed.room.floor.block.hostel',
            'rentPayments'
        ]);

        // Calculate statistics
        $hostelsLived = $this->getHostelsLived($resident);
        $totalPayments = $resident->rentPayments->count();
        $totalBedTransfers = $resident->bedTransfers->count();

        return view('admin.hostelUserBackend.dashboard', compact('resident', 'hostelsLived', 'totalPayments', 'totalBedTransfers'));
    }

    public function hostels()
    {
        $user = Auth::user();
        $resident = $user->resident->load([
            'bed.room.floor.block.hostel',
            'bedTransfers.fromBed.room.floor.block.hostel',
            'bedTransfers.toBed.room.floor.block.hostel'
        ]);

        // Get all unique hostels the resident has lived in
        $hostels = $this->getHostelsList($resident);

        return view('admin.hostelUserBackend.hostels.index', compact('resident', 'hostels'));
    }

    public function hostelDetail($hostelId)
    {
        $user = Auth::user();
        $resident = $user->resident->load([
            'bed.room.floor.block.hostel',
            'bedTransfers.fromBed.room.floor.block.hostel',
            'bedTransfers.toBed.room.floor.block.hostel',
            'rentPayments.bill'
        ]);

        $hostel = Hostel::findOrFail($hostelId);

        // Cast hostelId to integer for comparison
        $targetHostelId = (int) $hostelId;

        // Get all bed transfers first
        $allTransfers = $resident->bedTransfers;

        // Get bed transfers that happened WITHIN this specific hostel (internal transfers only)
        // Both fromBed and toBed must belong to the same hostel
        $hostelBedTransfers = collect();

        foreach ($allTransfers as $transfer) {
            $fromBedHostelId = null;
            $toBedHostelId = null;

            // Get hostel ID of the from_bed
            if ($transfer->fromBed && $transfer->fromBed->room && $transfer->fromBed->room->floor && $transfer->fromBed->room->floor->block) {
                $fromBedHostelId = (int) $transfer->fromBed->room->floor->block->hostel_id;
            }

            // Get hostel ID of the to_bed
            if ($transfer->toBed && $transfer->toBed->room && $transfer->toBed->room->floor && $transfer->toBed->room->floor->block) {
                $toBedHostelId = (int) $transfer->toBed->room->floor->block->hostel_id;
            }

            // Debug log
            \Log::info("Transfer #{$transfer->id}: from={$fromBedHostelId}, to={$toBedHostelId}, target={$targetHostelId}, match=" . ($fromBedHostelId === $targetHostelId && $toBedHostelId === $targetHostelId ? 'YES' : 'NO'));

            // Only include transfers where BOTH beds are in the SAME hostel (internal transfers)
            if ($fromBedHostelId === $targetHostelId && $toBedHostelId === $targetHostelId) {
                $hostelBedTransfers->push($transfer);
            }
        }

        // Get payments related to this hostel by determining which hostel the resident was in at the time of payment
        $hostelPayments = $resident->rentPayments->filter(function ($payment) use ($hostelId, $resident) {
            if (!$payment->bill || !$payment->payment_date) {
                return false;
            }

            $paymentDate = \Carbon\Carbon::parse($payment->payment_date);

            // Find which bed/hostel the resident was in at the time of payment
            // Check if there was a bed transfer that happened after this payment
            $transferAfterPayment = $resident->bedTransfers
                ->where('transfer_date', '>', $paymentDate)
                ->sortBy('transfer_date')
                ->first();

            if ($transferAfterPayment) {
                // Resident was in the "from_bed" at the time of payment
                $bedAtPaymentTime = $transferAfterPayment->fromBed;
            } else {
                // No transfer after payment, so resident is in current bed or last transferred bed
                $lastTransfer = $resident->bedTransfers->sortByDesc('transfer_date')->first();
                $bedAtPaymentTime = $lastTransfer ? $lastTransfer->toBed : $resident->bed;
            }

            // Check if the bed at payment time belonged to this hostel
            if ($bedAtPaymentTime && $bedAtPaymentTime->room && $bedAtPaymentTime->room->floor && $bedAtPaymentTime->room->floor->block) {
                return $bedAtPaymentTime->room->floor->block->hostel_id == $hostelId;
            }

            return false;
        });

        // Get current or last bed info for this hostel
        $currentBed = null;
        if ($resident->bed && $resident->bed->room->floor->block->hostel_id == $hostelId) {
            $currentBed = $resident->bed;
        } else {
            // Find last bed in this hostel from transfers
            $lastTransfer = $resident->bedTransfers
                ->where('toBed.room.floor.block.hostel_id', $hostelId)
                ->sortByDesc('created_at')
                ->first();
            if ($lastTransfer) {
                $currentBed = $lastTransfer->toBed;
            }
        }

        return view('admin.hostelUserBackend.hostels.show', compact('resident', 'hostel', 'hostelBedTransfers', 'hostelPayments', 'currentBed'));
    }

    public function profile()
    {
        $user = Auth::user();
        $resident = $user->resident->load([
            'bed.room.floor.block.hostel',
            'occupancy'
        ]);

        return view('admin.hostelUserBackend.profile', compact('resident'));
    }

    /**
     * Get count of unique hostels the resident has lived in
     */
    private function getHostelsLived($resident)
    {
        $hostelIds = collect();

        // Add current hostel
        if ($resident->bed && $resident->bed->room->floor->block->hostel) {
            $hostelIds->push($resident->bed->room->floor->block->hostel_id);
        }

        // Add hostels from bed transfers
        foreach ($resident->bedTransfers as $transfer) {
            if ($transfer->fromBed && $transfer->fromBed->room->floor->block->hostel) {
                $hostelIds->push($transfer->fromBed->room->floor->block->hostel_id);
            }
            if ($transfer->toBed && $transfer->toBed->room->floor->block->hostel) {
                $hostelIds->push($transfer->toBed->room->floor->block->hostel_id);
            }
        }

        return $hostelIds->unique()->count();
    }

    /**
     * Get list of all hostels with details
     */
    private function getHostelsList($resident)
    {
        $hostelsData = collect();

        // Add current hostel
        if ($resident->bed && $resident->bed->room->floor->block->hostel) {
            $hostel = $resident->bed->room->floor->block->hostel;
            $hostelsData->push([
                'id' => $hostel->id,
                'name' => $hostel->name,
                'logo' => $hostel->logo,
                'block' => $resident->bed->room->floor->block->name . ' Block ' . $resident->bed->room->floor->block->block_number,
                'check_in_date' => $resident->check_in_date,
                'check_out_date' => $resident->check_out_date,
                'status' => $resident->check_out_date ? 'Past' : 'Current'
            ]);
        }

        // Add hostels from bed transfers
        foreach ($resident->bedTransfers as $transfer) {
            if ($transfer->toBed && $transfer->toBed->room->floor->block->hostel) {
                $hostel = $transfer->toBed->room->floor->block->hostel;
                $existing = $hostelsData->firstWhere('id', $hostel->id);

                if (!$existing) {
                    $hostelsData->push([
                        'id' => $hostel->id,
                        'name' => $hostel->name,
                        'logo' => $hostel->logo,
                        'block' => $transfer->toBed->room->floor->block->name . ' Block ' . $transfer->toBed->room->floor->block->block_number,
                        'check_in_date' => $transfer->transfer_date,
                        'check_out_date' => null,
                        'status' => 'Past'
                    ]);
                }
            }
        }

        return $hostelsData->unique('id');
    }
}
