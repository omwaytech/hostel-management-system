@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Amenity</h1>
        <ul>
            <li>
                <a href="{{ route('admin.amenity.index') }}" class="text-primary">Index</a>
            </li>
            <li>Create</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.amenity.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div id="amenityContainer">
                            @php
                                $oldAmenities = old('amenity', ['']);
                            @endphp

                            @foreach ($oldAmenities as $key => $amenity)
                                <div class="amenity-item rounded">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label">Amenity name <code>*</code></label>
                                            <input type="text" name="amenity[{{ $key }}][amenity_name]"
                                                class="form-control @error('amenity.' . $key . '.amenity_name') is-invalid @enderror"
                                                placeholder="Enter amenity name"
                                                value="{{ old('amenity.' . $key . '.amenity_name') }}">
                                            @error('amenity.' . $key . '.amenity_name')
                                                <div class="text-danger small mt-1">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 text-md-end">
                                            <button type="button"
                                                class="btn btn-danger btn-sm mt-4 removeAmenity">-</button>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-4 form-group">
                                            <div class="d-flex justify-content-center">
                                                <select name="amenity[{{ $key }}][amenity_icon]"
                                                    class="form-control @error('amenity.' . $key . '.amenity_icon') is-invalid @enderror icon-dropdown mt-3"
                                                    onchange="previewSelectedIcon(this)">
                                                    <option value="">-- Select Icon --</option>
                                                    @foreach ($icons as $icon)
                                                        <option value="{{ $icon->icon_path }}"
                                                            data-icon="{{ asset('storage/images/icons/' . $icon->icon_path) }}"
                                                            {{ old('amenity.' . $key . '.amenity_icon') == $icon->icon_path ? 'selected' : '' }}>
                                                            {{ $icon->icon_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                    class="img-preview ml-3 mt-2"
                                                    style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" />
                                            </div>
                                            @error('amenity.' . $key . '.amenity_icon')
                                                <div class="text-danger small mt-1">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary btn-sm" id="addMore">+ New</button>
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
        $(document).ready(function() {
            let amenityIndex = {{ count(old('amenity', [''])) }};

            $('#addMore').on('click', function() {
                let newAmenity = `
                <div class="amenity-item rounded">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Amenity Name <code>*</code></label>
                            <input type="text" name="amenity[${amenityIndex}][amenity_name]"
                                class="form-control" placeholder="Enter amenity name" required>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="d-flex justify-content-center">
                                <select name="amenity[${amenityIndex}][amenity_icon]" class="form-control icon-dropdown" onchange="previewSelectedIcon(this)" required>
                                    <option value="">-- Select Icon --</option>
                                    @foreach ($icons as $icon)
                                        <option value="{{ $icon->icon_path }}" data-icon="{{ asset('storage/images/icons/' . $icon->icon_path) }}">{{ $icon->icon_name }}</option>
                                    @endforeach
                                </select>
                                <img src="{{ asset('assets/images/noPreview.jpeg') }}" class="img-preview ml-2"
                                    style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" />
                            </div>
                        </div>

                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-danger btn-sm mt-4 removeAmenity">-</button>
                        </div>
                    </div>
                </div>
                `;
                $('#addMore').before(newAmenity);
                amenityIndex++;
            });

            // Remove amenity item
            $(document).on('click', '.removeAmenity', function() {
                $(this).closest('.amenity-item').remove();
            });
        });

        function previewSelectedIcon(select) {
            const selectedOption = $(select).find(':selected');
            const iconUrl = selectedOption.data('icon');
            $(select).closest('.col-md-4').find('.img-preview').attr('src', iconUrl ||
                "{{ asset('assets/images/noPreview.jpeg') }}");
        }
    </script>
@endsection
