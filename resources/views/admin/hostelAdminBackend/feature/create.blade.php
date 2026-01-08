@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Feature</h1>
        <ul>
            <li>
                <a href="{{ route('hostelAdmin.hostel-feature.index') }}" class="text-primary">Index</a>
            </li>
            <li>Create</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('hostelAdmin.hostel-feature.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <input type="hidden" name="hostel_id" id="hostel_id" value="{{ $hostelId }}">
                        <div id="featureContainer">
                            @php
                                $oldFeatures = old('feature', ['']);
                            @endphp

                            @foreach ($oldFeatures as $key => $feature)
                                <div class="feature-item rounded">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 mb-2 form-group">
                                            <label class="form-label">
                                                <h6>Feature name <code>*</code></h6>
                                            </label>
                                            <input type="text" name="feature[{{ $key }}][feature_name]"
                                                class="form-control @error('feature.' . $key . '.feature_name') is-invalid @enderror mt-1"
                                                placeholder="Enter feature name"
                                                value="{{ old('feature.' . $key . '.feature_name') }}">
                                            @error('feature.' . $key . '.feature_name')
                                                <div class="text-danger small mt-1">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 text-md-end mt-4">
                                            <button type="button" class="btn btn-danger btn-sm removeFeature">-</button>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-4 mb-2 form-group">
                                            <div class="d-flex justify-content-center">
                                                <select name="feature[{{ $key }}][feature_icon]"
                                                    class="form-control @error('feature.' . $key . '.feature_icon') is-invalid @enderror icon-dropdown mt-3"
                                                    onchange="previewSelectedIcon(this)">
                                                    <option value="">-- Select Icon --</option>
                                                    @foreach ($icons as $icon)
                                                        <option value="{{ $icon->icon_path }}"
                                                            data-icon="{{ asset('storage/images/icons/' . $icon->icon_path) }}"
                                                            {{ old('feature.' . $key . '.feature_icon') == $icon->icon_path ? 'selected' : '' }}>
                                                            {{ $icon->icon_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                    class="img-preview ml-3"
                                                    style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" />
                                            </div>
                                            @error('feature.' . $key . '.feature_icon')
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
            let featureIndex = {{ count(old('feature', [''])) }};

            $('#addMore').on('click', function() {
                let newFeature = `
                <div class="feature-item rounded">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><h6>Feature Name <code>*</code></h6></label>
                            <input type="text" name="feature[${featureIndex}][feature_name]"
                                class="form-control" placeholder="Enter feature name" required>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="d-flex justify-content-center">
                                <select name="feature[${featureIndex}][feature_icon]" class="form-control icon-dropdown" onchange="previewSelectedIcon(this)" required>
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
                            <button type="button" class="btn btn-danger btn-sm removeFeature">-</button>
                        </div>
                    </div>
                </div>
                `;
                $('#addMore').before(newFeature);
                featureIndex++;
            });

            // Remove feature item
            $(document).on('click', '.removeFeature', function() {
                $(this).closest('.feature-item').remove();
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
