@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Hostel Amenity</h1>
        <ul>
            <li>
                <a href="{{ route('hostelAdmin.hostel-amenity.index') }}" class="text-primary">Index</a>
            </li>
            <li>Edit</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('hostelAdmin.hostel-amenity.update', $amenity->slug) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="amenity_name">
                                    <h6>Amenity Name <code>*</code></h6>
                                </label>
                                <input class="form-control @error('amenity_name') is-invalid @enderror mt-3"
                                    id="amenity_name" name="amenity_name" type="text" placeholder="Enter name"
                                    value="{{ old('amenity_name', $amenity->amenity_name ?? '') }}" />
                                @error('amenity_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-2 mt-2">
                                <label class="form-label">
                                    <h6>Amenity Icon <code>*</code></h6>
                                </label>
                                <div class="d-flex justify-content-center align-items-center">
                                    <select name="amenity_icon" id="amenity_icon" class="form-control icon-dropdown"
                                        onchange="previewSelectedIcon(this)" required>
                                        <option value="">-- Select Icon --</option>
                                        @foreach ($icons as $icon)
                                            <option value="{{ $icon->icon_path }}"
                                                data-icon="{{ asset('storage/images/icons/' . $icon->icon_path) }}"
                                                {{ old('amenity_icon', $amenity->amenity_icon) == $icon->icon_path ? 'selected' : '' }}>
                                                {{ $icon->icon_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- Preview previously saved icon --}}
                                    <img src="{{ $amenity->amenity_icon ? asset('storage/images/icons/' . $amenity->amenity_icon) : asset('assets/images/noPreview.jpeg') }}"
                                        class="img-preview ml-2"
                                        style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" />
                                </div>

                                @error('amenity_icon')
                                    <div class="text-danger small mt-1">*{{ $message }}</div>
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
        function previewSelectedIcon(select) {
            const selectedOption = $(select).find(':selected');
            const iconUrl = selectedOption.data('icon');

            // Find the preview image inside the same .d-flex
            $(select).closest('.d-flex').find('.img-preview')
                .attr('src', iconUrl || "{{ asset('assets/images/noPreview.jpeg') }}");
        }
    </script>
@endsection
