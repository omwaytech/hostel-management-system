<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PayrollController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');

        $payrolls = Payroll::whereHas('staff.block', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        })->where('is_deleted', false)->get();

        return view('admin.hostelAdminBackend.payroll.index', compact('payrolls'));
    }
    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        $currentHostelId = session('current_hostel_id');

        $staffs = Staff::with(['block'])
            ->whereHas('block', function ($query) use ($currentHostelId) {
                $query->where('hostel_id', $currentHostelId);
            })
            ->where(function ($query) use ($keyword) {
                $query->where('full_name', 'like', "%{$keyword}%")
                    ->orWhere('contact_number', 'like', "%{$keyword}%")
                    ->orWhereHas('block', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
            })
            ->take(10)
            ->get()
            ->map(function ($staff) {
                return [
                    'full_name' => $staff->full_name,
                    'contact' => $staff->contact_number,
                    'slug' => $staff->slug,
                    'block_name' => $staff->block->name ?? '',
                ];
            });

        return response()->json($staffs);
    }

    // public function create()
    // {
    //     return view('admin.hostelAdminBackend.payroll.create', ['payroll' => null]);
    // }
    public function create($staffSlug)
    {
        $staff = Staff::with('block')->where('slug', $staffSlug)->first();

        $lastInvoice = Payroll::orderBy('invoice_number', 'desc')->first();
        $nextInvoiceNumber = $lastInvoice ? $lastInvoice->invoice_number + 1 : 100;

        $lastPayslip = Payroll::where('staff_id', $staff->id)
        ->latest('pay_date')
        ->first();

        $showForm = true;

        if ($lastPayslip && now()->diffInDays($lastPayslip->pay_date) < 28) {
            $showForm = false;
        }

        return view('admin.hostelAdminBackend.payroll.create', [
            'payroll' => null,
            'staff' => $staff,
            'nextInvoiceNumber' => $nextInvoiceNumber,
            'showForm' => $showForm,
            'lastPayslip' => $lastPayslip
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $payroll = Payroll::create([
                'staff_id' => $request->staff_id,
                'invoice_number' => $request->invoice_number,
                'pay_date' => $request->pay_date,
                'month' => $request->month,
                'total' => $request->net_total,
                'total_earning' => $request->total_earning,
                'total_deduction' => $request->total_deduction,
                'generated_by' => $request->generated_by,
                'slug' => Str::slug($request->staff_id . '-' . $request->pay_date . '-' . $request->total),
            ]);

            foreach ($request->earnings ?? [] as $item) {
                $payroll->payrollItems()->create([
                    'payroll_id' => $payroll->id,
                    'type' => 'earning',
                    'particular' => $item['particular'],
                    'amount' => $item['amount'],
                    'slug' => Str::slug($payroll->id . '-' . $item['particular'] . '-' . time())
                ]);
            }

            foreach ($request->deductions ?? [] as $item) {
                $payroll->payrollItems()->create([
                    'payroll_id' => $payroll->id,
                    'type' => 'deduction',
                    'particular' => $item['particular'],
                    'amount' => $item['amount'],
                    'slug' => Str::slug($payroll->id . '-' . $item['particular'] . '-' . time())
                ]);
            }
            $notification = notificationMessage('success', 'Payroll', 'stored');
            return redirect()->route('hostelAdmin.payroll.show', $payroll->slug)->with($notification);
        } catch (\Exception $e) {
            dd($e);
            $notification = notificationMessage('error', 'Payroll', 'stored');
            return redirect()->route('hostelAdmin.payroll.index')->with($notification);
        }
    }

    public function show($slug)
    {
        $payroll = Payroll::whereSlug($slug)->first();
        return view('admin.hostelAdminBackend.payroll.show', compact('payroll'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
