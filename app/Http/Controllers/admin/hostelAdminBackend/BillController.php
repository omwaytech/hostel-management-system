<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\RentPaymentHistory;
use App\Models\Resident;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BillController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');

        // $residents = Resident::with('bed.room.floor.block')->where('is_deleted', false)->get();

        $bills = Bill::whereHas('resident.block', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        })->where('is_deleted', false)->get();

        return view('admin.hostelAdminBackend.bill.index', compact('bills'));
    }

    public function create($residentSlug)
    {
        $resident = Resident::with(['bed.room.floor.block'])->where('slug', $residentSlug)->first();

        $lastInvoice = Bill::orderBy('invoice_number', 'desc')->first();
        $nextInvoiceNumber = $lastInvoice ? $lastInvoice->invoice_number + 1 : 100;

        $lastBill = Bill::where('resident_id', $resident->id)
            ->latest('generated_date')
            ->first();

        // Reset advance_rent_payment if advance period has expired
        if ($resident && $resident->advance_rent_payment > 0 && $resident->occupancy->monthly_rent > 0 && $lastBill) {
            $advanceMonths = $resident->advance_rent_payment / $resident->occupancy->monthly_rent;
            $advanceExpiryDate = \Carbon\Carbon::parse($lastBill->generated_date)->addMonths($advanceMonths);
            if (now()->gte($advanceExpiryDate)) {
                $resident->advance_rent_payment = 0;
                $resident->save();
            }
        }

        $showRent = true;
        $daysToAdd = 28; // default

        if ($resident->advance_rent_payment > 0) {
            // How many months (fractional) the advance covers
            $monthsCovered = $resident->advance_rent_payment / $resident->occupancy->monthly_rent;

            // Convert to days (multiply by 28)
            $daysToAdd = (int) floor($monthsCovered * 28);
        }

        if ($lastBill && now()->diffInDays($lastBill->generated_date) < $daysToAdd) {
            $showRent = false;
        }

        $nextDueDate = $lastBill
            ? \Carbon\Carbon::parse($lastBill->generated_date)->addDays($daysToAdd)
            : now()->addDays($daysToAdd);


        return view('admin.hostelAdminBackend.bill.create', [
            'bill' => null,
            'resident' => $resident,
            'nextInvoiceNumber' => $nextInvoiceNumber,
            'showRent' => $showRent,
            'lastBill' => $lastBill,
            'nextDueDate' => $nextDueDate
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            $html = $request->input('bill_html');

            $bill = Bill::create([
                'resident_id' => $request->resident_id,
                'invoice_number' => $request->invoice_number,
                'html_content' => $html,
                'month' => $request->month,
                'subtotal' => $request->subtotal,
                'discount' => $request->overall_discount,
                'total' => $request->total,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount,
                'generated_date' => now(),
                'generated_by' => $request->generated_by,
                'slug' => Str::slug($request->resident_id . '-' . $request->invoice_number .'-' . $request->month)
            ]);

            if ($request->hasFile('snapshot')) {
                $originalName = $request->file('snapshot')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/billSnaps/');
                $request->file('snapshot')->move($path, $fileName);
                $bill->snapshots = $fileName;
                $bill->save();
            };

            foreach ($request->particulars as $index => $particular) {
                BillItem::create([
                    'bill_id' => $bill->id,
                    'particular' => $particular,
                    'unit_price' => $request->unit_prices[$index],
                    'quantity' => $request->quantities[$index],
                    'discount' => $request->discounts[$index],
                    'amount' => $request->amounts[$index],
                    'slug' => Str::slug($bill->id . '-' . $particular . '-' . now()),
                ]);
            }

            $resident = Resident::findOrFail($bill->resident_id);
            // due
            $previousDueIncluded = false;
            foreach ($request->particulars as $particular) {
                if (strtolower(trim($particular)) === 'due amount') {
                    $previousDueIncluded = true;
                    break;
                }
            }
            $newDue = floatval($request->due_amount);
            if ($previousDueIncluded) {
                $resident->due_amount = $newDue;
            } else {
                $resident->due_amount += $newDue;
            }
            $resident->save();

            // advance payment
            $advanceIndex = collect($request->particulars)->search(function ($item) {
            return strtolower(trim($item)) === 'advance rent';
            });

            if ($advanceIndex !== false) {
                $advanceAmount = ((float)$request->unit_prices[$advanceIndex] *
                                (float)$request->quantities[$advanceIndex]) -
                                (float)$request->discounts[$advanceIndex];
                $resident->advance_rent_payment = ($resident->advance_rent_payment ?? 0) + $advanceAmount;
                $resident->save();
            }

            RentPaymentHistory::create([
                'resident_id' => $resident->id,
                'bill_id' => $bill->id,
                'amount_paid' => $request->paid_amount,
                'payment_date' => now(),
                'payment_method' => $request->payment_method,
                'slug' => Str::slug($resident->id . '-' . $bill->id . '-' . $request->paid_amount),
            ]);
            // Removed immediate deduction of monthly rent from advance_rent_payment. Deduct only when rent cycle is processed.

            DB::commit();
            $notification = notificationMessage('success', 'Bill', 'stored');
            return redirect()->route('hostelAdmin.bill.show', $bill->slug)->with($notification);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $notification = notificationMessage('error', 'Bill', 'stored');
            return redirect()->route('hostelAdmin.bill.index')->with($notification);
        }
    }

    // public function storeSnapshot(Request $request, Bill $bill)
    // {
    //     if ($request->hasFile('snapshot')) {
    //         $file = $request->file('snapshot');
    //         $fileName = 'bill-snapshot-' . $bill->id . '-' . time() . '.jpg';
    //         $path = public_path('storage/images/billSnaps/');
    //         $file->move($path, $fileName);
    //         $bill->snapshots = $fileName;
    //         $bill->save();

    //         return response()->json(['success' => true, 'path' => $fileName]);
    //     }
    //     return response()->json(['success' => false], 400);
    // }

    public function storeSnapshot(Request $request)
    {
        // $request->validate([
        //     'bill_id' => 'required|exists:bills,id',
        //     'snapshot' => 'required|image'
        // ]);

        $bill = Bill::findOrFail($request->bill_id);

        $file = $request->file('snapshot');
            $fileName = 'bill-snapshot-' . $bill->id . '-' . time() . '.jpg';
            $path = public_path('storage/images/billSnaps/');
            $file->move($path, $fileName);
            $bill->snapshots = $fileName;
            $bill->save();

        return response()->json(['success' => true]);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        $currentHostelId = session('current_hostel_id');

        $residents = Resident::with(['bed.room.floor.block'])
            ->whereHas('bed.room.floor.block', function ($query) use ($currentHostelId) {
                $query->where('hostel_id', $currentHostelId);
            })
            ->where(function ($query) use ($keyword) {
                $query->where('full_name', 'like', "%{$keyword}%")
                    ->orWhere('contact_number', 'like', "%{$keyword}%")
                    ->orWhereHas('bed.room.floor.block', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('bed.room.floor', function ($q) use ($keyword) {
                        $q->where('floor_label', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('bed.room', function ($q) use ($keyword) {
                        $q->where('room_number', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('bed', function ($q) use ($keyword) {
                        $q->where('bed_number', 'like', "%{$keyword}%");
                    });
            })
            ->take(10)
            ->get()
            ->map(function ($resident) {
                return [
                    'full_name' => $resident->full_name,
                    'contact' => $resident->contact_number,
                    'slug' => $resident->slug,
                    'block_name' => $resident->bed->room->floor->block->name ?? '',
                    'floor_label' => $resident->bed->room->floor->floor_label ?? '',
                    'room_number' => $resident->bed->room->room_number ?? '',
                    'bed_number' => $resident->bed->bed_number ?? '',
                ];
            });

        return response()->json($residents);
    }

    public function show($slug)
    {
        $bill = Bill::where('slug', $slug)->firstOrFail();
        return view('admin.hostelAdminBackend.bill.show', compact('bill'));
    }

    public function edit(string $id)
    {

    }

    public function update(Request $request, string $id)
    {

    }

    public function destroy($slug)
    {
        try {
            Bill::where('slug', $slug)->update(['is_deleted' => true]);
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
