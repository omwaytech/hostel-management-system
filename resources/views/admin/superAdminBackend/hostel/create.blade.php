@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Hostel</h1>
            <ul>
                <li>
                    <a href="{{ route('admin.hostel.index') }}" class="text-primary">Index</a>
                </li>
                <li>{{ $hostel ? 'Edit' : 'Create' }}</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ $hostel ? route('admin.hostel.update', $hostel->slug) : route('admin.hostel.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($hostel)
                        @method('PUT')
                    @endif
                    <div class="card mb-4 bg-white">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="name">
                                        <h6>Hostel Name <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" type="text" placeholder="Enter page name"
                                        value="{{ old('name', $hostel->name ?? '') }}" />
                                    @error('name')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="contact">
                                        <h6>Contact <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('contact') is-invalid @enderror" id="contact"
                                        name="contact" type="number" placeholder="Enter contact"
                                        value="{{ old('contact', $hostel->contact ?? '') }}" />
                                    @error('contact')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="location">
                                        <h6>Location <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('location') is-invalid @enderror" id="location"
                                        name="location" type="text" placeholder="Enter location"
                                        value="{{ old('location', $hostel->location ?? '') }}" />
                                    @error('location')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="latitude">
                                        <h6>Latitude</h6>
                                    </label>
                                    <input class="form-control @error('latitude') is-invalid @enderror" id="latitude"
                                        name="latitude" type="text" placeholder="Enter latitude (e.g., 27.7172)"
                                        value="{{ old('latitude', $hostel->latitude ?? '') }}" />
                                    @error('latitude')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="longitude">
                                        <h6>Longitude</h6>
                                    </label>
                                    <input class="form-control @error('longitude') is-invalid @enderror" id="longitude"
                                        name="longitude" type="text" placeholder="Enter longitude (e.g., 85.3240)"
                                        value="{{ old('longitude', $hostel->longitude ?? '') }}" />
                                    @error('longitude')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="email">
                                        <h6>Email <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" type="email" placeholder="Enter email"
                                        value="{{ old('email', $hostel->email ?? '') }}" />
                                    @error('email')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="type">
                                        <h6>Type<code> *</code></h5>
                                    </label>
                                    <select class="form-control @error('type') is-invalid @enderror" name="type">
                                        <option value="" disabled selected>Select one</option>
                                        <option value="Boys"
                                            {{ old('type', $hostel->type ?? '') == 'Boys' ? 'selected' : '' }}>
                                            Boys
                                        </option>
                                        <option value="Girls"
                                            {{ old('type', $hostel->type ?? '') == 'Girls' ? 'selected' : '' }}>
                                            Girls
                                        </option>
                                        <option value="Co-ed"
                                            {{ old('type', $hostel->type ?? '') == 'Co-ed' ? 'selected' : '' }}>
                                            Co-ed
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>
                                        <h6>Logo <code>*</code></h6>
                                    </label><br>
                                    <div class="d-flex justify-content-center">
                                        @if ($hostel && $hostel->logo)
                                            <img src="{{ asset('storage/images/hostelLogos/' . $hostel->logo) }}"
                                                id="preview" alt="{{ $hostel->logo }}"
                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                        @else
                                            <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview"
                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                        @endif
                                        <input class="ml-2 mt-2 form-control @error('logo') is-invalid @enderror"
                                            type="file" name="logo" id="logo"
                                            accept="image/jpeg,image/png,image/jpg" value="{{ old('logo') }}"
                                            onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                                    </div>
                                    @error('logo')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="description">
                                        <h6>Description <code>*</code></h6>
                                    </label>
                                    <textarea class="form-control ckeditor @error('description') is-invalid @enderror" rows="6" id="description"
                                        name="description" placeholder="Type Here..." />{{ old('description', $hostel->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4 bg-white">
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    <h6>Select Amenities</h6>
                                </label>
                                <div class="row">
                                    @foreach ($amenities as $amenity)
                                        <div class="col-md-4">
                                            <label>
                                                <h6>
                                                    <input type="checkbox" name="amenities[]"
                                                        value="{{ $amenity->id }}"
                                                        {{ in_array($amenity->id, old('amenities', $hostel?->amenities?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                                                    <img src="{{ asset('storage/images/icons/' . $amenity->amenity_icon) }}"
                                                        alt="{{ $amenity->amenity_name }}"
                                                        style="width:20px; height:20px; border-radius:8px;"> |
                                                    {{ $amenity->amenity_name }}
                                                </h6>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4 bg-white">
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="image_uploads">
                                        <h6>Upload Image (Can be multiple) <code>*</code></h6>
                                    </label>
                                    <input type="file" name="image_uploads[]" id="imageInput" multiple
                                        accept="image/*" class="form-control mb-3" />
                                    @error('image_uploads')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div id="image-gallery-wrapper">
                                @if (isset($hostel->images))
                                    <div id="image-list" class="row gy-3 gx-2"> {{-- Only one row --}}
                                        @foreach ($hostel->images as $index => $image)
                                            <div class="col-md-4 image-item" data-index="{{ $index }}">
                                                <div class="border rounded p-2 h-100">
                                                    <img src="{{ asset('storage/images/hostelImages/' . $image->image) }}"
                                                        class="img-thumbnail mb-2 preview-image"
                                                        style="max-width: 100px; max-height: 100px;" alt="Image">
                                                    <input type="hidden"
                                                        name="images_data[{{ $index }}][existing]"
                                                        value="{{ $image->id }}">
                                                    <input type="hidden" name="images_data[{{ $index }}][image]"
                                                        value="{{ $image->image }}">

                                                    <input type="text"
                                                        name="images_data[{{ $index }}][caption]"
                                                        value="{{ $image->caption }}" placeholder="Image caption"
                                                        class="form-control mb-2" />

                                                    <button type="button"
                                                        class="btn btn-sm btn-danger remove-image">-</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div id="image-list" class="row gy-3">
                                        @if (old('images_data'))
                                            @foreach (old('images_data') as $index => $data)
                                                <div class="col-md-4 image-item" data-index="{{ $index }}">
                                                    <div class="border rounded p-2 h-100">
                                                        <input type="hidden"
                                                            name="images_data[{{ $index }}][image]"
                                                            value="{{ $data['image'] ?? '' }}">

                                                        <input type="text"
                                                            name="images_data[{{ $index }}][caption]"
                                                            value="{{ $data['caption'] ?? '' }}"
                                                            placeholder="Image caption"
                                                            class="form-control mb-1 @error("images_data.$index.caption") is-invalid @enderror" />
                                                        @error("images_data.$index.caption")
                                                            <div class="text-danger small">{{ $message }}
                                                            </div>
                                                        @enderror

                                                        <button type="button"
                                                            class="btn btn-sm btn-danger remove-image mt-2">-</button>
                                                    </div>
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
    </div>
@endsection

@section('script')
    <script>
        let imageIndex = {{ isset($hostel) && $hostel->images ? count($hostel->images) : 0 }};

        $('#imageInput').on('change', function(e) {
            const files = e.target.files;

            $.each(files, function(i, file) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    const preview = `
                        <div class="col-md-4 image-item" data-index="${imageIndex}">
                            <div class="border rounded p-2 h-100">
                                <img src="${event.target.result}" class="img-thumbnail mb-2" style="max-width: 100px; max-height: 100px;" alt="Preview">
                                <input type="hidden" name="images_data[${imageIndex}][image]" value="${file.name}">
                                <input type="text" name="images_data[${imageIndex}][caption]" placeholder="Image caption" class="form-control mb-2" />
                                <button type="button" class="btn btn-sm btn-danger remove-image">-</button>
                            </div>
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
