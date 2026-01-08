@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Blog</h1>
        <ul>
            <li>
                <a href="{{ route('admin.news-blog.index') }}" class="text-primary">Index</a>
            </li>
            <li>{{ $blog ? 'Edit' : 'Create' }}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ $blog ? route('admin.news-blog.update', $blog->slug) : route('admin.news-blog.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($blog)
                    @method('PUT')
                @endif
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="blog_title">
                                    <h6>Title <code>*</code></h6>
                                </label>
                                <input class="form-control @error('blog_title') is-invalid @enderror" id="blog_title"
                                    name="blog_title" type="text" placeholder="Enter title"
                                    value="{{ old('blog_title', $blog->blog_title ?? '') }}" />
                                @error('blog_title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="blog_badge">
                                    <h6>Badge <code>*</code></h6>
                                </label>
                                <input class="form-control @error('blog_badge') is-invalid @enderror" id="blog_badge"
                                    name="blog_badge" type="text" placeholder="Enter badge"
                                    value="{{ old('blog_badge', $blog->blog_badge ?? '') }}" />
                                @error('blog_badge')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="blog_time_to_read">
                                    <h6>Time to read (min) <code>*</code></h6>
                                </label>
                                <input class="form-control @error('blog_time_to_read') is-invalid @enderror"
                                    id="blog_time_to_read" name="blog_time_to_read" type="number" placeholder="Enter time"
                                    value="{{ old('blog_time_to_read', $blog->blog_time_to_read ?? '') }}" />
                                @error('blog_time_to_read')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label>
                                    <h6>News and Blog Image <code>*</code></h6>
                                </label><br>
                                <div class="d-flex justify-content-center">
                                    @if ($blog && $blog->blog_image)
                                        <img src="{{ asset('storage/images/blogImages/' . $blog->blog_image) }}"
                                            id="preview1" alt="{{ $blog->blog_image }}"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                    @else
                                        <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview1"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                    @endif
                                    <input class="ml-2 mt-2 form-control @error('blog_image') is-invalid @enderror"
                                        type="file" name="blog_image" id="blog_image"
                                        accept="image/jpeg,image/png,image/jpg" value="{{ old('blog_image') }}"
                                        onchange="document.getElementById('preview1').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                @error('blog_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="blog_description">
                                    <h6>Description <code>*</code></h6>
                                </label>
                                <textarea class="form-control ckeditor @error('blog_description') is-invalid @enderror" rows="3"
                                    id="blog_description" name="blog_description" placeholder="Type Here..." />{{ old('blog_description', $blog->blog_description ?? '') }}</textarea>
                                @error('blog_description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="blog_author_name">
                                    <h6>Author Name <code>*</code></h6>
                                </label>
                                <input class="form-control @error('blog_author_name') is-invalid @enderror"
                                    id="blog_author_name" name="blog_author_name" type="text" placeholder="Enter name"
                                    value="{{ old('blog_author_name', $blog->blog_author_name ?? '') }}" />
                                @error('blog_author_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label>
                                    <h6>Author Image <code>*</code></h6>
                                </label><br>
                                <div class="d-flex justify-content-center">
                                    @if ($blog && $blog->blog_author_image)
                                        <img src="{{ asset('storage/images/authorImages/' . $blog->blog_author_image) }}"
                                            id="preview2" alt="{{ $blog->blog_author_image }}"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                    @else
                                        <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview2"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                    @endif
                                    <input class="ml-2 mt-2 form-control @error('blog_author_image') is-invalid @enderror"
                                        type="file" name="blog_author_image" id="blog_author_image"
                                        accept="image/jpeg,image/png,image/jpg" value="{{ old('blog_author_image') }}"
                                        onchange="document.getElementById('preview2').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                @error('blog_author_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="page_title">
                                    <h6>Page Title</h6>
                                </label>
                                <input class="form-control @error('page_title') is-invalid @enderror" id="page_title"
                                    name="page_title" type="text" placeholder="Enter page title"
                                    value="{{ old('page_title', $blog->page_title ?? '') }}" />
                                @error('page_title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                @php
                                    $metaTagsRaw = old('meta_tags') ?? (isset($blog) ? $blog->meta_tags : '[]');

                                    $metaTagsArray = is_array($metaTagsRaw)
                                        ? $metaTagsRaw
                                        : json_decode($metaTagsRaw, true) ?? explode(',', $metaTagsRaw);

                                    $metaTagsArray = array_filter($metaTagsArray);
                                @endphp
                                <label for="meta_tags">
                                    <h6>Meta Tags</h6>
                                </label>
                                <div class="form-group">
                                    <div class="tagBox" data-tags-input-name="meta_tags" data-no-duplicate="true"
                                        data-pre-tags-separator="," data-no-duplicate-text="Duplicate tag"
                                        data-type-zone-class="type-zone" data-tag-box-class="tagging"
                                        data-edit-on-delete="false" data-tag-char="">
                                        {{ implode(',', $metaTagsArray) }}
                                    </div>
                                    <p class="text-muted">Type and press space or comma to add a tag.</p>
                                </div>
                                @error('meta_tags')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="meta_description">
                                    <h6>Meta Description</h6>
                                </label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" rows="3" id="meta_description"
                                    name="meta_description" placeholder="Type Here..." />{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
                                @error('meta_description')
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
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const scrollPos = {
                x: window.scrollX,
                y: window.scrollY
            };

            setTimeout(() => {
                document.activeElement.blur();
                window.scrollTo(scrollPos.x, scrollPos.y); // restore scroll position
            }, 50);
        });
    </script>
@endsection
