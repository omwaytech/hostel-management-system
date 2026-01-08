@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Icon</h1>
        <ul>
            <li>
                <a href="{{ route('admin.icon.index') }}" class="text-primary">Index</a>
            </li>
            <li>Edit</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.icon.update', $icon->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="icon_name">
                                    <h6>Icon Name <code>*</code></h6>
                                </label>
                                <input class="form-control @error('icon_name') is-invalid @enderror" id="icon_name"
                                    name="icon_name" type="text" placeholder="Enter name"
                                    value="{{ old('icon_name', $icon->icon_name ?? '') }}" />
                                @error('icon_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group">
                                <label>
                                    <h6>Icon <code>*</code></h6>
                                </label><br>
                                <div class="d-flex justify-content-center">
                                    @if ($icon && $icon->icon_path)
                                        <img src="{{ asset('storage/images/icons/' . $icon->icon_path) }}" id="preview1"
                                            alt="{{ $icon->icon_path }}"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                    @else
                                        <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview1"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                    @endif
                                    <input class="ml-2 mt-2 form-control @error('icon_path') is-invalid @enderror"
                                        type="file" name="icon_path" id="icon_path"
                                        accept="image/jpeg,image/png,image/jpg" value="{{ old('icon_path') }}"
                                        onchange="document.getElementById('preview1').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                @error('icon_path')
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
