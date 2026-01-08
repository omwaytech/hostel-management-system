@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Icon</h1>
        <ul>
            <li>
                <a href="{{ route('admin.icon.index') }}" class="text-primary">Index</a>
            </li>
            <li>Create</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.icon.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div id="iconContainer">
                            @php
                                $oldIcons = old('icon', ['']);
                            @endphp

                            @foreach ($oldIcons as $key => $icon)
                                <div class="icon-item rounded">
                                    <div class="row align-items-center">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Icon name <code>*</code></label>
                                            <input type="text" name="icon[{{ $key }}][icon_name]"
                                                class="form-control @error('icon.' . $key . '.icon_name') is-invalid @enderror"
                                                placeholder="Enter icon name"
                                                value="{{ old('icon.' . $key . '.icon_name') }}">
                                            @error('icon.' . $key . '.icon_name')
                                                <div class="text-danger small mt-1">*{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Icon <code>*</code></label>
                                            <div class="d-flex align-items-center">
                                                <input type="file" name="icon[{{ $key }}][icon_path]"
                                                    class="form-control icon-icon mr-3" onchange="previewImage(this)">
                                                <img src="{{ asset('assets/images/noPreview.jpeg') }}" class="img-preview"
                                                    style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                    alt="Preview Image" />
                                            </div>
                                            @error('icon.' . $key . '.icon_path')
                                                <div class="text-danger small mt-1">*{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2 text-md-end">
                                            <button type="button" class="btn btn-danger btn-sm mt-3 removeIcon">-</button>
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
            let iconIndex = {{ count(old('icon', [''])) }};

            $('#addMore').on('click', function() {
                let newIcon = `
                <div class="icon-item rounded">
                    <div class="row align-items-center">
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Icon Name <code>*</code></label>
                            <input type="text" name="icon[${iconIndex}][icon_name]"
                                class="form-control" placeholder="Enter icon name" required>
                        </div>

                        <div class="col-md-3 mb-2">
                            <label class="form-label">Icon <code>*</code></label>
                            <div class="d-flex align-items-center">
                                <input type="file" name="icon[${iconIndex}][icon_path]"
                                    class="form-control mr-3" onchange="previewImage(this)">
                                <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                    class="img-preview"
                                    style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                    alt="Preview Image" />
                            </div>
                        </div>

                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-danger btn-sm mt-4 removeIcon">-</button>
                        </div>
                    </div>
                </div>
                `;
                $('#addMore').before(newIcon);
                iconIndex++;
            });

            // Remove icon item
            $(document).on('click', '.removeIcon', function() {
                $(this).closest('.icon-item').remove();
            });
        });

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $(input).closest('.d-flex').find('.img-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
