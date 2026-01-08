@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Registration</h1>
        <ul>
            <li>
                <a href="{{ route('hostelAdmin.registration.index') }}" class="text-primary">Index</a>
            </li>
            <li>{{ $registration ? 'Edit' : 'Create' }}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form
                action="{{ $registration ? route('hostelAdmin.registration.update', $registration->slug) : route('hostelAdmin.registration.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($registration)
                    @method('PUT')
                @endif
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="hostel_id" id="hostel_id" value="{{ $hostelId }}">
                            <div class="col-md-6 form-group">
                                <label for="registered_to">
                                    <h6>Registered To <code>*</code></h6>
                                </label>
                                <input class="form-control @error('registered_to') is-invalid @enderror" id="registered_to"
                                    name="registered_to" type="text" placeholder="Enter title"
                                    value="{{ old('registered_to', $registration->registered_to ?? '') }}" />
                                @error('registered_to')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="registered_number">
                                    <h6>Registration Number <code>*</code></h6>
                                </label>
                                <input class="form-control @error('registered_number') is-invalid @enderror"
                                    id="registered_number" name="registered_number" type="text"
                                    placeholder="Enter number"
                                    value="{{ old('registered_number', $registration->registered_number ?? '') }}" />
                                @error('registered_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
@endsection
