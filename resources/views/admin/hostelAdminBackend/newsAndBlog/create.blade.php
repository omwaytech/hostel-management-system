@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>News And Blog</h1>
        <ul>
            <li>
                <a href="{{ route('hostelAdmin.news-and-blog.index') }}" class="text-primary">Index</a>
            </li>
            <li>{{ $newsAndBlog ? 'Edit' : 'Create' }}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form
                action="{{ $newsAndBlog ? route('hostelAdmin.news-and-blog.update', $newsAndBlog->slug) : route('hostelAdmin.news-and-blog.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($newsAndBlog)
                    @method('PUT')
                @endif
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="hostel_id" id="hostel_id" value="{{ $hostelId }}">
                            <div class="col-md-6 form-group">
                                <label for="nb_title">
                                    <h6>Title <code>*</code></h6>
                                </label>
                                <input class="form-control @error('nb_title') is-invalid @enderror" id="nb_title"
                                    name="nb_title" type="text" placeholder="Enter title"
                                    value="{{ old('nb_title', $newsAndBlog->nb_title ?? '') }}" />
                                @error('nb_title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="nb_badge">
                                    <h6>Badge <code>*</code></h6>
                                </label>
                                <input class="form-control @error('nb_badge') is-invalid @enderror" id="nb_badge"
                                    name="nb_badge" type="text" placeholder="Enter badge"
                                    value="{{ old('nb_badge', $newsAndBlog->nb_badge ?? '') }}" />
                                @error('nb_badge')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="nb_time_to_read">
                                    <h6>Time to read (min) <code>*</code></h6>
                                </label>
                                <input class="form-control @error('nb_time_to_read') is-invalid @enderror"
                                    id="nb_time_to_read" name="nb_time_to_read" type="number" placeholder="Enter time"
                                    value="{{ old('nb_time_to_read', $newsAndBlog->nb_time_to_read ?? '') }}" />
                                @error('nb_time_to_read')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label>
                                    <h6>News and Blog Image <code>*</code></h6>
                                </label><br>
                                <div class="d-flex justify-content-center">
                                    @if ($newsAndBlog && $newsAndBlog->nb_image)
                                        <img src="{{ asset('storage/images/newsBlogImages/' . $newsAndBlog->nb_image) }}"
                                            id="preview1" alt="{{ $newsAndBlog->nb_image }}"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                    @else
                                        <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview1"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                    @endif
                                    <input class="ml-2 mt-2 form-control @error('nb_image') is-invalid @enderror"
                                        type="file" name="nb_image" id="nb_image"
                                        accept="image/jpeg,image/png,image/jpg" value="{{ old('nb_image') }}"
                                        onchange="document.getElementById('preview1').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                @error('nb_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="nb_description">
                                    <h6>Description <code>*</code></h6>
                                </label>
                                <textarea class="form-control ckeditor @error('nb_description') is-invalid @enderror" rows="3" id="nb_description"
                                    name="nb_description" placeholder="Type Here..." />{{ old('nb_description', $newsAndBlog->nb_description ?? '') }}</textarea>
                                @error('nb_description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="nb_author_name">
                                    <h6>Author Name <code>*</code></h6>
                                </label>
                                <input class="form-control @error('nb_author_name') is-invalid @enderror"
                                    id="nb_author_name" name="nb_author_name" type="text" placeholder="Enter name"
                                    value="{{ old('nb_author_name', $newsAndBlog->nb_author_name ?? '') }}" />
                                @error('nb_author_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label>
                                    <h6>Author Image <code>*</code></h6>
                                </label><br>
                                <div class="d-flex justify-content-center">
                                    @if ($newsAndBlog && $newsAndBlog->nb_author_image)
                                        <img src="{{ asset('storage/images/authorImages/' . $newsAndBlog->nb_author_image) }}"
                                            id="preview2" alt="{{ $newsAndBlog->nb_author_image }}"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                    @else
                                        <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview2"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                    @endif
                                    <input class="ml-2 mt-2 form-control @error('nb_author_image') is-invalid @enderror"
                                        type="file" name="nb_author_image" id="nb_author_image"
                                        accept="image/jpeg,image/png,image/jpg" value="{{ old('nb_author_image') }}"
                                        onchange="document.getElementById('preview2').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                @error('nb_author_image')
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
