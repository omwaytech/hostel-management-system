@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Config</h1>
            <ul>
                <li><a href="{{ route('admin.config.index') }}"class="text-primary">Index</a></li>
                <li>Config</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <form action="{{ route('admin.config.update') }}" method="POST" enctype="multipart/form-data">
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
                                                <img src="{{ asset('storage/images/adminConfigImages/' . $configs['navbar_logo']) }}"
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

                    <!-- Banner Section -->
                    <div class="card text-left bg-white mb-3">
                        <div class="card-body">
                            <div class="form-section">
                                <h4 class="section-title text-center">Banner Section</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Banner Title</label>
                                        <input type="text" name="banner_title" class="form-control"
                                            value="{{ $configs['banner_title'] ?? '' }}" placeholder="Enter banner title">
                                        @error('banner_title')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Banner Subtitle</label>
                                        <input type="text" name="banner_subtitle" class="form-control"
                                            value="{{ $configs['banner_subtitle'] ?? '' }}"
                                            placeholder="Enter banner subtitle">
                                        @error('banner_subtitle')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Banner Image</label><br>
                                        <div class="d-flex justify-content-center">
                                            @if ($configs && isset($configs['banner_image']) && $configs['banner_image'])
                                                <img src="{{ asset('storage/images/adminConfigImages/' . $configs['banner_image']) }}"
                                                    id="preview_banner_image" alt="{{ $configs['banner_image'] }}"
                                                    style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                            @else
                                                <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                    id="preview_banner_image"
                                                    style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                    alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                            @endif
                                            <input
                                                class="ml-2 mt-2 form-control @error('banner_image') is-invalid @enderror"
                                                type="file" name="banner_image" accept="image/jpeg,image/png,image/jpg"
                                                value="{{ old('banner_image') }}"
                                                onchange="document.getElementById('preview_banner_image').src = window.URL.createObjectURL(this.files[0])">
                                        </div>
                                        @error('banner_image')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Section -->
                    <div class="card text-left bg-white mb-3">
                        <div class="card-body">
                            <div class="form-section">
                                <h4 class="section-title text-center">Statistics</h4>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Hostel Listed</label>
                                        <input type="number" name="hostel_listed" class="form-control"
                                            value="{{ $configs['hostel_listed'] ?? '' }}" placeholder="Eg: 50">
                                        @error('hostel_listed')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Happy Customers</label>
                                        <input type="number" name="happy_customers" class="form-control"
                                            value="{{ $configs['happy_customers'] ?? '' }}" placeholder="Eg: 1000">
                                        @error('happy_customers')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Trusted Owners</label>
                                        <input type="number" name="trusted_owners" class="form-control"
                                            value="{{ $configs['trusted_owners'] ?? '' }}" placeholder="Eg: 100">
                                        @error('trusted_owners')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Background Section -->
                    <div class="card text-left bg-white mb-3">
                        <div class="card-body">
                            <div class="form-section">
                                <h4 class="section-title text-center">Background Section</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Background Title</label>
                                        <input type="text" name="background_title" class="form-control"
                                            value="{{ $configs['background_title'] ?? '' }}" placeholder="Enter title">
                                        @error('background_title')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label>Background Description</label>
                                        <textarea name="background_description" class="form-control" placeholder="Type Here..." rows="5">{{ $configs['background_description'] ?? '' }}</textarea>
                                        @error('background_description')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Background Image</label><br>
                                        <div class="d-flex justify-content-center">
                                            @if ($configs && isset($configs['background_image']) && $configs['background_image'])
                                                <img src="{{ asset('storage/images/adminConfigImages/' . $configs['background_image']) }}"
                                                    id="preview_background_image"
                                                    alt="{{ $configs['background_image'] }}"
                                                    style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                            @else
                                                <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                    id="preview_background_image"
                                                    style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                    alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                            @endif
                                            <input
                                                class="ml-2 mt-2 form-control @error('background_image') is-invalid @enderror"
                                                type="file" name="background_image"
                                                accept="image/jpeg,image/png,image/jpg"
                                                value="{{ old('background_image') }}"
                                                onchange="document.getElementById('preview_background_image').src = window.URL.createObjectURL(this.files[0])">
                                        </div>
                                        @error('background_image')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Active Monthly Users</label>
                                        <input type="number" name="active_monthly_users" class="form-control"
                                            value="{{ $configs['active_monthly_users'] ?? '' }}" placeholder="Eg: 5000">
                                        @error('active_monthly_users')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
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
                                    <div class="col-md-4 mb-3">
                                        <label>Contact Phone</label>
                                        <input type="text" name="contact_phone" class="form-control"
                                            value="{{ $configs['contact_phone'] ?? '' }}"
                                            placeholder="Enter phone number">
                                        @error('contact_phone')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Email Address</label>
                                        <input type="email" name="email_address" class="form-control"
                                            value="{{ $configs['email_address'] ?? '' }}" placeholder="Enter email">
                                        @error('email_address')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Physical Address</label>
                                        <input type="text" name="physical_address" class="form-control"
                                            value="{{ $configs['physical_address'] ?? '' }}" placeholder="Enter address">
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
                                    <div class="col-md-6 mb-3">
                                        <label>Facebook</label>
                                        <input type="text" name="social_facebook" class="form-control"
                                            value="{{ $configs['social_facebook'] ?? '' }}"
                                            placeholder="Enter Facebook link">
                                        @error('social_facebook')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>WhatsApp</label>
                                        <input type="text" name="social_whatsapp" class="form-control"
                                            value="{{ $configs['social_whatsapp'] ?? '' }}"
                                            placeholder="Enter WhatsApp link">
                                        @error('social_whatsapp')
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
                                                <img src="{{ asset('storage/images/adminConfigImages/' . $configs['footer_logo']) }}"
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

                    <!-- About Image -->
                    <div class="card text-left bg-white mb-3">
                        <div class="card-body">
                            <div class="form-section">
                                <h4 class="section-title text-center">About Image</h4>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>About Image</label><br>
                                        <div class="d-flex justify-content-center">
                                            @if ($configs && isset($configs['about_image']) && $configs['about_image'])
                                                <img src="{{ asset('storage/images/adminConfigImages/' . $configs['about_image']) }}"
                                                    id="preview_about_image" alt="{{ $configs['about_image'] }}"
                                                    style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                            @else
                                                <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                    id="preview_about_image"
                                                    style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                    alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                            @endif
                                            <input
                                                class="ml-2 mt-2 form-control @error('about_image') is-invalid @enderror"
                                                type="file" name="about_image" accept="image/jpeg,image/png,image/jpg"
                                                value="{{ old('about_image') }}"
                                                onchange="document.getElementById('preview_about_image').src = window.URL.createObjectURL(this.files[0])">
                                        </div>
                                        @error('about_image')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-warning float-right"><i class="far fa-hand-point-up"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
