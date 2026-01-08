@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Slider</h1>
        <ul>
            <li>
                <a href="{{ route('hostelAdmin.slider.index') }}" class="text-primary">Index</a>
            </li>
            <li>{{ $slider ? 'Edit' : 'Create' }}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form
                action="{{ $slider ? route('hostelAdmin.slider.update', $slider->slug) : route('hostelAdmin.slider.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($slider)
                    @method('PUT')
                @endif
                <input type="hidden" name="hostel_id" id="hostel_id" value="{{ $hostelId }}">
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="slider_title">
                                    <h6>Slider Title <code>*</code></h6>
                                </label>
                                <input class="form-control @error('slider_title') is-invalid @enderror" id="slider_title"
                                    name="slider_title" type="text" placeholder="Enter title"
                                    value="{{ old('slider_title', $slider->slider_title ?? '') }}" />
                                @error('slider_title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="slider_subtitle">
                                    <h6>Slider Subtitle <code>*</code></h6>
                                </label>
                                <input class="form-control @error('slider_subtitle') is-invalid @enderror"
                                    id="slider_subtitle" name="slider_subtitle" type="text" placeholder="Enter subtitle"
                                    value="{{ old('slider_subtitle', $slider->slider_subtitle ?? '') }}" />
                                @error('slider_subtitle')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label>
                                    <h6>Image <code>*</code></h6>
                                </label><br>
                                <div class="d-flex justify-content-center">
                                    @if ($slider && $slider->slider_image)
                                        <img src="{{ asset('storage/images/sliderImages/' . $slider->slider_image) }}"
                                            id="preview1" alt="{{ $slider->slider_image }}"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                    @else
                                        <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview1"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                    @endif
                                    <input class="ml-2 mt-2 form-control @error('slider_image') is-invalid @enderror"
                                        type="file" name="slider_image" id="slider_image"
                                        accept="image/jpeg,image/png,image/jpg" value="{{ old('slider_image') }}"
                                        onchange="document.getElementById('preview1').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                @error('slider_image')
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
