@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Feature</h1>
        <ul>
            <li>
                <a href="{{ route('hostelAdmin.hostel-feature.index') }}" class="text-primary">Index</a>
            </li>
            <li>Edit</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('hostelAdmin.hostel-feature.update', $feature->slug) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="feature_name" class="mb-3">
                                    <h6>Feature Name <code>*</code></h6>
                                </label>
                                <input class="form-control @error('feature_name') is-invalid @enderror" id="feature_name"
                                    name="feature_name" type="text" placeholder="Enter name"
                                    value="{{ old('feature_name', $feature->feature_name ?? '') }}" />
                                @error('feature_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-2 mt-2">
                                <label class="form-label">
                                    <h6>Feature Icon <code>*</code></h6>
                                </label>
                                <div class="d-flex justify-content-center align-items-center">
                                    <select name="feature_icon" id="feature_icon" class="form-control icon-dropdown"
                                        onchange="previewSelectedIcon(this)" required>
                                        <option value="">-- Select Icon --</option>
                                        @foreach ($icons as $icon)
                                            <option value="{{ $icon->icon_path }}"
                                                data-icon="{{ asset('storage/images/icons/' . $icon->icon_path) }}"
                                                {{ old('feature_icon', $feature->feature_icon) == $icon->icon_path ? 'selected' : '' }}>
                                                {{ $icon->icon_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- Preview previously saved icon --}}
                                    <img src="{{ $feature->feature_icon ? asset('storage/images/icons/' . $feature->feature_icon) : asset('assets/images/noPreview.jpeg') }}"
                                        class="img-preview ml-2"
                                        style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" />
                                </div>

                                @error('feature_icon')
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
