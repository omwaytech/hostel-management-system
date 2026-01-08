@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Staff Payroll of {{ $staff->full_name }}</h1>
            <ul>
                <li>
                    <a href="{{ route('hostelAdmin.payroll.index') }}" class="text-primary">Index</a>
                </li>
                <li>Create Payslip</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            @if ($showForm)
                <div class="col-md-6">
                    <div class="card mb-4 bg-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                <div>
                                    <h5 class="mb-0 text-success">
                                        <strong>Basic Salary:</strong> Rs.
                                        {{ $staff->basic_salary }}
                                    </h5>
                                </div>
                                <button class="btn btn-sm btn-success" id="add-salary"
                                    data-salary="{{ $staff->basic_salary }}" data-tax="{{ $staff->income_tax }}"
                                    data-cit="{{ $staff->cit }}" data-ssf="{{ $staff->ssf }}">
                                    <i class="fas fa-plus"></i> Add to Payslip
                                </button>
                            </div>
                            <div class="mb-4">
                                <h5 class="text-center">Earnings</h5>
                                <div class="separator-breadcrumb border-top"></div>
                                <div id="earnings-inputs">
                                    <div class="row mb-2 earning-item">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control earning-particular"
                                                placeholder="Particular">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control earning-amount" placeholder="Amount">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-sm btn-danger remove-earning">-</button>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-sm" id="add-earning-field">
                                    <i class="fas fa-plus"></i>
                                    Add More
                                </button>
                            </div>
                            <div>
                                <h5 class="text-center">Deductions</h5>
                                <div class="separator-breadcrumb border-top"></div>
                                <div id="deductions-inputs">
                                    <div class="row mb-2 deduction-item">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control deduction-particular"
                                                placeholder="Particular">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control deduction-amount"
                                                placeholder="Amount">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-sm btn-danger remove-deduction">-</button>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-sm" id="add-deduction-field">
                                    <i class="fas fa-plus"></i>
                                    Add More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <form id="payslip-form" action="{{ route('hostelAdmin.payroll.store') }}" method="POST">
                        @csrf
                        <div class="card shadow-sm rounded-1 bg-white border" id="payslip-section"
                            style="overflow: hidden;">
                            <input type="hidden" name="payslip_html" id="payslip_html">
                            <input type="hidden" name="staff_id" value="{{ $staff->id }}">
                            <input type="hidden" name="generated_by" value="{{ Auth::user()->name }}">
                            <input type="hidden" name="pay_date" value="{{ now()->toDateString() }}">
                            <input type="hidden" name="month" value="{{ now()->format('M') }}">
                            <input type="hidden" name="net_total" id="hidden_net_total">
                            <input type="hidden" name="total_earning" id="hidden_total_earning">
                            <input type="hidden" name="total_deduction" id="hidden_total_deduction">
                            <div
                                style="max-width: auto; background: white; box-shadow: 0 0 20px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
                                <div style="padding: 30px; text-align: center;">
                                    <h1 style="margin: 0; font-size: 28px; font-weight: 300; letter-spacing: 2px;">PAY SLIP
                                    </h1>
                                    <div style="margin-top: 15px; font-size: 18px; opacity: 0.9;">
                                        <div style="font-weight: 600;">{{ $staff->block->name }}</div>
                                        <div style="font-size: 14px; margin-top: 5px;">{{ $staff->block->location }}</div>
                                        <div style="font-size: 12px; margin-top: 3px;">Phone: {{ $staff->block->contact }}
                                            |
                                            Email:
                                            {{ $staff->block->hostel->email }}</div>
                                    </div>
                                </div>

                                <div style="background: #f8f9fa; padding: 15px 30px; border-bottom: 3px solid #e9ecef;">
                                    <div
                                        style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                                        <div style="font-size: 14px; font-weight: 600; color: #495057;">
                                            Invoice Number # INV-{{ $nextInvoiceNumber }}
                                        </div>
                                        <input type="hidden" name="invoice_number" value="{{ $nextInvoiceNumber }}">
                                        <div style="font-size: 14px; font-weight: 600; color: #495057;">
                                            Pay Period: {{ now()->format('M') }}
                                        </div>
                                        <div style="color: #6c757d; font-size: 14px;">
                                            Pay Date: {{ now()->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>

                                <div style="padding: 30px;">
                                    <div style="display: flex; gap: 30px; margin-bottom: 30px;">
                                        <div style="flex: 1;">
                                            <h3
                                                style="color: #495057; font-size: 16px; border-bottom: 2px solid #dee2e6; text-align: center;">
                                                STAFF INFORMATION
                                            </h3>
                                            <div style="margin-bottom: 12px;">
                                                <span style="color: #6c757d; font-size: 13px; display: block;">Employee
                                                    Name</span>
                                                <span
                                                    style="font-weight: 600; color: #212529; font-size: 15px;">{{ $staff->full_name }}</span>
                                            </div>
                                            <div style="margin-bottom: 12px;">
                                                <span style="color: #6c757d; font-size: 13px;  display: block;">Employee
                                                    Role</span>
                                                <span
                                                    style="font-weight: 600; color: #212529; font-size: 15px;">{{ $staff->role }}</span>
                                            </div>
                                        </div>

                                        <div style="flex: 1;">
                                            <h3
                                                style="color: #495057; font-size: 16px; border-bottom: 2px solid #dee2e6; text-align: center;">
                                                STAFF DETAILS
                                            </h3>
                                            <div style="margin-bottom: 12px;">
                                                <span style="color: #6c757d; font-size: 13px;  display: block;">Date
                                                    of Joining</span>
                                                <span
                                                    style="font-weight: 600; color: #212529; font-size: 15px;">{{ $staff->join_date }}</span>
                                            </div>
                                            <div style="margin-bottom: 12px;">
                                                <span style="color: #6c757d; font-size: 13px;  display: block;">Bank
                                                    Account</span>
                                                <span
                                                    style="font-weight: 600; color: #212529; font-size: 15px;">{{ $staff->bank_account_number }}
                                                </span>
                                            </div>
                                            {{-- <div style="margin-bottom: 12px;">
                                            <span style="color: #6c757d; font-size: 13px;  display: block;">PAN
                                                Number</span>
                                            <span
                                                style="font-weight: 600; color: #212529; font-size: 15px;">{{ $staff->pan_number }}</span>
                                        </div> --}}
                                        </div>
                                    </div>

                                    <div style="display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap;">
                                        <div style="flex: 1; min-width: auto;">
                                            <h3
                                                style="color: #495057; margin: 0 0 15px 0; font-size: 16px; text-align: center;">
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
                                                        <!-- Dynamic earnings rows go here -->
                                                    </tbody>
                                                    <div id="earnings_data">
                                                    </div>
                                                    <tfoot>
                                                        <tr style="background: #f8f9fa;">
                                                            <td
                                                                style="padding: 15px 12px; color: #28a745; font-size: 13px;">
                                                                Total
                                                                Earnings</td>
                                                            <td id="total-earnings-cell"
                                                                style="padding: 15px 12px; text-align: right; color: #28a745; font-size: 16px;">
                                                                Rs. 0.00</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Deductions Table -->
                                        <div style="flex: 1; min-width: auto;">
                                            <h3
                                                style="color: #495057; margin: 0 0 15px 0; font-size: 16px; text-align: center;">
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

                                                    </tbody>
                                                    <div id="deductions_data">

                                                    </div>
                                                    <tfoot>
                                                        <tr style="background: #f8f9fa;">
                                                            <td
                                                                style="padding: 13px 10px; color: #dc3545; font-size: 13px;">
                                                                Total
                                                                Deductions</td>
                                                            <td id="total-deductions-cell"
                                                                style="padding: 13px 10px; text-align: right; color: #dc3545; font-size: 16px;">
                                                                Rs. 0.00</td>
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
                                                <h3 style="margin: 0 0 10px 0; color: #495057; font-size: 18px;">Net Pay
                                                </h3>
                                                <div id="net-pay-amount"
                                                    style="font-size: 22px; font-weight: 700; color: #28a745; margin-bottom: 5px;">
                                                    Rs. 0.00
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer Note -->
                                    <div
                                        style="border-top: 2px solid #dee2e6; padding-top: 20px; text-align: center; color: #6c757d; font-size: 12px;">
                                        <p style="margin: 0 0 10px 0; font-weight: 600;">This is a computer-generated pay
                                            slip
                                            and
                                            does
                                            not
                                            require a signature.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3 mb-5">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="alert alert-success text-center w-100" role="alert"
                    style="padding: 30px; font-size: 20px;">
                    Payslip has already been issued to {{ $staff->full_name }} for this month on
                    <strong>{{ \Carbon\Carbon::parse($lastPayslip->pay_date)->format('F j, Y') }}</strong>.<br>
                    You can generate the next payslip after
                    <strong>{{ \Carbon\Carbon::parse($lastPayslip->pay_date)->addDays(28)->format('F j, Y') }}</strong>.
                </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            function updateFormInputs() {

                $('#earnings-inputs-wrapper').empty();
                $('#deductions-inputs-wrapper').empty();

                $('#earnings-body tr').each(function(i, row) {
                    const particular = $(row).find('.earning-particular').text().trim();
                    const amount = parseFloat($(row).find('.earning-amount').text().replace(/[^\d.-]/g,
                        '')) || 0;

                    $('#earnings-inputs-wrapper').append(`
                        <input type="hidden" name="earnings[${i}][particular]" value="${particular}">
                        <input type="hidden" name="earnings[${i}][amount]" value="${amount}">
                    `);
                });

                $('#deductions-body tr').each(function(i, row) {
                    const particular = $(row).find('.deduction-particular').text().trim();
                    const amount = parseFloat($(row).find('.deduction-amount').text().replace(/[^\d.-]/g,
                        '')) || 0;

                    $('#deductions-inputs-wrapper').append(`
                        <input type="hidden" name="deductions[${i}][particular]" value="${particular}">
                        <input type="hidden" name="deductions[${i}][amount]" value="${amount}">
                    `);
                });
            }

            function updatePayslip() {
                let totalEarnings = 0;
                let totalDeductions = 0;

                $('#earnings-body').empty();
                $('#deductions-body').empty();

                // Earning Items
                $('.earning-item').each(function() {
                    const title = $(this).find('.earning-particular').val();
                    const amount = parseFloat($(this).find('.earning-amount').val()) || 0;

                    if (title && amount > 0) {
                        $('#earnings-body').append(`
                        <tr>
                            <td style="padding: 12px; color: #212529;">${title}</td>
                            <td style="padding: 12px; text-align: right;">Rs. ${amount.toFixed(2)}</td>
                        </tr>
                    `);
                        totalEarnings += amount;
                    }
                });

                // Deduction Items
                $('.deduction-item').each(function() {
                    const title = $(this).find('.deduction-particular').val();
                    const amount = parseFloat($(this).find('.deduction-amount').val()) || 0;

                    if (title && amount > 0) {
                        $('#deductions-body').append(`
                        <tr>
                            <td style="padding: 12px; color: #212529;">${title}</td>
                            <td style="padding: 12px; text-align: right;">Rs. ${amount.toFixed(2)}</td>
                        </tr>
                    `);
                        totalDeductions += amount;
                    }
                });

                // Update Totals
                $('#total-earnings-cell').text('Rs. ' + totalEarnings.toFixed(2));
                $('#total-deductions-cell').text('Rs. ' + totalDeductions.toFixed(2));
                $('#net-pay-amount').text('Rs. ' + (totalEarnings - totalDeductions).toFixed(2));
            }

            // Add earning row
            $('#add-earning-field').click(function() {
                $('#earnings-inputs').append(`
                <div class="row mb-2 earning-item">
                    <div class="col-md-6"><input type="text" class="form-control earning-particular" placeholder="Particular"></div>
                    <div class="col-md-4"><input type="number" class="form-control earning-amount" placeholder="Amount"></div>
                    <div class="col-md-2"><button class="btn btn-sm btn-danger remove-earning">-</button></div>
                </div>
            `);
            });

            // Add deduction row
            $('#add-deduction-field').click(function() {
                $('#deductions-inputs').append(`
                <div class="row mb-2 deduction-item">
                    <div class="col-md-6"><input type="text" class="form-control deduction-particular" placeholder="Particular"></div>
                    <div class="col-md-4"><input type="number" class="form-control deduction-amount" placeholder="Amount"></div>
                    <div class="col-md-2"><button class="btn btn-sm btn-danger remove-deduction">-</button></div>
                </div>
            `);
            });

            // Remove row
            $(document).on('click', '.remove-earning', function() {
                $(this).closest('.earning-item').remove();
                updatePayslip();
            });
            $(document).on('click', '.remove-deduction', function() {
                $(this).closest('.deduction-item').remove();
                updatePayslip();
            });

            // Trigger update on input change
            $(document).on('input',
                '.earning-particular, .earning-amount, .deduction-particular, .deduction-amount',
                function() {
                    updatePayslip();
                });

            // Auto-fill basic salary + fixed deductions
            $('#add-salary').on('click', function() {
                const dueExists = $('#earnings-inputs .earning-particular').filter(function() {
                    return $(this).val().trim().toLowerCase() === 'basic salary';
                }).length > 0;

                if (dueExists) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Already Added',
                        text: 'Basic Salary is already added to the bill.',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }
                const salary = parseFloat($(this).data('salary')) || 0;
                const incomeTaxRate = parseFloat($(this).data('tax')) || 0;
                const citRate = parseFloat($(this).data('cit')) || 0;
                const ssfRate = parseFloat($(this).data('ssf')) || 0;

                const incomeTax = (salary * incomeTaxRate) / 100;
                const cit = (salary * citRate) / 100;
                const ssf = (salary * ssfRate) / 100;

                // Add Basic Salary to earnings
                $('#earnings-inputs').prepend(`
                <div class="row mb-2 earning-item">
                    <div class="col-md-6"><input type="text" class="form-control earning-particular" value="Basic Salary" readonly></div>
                    <div class="col-md-4"><input type="number" class="form-control earning-amount" value="${salary.toFixed(2)}" readonly></div>
                    <div class="col-md-2"><button class="btn btn-sm btn-danger remove-earning">-</button></div>
                </div>
            `);

                // Add fixed deductions
                if (incomeTax > 0) {
                    $('#deductions-inputs').prepend(`
                    <div class="row mb-2 deduction-item">
                        <div class="col-md-6"><input type="text" class="form-control deduction-particular" value="Income Tax (${incomeTaxRate}%)" readonly></div>
                        <div class="col-md-4"><input type="number" class="form-control deduction-amount" value="${incomeTax.toFixed(2)}" readonly></div>
                        <div class="col-md-2"><button class="btn btn-sm btn-danger remove-deduction">-</button></div>
                    </div>
                `);
                }
                if (cit > 0) {
                    $('#deductions-inputs').prepend(`
                    <div class="row mb-2 deduction-item">
                        <div class="col-md-6"><input type="text" class="form-control deduction-particular" value="CIT (${citRate}%)" readonly></div>
                        <div class="col-md-4"><input type="number" class="form-control deduction-amount" value="${cit.toFixed(2)}" readonly></div>
                        <div class="col-md-2"><button class="btn btn-sm btn-danger remove-deduction">-</button></div>
                    </div>
                `);
                }
                if (ssf > 0) {
                    $('#deductions-inputs').prepend(`
                    <div class="row mb-2 deduction-item">
                        <div class="col-md-6"><input type="text" class="form-control deduction-particular" value="SSF (${ssfRate}%)" readonly></div>
                        <div class="col-md-4"><input type="number" class="form-control deduction-amount" value="${ssf.toFixed(2)}" readonly></div>
                        <div class="col-md-2"><button class="btn btn-sm btn-danger remove-deduction">-</button></div>
                    </div>
                `);
                }

                updatePayslip();
            });

            $('#payslip-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                const payslipHtml = document.getElementById('payslip-section').innerHTML;

                // Extract totals from preview
                const totalEarnings = $('#total-earnings-cell').text().replace('Rs. ', '').trim();
                const totalDeductions = $('#total-deductions-cell').text().replace('Rs. ', '').trim();
                const netTotal = $('#net-pay-amount').text().replace('Rs. ', '').trim();

                // Set them to hidden inputs
                $('#payslip_html').val(payslipHtml);
                $('#hidden_total_earning').val(totalEarnings);
                $('#hidden_total_deduction').val(totalDeductions);
                $('#hidden_net_total').val(netTotal);

                // Clean previous hidden inputs
                $('#earnings_data').empty();
                $('#deductions_data').empty();

                // Populate earnings data
                $('#earnings-body tr').each(function(index) {
                    const name = $(this).find('td:first').text().trim();
                    const amount = $(this).find('td:last').text().replace('Rs. ', '').trim();
                    if (!name || !amount) return;

                    $('#earnings_data').append(`
                        <input type="hidden" name="earnings[${index}][particular]" value="${name}">
                        <input type="hidden" name="earnings[${index}][amount]" value="${amount}">
                    `);
                });

                // Populate deductions data
                $('#deductions-body tr').each(function(index) {
                    const name = $(this).find('td:first').text().trim();
                    const amount = $(this).find('td:last').text().replace('Rs. ', '').trim();
                    if (!name || !amount) return;

                    $('#deductions_data').append(`
                <input type="hidden" name="deductions[${index}][particular]" value="${name}">
                <input type="hidden" name="deductions[${index}][amount]" value="${amount}">
            `);
                });
                updateFormInputs();

                // Finally, submit the form
                this.submit();
            });


        });
    </script>
@endsection
