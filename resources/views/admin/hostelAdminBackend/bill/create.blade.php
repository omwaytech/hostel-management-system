@extends('admin.layouts.hostelAdminBackend')

@section('content')
    {{-- @dd($resident) --}}
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Resident Bill</h1>
            <ul>
                <li>
                    <a href="{{ route('hostelAdmin.bill.index') }}" class="text-primary">Index</a>
                </li>
                <li>Create Bill</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        @if ($showRent)
                            <div class="text-center mb-3">
                                <button class="btn btn-outline-secondary" id="advance-rent-payment">
                                    Advance Rent Payment
                                </button>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                <div>
                                    <h5 class="mb-0 text-warning">
                                        <strong>Monthly Rent:</strong> Rs.
                                        {{ $resident->bed->room->occupancy->monthly_rent }}
                                    </h5>
                                </div>
                                <button class="btn btn-sm btn-success" id="add-rent">
                                    <i class="fas fa-plus"></i> Add to Bill
                                </button>
                            </div>
                        @else
                            <div class="alert alert-success text-center w-100" role="alert"
                                style="padding: 10px; font-size: 13px;">
                                Rent charge has already been added to {{ $resident->full_name }}’s bill.
                                </br> You can charge next rent amount after
                                <strong>{{ $nextDueDate->format('F j, Y') }}</strong>.
                            </div>
                        @endif

                        @if ($resident->due_amount >= 1)
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                <div>
                                    <h5 class="mb-0 text-danger">
                                        <strong>Previous Due:</strong> Rs.
                                        {{ $resident->due_amount }}
                                    </h5>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-success" id="add-due"><i class="fas fa-plus"></i>
                                        Add to Bill
                                    </button>
                                </div>
                            </div>
                        @endif
                        {{-- <h5 class="text-center">HOSTEL CHARGES</h5>
                        <div class="separator-breadcrumb border-top"></div> --}}
                        <div class="row d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-success float-left btn-sm mt-2 mb-2" id="add-service">
                                <i class="fas fa-plus"></i> Add Other Charges
                            </button>
                        </div>
                        <div id="services-container" class="mt-3">
                        </div>

                        <div class="separator-breadcrumb border-top"></div>
                        <div class="row mb-3">
                            <div class="col-md-6 form-group">
                                <label for="overall_discount">
                                    <h6>Discount On Subtotal</h6>
                                </label>
                                <input class="form-control" id="overall_discount" name="overall_discount" type="number"
                                    placeholder="Eg: 500" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="paid_amount">
                                    <h6>Total Paid Amount</h6>
                                </label>
                                <input class="form-control" id="paid_amount" name="paid_amount" type="number"
                                    placeholder="Eg: 500" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <form id="bill-form" action="{{ route('hostelAdmin.bill.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="bill_html" id="bill_html">
                    <input type="hidden" name="resident_id" id="resident_id" value="{{ $resident->id }}">
                    <input type="hidden" name="generated_by" id="generated_by" value="{{ Auth::user()->name }}">

                    <div class="card shadow-sm rounded-1 bg-white border" id="bill-section">
                        <div class="card-body">
                            <div class="mb-3" style="text-align: center;">
                                <h1 style="margin: 0; font-size: 25px; font-weight: 300; letter-spacing: 2px;">INVOICE
                                </h1>
                            </div>
                            <h4 class="text-black text-center" style="font-size: 20px;">
                                <span class="ms-2">{{ $resident->block->name }}</span>
                            </h4>
                            <h5 class="mb-4 text-black text-center" style="font-size: 14px;">
                                <span class="ms-2">{{ $resident->block->location }}</span>
                            </h5>
                            <div style="border-bottom: 2px solid #e9ecef;">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                                    <div style="font-size: 12px; font-weight: 600; color: #495057;" id="preview_invoice">
                                        Invoice Number # INV-{{ $nextInvoiceNumber }}
                                    </div>
                                    <input type="hidden" name="invoice_number" id="hidden_invoice_number"
                                        value="{{ $nextInvoiceNumber }}">
                                    <div style="color: #6c757d; font-size: 12px;" id="preview_date">
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
                                        <span
                                            style="color: #6c757d; font-size: 12px; display: block; margin-bottom: 4px;">Resident
                                            Name</span>
                                        <span style="font-weight: 600; color: #212529; font-size: 14px;"
                                            id="preview_name">{{ $resident->full_name }}
                                        </span>
                                    </div>
                                    <div style="margin-bottom: 5px;">
                                        <span
                                            style="color: #6c757d; font-size: 12px; display: block; margin-bottom: 4px;">Contact
                                            Number</span>
                                        <span style="font-weight: 600; color: #212529; font-size: 14px;"
                                            id="preview_contact">{{ $resident->contact_number }}
                                        </span>
                                    </div>
                                    <div style="margin-bottom: 5px;">
                                        <span
                                            style="color: #6c757d; font-size: 12px; display: block; margin-bottom: 4px;">Accommodation</span>
                                        <span style="font-weight: 600; color: #212529; font-size: 14px;"
                                            id="preview_block">{{ $resident->bed->room->floor->block->name }}
                                            | {{ $resident->bed->room->floor->floor_label }}
                                            | Room - {{ $resident->bed->room->room_number }}
                                            | Bed - {{ $resident->bed->bed_number }}
                                        </span>
                                    </div>
                                    <div style="margin-bottom: 5px;">
                                        <span
                                            style="color: #6c757d; font-size: 12px; display: block; margin-bottom: 4px;">Occupancy
                                            Type</span>
                                        <span style="font-weight: 600; color: #212529; font-size: 14px;"
                                            id="preview_seater">{{ $resident->occupancy->occupancy_type }}
                                        </span>
                                    </div>
                                </div>
                                <input type="hidden" name="month" id="hidden_month">
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
                                    </tbody>
                                </table>
                            </div>

                            <div id="services_data"></div>
                            <div style="max-width: 800px; margin-left: auto;" class="mt-5">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <input type="hidden" id="hidden_subtotal" name="subtotal">
                                    <span
                                        style="color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Subtotal
                                    </span>
                                    <span style="font-weight: 600; color: #212529; font-size: 12px;">
                                        <span id="preview_subtotal">0</span>
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
                                        <span id="preview_discount">0</span>
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
                                            <span id="preview_total">0</span>
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
                                        <span id="preview_paid">0</span>
                                    </span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <input type="hidden" id="hidden_due_amount" name="due_amount">
                                    <span
                                        style="color: #856404; font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Amount
                                        Due
                                    </span>
                                    <span style="font-weight: 700; color: #856404; font-size: 14px;">
                                        <span id="preview_due">0</span>
                                    </span>
                                </div>
                            </div>
                            <div
                                style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #dee2e6; text-align: center; color: #6c757d; font-size: 12px;">
                                <p style="margin: 0;">Thank you for choosing our services. Please make payment by the
                                    due date to avoid late fees.</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-3 mb-5">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        const monthlyRentAmount = {{ $resident->bed->room->occupancy->monthly_rent }};
    </script>
    <script>
        let invoiceCounter = 1;

        $(document).ready(function() {
            // date fetch
            $('#preview_date').text(new Date().toLocaleDateString());

            // month fetch
            const currentDate = new Date();
            const monthName = currentDate.toLocaleString('default', {
                month: 'long'
            });
            const year = currentDate.getFullYear();
            $('#preview_month').text(`${monthName}`);
            $('#hidden_month').val(`${monthName}`);

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
                            <label>Particular</label>
                            <input type="text" class="form-control service-name" placeholder="Eg: Meal">
                        </div>
                        <div class="col-md-3">
                            <label>Amount</label>
                            <input type="number" class="form-control service-price" placeholder="Eg: 1000" value="0" min="0" disabled>
                        </div>
                        <div class="col-md-2">
                            <label>Qty</label>
                            <input type="number" class="form-control service-qty" placeholder="Eg: 2" value="1" min="1" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>Discount</label>
                            <input type="number" class="form-control service-discount" placeholder="Eg: 100" value="0" min="0" disabled>
                        </div><br>
                        <div class="col-md-2 mt-2">
                            <button type="button" class="btn btn-sm btn-danger remove-service">x</button>
                        </div>
                    </div>
                `;
                const specialRows = $('.service-row').filter(function() {
                    const name = $(this).find('.service-name').val()?.toLowerCase();
                    return name === 'due amount' || name === 'monthly rent';
                });

                if (specialRows.length > 0) {
                    $(row).insertBefore(specialRows.first());
                } else {
                    $('#services-container').append(row);
                }

                updateBillPreview();
            });

            const dueAmount = parseFloat('{{ $resident->due_amount ?? 0 }}');

            $('#add-due').on('click', function() {
                const dueExists = $('#services-container .service-name').filter(function() {
                    return $(this).val().trim().toLowerCase() === 'due amount';
                }).length > 0;

                if (dueExists) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Already Added',
                        text: 'Due Amount is already added to the bill.',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                const dueRow = `
                    <div class="row service-row mb-2">
                        <div class="col-md-4">
                            <label>Particular</label>
                            <input type="text" class="form-control service-name" value="Due Amount" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Amount</label>
                            <input type="number" class="form-control service-price" value="${dueAmount}" min="0" readonly>
                        </div>
                        <div class="col-md-2">
                            <label>Qty</label>
                            <input type="number" class="form-control service-qty" value="1" min="1" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Discount</label>
                            <input type="number" class="form-control service-discount" value="0" min="0">
                        </div>
                        <div class="col-md-2 mt-2">
                            <button type="button" class="btn btn-sm btn-danger remove-service">x</button>
                        </div>
                    </div>
                `;

                $('#services-container').append(dueRow);
                // moveDueAmountToEnd();

                updateBillPreview();
            });

            function moveDueAmountToEnd() {
                const dueRow = $('.service-row .service-name').filter(function() {
                    return $(this).val().trim().toLowerCase() === 'due amount';
                }).closest('.service-row');

                if (dueRow.length > 0) {
                    dueRow.appendTo('#services-container');
                }
            }

            const monthlyRentAmount = parseFloat('{{ $resident->bed->room->occupancy->monthly_rent ?? 0 }}');

            $('#add-rent').on('click', function() {
                // Check if Monthly Rent is already added (prevent duplicates)
                const rentExists = $('#services-container .service-name').filter(function() {
                    return $(this).val().trim().toLowerCase() === 'monthly rent';
                }).length > 0;

                if (rentExists) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Already Added',
                        text: 'Monthly Rent is already added to the bill.',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                const rentRow = `
                    <div class="row service-row mb-2 hidden">
                        <div class="col-md-4">
                            <label>Particular</label>
                            <input type="text" class="form-control service-name" value="Monthly Rent" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Amount</label>
                            <input type="number" class="form-control service-price" value="${monthlyRentAmount}" min="0" readonly>
                        </div>
                        <div class="col-md-2">
                            <label>Qty</label>
                            <input type="number" class="form-control service-qty" value="1" min="1" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Discount</label>
                            <input type="number" class="form-control service-discount" value="0" min="0">
                        </div>
                        <div class="col-md-2 mt-2">
                            <button type="button" class="btn btn-sm btn-danger remove-service">x</button>
                        </div>
                    </div>
                `;

                $('#services-container').append(rentRow);
                // moveDueAmountToEnd();

                updateBillPreview();
            });

            $(document).on('click', '.remove-service', function() {
                $(this).closest('.service-row').remove();
                updateBillPreview();
            });

            $(document).on('input', '.service-name', function() {
                const row = $(this).closest('.service-row');
                const nameVal = $(this).val().trim();

                //
                row.find('.service-price, .service-qty, .service-discount').prop('disabled', nameVal ===
                    '');
            });

            // Trigger update on any input change in service rows
            $(document).on('input', '.service-name, .service-price, .service-qty, .service-discount', function() {
                updateBillPreview();
            });
            // Trigger when overall discount input changes
            $('#overall_discount').on('input', updateBillPreview);
            $('#paid_amount').on('input', updateBillPreview);


            $('#advance-rent-payment').on('click', function(e) {
                e.preventDefault();

                // Example fixed values (you can adjust as needed)
                const advanceName = "Advance Rent";
                const monthlyRent = {{ $resident->bed->room->occupancy->monthly_rent ?? 0 }}; // from backend
                const months = 1; // default 1, you could ask user input for months

                const rowHtml = `
                    <div class="row service-row mb-2">
                        <div class="col-md-4">
                            <label>Particular</label>
                            <input type="text" class="form-control service-name" value="${advanceName}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Amount</label>
                            <input type="number" class="form-control service-price" value="${monthlyRent}" min="0" readonly>
                        </div>
                        <div class="col-md-2">
                            <label>Qty</label>
                            <input type="number" class="form-control service-qty" value="${months}" min="1">
                        </div>
                        <div class="col-md-3">
                            <label>Discount</label>
                            <input type="number" class="form-control service-discount" value="0" min="0">
                        </div>
                        <div class="col-md-2 mt-2">
                            <button type="button" class="btn btn-sm btn-danger remove-service">x</button>
                        </div>
                    </div>
                `;

                $('#services-container').append(rowHtml);

                updateBillPreview();
            });

            // Bill calculation and preview rendering
            function updateBillPreview() {
                let subtotal = 0;

                $('#bill_items_preview').empty();

                $('.service-row').each(function() {
                    const name = $(this).find('.service-name').val().trim();
                    const price = parseFloat($(this).find('.service-price').val()) || 0;
                    const qty = parseFloat($(this).find('.service-qty').val()) || 0;
                    const discountInput = $(this).find('.service-discount').val();
                    const discount = discountInput === '' ? 0 : parseFloat(discountInput) || 0;

                    if (!name) return;

                    const itemTotal = (price * qty) - discount;
                    subtotal += isNaN(itemTotal) ? 0 : itemTotal;

                    $('#bill_items_preview').append(`
                        <tr style="border-bottom: 1px solid #f1f3f4;">
                            <td style="padding: 15px 12px; text-align: center; color: #212529;">
                                ${name}
                            </td>
                            <td style="padding: 15px 12px; text-align: center; color: #6c757d;">
                                Rs. ${price.toFixed(2)}
                            </td>
                            <td style="padding: 15px 12px; text-align: center; color: #6c757d;">
                                ${qty}
                            </td>
                            <td style="padding: 15px 12px; text-align: center; color: #28a745;">
                                ${discount.toFixed(2)}
                            </td>
                            <td
                                style="padding: 15px 12px; text-align: center; font-weight: 600; color: #212529;">
                                Rs. ${itemTotal.toFixed(2)}
                            </td>
                        </tr>
                    `);
                });

                $('#preview_subtotal').text(`Rs. ${subtotal.toFixed(2)}`);

                const overallDiscount = parseFloat($('#overall_discount').val()) || 0;
                const total = subtotal - overallDiscount;

                if (overallDiscount > 0) {
                    $('#preview_discount').text(`Rs. ${overallDiscount.toFixed(2)}`);
                } else {
                    $('#preview_discount').text('');
                }

                $('#preview_total').text(`Rs. ${total.toFixed(2)}`);
                $('#hidden_total').val(total); // Sync hidden total

                const paid = parseFloat($('#paid_amount').val()) || 0;
                console.log(paid);
                const due = total - paid;

                $('#hidden_paid_amount').val(paid);
                $('#hidden_due_amount').val(due);

                $('#preview_paid').text(`Rs. ${paid.toFixed(2)}`);
                $('#preview_due').text(`Rs. ${due.toFixed(2)}`);
            }

            $('#bill-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default submission

                const billHtml = document.getElementById('bill-section').innerHTML;

                // Extract preview values (strip "Rs. " prefix)
                const subtotal = $('#preview_subtotal').text().replace('Rs. ', '').trim();
                const discount = $('#preview_discount').text().replace('Rs. ', '').trim() || 0;
                const total = $('#preview_total').text().replace('Rs. ', '').trim();

                // Set values to hidden fields
                $('#bill_html').val(billHtml);
                $('#hidden_subtotal').val(subtotal);
                $('#hidden_discount').val(discount);
                $('#hidden_total').val(total);

                $('#services_data').empty(); // clear previous if any

                $('.service-row').each(function() {
                    const name = $(this).find('.service-name').val().trim();
                    const price = $(this).find('.service-price').val();
                    const qty = $(this).find('.service-qty').val();
                    const discount = $(this).find('.service-discount').val();

                    if (!name || parseFloat(price) === 0) return;

                    const amount = ((price * qty) - discount).toFixed(2);

                    $('#services_data').append(`
                        <input type="hidden" name="particulars[]" value="${name}">
                        <input type="hidden" name="unit_prices[]" value="${price}">
                        <input type="hidden" name="quantities[]" value="${qty}">
                        <input type="hidden" name="discounts[]" value="${discount}">
                        <input type="hidden" name="amounts[]" value="${amount}">
                    `);
                });

                // Now submit the form after values are set
                this.submit();

                // Optional: Print after short delay
                setTimeout(() => {
                    printBill(billHtml);
                }, 500);
            });


            function saveBill() {
                const billHtml = document.getElementById('bill-section').innerHTML;
                const formData = new FormData(document.getElementById('bill-form'));
                formData.set('bill_html', billHtml); // Ensure HTML is set

                fetch('{{ route('hostelAdmin.bill.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: formData,
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to save');
                        return response.json(); // Or .text() if your controller doesn't return JSON
                    })
                    .then(data => {
                        printBill(billHtml); // Show preview after successful save
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Something went wrong while saving the bill.');
                    });
            }

        });
    </script>
@endsection
