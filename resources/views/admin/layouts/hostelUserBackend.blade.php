<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Resident Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dist-assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist-assets/css/themes/lite-purple.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dist-assets/css/plugins/perfect-scrollbar.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dist-assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist-assets/css/plugins/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/data-table-bg-color.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/input-field-color.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dist-assets/css/themes/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/swalbtn.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/dark-mode.css') }}" />
</head>

<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large">
        <div class="main-header d-flex align-items-center justify-content-between">
            <div class="logo">
                <a href="{{ route('resident.dashboard') }}">
                    @if (
                        $resident &&
                            $resident->bed &&
                            $resident->bed->room &&
                            $resident->bed->room->floor &&
                            $resident->bed->room->floor->block &&
                            $resident->bed->room->floor->block->hostel)
                        <img src="{{ asset('storage/images/hostelLogos/' . $resident->bed->room->floor->block->hostel->logo) }}"
                            alt="Hostel Logo" style="width: 50px; height: auto;">
                    @else
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo"
                            style="width: 50px; height: auto;">
                    @endif
                </a>
            </div>
            <div class="menu-toggle d-flex flex-column justify-content-center align-items-center"
                style="cursor: pointer;">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="flex-grow-1 text-center">
                <h2 class="mb-0 text-primary">
                    {{-- @if ($resident && $resident->bed && $resident->bed->room && $resident->bed->room->floor && $resident->bed->room->floor->block && $resident->bed->room->floor->block->hostel)
                        {{ $resident->bed->room->floor->block->hostel->name }} Block
                        {{ $resident->bed->room->floor->block->block_number }} - Resident Dashboard
                    @else --}}
                    {{-- {{ Auth::user()->name }} Dashboard --}}
                    {{-- @endif --}}
                </h2>
            </div>
            <div style="margin: auto"></div>
            <div class="header-part-right">
                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <div class="user col align-self-end">
                        <img src="{{ Auth::user()->resident->photo ? asset('storage/images/residentPhotos/' . Auth::user()->resident->photo) : asset('assets/images/faces/1.jpg') }}"
                            id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                                <i class="i-Lock-User mr-1"></i> {{ Auth::user()->name }}
                            </div>
                            <a class="dropdown-item" href="{{ route('resident.profile') }}">
                                <i class="i-User mr-1"></i> My Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('resident.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="i-Lock-2 mr-1"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('resident.logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="side-content-wrap">
            <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
                <ul class="navigation-left">
                    <li class="nav-item {{ request()->routeIs('resident.dashboard') ? 'active' : '' }}">
                        <a class="nav-item-hold" href="{{ route('resident.dashboard') }}">
                            <i class="nav-icon i-Bar-Chart"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('resident.hostels*') ? 'active' : '' }}">
                        <a class="nav-item-hold" href="{{ route('resident.hostels') }}">
                            <i class="nav-icon i-Home1"></i>
                            <span class="nav-text">All Hostels</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('resident.profile') ? 'active' : '' }}">
                        <a class="nav-item-hold" href="{{ route('resident.profile') }}">
                            <i class="nav-icon i-Male"></i>
                            <span class="nav-text">My Profile</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon i-Receipt-4"></i>
                            <span class="nav-text">My Payments</span>
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon i-Bell"></i>
                            <span class="nav-text">Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon i-Speach-Bubble-6"></i>
                            <span class="nav-text">Support</span>
                        </a>
                    </li> --}}
                </ul>
            </div>

            <div class="sidebar-overlay"></div>
        </div>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <div class="breadcrumb">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <ul>
                    @yield('breadcrumb')
                </ul>
            </div>
            <div class="separator-breadcrumb border-top"></div>

            @yield('content')

            <!-- Footer -->
            <div class="flex-grow-1"></div>
            <div class="app-footer">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="mb-0">© {{ date('Y') }} Hostel Management System. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main Content -->
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/dist-assets/js/plugins/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/script.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/sidebar.large.script.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/delete-function.js') }}"></script>
    <script src="{{ asset('assets/js/publish-status.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('assets/ckeditor5/build/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif

        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type') }}"
            switch (type) {
                case 'info':
                    toastr.options.timeOut = 10000;
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.options.timeOut = 10000;
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.options.timeOut = 10000;
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.options.timeOut = 1000000;
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif

        function toastMessage(notification) {
            const type = notification["alert-type"];
            const message = notification.message;
            switch (type) {
                case 'info':
                    toastr.options.timeOut = 10000;
                    toastr.info(message);
                    break;
                case 'success':
                    toastr.options.timeOut = 10000;
                    toastr.success(message);
                    break;
                case 'warning':
                    toastr.options.timeOut = 10000;
                    toastr.warning(message);
                    break;
                case 'error':
                    toastr.options.timeOut = 10000;
                    toastr.error(message);
                    break;
            }
        }
    </script>

    @yield('scripts')
</body>

</html>
