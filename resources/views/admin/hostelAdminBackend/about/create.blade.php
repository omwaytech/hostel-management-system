@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>About</h1>
        <ul>
            <li>
                <a href="{{ route('hostelAdmin.about.index') }}" class="text-primary">Index</a>
            </li>
            <li>{{ $about ? 'Edit' : 'Create' }}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ $about ? route('hostelAdmin.about.update', $about->slug) : route('hostelAdmin.about.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($about)
                    @method('PUT')
                @endif
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="hostel_id" id="hostel_id" value="{{ $hostelId }}">
                            <div class="col-md-6 form-group">
                                <label for="about_title">
                                    <h6>Title <code>*</code></h6>
                                </label>
                                <input class="form-control @error('about_title') is-invalid @enderror" id="about_title"
                                    name="about_title" type="text" placeholder="Enter title"
                                    value="{{ old('about_title', $about->about_title ?? '') }}" />
                                @error('about_title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="about_description">
                                    <h6>Description <code>*</code></h6>
                                </label>
                                <textarea class="form-control ckeditor @error('about_description') is-invalid @enderror" rows="6"
                                    id="about_description" name="about_description" placeholder="Type Here..." />{{ old('about_description', $about->about_description ?? '') }}</textarea>
                                @error('about_description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="about_mission">
                                    <h6>Mission <code>*</code></h6>
                                </label>
                                <textarea class="form-control @error('about_mission') is-invalid @enderror" rows="6" id="about_mission"
                                    name="about_mission" placeholder="Type Here..." />{{ old('about_mission', $about->about_mission ?? '') }}</textarea>
                                @error('about_mission')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="about_vision">
                                    <h6>Vision <code>*</code></h6>
                                </label>
                                <textarea class="form-control @error('about_vision') is-invalid @enderror" rows="6" id="about_vision"
                                    name="about_vision" placeholder="Type Here..." />{{ old('about_vision', $about->about_vision ?? '') }}</textarea>
                                @error('about_vision')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="about_value">
                                    <h6>Value <code>*</code></h6>
                                </label>
                                <textarea class="form-control @error('about_value') is-invalid @enderror" rows="6" id="about_value"
                                    name="about_value" placeholder="Type Here..." />{{ old('about_value', $about->about_value ?? '') }}</textarea>
                                @error('about_value')
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
