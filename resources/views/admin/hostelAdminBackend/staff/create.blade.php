@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Staff</h1>
            <ul>
                <li>
                    <a href="{{ route('hostelAdmin.staff.index') }}" class="text-primary">Index</a>
                </li>
                <li>{{ $staff ? 'Edit' : 'Create' }}</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <form
                            action="{{ $staff ? route('hostelAdmin.staff.update', $staff->slug) : route('hostelAdmin.staff.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($staff)
                                @method('PUT')
                            @endif
                            <div class="row mb-4">
                                <div class="col-md-12 mb-4">
                                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="staff-tab" data-toggle="tab" href="#staff"
                                                role="tab" aria-controls="staff" aria-selected="true">STAFF INFO</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="financial-tab" data-toggle="tab" href="#financial"
                                                role="tab" aria-controls="financial" aria-selected="false">FINANCIAL
                                                DETAIL
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="staff" role="tabpanel"
                                            aria-labelledby="staff-tab">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="block_id">
                                                        <h6>Block <code>*</code></h6>
                                                    </label>
                                                    <select name="block_id" id="block_id"
                                                        class="form-control @error('block_id') is-invalid @enderror">
                                                        <option value="" disabled
                                                            {{ old('block_id', $staff->block_id ?? '') == '' ? 'selected' : '' }}>
                                                            Please Choose One</option>

                                                        @foreach ($blocks as $block)
                                                            <option value="{{ $block->id }}"
                                                                {{ old('block_id', $staff->block_id ?? '') == $block->id ? 'selected' : '' }}>
                                                                {{ $block->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('block_id')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="full_name">
                                                        <h6>Full Name <code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('full_name') is-invalid @enderror"
                                                        id="full_name" name="full_name" type="text"
                                                        placeholder="Enter full name"
                                                        value="{{ old('full_name', $staff->full_name ?? '') }}" />
                                                    @error('full_name')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label for="contact_number">
                                                        <h6>Contact Number <code>*</code></h6>
                                                    </label>
                                                    <input
                                                        class="form-control @error('contact_number') is-invalid @enderror"
                                                        id="contact_number" name="contact_number" type="number"
                                                        placeholder="Enter number"
                                                        value="{{ old('contact_number', $staff->contact_number ?? '') }}" />
                                                    @error('contact_number')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="role">
                                                        <h6>Role <code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('role') is-invalid @enderror"
                                                        id="role" name="role" type="text"
                                                        placeholder="Enter role"
                                                        value="{{ old('role', $staff->role ?? '') }}" />
                                                    @error('role')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>
                                                        <h6>Photo <code>*</code></h6>
                                                    </label><br>
                                                    <div class="d-flex justify-content-center">
                                                        @if ($staff && $staff->photo)
                                                            <img src="{{ asset('storage/images/staffPhotos/' . $staff->photo) }}"
                                                                id="preview" alt="{{ $staff->photo }}"
                                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                                        @else
                                                            <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                                id="preview"
                                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                                alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                                        @endif
                                                        <input
                                                            class="ml-2 mt-2 form-control @error('photo') is-invalid @enderror"
                                                            type="file" name="photo" id="photo"
                                                            accept="image/jpeg,image/png,image/jpg"
                                                            value="{{ old('photo') }}"
                                                            onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                                                    </div>
                                                    @error('photo')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>
                                                        <h6>Citizenship <code>*</code></h6>
                                                    </label><br>
                                                    <div class="d-flex justify-content-center">
                                                        @if ($staff && $staff->citizenship)
                                                            <img src="{{ asset('storage/images/staffCitizenship/' . $staff->citizenship) }}"
                                                                id="preview1" alt="{{ $staff->citizenship }}"
                                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                                        @else
                                                            <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                                id="preview1"
                                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                                alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                                        @endif
                                                        <input
                                                            class="ml-2 mt-2 form-control @error('citizenship') is-invalid @enderror"
                                                            type="file" name="citizenship" id="citizenship"
                                                            accept="image/jpeg,image/png,image/jpg"
                                                            value="{{ old('citizenship') }}"
                                                            onchange="document.getElementById('preview1').src = window.URL.createObjectURL(this.files[0])">
                                                    </div>
                                                    @error('citizenship')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="join_date">
                                                        <h6>Join Date <code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('join_date') is-invalid @enderror"
                                                        id="join_date" name="join_date" type="date"
                                                        value="{{ old('join_date', $staff->join_date ?? '') }}" />
                                                    @error('join_date')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="leave_date">
                                                        <h6>Leave Date</h6>
                                                    </label>
                                                    <input class="form-control @error('leave_date') is-invalid @enderror"
                                                        id="leave_date" name="leave_date" type="date"
                                                        value="{{ old('leave_date', $staff->leave_date ?? '') }}" />
                                                    @error('leave_date')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="financial" role="tabpanel"
                                            aria-labelledby="financial-tab">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="pan_number">
                                                        <h6>Pan Number <code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('pan_number') is-invalid @enderror"
                                                        id="pan_number" name="pan_number" type="number"
                                                        placeholder="Enter number"
                                                        value="{{ old('pan_number', $staff->pan_number ?? '') }}" />
                                                    @error('pan_number')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="bank_account_number">
                                                        <h6>Bank Account Number <code>*</code></h6>
                                                    </label>
                                                    <input
                                                        class="form-control @error('bank_account_number') is-invalid @enderror"
                                                        id="bank_account_number" name="bank_account_number"
                                                        type="number" placeholder="Enter number"
                                                        value="{{ old('bank_account_number', $staff->bank_account_number ?? '') }}" />
                                                    @error('bank_account_number')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="basic_salary">
                                                        <h6>Basic Salary <code>*</code></h6>
                                                    </label>
                                                    <input
                                                        class="form-control @error('basic_salary') is-invalid @enderror"
                                                        id="basic_salary" name="basic_salary" type="number"
                                                        placeholder="Enter salary"
                                                        value="{{ old('basic_salary', $staff->basic_salary ?? '') }}" />
                                                    @error('basic_salary')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="income_tax">
                                                        <h6>Income Tax (%) <code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('income_tax') is-invalid @enderror"
                                                        id="income_tax" name="income_tax" type="number"
                                                        placeholder="Auto-calculated"
                                                        value="{{ old('income_tax', $staff->income_tax ?? '') }}"
                                                        readonly />
                                                    @error('income_tax')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="cit">
                                                        <h6>Citizen Investment Fund (%)</h6>
                                                    </label>
                                                    <input class="form-control @error('cit') is-invalid @enderror"
                                                        id="cit" name="cit" type="number"
                                                        placeholder="Enter salary"
                                                        value="{{ old('cit', $staff->cit ?? '') }}" />
                                                    @error('cit')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="ssf">
                                                        <h6>Social Security Fund (%)</h6>
                                                    </label>
                                                    <input class="form-control @error('ssf') is-invalid @enderror"
                                                        id="ssf" name="ssf" type="number"
                                                        placeholder="Enter salary"
                                                        value="{{ old('ssf', $staff->ssf ?? '') }}" />
                                                    @error('ssf')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <h5 class="text-center">BASIC INFORMATION</h5>
                            <div class="separator-breadcrumb border-top"></div>

                            <h5 class="text-center mt-3">FINANCIAL INFORMATION</h5>
                            <div class="separator-breadcrumb border-top"></div> --}}

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-success float-right"><i class="far fa-hand-point-up"></i>
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#basic_salary').on('input', function() {
                var monthlySalary = parseFloat($(this).val());
                var annualSalary = monthlySalary * 12;
                var taxRate = 0;

                if (!isNaN(annualSalary)) {
                    if (annualSalary <= 400000) {
                        taxRate = 1;
                    } else if (annualSalary <= 500000) {
                        taxRate = 10;
                    } else if (annualSalary <= 700000) {
                        taxRate = 10;
                    } else if (annualSalary <= 2000000) {
                        taxRate = 10;
                    } else {
                        taxRate = 36;
                    }
                }

                $('#income_tax').val(taxRate);
            });
        });
    </script>
@endsection
