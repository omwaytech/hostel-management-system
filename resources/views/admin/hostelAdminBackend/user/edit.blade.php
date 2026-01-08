@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>User of {{ $currentHostel->name }}</h1>
            <ul>
                <li>
                    <a href="{{ route('hostelAdmin.setting.index', $user->slug) }}" class="text-primary">Index</a>
                </li>
                <li>User Edit</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <form action="{{ route('hostelAdmin.user.update', $user->slug) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="name">
                                        <h6>User Name <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" type="text" placeholder="Enter user name"
                                        value="{{ old('name', $user->name ?? '') }}" />
                                    @error('name')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2 form-group mb-3">
                                    <label for="gender">
                                        <h6>Gender<code> *</code></h5>
                                    </label>
                                    <select class="form-control @error('gender') is-invalid @enderror" name="gender">
                                        <option value="" disabled selected>Select one</option>
                                        <option value="Male"
                                            {{ old('gender', $user->gender ?? '') == 'Male' ? 'selected' : '' }}>
                                            Male
                                        </option>
                                        <option value="Female"
                                            {{ old('gender', $user->gender ?? '') == 'Female' ? 'selected' : '' }}>
                                            Female
                                        </option>
                                        <option value="Other"
                                            {{ old('gender', $user->gender ?? '') == 'Other' ? 'selected' : '' }}>
                                            Other
                                        </option>
                                    </select>
                                    @error('gender')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="date_of_birth">
                                        <h6>Date of Birth <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('date_of_birth') is-invalid @enderror"
                                        id="date_of_birth" name="date_of_birth" type="date" placeholder="Enter number"
                                        value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}" />
                                    @error('date_of_birth')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="contact_number">
                                        <h6>Contact Number <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('contact_number') is-invalid @enderror"
                                        id="contact_number" name="contact_number" type="number" placeholder="Enter number"
                                        value="{{ old('contact_number', $user->contact_number ?? '') }}" />
                                    @error('contact_number')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="permanent_address">
                                        <h6>Permanent Address <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('permanent_address') is-invalid @enderror"
                                        id="permanent_address" name="permanent_address" type="text"
                                        placeholder="Enter number"
                                        value="{{ old('permanent_address', $user->permanent_address ?? '') }}" />
                                    @error('permanent_address')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>
                                        <h6>Photo <code>*</code></h6>
                                    </label><br>
                                    <div class="d-flex justify-content-center">
                                        @if ($user && $user->photo)
                                            <img src="{{ asset('storage/images/userPhotos/' . $user->photo) }}"
                                                id="preview" alt="{{ $user->photo }}"
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
                                        @if ($user && $user->citizenship)
                                            <img src="{{ asset('storage/images/userCitizenship/' . $user->citizenship) }}"
                                                id="preview1" alt="{{ $user->citizenship }}"
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
                            </div>
                            <div class="separator-breadcrumb border-top"></div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="role_id">
                                        <h6>Hostel role <code>*</code></h6>
                                    </label>
                                    @php
                                        $userRoleId =
                                            $user->hostels()->withPivot('role_id')->first()?->pivot->role_id ?? null;
                                    @endphp

                                    <select name="role_id" id="role_id"
                                        class="form-control @error('role_id') is-invalid @enderror">
                                        <option value="" disabled
                                            {{ old('role_id', $userRoleId) == '' ? 'selected' : '' }}>
                                            Please Choose One
                                        </option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role_id', $userRoleId) == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
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
