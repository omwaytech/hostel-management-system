@extends('layouts.backend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Customer Bill</h1>
            {{-- <ul>
                <li>
                    <a href="{{ route('bill.index') }}" class="text-danger">Index</a>
                </li>
                <li>Generate Bill</li>
            </ul> --}}
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            {{-- <form action="{{ route('bill.store') }}" method="POST" enctype="multipart/form-data">
                @csrf --}}
            <div class="col-md-6">
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <h5 class="text-center">CUSTOMER INFORMATION</h5>
                        <div class="separator-breadcrumb border-top"></div>
                        <div class="row mb-3">
                            <div class="col-md-6 form-group">
                                <label for="customer_name">
                                    <h6>Customer Name</h6>
                                </label>
                                <input class="form-control" id="customer_name" name="customer_name" type="text"
                                    placeholder="Eg: Dummy" />
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="room_number">
                                    <h6>Room Number</h6>
                                </label>
                                <input class="form-control" id="room_number" name="room_number" type="text"
                                    placeholder="Eg: 420" />
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="seater_type">
                                    <h6>Seater Type</h6>
                                </label>
                                <input class="form-control" id="seater_type" name="seater_type" type="text"
                                    placeholder="Eg: Double" />
                            </div>
                        </div>
                        <h5 class="text-center">HOSTEL SERVICES USED</h5>
                        <div class="separator-breadcrumb border-top"></div>
                        <div id="services-container" class="mt-3">
                            <div class="service-row row">
                                <div class="col-md-4 form-group">
                                    <label for="service_name">
                                        <h6>Service Name</h6>
                                    </label>
                                    <input class="form-control service-name" id="service_name" name="service_name"
                                        type="text" placeholder="Eg: Meal" />
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="service_price">
                                        <h6>Price</h6>
                                    </label>
                                    <input class="form-control service-price" id="service_price" name="service_price"
                                        type="number" placeholder="Eg: 1000" value="0" min="0" disabled />
                                </div>
                                <div class="col-md-2 form-group">
                                    <label for="service_qty">
                                        <h6>Qty</h6>
                                    </label>
                                    <input class="form-control service-qty" id="service_qty" name="service_qty"
                                        type="number" placeholder="Eg: 2" value="1" min="1" disabled />
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="service_discount">
                                        <h6>Discount</h6>
                                    </label>
                                    <input class="form-control service-discount" id="service_discount"
                                        name="service_discount" type="number" placeholder="Eg: 100" value="0"
                                        min="0" disabled />
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success float-right btn-sm mt-2 mb-2" id="add-service">
                            New
                        </button>
                        <h5 class="text-center mt-5">DISCOUNT ON SUBTOTAL</h5>
                        <div class="separator-breadcrumb border-top"></div>
                        <div class="row mb-3">
                            <div class="col-md-6 form-group">
                                <label for="overall_discount">
                                    <h6>Discount Amount</h6>
                                </label>
                                <input class="form-control" id="overall_discount" name="overall_discount" type="number"
                                    placeholder="Eg: 500" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </form> --}}
            <div class="col-md-6">
                <div class="card shadow-sm rounded-0 bg-white border border-light" id="bill-section">
                    <div class="card-body">
                        <h4 class="text-info text-center">
                            <span class="ms-2">PQR Hostel</span>
                        </h4>
                        <h5 class="mb-4 text-info text-center">
                            <span class="ms-2">Kathmandu, Nepal</span>
                        </h5>
                        <div class="row mb-3">
                            <div class="col-6">
                                <p class="mb-1">
                                    <strong class="text-muted">Customer Name:</strong>
                                    <span id="preview_name" class="fw-semibold"></span>
                                </p>
                                <p class="mb-1">
                                    <strong class="text-muted">Room Number:</strong>
                                    <span id="preview_room" class="fw-semibold"></span>
                                </p>
                                <p class="mb-1">
                                    <strong class="text-muted">Seater:</strong>
                                    <span id="preview_seater" class="fw-semibold"></span>
                                </p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-1">
                                    <strong class="text-muted">Invoice Number:</strong>
                                    <span id="preview_invoice" class="fw-semibold"></span>
                                </p>
                                <p class="mb-1">
                                    <strong class="text-muted">Date:</strong>
                                    <span id="preview_date" class="fw-semibold"></span>
                                </p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm">
                                <thead class="thead-light">
                                    <tr class="bg-light text-center">
                                        <th>Particular</th>
                                        <th>Unit Price</th>
                                        <th>Qty</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="bill_items_preview" class="text-center">

                                </tbody>
                            </table>
                        </div>

                        <hr class="my-3">

                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Subtotal:</span>
                            <span class="fw-bold text-dark"><span id="preview_subtotal">0</span></span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Discount:</span>
                            <span class="fw-bold text-info"><span id="preview_discount">0</span></span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Total:</span>
                            <span class="fw-bold text-success fs-5"><span id="preview_total">0</span></span>
                        </div>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button class="btn btn-dark float-right" onclick="printBill()">
                        <i class="fas fa-print"></i> Print Bill
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        let invoiceCounter = 1;

        $(document).ready(function() {
            // Set initial invoice number and current date
            const invoiceNumber = Math.floor(100000 + Math.random() * 900000);
            $('#preview_invoice').text('INV-' + invoiceNumber);
            $('#preview_date').text(new Date().toLocaleDateString());

            // Live preview updates
            $('#customer_name').on('input', function() {
                $('#preview_name').text($(this).val());
            });

            $('#room_number').on('input', function() {
                $('#preview_room').text($(this).val());
            });

            $('#seater_type').on('input', function() {
                $('#preview_seater').text($(this).val());
            });

            // Add service row with input fields
            $('#add-service').on('click', function() {
                const row = `
                    <div class="row service-row mb-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control service-name" placeholder="Eg: Meal">
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control service-price" placeholder="Eg: 1000" value="0" min="0" disabled>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control service-qty" placeholder="Eg: 2" value="1" min="1" disabled>
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control service-discount" placeholder="Eg: 100" value="0" min="0" disabled>
                        </div><br>
                        <div class="col-md-2 mt-2">
                            <button type="button" class="btn btn-sm btn-danger remove-service">x</button>
                        </div>
                    </div>
                `;
                $('#services-container').append(row);
                updateBillPreview(); // Optional: recalculate immediately
            });
            $(document).on('click', '.remove-service', function() {
                $(this).closest('.service-row').remove();
                updateBillPreview();
            });

            $(document).on('input', '.service-name', function() {
                const row = $(this).closest('.service-row');
                const nameVal = $(this).val().trim();

                // Enable if there's text, disable if empty
                row.find('.service-price, .service-qty, .service-discount').prop('disabled', nameVal ===
                    '');
            });

            // -----------------------
            // Trigger update on any input change in service rows
            $(document).on('input', '.service-name, .service-price, .service-qty, .service-discount', function() {
                updateBillPreview();
            });
            // Trigger when overall discount input changes
            $('#overall_discount').on('input', updateBillPreview);


            // -----------------------

            // Bill calculation and preview rendering
            function updateBillPreview() {
                let subtotal = 0;

                $('#bill_items_preview').empty();

                $('.service-row').each(function() {
                    const name = $(this).find('.service-name').val() || '';
                    const price = parseFloat($(this).find('.service-price').val()) || '';
                    const qty = parseFloat($(this).find('.service-qty').val()) || '';
                    const discountInput = $(this).find('.service-discount').val();
                    const discount = discountInput === '' ? 0 : parseFloat(discountInput);

                    const itemTotal = (price * qty) - discount;
                    subtotal += itemTotal;

                    $('#bill_items_preview').append(`
                        <tr>
                            <td>${name}</td>
                            <td>Rs. ${price.toFixed(2)}</td>
                            <td>${qty}</td>
                            <td>${discount.toFixed(2)}</td>
                            <td>Rs. ${itemTotal.toFixed(2)}</td>
                        </tr>
                    `);
                });

                $('#preview_subtotal').text(`Rs. ${subtotal.toFixed(2)}`);

                const overallDiscount = parseFloat($('#overall_discount').val());
                if (!isNaN(overallDiscount) && overallDiscount > 0) {
                    $('#preview_discount').text(`Rs. ${overallDiscount.toFixed(2)}`);
                    $('#preview_total').text(`Rs. ${(subtotal - overallDiscount).toFixed(2)}`);
                } else {
                    $('#preview_discount').text('');
                    $('#preview_total').text(`Rs. ${subtotal.toFixed(2)}`);
                }
            }
        });
    </script>
    <script>
        function printBill() {
            const billSection = document.getElementById('bill-section').cloneNode(true);

            const printWindow = window.open('', '', 'height=800,width=600');
            printWindow.document.write('<html><head><title>Hostel Bill of </title>');

            // Include Bootstrap CSS (or your own if using locally)
            printWindow.document.write(`
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    @media print {
                        @page {
                            margin: 0;
                            size: auto;
                        }

                        body {
                            margin: 1cm;
                        }
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
                </style>
            `);


            printWindow.document.write('</head><body>');
            printWindow.document.body.appendChild(billSection);
            printWindow.document.write('</body></html>');

            printWindow.document.close();
            printWindow.focus();

            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);
        }
    </script>
@endsection
