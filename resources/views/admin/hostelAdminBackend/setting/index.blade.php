@extends('admin.layouts.hostelAdminBackend')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .settings-container {
        max-width: 800px;
        margin: 2rem auto;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        object-fit: cover;
    }

    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 2px solid transparent;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
        border-bottom: 2px solid #0d6efd;
        background: none;
    }

    .tab-content {
        padding: 2rem 0;
    }

    .form-section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
</style>
@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Settings</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.setting.index', $user->slug) }}" class="text-primary">Index</a></li>
                <li>Manage your account settings and preferences</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs justify-content-center" id="settingsTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                    type="button" role="tab" aria-controls="profile" aria-selected="true">
                    <i class="bi bi-person me-2"></i>User Profile
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button"
                    role="tab" aria-controls="email" aria-selected="false">
                    <i class="bi bi-envelope me-2"></i>Change Email
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button"
                    role="tab" aria-controls="password" aria-selected="false">
                    <i class="bi bi-lock me-2"></i>Change Password
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="settingsTabContent">
            <!-- User Profile Tab -->
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="card">
                    <div class="card-body">
                        <!-- Profile Picture Section -->
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                <img src="{{ $user->photo ? asset('storage/images/userPhotos/' . $user->photo) : asset('assets/images/user.jpg') }}"
                                    alt="Profile Picture" class="rounded-circle profile-avatar mb-3">
                                <div>
                                    <a href="{{ route('hostelAdmin.user.edit', $user->slug) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i> Edit Profile
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="col-lg-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">
                                                        Full Name
                                                    </p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0">{{ $user->name }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">Gender</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0">{{ $user->gender ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">Email</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0">{{ $user->email }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">Phone</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0">{{ $user->contact_number ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">Permanent Address</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0">{{ $user->permanent_address ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">Role</p>
                                                </div>
                                                @php
                                                    $hostelUser = Auth::user()
                                                        ->hostels()
                                                        ->withPivot('role_id')
                                                        ->first();
                                                    if ($hostelUser->pivot->role_id == 2) {
                                                        $role = 'Hostel Admin';
                                                    } elseif ($hostelUser->pivot->role_id == 3) {
                                                        $role = 'Hostel Warden';
                                                    }
                                                @endphp
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0">{{ $role }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="form-section">
                        <h6 class="mb-3">Account Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Member Since:</strong>
                                {{ $user->created_at->format('M d, Y') }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Account Status:</strong>
                                <span class="badge bg-success">Active</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        {{-- <button type="button" class="btn btn-primary">
                                <i class="bi bi-pencil me-1"></i>Edit Profile
                            </button> --}}
                    </div>
                </div>
            </div>
            <!-- Change Email Tab -->
            <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <div class="w-100" style="max-width: 500px;">
                            <div class="card shadow-sm p-4">

                                <h5 class="card-title mb-4 text-center">Change Email Address</h5>
                                <form action="{{ route('hostelAdmin.setting.updateEmail') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12 mb-3">
                                        <label for="currentEmailDisplay" class="form-label">Current Email</label>
                                        <input type="email" class="form-control" id="currentEmailDisplay"
                                            value="{{ $user->email }}" readonly>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="newEmail" class="form-label">New Email Address</label>
                                        <input type="email" class="form-control @error('newEmail') is-invalid @enderror"
                                            id="newEmail" name="new_email" placeholder="Enter your new email address"
                                            required>
                                        <div class="form-text">Make sure you have access to this email address.</div>
                                        @error('newEmail')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="confirmNewEmail" class="form-label">Confirm New Email</label>
                                        <input type="email"
                                            class="form-control @error('confirmNewEmail') is-invalid @enderror"
                                            id="confirmNewEmail" placeholder="Confirm your new email address" required>
                                        @error('confirmNewEmail')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label for="passwordForEmail" class="form-label">Current Password</label>
                                        <input type="password"
                                            class="form-control @error('passwordForEmail') is-invalid @enderror"
                                            id="passwordForEmail" placeholder="Enter your current password" required>
                                        <div class="form-text">Required for security verification.</div>
                                        @error('passwordForEmail')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="submit" class="btn btn-primary" id="updateEmailBtn" disabled>
                                            <i class="bi bi-envelope-check me-1"></i>Update Email
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Change Password Tab -->
            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <div class="w-100" style="max-width: 500px;">
                            <div class="card shadow-sm p-4">
                                <h5 class="card-title mb-4 text-center">Change Password</h5>

                                <div class="alert alert-warning text-center" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Choose a strong password with at least 8 characters, including uppercase, lowercase,
                                    numbers,
                                    and special characters.
                                </div>

                                <form action="{{ route('hostelAdmin.setting.updatePassword') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12 mb-3">
                                        <label for="currentPassword" class="form-label">Current Password</label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control @error('currentPassword') is-invalid @enderror"
                                                id="currentPassword" placeholder="Enter your current password" required>
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('currentPassword')">
                                                <i class="bi bi-eye" id="currentPassword-icon"></i>
                                            </button>
                                        </div>
                                        @error('currentPassword')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="newPassword" class="form-label">New Password</label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control @error('newPassword') is-invalid @enderror"
                                                id="newPassword" name="new_password"
                                                placeholder="Enter your new password" disabled required>
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('newPassword')">
                                                <i class="bi bi-eye" id="newPassword-icon"></i>
                                            </button>
                                        </div>
                                        <div id="newPasswordError" class="text-danger mt-1" style="display:none;">
                                        </div>
                                        @error('newPassword')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control @error('confirmPassword') is-invalid @enderror"
                                                id="confirmPassword" placeholder="Confirm your new password" disabled
                                                required>
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('confirmPassword')">
                                                <i class="bi bi-eye" id="confirmPassword-icon"></i>
                                            </button>
                                        </div>
                                        @error('confirmPassword')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password Strength Indicator -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Password Strength</label>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 25%"
                                                id="passwordStrength"></div>
                                        </div>
                                        <small class="text-muted" id="passwordStrengthText">Weak</small>
                                    </div>

                                    <div class="d-flex gap-2 justify-content-center">
                                        <button type="submit" class="btn btn-primary" id="updatePasswordBtn" disabled>
                                            <i class="bi bi-shield-lock me-1"></i>Update Password
                                        </button>
                                        {{-- <button type="button" class="btn btn-outline-secondary">Cancel</button> --}}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- password --}}
    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                field.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        // Password strength checker
        document.getElementById('newPassword').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('passwordStrengthText');

            let strength = 0;
            let strengthLabel = 'Very Weak';
            let strengthClass = 'bg-danger';

            // Check password criteria
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            // Update strength indicator
            switch (strength) {
                case 0:
                case 1:
                    strengthLabel = 'Very Weak';
                    strengthClass = 'bg-danger';
                    break;
                case 2:
                    strengthLabel = 'Weak';
                    strengthClass = 'bg-warning';
                    break;
                case 3:
                    strengthLabel = 'Fair';
                    strengthClass = 'bg-info';
                    break;
                case 4:
                    strengthLabel = 'Good';
                    strengthClass = 'bg-primary';
                    break;
                case 5:
                    strengthLabel = 'Strong';
                    strengthClass = 'bg-success';
                    break;
            }

            strengthBar.style.width = (strength * 20) + '%';
            strengthBar.className = 'progress-bar ' + strengthClass;
            strengthText.textContent = strengthLabel;
        });
    </script>
    {{-- verify password --}}
    <script>
        $(document).ready(function() {
            $('#passwordForEmail').on('keyup', function() {
                const password = $(this).val();

                if (password.length >= 6) {
                    $.ajax({
                        url: "{{ route('hostelAdmin.setting.verifyPassword') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            password: password
                        },
                        success: function(response) {
                            if (response.valid) {
                                $('#updateEmailBtn').prop('disabled', false);
                            } else {
                                $('#updateEmailBtn').prop('disabled', true);
                            }
                        },
                        error: function() {
                            $('#updateEmailBtn').prop('disabled', true);
                        }
                    });
                } else {
                    $('#updateEmailBtn').prop('disabled', true);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const $currentPassword = $('#currentPassword');
            const $newPassword = $('#newPassword');
            const $confirmPassword = $('#confirmPassword');
            const $updateBtn = $('#updatePasswordBtn');

            // Inject error placeholder
            if ($('#newPasswordError').length === 0) {
                $newPassword.after(
                    '<div id="newPasswordError" class="text-danger mt-1" style="display:none;"></div>');
            }

            // Check current password validity
            $currentPassword.on('keyup', function() {
                const currentVal = $(this).val();

                if (currentVal.length >= 6) {
                    $.ajax({
                        url: "{{ route('hostelAdmin.setting.verifyPassword') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            password: currentVal
                        },
                        success: function(response) {
                            if (response.valid) {
                                $newPassword.prop('disabled', false);
                                $confirmPassword.prop('disabled', false);
                            } else {
                                $newPassword.val('').prop('disabled', true);
                                $confirmPassword.val('').prop('disabled', true);
                                $updateBtn.prop('disabled', true);
                            }

                            validateMatchingPasswords();
                        },
                        error: function() {
                            $newPassword.val('').prop('disabled', true);
                            $confirmPassword.val('').prop('disabled', true);
                            $updateBtn.prop('disabled', true);
                        }
                    });
                } else {
                    $newPassword.val('').prop('disabled', true);
                    $confirmPassword.val('').prop('disabled', true);
                    $updateBtn.prop('disabled', true);
                    $('#newPasswordError').hide();
                }
            });

            // On input change, validate all
            $newPassword.on('keyup', validateMatchingPasswords);
            $confirmPassword.on('keyup', validateMatchingPasswords);

            function validateMatchingPasswords() {
                const currentVal = $currentPassword.val();
                const newVal = $newPassword.val();
                const confirmVal = $confirmPassword.val();

                if (newVal === currentVal && newVal !== '') {
                    $('#newPasswordError')
                        .text('New password must be different from current password.')
                        .show();
                    $updateBtn.prop('disabled', true);
                    return;
                } else {
                    $('#newPasswordError').hide();
                }

                if (newVal.length >= 6 && newVal === confirmVal) {
                    $updateBtn.prop('disabled', false);
                } else {
                    $updateBtn.prop('disabled', true);
                }
            }
        });
    </script>
@endsection
