@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Staff Payroll of {{ $payroll->staff->full_name }}</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.payroll.index') }}" class="text-primary">Index</a></li>
                <li>Payslip Preview</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="d-flex">
            <div id="payroll-section"
                style="max-width: auto; margin: 0 auto; background: white; box-shadow: 0 0 20px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
                <div style="padding: 30px; text-align: center;">
                    <h1 style="margin: 0; font-size: 28px; font-weight: 300; letter-spacing: 2px;">PAY SLIP</h1>
                    <div style="margin-top: 15px; font-size: 18px; opacity: 0.9;">
                        <div style="font-weight: 600;">{{ $payroll->staff->block->name }}</div>
                        <div style="font-size: 14px; margin-top: 5px;">{{ $payroll->staff->block->location }}</div>
                        <div style="font-size: 12px; margin-top: 3px;">Phone: {{ $payroll->staff->block->contact }} |
                            Email:
                            {{ $payroll->staff->block->hostel->email }}</div>
                    </div>
                </div>

                <div style="background: #f8f9fa; padding: 15px 30px; border-bottom: 3px solid #e9ecef;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <div style="font-size: 14px; font-weight: 600; color: #495057;">
                            Invoice Number # INV-{{ $payroll->invoice_number }}
                        </div>
                        <div style="font-size: 14px; font-weight: 600; color: #495057;">
                            Pay Period: {{ now()->format('M') }}
                        </div>
                        <div style="color: #6c757d; font-size: 14px;">
                            Pay Date: {{ now()->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <div style="padding: 30px;">
                    <div
                        style="display: flex; justify-content: space-between; margin-bottom: 30px; flex-wrap: wrap; gap: 20px;">
                        <div style="flex: 1; min-width: 300px;">
                            <h3
                                style="color: #495057; font-size: 16px; border-bottom: 2px solid #dee2e6; text-align: center;">
                                EMPLOYEE INFORMATION
                            </h3>
                            <div style="margin-bottom: 12px;">
                                <span style="color: #6c757d; font-size: 13px; display: block;">Employee
                                    Name</span>
                                <span
                                    style="font-weight: 600; color: #212529; font-size: 15px;">{{ $payroll->staff->full_name }}</span>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <span style="color: #6c757d; font-size: 13px; display: block;">Employee
                                    Role</span>
                                <span
                                    style="font-weight: 600; color: #212529; font-size: 15px;">{{ $payroll->staff->role }}</span>
                            </div>
                        </div>

                        <div style="flex: 1; min-width: 300px;">
                            <h3
                                style="color: #495057; font-size: 16px; border-bottom: 2px solid #dee2e6; text-align: center;">
                                EMPLOYEE DETAILS
                            </h3>
                            <div style="margin-bottom: 12px;">
                                <span style="color: #6c757d; font-size: 13px; display: block;">Date
                                    of Joining</span>
                                <span
                                    style="font-weight: 600; color: #212529; font-size: 15px;">{{ $payroll->staff->join_date }}</span>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <span style="color: #6c757d; font-size: 13px; display: block;">Bank
                                    Account</span>
                                <span
                                    style="font-weight: 600; color: #212529; font-size: 15px;">{{ $payroll->staff->bank_account_number }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: auto;">
                            <h3 style="color: #495057; margin: 0 0 15px 0; font-size: 16px; text-align: center;">
                                Earnings
                            </h3>
                            <div style="border: 1px solid #dee2e6; border-radius: 6px; overflow: hidden;">
                                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                                    <thead>
                                        <tr>
                                            <th
                                                style="padding: 12px; text-align: left; border-bottom: 1px solid #ececec; font-size: 12px;">
                                                Particular</th>
                                            <th
                                                style="padding: 12px; text-align: right; border-bottom: 1px solid #ececec; font-size: 12px;">
                                                Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="earnings-body">
                                        {{-- @dd($payroll->payrollItems) --}}
                                        @foreach ($payroll->payrollItems as $item)
                                            @if ($item->type == 'earning')
                                                <tr>
                                                    <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">
                                                        {{ $item->particular }}
                                                    </td>
                                                    <td
                                                        style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">
                                                        Rs. {{ number_format($item->amount, 2) }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="background: #f8f9fa;">
                                            <td style="padding: 15px 12px; color: #28a745; font-size: 13px;">
                                                Total
                                                Earnings</td>
                                            <td id="total-earnings-cell"
                                                style="padding: 15px 12px; text-align: right; color: #28a745; font-size: 16px;">
                                                Rs. {{ $payroll->total_earning }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Deductions Table -->
                        <div style="flex: 1; min-width: auto;">
                            <h3 style="color: #495057; margin: 0 0 15px 0; font-size: 16px; text-align: center;">
                                Deductions</h3>

                            <div style="border: 1px solid #dee2e6; border-radius: 6px; overflow: hidden;">
                                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                                    <thead>
                                        <tr>
                                            <th
                                                style="padding: 12px; text-align: left; border-bottom: 1px solid #ececec; font-size: 12px;">
                                                Particular</th>
                                            <th
                                                style="padding: 12px; text-align: right; border-bottom: 1px solid #ececec; font-size: 12px;">
                                                Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="deductions-body">
                                        @foreach ($payroll->payrollItems as $item)
                                            @if ($item->type == 'deduction')
                                                <tr>
                                                    <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">
                                                        {{ $item->particular }}
                                                    </td>
                                                    <td
                                                        style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">
                                                        Rs. {{ number_format($item->amount, 2) }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr style="background: #f8f9fa;">
                                            <td style="padding: 15px 12px; color: #dc3545; font-size: 13px;">
                                                Total
                                                Deductions</td>
                                            <td id="total-deductions-cell"
                                                style="padding: 15px 12px; text-align: right; color: #dc3545; font-size: 16px;">
                                                Rs. {{ $payroll->total_deduction }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div style="padding: 25px; border-left: 4px solid #28a745; margin-bottom: 20px;">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                            <div>
                                <h3 style="margin: 0 0 10px 0; color: #495057; font-size: 18px;">Net Pay</h3>
                                <div id="net-pay-amount"
                                    style="font-size: 22px; font-weight: 700; color: #28a745; margin-bottom: 5px;">
                                    Rs. {{ $payroll->total }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Note -->
                    <div class="payslip-footer"
                        style="border-top: 2px solid #dee2e6; padding-top: 20px; text-align: center; color: #6c757d; font-size: 12px;">
                        <p style="margin: 0 0 10px 0; font-weight: 600;">This is a computer-generated pay slip
                            and
                            does
                            not
                            require a signature.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3 mb-5 d-flex justify-content-center">
            <button type="submit" class="btn btn-lg btn-success" onclick="printBill()">Print</button>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function printBill(content = null) {
            const htmlContent = content || document.getElementById('payroll-section').innerHTML;
            const printWindow = window.open('', '', 'height=800,width=600');

            printWindow.document.write(`
            <html>
            <head>
                <title>Hostel Bill</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    @media print {
                        @page { margin: 0; size: auto; }
                        body { margin: 1cm; }
                    }
                    body {
                        font-family: Arial, sans-serif;
                    }
                    .card {
                        border: 1px solid #dee2e6;
                        padding: 20px;
                        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                    }
                    table th, table td {
                        border: 1px solid #dee2e6 !important;
                        padding: 8px !important;
                    }
                    hr {
                        border-top: 1px solid #dee2e6;
                    }
                    .payslip-footer {
                        position: fixed;
                        bottom: 0;
                        left: 0;
                        right: 0;
                        text-align: center;
                        color: #6c757d;
                        font-size: 12px;
                        padding: 10px 0;
                        border-top: 2px solid #dee2e6;
                        background: white;
                    }
                </style>
            </head>
            <body>${htmlContent}</body>
            </html>
        `);

            printWindow.document.close();

            printWindow.onload = function() {
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            };
        }
    </script>
@endsection
