@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>About</h1>
        <ul>
            <li>
                <a href="{{ route('admin.system-about.index') }}" class="text-primary">Index</a>
            </li>
            <li>{{ $about ? 'Edit' : 'Create' }}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form
                action="{{ $about ? route('admin.system-about.update', $about->slug) : route('admin.system-about.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($about)
                    @method('PUT')
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="about_title">
                                    <h6>Title <code>*</code></h6>
                                </label>
                                <input class="form-control @error('about_title') is-invalid @enderror" id="about_title"
                                    name="about_title" type="text" placeholder="Enter title"
                                    value="{{ old('about_title', $about->about_title ?? '') }}" />
                                @error('about_title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="about_description">
                                    <h6>Description <code>*</code></h6>
                                </label>
                                <textarea class="form-control ckeditor @error('about_description') is-invalid @enderror" rows="6"
                                    id="about_description" name="about_description" placeholder="Type Here..." />{{ old('about_description', $about->about_description ?? '') }}</textarea>
                                @error('about_description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="about_mission">
                                    <h6>Mission <code>*</code></h6>
                                </label>
                                <textarea class="form-control @error('about_mission') is-invalid @enderror" rows="6" id="about_mission"
                                    name="about_mission" placeholder="Type Here..." />{{ old('about_mission', $about->about_mission ?? '') }}</textarea>
                                @error('about_mission')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="about_vision">
                                    <h6>Vision <code>*</code></h6>
                                </label>
                                <textarea class="form-control @error('about_vision') is-invalid @enderror" rows="6" id="about_vision"
                                    name="about_vision" placeholder="Type Here..." />{{ old('about_vision', $about->about_vision ?? '') }}</textarea>
                                @error('about_vision')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="about_vision">
                                    <h6>Value <code>*</code></h6>
                                </label>
                                <div id="valueContainer">
                                    @if (isset($about->values))
                                        @if (old('value'))
                                            @foreach (old('value') as $key => $value)
                                                <div class="value-item">
                                                    <div class="row">
                                                        <input type="hidden" name="value[{{ $key }}][id]"
                                                            value="{{ $value['id'] ?? '' }}" />

                                                        <div class="col-md-6 form-group mb-3">
                                                            <label for="value_title">
                                                                <h6>Title <code>*</code></h6>
                                                            </label>
                                                            <input
                                                                class="form-control @error('value.' . $key . '.value_title') is-invalid @enderror"
                                                                id="value_title"
                                                                name="value[{{ $key }}][value_title]"
                                                                type="text" placeholder="Enter title"
                                                                value="{{ $value['value_title'] ?? '' }}" />
                                                            @error('value.' . $key . '.value_title')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-10 ml-3">
                                                            <label>Upload Image <code>*</code></label>
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <input type="file"
                                                                    name="value[{{ $key }}][value_icon]"
                                                                    class="form-control @error('value[{{ $key }}][value_icon]') is-invalid @enderror mr-3"
                                                                    onchange="previewImage(this, 'static')">
                                                                <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                                    id="preview-static"
                                                                    style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                                    alt="Preview Image" />
                                                            </div>
                                                            @error('value.' . $key . '.value_icon')
                                                                <div class="text-danger">
                                                                    *{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-12 form-group mb-3">
                                                            <label for="value_description">
                                                                <h6>Description <code>*</code></h6>
                                                            </label>
                                                            <textarea class="form-control @error('value.' . $key . '.value_description') is-invalid @enderror" rows="3"
                                                                id="value_description" name="value[{{ $key }}][value_description]" placeholder="Type Here..." />{{ $value['value_description'] ?? '' }}</textarea>
                                                            @error('value.' . $key . '.value_description')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @elseif (isset($about->values))
                                            @foreach ($about->values->where('is_deleted', 0) as $index => $value)
                                                <div class="value-item mt-2">
                                                    <div class="row">
                                                        <input type="hidden" name="value[{{ $value->id }}][id]"
                                                            value="{{ $value->id }}" />

                                                        <div class="col-md-5 form-group mb-3">
                                                            <label for="value_title">
                                                                <h6>Title <code>*</code></h6>
                                                            </label>
                                                            <input
                                                                class="form-control @error('value.' . $value->id . '.value_title') is-invalid @enderror"
                                                                id="value_title"
                                                                name="value[{{ $value->id }}][value_title]"
                                                                type="text" placeholder="Enter title"
                                                                value="{{ $value->value_title }}" />
                                                            @error('value.' . $value->id . '.value_title')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4 form-group mb-3">
                                                            <label>Upload Image </label>
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <input type="file"
                                                                    name="value[{{ $index }}][value_icon]"
                                                                    class="form-control @error('value.' . $index . '.value_icon') is-invalid @enderror mr-3"
                                                                    onchange="previewStoredImage(this, {{ $value->id }})">
                                                                <img src="{{ $value->value_icon ? asset('storage/images/valueImages/' . $value->value_icon) : asset('assets/images/noPreview.jpeg') }}"
                                                                    id="imagePreview-{{ $value->id }}"
                                                                    style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                                    alt="Preview Image" />
                                                            </div>
                                                            @error('value.' . $index . '.value_icon')
                                                                <div class="text-danger">
                                                                    *{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-2 form-group d-flex align-items-center">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm mt-3 remove-value">-</button>
                                                        </div>
                                                        <div class="col-md-12 form-group mb-3">
                                                            <label for="value_description">
                                                                <h6>Description <code>*</code></h6>
                                                            </label>
                                                            <textarea class="form-control @error('value.' . $value->id . '.value_description') is-invalid @enderror"
                                                                rows="3" id="value_description" name="value[{{ $value->id }}][value_description]"
                                                                placeholder="Type Here..." />{{ $value->value_description }}</textarea>
                                                            @error('value.' . $value->id . '.value_description')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @else
                                        @foreach (old('value', []) as $key => $value)
                                            <div class="value-item">
                                                <div class="row">
                                                    <input type="hidden" name="value[{{ $key }}][id]"
                                                        value="{{ $key }}" />
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label for="value_title">
                                                            <h6>Title <code>*</code></h6>
                                                        </label>
                                                        <input
                                                            class="form-control @error('value.' . $key . '.value_title') is-invalid @enderror"
                                                            id="value_title"
                                                            name="value[{{ $key }}][value_title]" type="text"
                                                            placeholder="Enter title"
                                                            value="{{ old('value.' . $key . '.value_title') }}" />
                                                        @error('value.' . $key . '.value_title')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4 form-group mb-3">
                                                        <label>Upload Image <code>*</code></label>
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <input type="file"
                                                                name="value[{{ $key }}][value_icon]"
                                                                class="form-control @error('value[{{ $key }}][value_icon]') is-invalid @enderror mr-3"
                                                                onchange="previewImage(this, 'static')">
                                                            <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                                id="preview-static"
                                                                style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                                alt="Preview Image" />
                                                        </div>
                                                        @error('value.' . $key . '.value_icon')
                                                            <div class="text-danger">
                                                                *{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12 form-group mb-3">
                                                        <label for="value_description">
                                                            <h6>Description <code>*</code></h6>
                                                        </label>
                                                        <textarea class="form-control @error('value.' . $key . '.value_description') is-invalid @enderror" rows="3"
                                                            id="value_description" name="value[{{ $key }}][value_description]" placeholder="Type Here..." />{{ old('value.' . $key . '.value_description') }}</textarea>
                                                        @error('value.' . $key . '.value_description')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-primary btn-sm ms-2 mt-2 mb-2" id="add-value">+
                                    New
                                </button>
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
        $(document).ready(function() {
            let newValueCount = 0;

            function addValueItem() {
                const newIndex = `new_${newValueCount++}`;
                let valueItem = `
                    <div class="value-item" data-index="${newIndex}">

                        <div class="row">
                            <div class="col-md-5 form-group mb-3">
                                <label><h6>Title<code> *</code></h6></label>
                                <input class="form-control" name="value[${newIndex}][value_title]" type="text" placeholder="Enter title" />
                            </div>
                            <div class="col-md-4 ml-3">
                                <label>Upload Image <code>*</code></label>
                                <div class="d-flex align-items-center">
                                    <input type="file"
                                        name="value[${newIndex}][value_icon]"
                                        class="form-control mr-3"
                                        onchange="previewImage(this, '${newIndex}')">
                                    <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                        id="preview-${newIndex}"
                                        style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                        alt="Default Image" />
                                </div>
                            </div>
                            <div class="col-md-2 form-group d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm mt-3 remove-value">-</button>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label><h6>Description<code> *</code></h6></label>
                                <textarea class="form-control" rows="3" name="value[${newIndex}][value_description]" placeholder="Type here..."></textarea>
                            </div>
                        </div>
                    </div>
                `;
                $('#valueContainer').append(valueItem);
            }

            if ($(".value-item").length === 0) {
                addValueItem();
            }

            $('#add-value').on('click', function() {
                addValueItem();
            });

            $(document).on('click', '.remove-value', function() {
                $(this).closest('.value-item').remove();
            });
        });

        function previewImage(input, newIndex) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(`preview-${newIndex}`);
                    if (preview) {
                        preview.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        function previewStoredImage(input, id) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(`imagePreview-${id}`);
                    if (preview) {
                        preview.src = e.target.result; // show new image instantly
                    }
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
