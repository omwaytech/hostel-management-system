@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Terms and Policies</h1>
        <ul>
            <li>
                <a href="{{ route('hostelAdmin.terms-and-policies.index') }}" class="text-primary">Index</a>
            </li>
            <li>{{ $termsAndPolicy ? 'Edit' : 'Create' }}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form
                action="{{ $termsAndPolicy ? route('hostelAdmin.terms-and-policies.update', $termsAndPolicy->slug) : route('hostelAdmin.terms-and-policies.store') }}"
                method="POST">
                @csrf
                @if ($termsAndPolicy)
                    @method('PUT')
                @endif
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="hostel_id" id="hostel_id" value="{{ $hostelId }}">

                            <div class="col-md-6 form-group">
                                <label for="tp_title">
                                    <h6>Title <code>*</code></h6>
                                </label>
                                <input class="form-control @error('tp_title') is-invalid @enderror" id="tp_title"
                                    name="tp_title" type="text"
                                    placeholder="Enter title (e.g., Privacy Policy, Terms of Service)"
                                    value="{{ old('tp_title', $termsAndPolicy->tp_title ?? '') }}" />
                                @error('tp_title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="tp_description">
                                    <h6>Description <code>*</code></h6>
                                </label>
                                <textarea class="form-control ckeditor @error('tp_description') is-invalid @enderror" rows="10" id="tp_description"
                                    name="tp_description" placeholder="Enter detailed terms and policies content...">{{ old('tp_description', $termsAndPolicy->tp_description ?? '') }}</textarea>
                                @error('tp_description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success float-right">
                            <i class="far fa-hand-point-up"></i> Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
