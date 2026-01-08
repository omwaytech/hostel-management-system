@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Resident Bill</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.bill.index') }}" class="text-primary">Index</a></li>
                <li>Bill Preview</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="d-flex justify-content-center align-items-center">
            <div class="card shadow-sm rounded-1 bg-white border" id="bill-section">
                <div class="card-body">
                    <div class="mb-3" style="text-align: center;">
                        <h1 style="margin: 0; font-size: 25px; font-weight: 300; letter-spacing: 2px;">INVOICE
                        </h1>
                    </div>
                    <h4 class="text-black text-center" style="font-size: 20px;">
                        <span class="ms-2">{{ $bill->resident->block->name }}</span>
                    </h4>
                    <h5 class="mb-4 text-black text-center" style="font-size: 14px;">
                        <span class="ms-2">{{ $bill->resident->block->location }}</span>
                    </h5>
                    <div style="border-bottom: 2px solid #e9ecef;">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                            <div style="font-size: 12px; font-weight: 600; color: #495057;" id="preview_invoice">
                                Invoice Number # INV-{{ $bill->invoice_number }}
                            </div>
                            <div style="color: #6c757d; font-size: 12px;" id="preview_date">
                                {{ $bill->generated_date }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h3 style="font-size: 16px; padding-bottom: 8px; text-align: center;">
                            RESIDENT INFORMATION
                        </h3>
                    </div>
                    <div class="row mb-3 mt-3">
                        <div class="col-8">
                            <div style="margin-bottom: 5px;">
                                <span style="color: #6c757d; font-size: 12px; display: block; margin-bottom: 4px;">Resident
                                    Name</span>
                                <span style="font-weight: 600; color: #212529; font-size: 14px;"
                                    id="preview_name">{{ $bill->resident->full_name }}
                                </span>
                            </div>
                            <div style="margin-bottom: 5px;">
                                <span style="color: #6c757d; font-size: 12px; display: block; margin-bottom: 4px;">Contact
                                    Number</span>
                                <span style="font-weight: 600; color: #212529; font-size: 14px;"
                                    id="preview_contact">{{ $bill->resident->contact_number }}
                                </span>
                            </div>
                            <div style="margin-bottom: 5px;">
                                <span
                                    style="color: #6c757d; font-size: 12px; display: block; margin-bottom: 4px;">Accommodation</span>
                                <span style="font-weight: 600; color: #212529; font-size: 14px;"
                                    id="preview_block">{{ $bill->resident->bed->room->floor->block->name }}
                                    | {{ $bill->resident->bed->room->floor->floor_label }}
                                    | Room - {{ $bill->resident->bed->room->room_number }}
                                    | Bed - {{ $bill->resident->bed->bed_number }}
                                </span>
                            </div>
                            <div style="margin-bottom: 5px;">
                                <span style="color: #6c757d; font-size: 12px; display: block; margin-bottom: 4px;">Occupancy
                                    Type</span>
                                <span style="font-weight: 600; color: #212529; font-size: 14px;"
                                    id="preview_seater">{{ $bill->resident->occupancy->occupancy_type }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h3 style="font-size: 16px; padding-bottom: 8px; text-align: center;">
                            BILLING DETAILS
                        </h3>
                    </div>
                    <div
                        style="overflow-x: auto; border: 1px solid #dee2e6; border-radius: 6px; border-bottom: 2px solid #e9ecef;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                            <thead>
                                <tr>
                                    <th
                                        style="padding: 15px 12px; text-align: center; border-bottom: 1px solid #dee2e6; font-size: 12px;">
                                        Particular</th>
                                    <th
                                        style="padding: 15px 12px; text-align: center; border-bottom: 1px solid #dee2e6; font-size: 12px;">
                                        Unit Price</th>
                                    <th
                                        style="padding: 15px 12px; text-align: center; border-bottom: 1px solid #dee2e6; font-size: 12px;">
                                        Qty</th>
                                    <th
                                        style="padding: 15px 12px; text-align: center; border-bottom: 1px solid #dee2e6; font-size: 12px;">
                                        Discount</th>
                                    <th
                                        style="padding: 15px 12px; text-align: center; border-bottom: 1px solid #dee2e6; font-size: 12px;">
                                        Amount</th>
                                </tr>
                            </thead>
                            <tbody id="bill_items_preview">
                                @foreach ($bill->items as $item)
                                    <tr style="border-bottom: 1px solid #f1f3f4;">
                                        <td style="padding: 15px 12px; text-align: center; color: #212529;">
                                            {{ $item->particular }}
                                        </td>
                                        <td style="padding: 15px 12px; text-align: center; color: #6c757d;">
                                            Rs. {{ $item->unit_price }}
                                        </td>
                                        <td style="padding: 15px 12px; text-align: center; color: #6c757d;">
                                            {{ $item->quantity }}
                                        </td>
                                        <td style="padding: 15px 12px; text-align: center; color: #28a745;">
                                            {{ $item->discount }}
                                        </td>
                                        <td
                                            style="padding: 15px 12px; text-align: center; font-weight: 600; color: #212529;">
                                            Rs. {{ $item->amount }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div id="services_data"></div>
                    <div style="max-width: auto; margin-left: auto;" class="mt-5">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span
                                style="color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Subtotal
                            </span>
                            <span style="font-weight: 600; color: #212529; font-size: 12px;">
                                <span id="preview_subtotal">Rs. {{ $bill->subtotal }}</span>
                            </span>
                        </div>

                        <div
                            style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px;">
                            <input type="hidden" id="hidden_discount" name="overall_discount">
                            <span
                                style="color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Total
                                Discount
                            </span>
                            <span style="font-weight: 600; color: #28a745; font-size: 12px;">
                                <span id="preview_discount">Rs. {{ $bill->discount }}</span>
                            </span>
                        </div>

                        <div style="border-top: 2px solid #dee2e6; padding-top: 10px; margin-bottom: 12px;">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                <input type="hidden" id="hidden_total" name="total">
                                <span
                                    style="color: #495057; font-size: 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total
                                    Amount
                                </span>
                                <span style="font-weight: 700; color: #dc3545; font-size: 16px;">
                                    <span id="preview_total">Rs. {{ $bill->total }}</span>
                                </span>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <input type="hidden" id="hidden_paid_amount" name="paid_amount">
                            <span
                                style="color: #6c757d; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Amount
                                Paid
                            </span>
                            <span style="font-weight: 600; color: #28a745; font-size: 14px;">
                                <span id="preview_paid">Rs. {{ $bill->paid_amount }}</span>
                            </span>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <input type="hidden" id="hidden_due_amount" name="due_amount">
                            <span
                                style="color: #856404; font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Amount
                                Due
                            </span>
                            <span style="font-weight: 700; color: #856404; font-size: 14px;">
                                <span id="preview_due">Rs. {{ $bill->due_amount ?? 0 }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="bill-footer"
                        style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #dee2e6; text-align: center; color: #6c757d; font-size: 12px;">
                        <p style="margin: 0;">Thank you for choosing our services. Please make payment by the
                            due date to avoid late fees.</p>
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
            const htmlContent = content || document.getElementById('bill-section').innerHTML;
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
                    .bill-footer {
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
