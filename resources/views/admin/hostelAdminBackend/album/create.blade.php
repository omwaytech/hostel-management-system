@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Album</h1>
        <ul>
            <li>
                <a href="{{ route('hostelAdmin.album.index') }}" class="text-primary">Index</a>
            </li>
            <li>{{ $album ? 'Edit' : 'Create' }}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ $album ? route('hostelAdmin.album.update', $album->slug) : route('hostelAdmin.album.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($album)
                    @method('PUT')
                @endif
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="hostel_id" id="hostel_id" value="{{ $hostelId }}">
                            <div class="col-md-6 form-group">
                                <label for="album_name">
                                    <h6>Album Name <code>*</code></h6>
                                </label>
                                <input class="form-control @error('album_name') is-invalid @enderror" id="album_name"
                                    name="album_name" type="text" placeholder="Enter title"
                                    value="{{ old('album_name', $album->album_name ?? '') }}" />
                                @error('album_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label>
                                    <h6>Cover Image <code>*</code></h6>
                                </label><br>
                                <div class="d-flex justify-content-center">
                                    @if ($album && $album->album_cover)
                                        <img src="{{ asset('storage/images/albumImages/' . $album->album_cover) }}"
                                            id="preview1" alt="{{ $album->album_cover }}"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                    @else
                                        <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview1"
                                            style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                    @endif
                                    <input class="ml-2 mt-2 form-control @error('album_cover') is-invalid @enderror"
                                        type="file" name="album_cover" id="album_cover"
                                        accept="image/jpeg,image/png,image/jpg" value="{{ old('album_cover') }}"
                                        onchange="document.getElementById('preview1').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                @error('album_cover')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="image_uploads">
                                    <h6>Upload Image (Can be multiple, 1 MB max each) <code>*</code></h6>
                                </label>
                                <input type="file" name="image_uploads[]" id="imageInput" multiple accept="image/*"
                                    class="form-control mb-3" />
                                @error('image_uploads')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                                @foreach ($errors->getMessages() as $key => $messages)
                                    @if (Str::startsWith($key, 'image_uploads.'))
                                        @foreach ($messages as $message)
                                            <div class="text-danger" data-error-for="{{ $key }}">
                                                {{ $message }}</div>
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div id="image-gallery-wrapper">
                            @if (isset($album->images))
                                <div id="image-list" class="row gy-3 gx-2"> {{-- Only one row --}}
                                    @foreach ($album->images as $index => $image)
                                        <div class="col-md-2 image-item" data-index="{{ $index }}">
                                            <img src="{{ asset('storage/images/albumImages/' . $image->gallery_image) }}"
                                                class="img-thumbnail mb-2 preview-image"
                                                style="width: 100px; height: 100px; object-fit: cover;" alt="Image">

                                            <input type="hidden" name="images_data[{{ $index }}][existing]"
                                                value="{{ $image->id }}">
                                            <input type="hidden" name="images_data[{{ $index }}][image]"
                                                value="{{ $image->image }}">
                                            <button type="button" class="btn btn-sm btn-danger remove-image">-</button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div id="image-list" class="row gy-3">
                                    @if (old('images_data'))
                                        @foreach (old('images_data') as $index => $data)
                                            <div class="col-md-3 image-item" data-index="{{ $index }}">
                                                <input type="hidden" name="images_data[{{ $index }}][image]"
                                                    value="{{ $data['image'] ?? '' }}">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger remove-image mt-2">-</button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endif
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
        let imageIndex = {{ isset($album) ? count($album->images) : 0 }};

        $('#imageInput').on('change', function(e) {
            const files = e.target.files;

            $.each(files, function(i, file) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    const preview = `
                        <div class="col-md-2 image-item" data-index="${imageIndex}">
                            <img src="${event.target.result}"
                                class="img-thumbnail mb-2"
                                style="width: 100px; height: 100px; object-fit: cover;"
                                alt="Preview">
                            <input type="hidden" name="images_data[${imageIndex}][image]" value="${file.name}">
                            <button type="button" class="btn btn-sm btn-danger remove-image">-</button>
                        </div>
                    `;
                    $('#image-list').append(preview);

                    imageIndex++;
                };

                reader.readAsDataURL(file);
            });
        });

        $('#image-list').on('click', '.remove-image', function() {
            $(this).closest('.image-item').remove();
        });
    </script>
@endsection
