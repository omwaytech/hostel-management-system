@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Resident</h1>
            <ul>
                <li>
                    <a href="{{ route('hostelAdmin.resident.index') }}" class="text-primary">Index</a>
                </li>
                <li>{{ $resident ? 'Edit' : 'Create' }}</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <form action="{{ route('hostelAdmin.resident.update', $resident->slug) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="full_name">
                                        <h6>Full Name <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                                        name="full_name" type="text" placeholder="Enter name"
                                        value="{{ old('full_name', $resident->full_name ?? '') }}" />
                                    @error('full_name')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="contact_number">
                                        <h6>Contact Number <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('contact_number') is-invalid @enderror"
                                        id="contact_number" name="contact_number" type="number" placeholder="Enter number"
                                        value="{{ old('contact_number', $resident->contact_number ?? '') }}" />
                                    @error('contact_number')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="guardian_contact">
                                        <h6>Guardian Contact <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('guardian_contact') is-invalid @enderror"
                                        id="guardian_contact" name="guardian_contact" type="number"
                                        placeholder="Enter number"
                                        value="{{ old('guardian_contact', $resident->guardian_contact ?? '') }}" />
                                    @error('guardian_contact')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>
                                        <h6>Photo <code>*</code></h6>
                                    </label><br>
                                    <div class="d-flex justify-content-center">
                                        @if ($resident && $resident->photo)
                                            <img src="{{ asset('storage/images/residentPhotos/' . $resident->photo) }}"
                                                id="preview" alt="{{ $resident->photo }}"
                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                        @else
                                            <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview"
                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                        @endif
                                        <input class="ml-2 mt-2 form-control @error('photo') is-invalid @enderror"
                                            type="file" name="photo" id="photo"
                                            accept="image/jpeg,image/png,image/jpg" value="{{ old('photo') }}"
                                            onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                                    </div>
                                    @error('photo')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>
                                        <h6>Citizenship (Both Side) <code>*</code></h6>
                                    </label><br>
                                    <div class="d-flex justify-content-center">
                                        @if ($resident && $resident->citizenship)
                                            <img src="{{ asset('storage/images/residentCitizenship/' . $resident->citizenship) }}"
                                                id="preview1" alt="{{ $resident->citizenship }}"
                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                        @else
                                            <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview1"
                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                        @endif
                                        <input class="ml-2 mt-2 form-control @error('citizenship') is-invalid @enderror"
                                            type="file" name="citizenship" id="citizenship"
                                            accept="image/jpeg,image/png,image/jpg" value="{{ old('citizenship') }}"
                                            onchange="document.getElementById('preview1').src = window.URL.createObjectURL(this.files[0])">
                                    </div>
                                    @error('citizenship')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="check_in_date">
                                        <h6>Check In Date</h6>
                                    </label>
                                    <input class="form-control @error('check_in_date') is-invalid @enderror"
                                        id="check_in_date" name="check_in_date" type="date"
                                        value="{{ old('check_in_date', $resident->check_in_date ?? '') }}" />
                                    @error('check_in_date')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="check_out_date">
                                        <h6>Check Out Date</h6>
                                    </label>
                                    <input class="form-control @error('check_out_date') is-invalid @enderror"
                                        id="check_out_date" name="check_out_date" type="date"
                                        value="{{ old('check_out_date', $resident->check_out_date ?? '') }}" />
                                    @error('check_out_date')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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
