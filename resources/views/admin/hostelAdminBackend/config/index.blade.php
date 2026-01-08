@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Hostel Configuration</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.config.index') }}" class="text-primary">Index</a></li>
                <li>Config</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <form action="{{ route('hostelAdmin.config.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Navbar Logo -->
                    <div class="card text-left bg-white mb-3">
                        <div class="card-body">
                            <div class="form-section">
                                <h4 class="section-title text-center">Navbar Logo</h4>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Navbar Logo</label><br>
                                        <div class="d-flex justify-content-center">
                                            @if ($configs && isset($configs['navbar_logo']) && $configs['navbar_logo'])
                                                <img src="{{ asset('storage/images/hostelConfigImages/' . $configs['navbar_logo']) }}"
                                                    id="preview_navbar_logo" alt="{{ $configs['navbar_logo'] }}"
                                                    style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                            @else
                                                <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                    id="preview_navbar_logo"
                                                    style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                    alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                            @endif
                                            <input class="ml-2 mt-2 form-control @error('navbar_logo') is-invalid @enderror"
                                                type="file" name="navbar_logo" accept="image/jpeg,image/png,image/jpg"
                                                value="{{ old('navbar_logo') }}"
                                                onchange="document.getElementById('preview_navbar_logo').src = window.URL.createObjectURL(this.files[0])">
                                        </div>
                                        @error('navbar_logo')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- About Section -->
                    <div class="card text-left bg-white mb-3">
                        <div class="card-body">
                            <div class="form-section">
                                <h4 class="section-title text-center">About Section</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>About Title</label>
                                        <input type="text" name="about_title" class="form-control"
                                            value="{{ $configs['about_title'] ?? '' }}" placeholder="Enter about title">
                                        @error('about_title')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label>About Description</label>
                                        <textarea name="about_description" class="form-control" placeholder="Type Here..." rows="5">{{ $configs['about_description'] ?? '' }}</textarea>
                                        @error('about_description')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Google Map -->
                    <div class="card text-left bg-white mb-3">
                        <div class="card-body">
                            <div class="form-section">
                                <h4 class="section-title text-center">Google Map</h4>
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <label>Google Map Embed Link</label>
                                        <input type="text" name="google_map_embed" class="form-control"
                                            value="{{ $configs['google_map_embed'] ?? '' }}"
                                            placeholder="Enter Google Map embed link">
                                        @error('google_map_embed')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Enter the complete iframe embed code or URL from
                                            Google Maps</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card text-left bg-white mb-3">
                        <div class="card-body">
                            <div class="form-section">
                                <h4 class="section-title text-center">Contact Information</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Contact Phone 1</label>
                                        <input type="text" name="contact_phone_1" class="form-control"
                                            value="{{ $configs['contact_phone_1'] ?? '' }}"
                                            placeholder="Enter primary phone number">
                                        @error('contact_phone_1')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Contact Phone 2</label>
                                        <input type="text" name="contact_phone_2" class="form-control"
                                            value="{{ $configs['contact_phone_2'] ?? '' }}"
                                            placeholder="Enter secondary phone number">
                                        @error('contact_phone_2')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label>Physical Address</label>
                                        <input type="text" name="physical_address" class="form-control"
                                            value="{{ $configs['physical_address'] ?? '' }}"
                                            placeholder="Enter physical address">
                                        @error('physical_address')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="card text-left bg-white mb-3">
                        <div class="card-body">
                            <div class="form-section">
                                <h4 class="section-title text-center">Social Media Links</h4>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>WhatsApp</label>
                                        <input type="text" name="social_whatsapp" class="form-control"
                                            value="{{ $configs['social_whatsapp'] ?? '' }}"
                                            placeholder="Enter WhatsApp link">
                                        @error('social_whatsapp')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Facebook</label>
                                        <input type="text" name="social_facebook" class="form-control"
                                            value="{{ $configs['social_facebook'] ?? '' }}"
                                            placeholder="Enter Facebook link">
                                        @error('social_facebook')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Instagram</label>
                                        <input type="text" name="social_instagram" class="form-control"
                                            value="{{ $configs['social_instagram'] ?? '' }}"
                                            placeholder="Enter Instagram link">
                                        @error('social_instagram')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Section -->
                    <div class="card text-left bg-white mb-3">
                        <div class="card-body">
                            <div class="form-section">
                                <h4 class="section-title text-center">Footer Section</h4>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Footer Logo</label><br>
                                        <div class="d-flex justify-content-center">
                                            @if ($configs && isset($configs['footer_logo']) && $configs['footer_logo'])
                                                <img src="{{ asset('storage/images/hostelConfigImages/' . $configs['footer_logo']) }}"
                                                    id="preview_footer_logo" alt="{{ $configs['footer_logo'] }}"
                                                    style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                            @else
                                                <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                    id="preview_footer_logo"
                                                    style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                    alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                            @endif
                                            <input
                                                class="ml-2 mt-2 form-control @error('footer_logo') is-invalid @enderror"
                                                type="file" name="footer_logo" accept="image/jpeg,image/png,image/jpg"
                                                value="{{ old('footer_logo') }}"
                                                onchange="document.getElementById('preview_footer_logo').src = window.URL.createObjectURL(this.files[0])">
                                        </div>
                                        @error('footer_logo')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label>Footer Description</label>
                                        <textarea name="footer_description" class="form-control" placeholder="Type Here..." rows="5">{{ $configs['footer_description'] ?? '' }}</textarea>
                                        @error('footer_description')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-warning float-right"><i class="far fa-hand-point-up"></i>
                            Update Configuration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
