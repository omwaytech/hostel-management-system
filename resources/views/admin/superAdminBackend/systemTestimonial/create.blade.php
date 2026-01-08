@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Testimonial</h1>
        <ul>
            <li>
                <a href="{{ route('admin.system-testimonial.index') }}" class="text-primary">Index</a>
            </li>
            <li>{{ $testimonial ? 'Edit' : 'Create' }}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form
                action="{{ $testimonial ? route('admin.system-testimonial.update', $testimonial->slug) : route('admin.system-testimonial.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($testimonial)
                    @method('PUT')
                @endif
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="person_name">
                                    <h6>Person Name <code>*</code></h6>
                                </label>
                                <input class="form-control @error('person_name') is-invalid @enderror" id="person_name"
                                    name="person_name" type="text" placeholder="Enter title"
                                    value="{{ old('person_name', $testimonial->person_name ?? '') }}" />
                                @error('person_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="person_address">
                                    <h6>Address <code>*</code></h6>
                                </label>
                                <input class="form-control @error('person_address') is-invalid @enderror"
                                    id="person_address" name="person_address" type="text" placeholder="Enter badge"
                                    value="{{ old('person_address', $testimonial->person_address ?? '') }}" />
                                @error('person_address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label>
                                    <h6>Image <code>*</code></h6>
                                </label><br>
                                <div class="d-flex justify-content-center">
                                    @if ($testimonial && $testimonial->person_image)
                                        <img src="{{ asset('storage/images/reviewImages/' . $testimonial->person_image) }}"
                                            id="preview1" alt="{{ $testimonial->person_image }}"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                    @else
                                        <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview1"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                    @endif
                                    <input class="ml-2 mt-2 form-control @error('person_image') is-invalid @enderror"
                                        type="file" name="person_image" id="person_image"
                                        accept="image/jpeg,image/png,image/jpg" value="{{ old('person_image') }}"
                                        onchange="document.getElementById('preview1').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                @error('person_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="person_statement">
                                    <h6>Statement <code>*</code></h6>
                                </label>
                                <textarea class="form-control ckeditor @error('person_statement') is-invalid @enderror" rows="3"
                                    id="person_statement" name="person_statement" placeholder="Type Here..." />{{ old('person_statement', $testimonial->person_statement ?? '') }}</textarea>
                                @error('person_statement')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="rating">
                                    <h6>Rating <code>*</code></h6>
                                </label>
                                <input type="number" name="rating" id="rating"
                                    class="form-control @error('rating') is-invalid @enderror" min="0" max="5"
                                    step="0.1" placeholder="e.g. 4.5"
                                    value="{{ old('rating', $testimonial->rating ?? '') }}">
                                @error('rating')
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
