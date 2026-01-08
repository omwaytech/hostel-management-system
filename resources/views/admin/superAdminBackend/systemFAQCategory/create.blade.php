@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>FAQ Category</h1>
        <ul>
            <li>
                <a href="{{ route('admin.system-faq-category.index') }}" class="text-primary">Index</a>
            </li>
            <li>{{ $category ? 'Edit' : 'Create' }}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form
                action="{{ $category ? route('admin.system-faq-category.update', $category->slug) : route('admin.system-faq-category.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($category)
                    @method('PUT')
                @endif
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="category_name">
                                    <h6>Category Name <code>*</code></h6>
                                </label>
                                <input class="form-control @error('category_name') is-invalid @enderror" id="category_name"
                                    name="category_name" type="text" placeholder="Enter name"
                                    value="{{ old('category_name', $category->category_name ?? '') }}" />
                                @error('category_name')
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
