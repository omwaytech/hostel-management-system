@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Team</h1>
        <ul>
            <li>
                <a href="{{ route('hostelAdmin.team.index') }}" class="text-primary">Index</a>
            </li>
            <li>{{ $team ? 'Edit' : 'Create' }}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ $team ? route('hostelAdmin.team.update', $team->slug) : route('hostelAdmin.team.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($team)
                    @method('PUT')
                @endif
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="hostel_id" id="hostel_id" value="{{ $hostelId }}">
                            <div class="col-md-6 form-group">
                                <label for="member_name">
                                    <h6>Member Name <code>*</code></h6>
                                </label>
                                <input class="form-control @error('member_name') is-invalid @enderror" id="member_name"
                                    name="member_name" type="text" placeholder="Enter title"
                                    value="{{ old('member_name', $team->member_name ?? '') }}" />
                                @error('member_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="member_designation">
                                    <h6>Member Designation <code>*</code></h6>
                                </label>
                                <input class="form-control @error('member_designation') is-invalid @enderror"
                                    id="member_designation" name="member_designation" type="text"
                                    placeholder="Enter badge"
                                    value="{{ old('member_designation', $team->member_designation ?? '') }}" />
                                @error('member_designation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label>
                                    <h6>Image <code>*</code></h6>
                                </label><br>
                                <div class="d-flex justify-content-center">
                                    @if ($team && $team->member_image)
                                        <img src="{{ asset('storage/images/memberImages/' . $team->member_image) }}"
                                            id="preview1" alt="{{ $team->member_image }}"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                    @else
                                        <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview1"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                    @endif
                                    <input class="ml-2 mt-2 form-control @error('member_image') is-invalid @enderror"
                                        type="file" name="member_image" id="member_image"
                                        accept="image/jpeg,image/png,image/jpg" value="{{ old('member_image') }}"
                                        onchange="document.getElementById('preview1').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                @error('member_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="member_description">
                                    <h6>Description <code>*</code></h6>
                                </label>
                                <textarea class="form-control ckeditor @error('member_description') is-invalid @enderror" rows="3"
                                    id="member_description" name="member_description" placeholder="Type Here..." />{{ old('member_description', $team->member_description ?? '') }}</textarea>
                                @error('member_description')
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
