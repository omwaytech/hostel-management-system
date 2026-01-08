<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\ResidentStoreRequest;
use App\Http\Requests\hostelAdminBackend\ResidentUpdateRequest;
use App\Models\Bed;
use App\Models\BedTransferHistory;
use App\Models\Block;
use App\Models\Booking;
use App\Models\Floor;
use App\Models\Hostel;
use App\Models\Occupancy;
use App\Models\Resident;
use App\Models\Room;
use App\Models\User;
use App\Notifications\NewHostelStudentAdded;
use App\Mail\ResidentCreatedMail;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResidentController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');

        // $residents = Resident::with('bed.room.floor.block')->where('is_deleted', false)->get();

        $residents = Resident::whereHas('bed.room.floor.block', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        })->where('is_deleted', false)->get();

        return view('admin.hostelAdminBackend.resident.index', compact('residents'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');

        $blocks = Block::with(['floors.rooms.beds'])
            ->where('hostel_id', $hostelId)
            ->where('is_deleted', 0)
            ->get();

        return view('admin.hostelAdminBackend.resident.create', [
            'resident' => null,
            'blocks' => $blocks
        ]);
    }

    public function getHostelBlocks($hostel)
    {
        $blocks = Block::where('hostel_id', $hostel)->where('is_deleted', false)->get();
        return response()->json($blocks);
    }

    public function getOccupancies($block)
    {
        $occupancy = Occupancy::where('block_id', $block)->where('is_deleted', false)->get();

        return response()->json($occupancy);
    }

    public function getFloors($block)
    {
        $floors = Floor::where('block_id', $block)->where('is_deleted', false)->get();
        return response()->json($floors);
    }

    public function getRooms($floor)
    {
        $rooms = Room::where('floor_id', $floor)->where('is_deleted', false)->get();
        return response()->json($rooms);
    }

    public function getBeds($room)
    {
        $beds = Bed::where('room_id', $room)->where('is_deleted', false)->where('status', 'Available')->get();
        return response()->json($beds);
    }

    public function store(ResidentStoreRequest $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $email = strtolower(str_replace(' ', '.', $request->full_name)) . '@hostelhub.com';
            $randomPassword = 'password';

            $user = User::create([
                'name' => $request->full_name,
                'email' => $email,
                'password' => bcrypt($randomPassword),
                'contact_number' => $request->contact_number,
                'role_id' => 4, // Student role
                'slug' => Str::slug($request->full_name . '-' . time())
            ]);

            $bookingId = null;
            if ($request->has('from_booking')) {
                $booking = Booking::where('slug', $request->from_booking)->first();
                if ($booking) {
                    $bookingId = $booking->id;
                }
            }

            $resident = Resident::create([
                'user_id' => $user->id,
                'booking_id' => $bookingId,
                'block_id' => $request->block_id,
                'bed_id' => $request->bed_id,
                'occupancy_id' => $request->occupancy_id,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'guardian_contact' => $request->guardian_contact,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'slug' => Str::slug($request->block_id .'-'. $request->full_name .'-'. $request->check_in_date)
            ]);
            if ($request->hasFile('photo')) {
                $originalName = $request->file('photo')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/residentPhotos/');
                $request->file('photo')->move($path, $fileName);
                $resident->photo = $fileName;
                $resident->save();
            };
            if ($request->hasFile('citizenship')) {
                $originalName = $request->file('citizenship')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/residentCitizenship/');
                $request->file('citizenship')->move($path, $fileName);
                $resident->citizenship = $fileName;
                $resident->save();
            };

            $block = $resident->block;
            $hostel = $block->hostel;

            // Get users by role
            $superAdmin = User::where('role_id', 1)->first();
            $hostelAdmin = $hostel->users()->wherePivot('role_id', 2)->first();

            // Send notifications
            if ($superAdmin) {
                $superAdmin->notify(new NewHostelStudentAdded($resident, $hostel, $block));
            }

            if ($hostelAdmin) {
                $hostelAdmin->notify(new NewHostelStudentAdded($resident, $hostel, $block));
            }
            
            // send mail
            try {
                $recipientEmail = $request->email ?? $email;
                Mail::to($recipientEmail)->send(new ResidentCreatedMail($resident, $user, $randomPassword));
            } catch (\Exception $mailException) {
                \Log::error('Failed to send resident welcome email: ' . $mailException->getMessage());
            }

            // change status of bed
            Bed::where('id', $request->bed_id)->update(['status' => 'Occupied']);

            DB::commit();

            $notification = notificationMessage('success', 'Resident', 'stored', "Resident created successfully! Welcome email sent to {$email}");
            return redirect()->route('hostelAdmin.resident.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $notification = notificationMessage('error', 'Resident', 'stored');
            return redirect()->route('hostelAdmin.resident.index')->with($notification);
        }
    }

    public function show($slug)
    {
        try {
            $currentHostelId = session('current_hostel_id');

            // Find resident by slug first, then check if user has access
            $resident = Resident::with([
                    'bed.room.floor.block.hostel',
                    'occupancy',
                    'bedTransfers.fromBed.room.floor.block.hostel',
                    'bedTransfers.toBed.room.floor.block.hostel',
                    'rentPayments.bill'
                ])
                ->whereSlug($slug)
                ->firstOrFail();

            // Check if user has access to this resident
            // Super Admin (role_id = 1) can access any resident
            // Hostel Admin/Warden can access residents in their hostels (current or transferred)
            $residentHostelId = $resident->bed->room->floor->block->hostel_id ?? null;

            if (auth()->user()->role_id != 1) {
                // Check if resident is in current hostel OR was previously in this hostel (via bed transfers)
                $hasAccess = false;

                // Check current location
                if ($residentHostelId == $currentHostelId) {
                    $hasAccess = true;
                }

                // Check previous locations via bed transfers
                if (!$hasAccess) {
                    foreach ($resident->bedTransfers as $transfer) {
                        $fromHostelId = $transfer->fromBed->room->floor->block->hostel_id ?? null;
                        if ($fromHostelId == $currentHostelId) {
                            $hasAccess = true;
                            break;
                        }
                    }
                }

                if (!$hasAccess) {
                    $notification = notificationMessage('error', 'Access', 'denied', 'You do not have permission to view this resident.');
                    return redirect()->route('hostelAdmin.resident.index')->with($notification);
                }
            }

            // Get blocks from current hostel for within-hostel bed transfer
            $blocks = Block::where('hostel_id', $currentHostelId)->get();

            // Get ALL hostels for cross-hostel transfer (if user is super admin or hostel admin with multiple hostels)
            $allHostels = Hostel::where('is_deleted', 0)->get();

            return view('admin.hostelAdminBackend.resident.show', compact('resident', 'blocks', 'allHostels'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $notification = notificationMessage('error', 'Resident', 'found', 'Resident not found.');
            return redirect()->route('hostelAdmin.resident.index')->with($notification);
        }
    }

    public function bedTransfer(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            // Get the resident and check if this is a cross-hostel transfer
            $resident = Resident::findOrFail($request->resident_id);
            $fromBed = Bed::with('room.floor.block')->findOrFail($request->from_bed_id);
            $toBed = Bed::with('room.floor.block')->findOrFail($request->to_bed_id);

            $oldHostelId = $fromBed->room->floor->block->hostel_id;
            $newHostelId = $toBed->room->floor->block->hostel_id;
            $isCrossHostelTransfer = ($oldHostelId != $newHostelId);

            // Create bed transfer history
            BedTransferHistory::create([
                'resident_id' => $request->resident_id,
                'from_bed_id' => $request->from_bed_id,
                'to_bed_id' => $request->to_bed_id,
                'transfer_date' => now()->toDateString(),
                'slug' => Str::slug($request->resident_id . '-' . $request->from_bed_id . '-' . $request->to_bed_id)
            ]);

            // Update bed statuses
            Bed::where('id', $request->from_bed_id)->update(['status' => 'Available']);
            Bed::where('id', $request->to_bed_id)->update(['status' => 'Occupied']);

            // Update resident information
            $residentUpdateData = [
                'block_id' => $request->block_id,
                'bed_id' => $request->to_bed_id,
                'occupancy_id' => $request->occupancy_id,
            ];

            // If cross-hostel transfer, set check_out_date to today for the old hostel
            if ($isCrossHostelTransfer) {
                $residentUpdateData['check_out_date'] = now()->toDateString();
                // Note: check_in_date for new hostel is typically set during the transfer
                // If you want to also update check_in_date, uncomment the line below:
                // $residentUpdateData['check_in_date'] = now()->toDateString();
            }

            Resident::where('id', $request->resident_id)->update($residentUpdateData);

            DB::commit();

            // Different success messages for cross-hostel vs same-hostel transfers
            if ($isCrossHostelTransfer) {
                $oldHostel = Hostel::find($oldHostelId);
                $newHostel = Hostel::find($newHostelId);
                $message = "Resident successfully transferred from {$oldHostel->name} to {$newHostel->name}! Check-out date set to today.";
                $notification = notificationMessage('success', 'Hostel Transfer', 'completed', $message);
            } else {
                $notification = notificationMessage('success', 'Bed Transfer', 'completed', 'Bed transferred successfully!');
            }

            return redirect()->back()->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Transfer', 'failed', 'An error occurred during the transfer. Please try again.');
            return redirect()->back()->with($notification);
        }
    }

    public function edit($slug)
    {
        $hostelId = session('current_hostel_id');

        $blocks = Block::with(['floors.rooms.beds'])
            ->where('hostel_id', $hostelId)
            ->where('is_deleted', 0)
            ->get();

        $resident = Resident::with('bed.room.floor.block')->whereSlug($slug)->first();
        return view('admin.hostelAdminBackend.resident.edit', compact('resident', 'blocks'));
    }

    public function update(ResidentUpdateRequest $request, $slug)
    {
        try {
            $resident = Resident::whereSlug($slug)->first();

            $oldPhoto = $resident->photo;
            $oldCitizenship = $resident->citizenship;

            $resident->update([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'guardian_contact' => $request->guardian_contact,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'slug' => Str::slug($request->block_id .'-'. $request->full_name .'-'. $request->check_in_date)
            ]);

            if ($request->hasFile('photo')) {
                $oldPhotoPath = public_path('storage/images/residentPhotos/' . $oldPhoto);
                if ($oldPhoto && file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
                $originalName = $request->file('photo')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/residentPhotos/');
                $request->file('photo')->move($path, $fileName);

                $resident->photo = $fileName;
                $resident->save();
            }

            if ($request->hasFile('citizenship')) {
                $oldCitizenshipPath = public_path('storage/images/residentCitizenship/' . $oldCitizenship);
                if ($oldCitizenship && file_exists($oldCitizenshipPath)) {
                    unlink($oldCitizenshipPath);
                }
                $originalName = $request->file('citizenship')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/residentCitizenship/');
                $request->file('citizenship')->move($path, $fileName);

                $resident->citizenship = $fileName;
                $resident->save();
            }

            $notification = notificationMessage('success', 'Resident', 'updated');
            return redirect()->route('hostelAdmin.resident.index')->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Resident', 'updated');
            return redirect()->route('hostelAdmin.resident.index')->with($notification);
        }
    }

    public function getRoomDetails($roomId)
    {
        try {
            $room = Room::with('floor.block')->findOrFail($roomId);

            return response()->json([
                'success' => true,
                'block_id' => $room->floor->block->id,
                'floor_id' => $room->floor->id,
                'room_id' => $room->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Room not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function destroy($slug)
    {
        try {
            Resident::where('slug', $slug)->update(['is_deleted' => true]);
            return response()->json([
                'success' => true,
                'message' => 'Successfully removed.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove !',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
