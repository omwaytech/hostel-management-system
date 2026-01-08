<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
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
<style>
    .custom-wide-modal {
        max-width: 65% !important;
    }
</style>
<style>
    /* Notification container styling */
    .notification-item {
        transition: background-color 0.2s ease;
        word-wrap: break-word;
        white-space: normal;
    }

    .notification-item:hover {
        background-color: #f8f9fa;
    }

    /* Highlight unread notifications */
    .unread-notification {
        background-color: #eef6ff;
        border-left: 4px solid #007bff;
    }

    /* Icon styling */
    .notification-link i {
        min-width: 20px;
        text-align: center;
        font-size: 18px;
    }

    /* Text layout */
    .notification-text {
        flex-grow: 1;
        overflow: visible;
        white-space: normal;
        word-break: break-word;
    }

    .notification-title {
        font-size: 15px;
        color: #2d2d2d;
        margin-bottom: 2px;
    }

    .notification-message {
        font-size: 14px;
        color: #555;
        line-height: 1.3;
        word-break: break-word;
    }
</style>

<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large">
        <div class="main-header d-flex align-items-center justify-content-between">
            <div class="logo">
                <a href="{{ route('hostelAdmin.dashboard', $currentHostel->token) }}">
                    <img src="{{ asset('storage/images/hostelLogos/' . $currentHostel->logo) }}" alt="Hostel Logo"
                        style="width: 50px; height: auto;">
                </a>
            </div>
            <div class="menu-toggle d-flex flex-column justify-content-center align-items-center"
                style="cursor: pointer;">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="flex-grow-1 text-center">
                @php
                    $hostelUser = Auth::user()->hostels()->withPivot('role_id')->first();
                @endphp

                @if (($hostelUser && $hostelUser->pivot->role_id == 2) || Auth::user()->role_id == 1)
                    <h2 class="mb-0 text-primary">{{ $currentHostel->name }}</h2>
                @elseif ($hostelUser && $hostelUser->pivot->role_id == 3)
                    @php
                        $block = \App\Models\Block::find(session('current_block_id'));
                    @endphp
                    @if ($block)
                        <h2 class="mb-0 text-primary">{{ $block->name }}</h2>
                    @endif
                @endif
            </div>
            <div class="header-part-right d-flex align-items-center">
                {{-- Theme Toggle Button --}}
                <button class="theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
                    <i class="fas fa-moon" id="themeIcon"></i>
                </button>

                @if (Auth::user()->role_id == 1)
                    <form method="POST" action="{{ route('hostel.exit') }}">
                        @csrf
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-chevron-left"></i> Back to Super Admin Dashboard
                        </button>
                    </form>
                @endif
                @php
                    $currentHostelId = session('current_hostel_id');
                    $blocks = App\Models\Block::where('hostel_id', $currentHostelId)->get();
                    $blockData = getFloorsWithRoomsAndBedsByBlocks($blocks);
                @endphp
                @if (($hostelUser && $hostelUser->pivot->role_id == 2) || Auth::user()->role_id == 1)
                    <button class="btn btn-outline-success ml-2" data-toggle="modal" data-target="#visualizeBedsModal">
                        Visualize Beds
                    </button>
                @endif
                {{-- Notification Dropdown --}}
                <x-notificationDropdown />

                {{-- User avatar dropdown --}}
                <div class="dropdown">
                    <div class="user col align-self-end">
                        <img src="{{ Auth::user()->photo ? asset('storage/images/userPhotos/' . Auth::user()->photo) : asset('assets/images/user.jpg') }}"
                            id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                                <i class="i-Lock-User mr-1"></i> {{ Auth::user()->name }}
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Sign Out
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="visualizeBedsModal" tabindex="-1" role="dialog"
            aria-labelledby="visualizeBedsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl custom-wide-modal modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="visualizeBedsModalLabel">Beds Availability</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($blockData as $data)
                            <h4 class="mt-3 text-primary text-center">Block: {{ $data['block']->name }}</h4>
                            @foreach ($data['floors'] as $floor)
                                <h5 class="mt-2 text-secondary">
                                    {{ $floor->floor_label ?? $floor->floor_number }}</h5>

                                @foreach ($floor->rooms as $room)
                                    <div class=" mb-3 p-4 border rounded">
                                        <strong>Room {{ $room->room_number }}</strong>
                                        <div class="d-flex flex-wrap mt-2">
                                            @foreach ($room->beds as $bed)
                                                @php
                                                    $badgeClass = match ($bed->status) {
                                                        'Occupied' => 'badge-danger',
                                                        'Available' => 'badge-success',
                                                        'OnMaintenance' => 'badge-light text-dark',
                                                        default => 'badge-secondary',
                                                    };
                                                    $residentName = $bed->resident->full_name ?? '';
                                                @endphp
                                                <span class="badge m-1 p-3 {{ $badgeClass }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $residentName }}">
                                                    Bed {{ $bed->bed_number }} - {{ $bed->status }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        @endforeach
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="side-content-wrap">
            <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <ul class="navigation-left">
                    <li class="nav-item">
                        <a class="nav-item-hold" href="{{ route('hostelAdmin.dashboard', $currentHostel->token) }}">
                            <i class="nav-icon i-Bar-Chart"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    @if (($hostelUser && $hostelUser->pivot->role_id == 2) || Auth::user()->role_id == 1)
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.booking.index') }}">
                                <i class="nav-icon i-Financial"></i>
                                <span class="nav-text">Booking</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.short-term-bookings.index') }}">
                                <i class="nav-icon i-Financial"></i>
                                <span class="nav-text">Short Term Books</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.user.index') }}">
                                <i class="nav-icon i-Administrator"></i>
                                <span class="nav-text">User</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.slider.index') }}">
                                <i class="nav-icon i-Receipt"></i>
                                <span class="nav-text">Slider</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.about.index') }}">
                                <i class="nav-icon i-Home1"></i>
                                <span class="nav-text">About</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.album.index') }}">
                                <i class="nav-icon i-Medal-2"></i>
                                <span class="nav-text">Album</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.news-and-blog.index') }}">
                                <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                                <span class="nav-text">News and Blog</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.registration.index') }}">
                                <i class="nav-icon i-Belt-3"></i>
                                <span class="nav-text">Registration</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.team.index') }}">
                                <i class="nav-icon i-Home1"></i>
                                <span class="nav-text">Team</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.contact-us.index') }}">
                                <i class="nav-icon i-Home1"></i>
                                <span class="nav-text">Contact</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.hostel-feature.index') }}">
                                <i class="nav-icon i-Drop"></i>
                                <span class="nav-text">Feature</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.review.index') }}">
                                <i class="nav-icon i-Approved-Window"></i>
                                <span class="nav-text">Review</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.block.index') }}">
                                <i class="nav-icon i-Home1"></i>
                                <span class="nav-text">Block</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.room.index') }}">
                                <i class="nav-icon i-Tag-2"></i>
                                <span class="nav-text">Room</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        {{-- <li class="nav-item">
                        <a class="nav-item-hold" href="{{ route('hostelAdmin.occupancy.index') }}">
                            <i class="nav-icon i-Business-ManWoman"></i>
                            <span class="nav-text">Occupancy</span>
                        </a>
                        <div class="triangle"></div>
                        </li> --}}
                        <li class="nav-item" data-item="resident">
                            <a class="nav-item-hold" style="text-decoration: none;">
                                <i class="nav-icon i-Business-ManWoman"></i>
                                <span class="nav-text">Resident</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item" data-item="staff">
                            <a class="nav-item-hold" style="text-decoration: none;">
                                <i class="nav-icon i-Business-ManWoman"></i>
                                <span class="nav-text">Staff</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.config.index') }}">
                                <i class="nav-icon i-Tag-2"></i>
                                <span class="nav-text">Config</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-hold" href="{{ route('hostelAdmin.terms-and-policies.index') }}">
                                <i class="nav-icon i-Receipt"></i>
                                <span class="nav-text">Terms and Policies</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-item-hold" href="{{ route('hostelAdmin.inventory.index') }}">
                            <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                            <span class="nav-text">Inventory</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    @if ($hostelUser && isset($hostelUser->pivot) && in_array($hostelUser->pivot->role_id, [2, 3]))
                        <li class="nav-item">
                            <a class="nav-item-hold"
                                href="{{ route('hostelAdmin.setting.index', Auth::user()->slug) }}">
                                <i class="nav-icon i-Gear"></i>
                                <span class="nav-text">Setting</span>
                            </a>
                            <div class="triangle"></div>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <ul class="childNav" data-parent="resident">
                    <li class="nav-item">
                        <a href="{{ route('hostelAdmin.resident.index') }}">
                            <i class="nav-icon i-Arrow-Next"></i>
                            <span class="item-name">Residents</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hostelAdmin.bill.index') }}">
                            <i class="nav-icon i-Arrow-Next"></i>
                            <span class="item-name">Bills</span>
                        </a>
                    </li>
                </ul>
                <ul class="childNav" data-parent="staff">
                    <li class="nav-item">
                        <a href="{{ route('hostelAdmin.staff.index') }}">
                            <i class="nav-icon i-Arrow-Next"></i>
                            <span class="item-name">Staffs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hostelAdmin.payroll.index') }}">
                            <i class="nav-icon i-Arrow-Next"></i>
                            <span class="item-name">Payrolls</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-overlay"></div>
        </div>
        <!-- =============== Left side End ================-->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <!-- ============ Body content start ============= -->
            <div class="main-content">
                @yield('content')
            </div>
            <!-- Footer Start -->
            {{-- <div class="flex-grow-1"></div>
            <div class="app-footer">
                <div class="row">
                    <div class="col-md-9">
                        <p><strong>Gull - Laravel + Bootstrap 4 admin template</strong></p>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Libero quis beatae officia saepe
                            perferendis voluptatum minima eveniet voluptates dolorum, temporibus nisi maxime nesciunt
                            totam repudiandae commodi sequi dolor quibusdam
                            <sunt></sunt>
                        </p>
                    </div>
                </div>
                <div class="footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center">
                    <a class="btn btn-primary text-white btn-rounded"
                        href="https://themeforest.net/item/gull-bootstrap-laravel-admin-dashboard-template/23101970"
                        target="_blank">Buy Gull HTML</a>
                    <span class="flex-grow-1"></span>
                    <div class="d-flex align-items-center">
                        <img class="logo" src="{{ asset('assets/dist-assets/images/logo.png') }}" alt="">
                        <div>
                            <p class="m-0">&copy; 2018 Gull HTML</p>
                            <p class="m-0">All rights reserved</p>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/script.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/sidebar.large.script.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/datatables.script.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/echart.options.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/dashboard.v1.script.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/customizer.script.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/delete-function.js') }}"></script>
    <script src="{{ asset('assets/js/publish-status.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('assets/ckeditor5/build/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- toastr --}}
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
    {{-- ck editor --}}
    <script>
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
                this.url = '{{ route('ckeditor.upload') }}';

            }
            upload() {
                return this.loader.file.then(
                    (file) =>
                    new Promise((resolve, reject) => {
                        this._initRequest();
                        this._initListeners(resolve, reject, file);
                        this._sendRequest(file);
                    })
                );
            }
            abort() {
                if (this.xhr) {
                    this.xhr.abort();
                }
            }
            _initRequest() {
                const xhr = (this.xhr = new XMLHttpRequest());
                xhr.open("POST", this.url, true);
                xhr.setRequestHeader("x-csrf-token", "{{ csrf_token() }}");
                xhr.responseType = "json";
            }
            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${file.name}.`;
                xhr.addEventListener("error", () => reject(genericErrorText));
                xhr.addEventListener("abort", () => reject());
                xhr.addEventListener("load", () => {
                    const response = xhr.response;
                    if (!response || response.error) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
                    }
                    resolve({
                        default: response.url,
                    });
                });
                if (xhr.upload) {
                    xhr.upload.addEventListener("progress", (evt) => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    });
                }
            }
            _sendRequest(file) {
                // Prepare the form data.
                const data = new FormData();
                data.append("upload", file);
                this.xhr.send(data);
            }
        }

        function SimpleUploadAdapterPlugin(editor) {
            editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        document.querySelectorAll('.ckeditor').forEach((textarea) => {
            ClassicEditor
                .create(textarea, {
                    extraPlugins: [SimpleUploadAdapterPlugin],
                })
                .then(editor => {
                    // Store the editor instance globally if needed
                    window[`editor_${textarea.id}`] = editor;
                })
                .catch(error => {
                    console.error(`Error initializing CKEditor for ${textarea.id}:`, error);
                });
        });

        function handleSampleError(error) {
            const issueUrl = 'https://github.com/ckeditor/ckeditor5/issues';

            const message = [
                'Oops, something went wrong!',
                `Please, report the following error on ${issueUrl} with the build id "v3jsca8olziy-tyog72tqnmsr" and the error stack trace:`
            ].join('\n');

            console.error(message);
            console.error(error);
        }
    </script>
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
            max-height: 300px;
            width: 100%;
        }
    </style>
    {{-- bed resident --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
    {{-- notification --}}
    <script>
        $(document).ready(function() {
            // Delegated handler: works even if dropdown content is re-rendered dynamically
            $(document).on('click', '.notification-link', function(e) {
                e.preventDefault(); // stop navigation until AJAX completes

                var $link = $(this);
                var $item = $link.closest('.notification-item');
                var id = $item.data('id');
                var href = $link.attr('href') || '#';

                // If already read, just navigate immediately
                if (!$item.hasClass('fw-bold')) {
                    if (href && href !== '#') {
                        window.location.href = href;
                    }
                    return;
                }

                // CSRF token
                var token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: "/notifications/read/" + id,
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function(res) {
                        if (res && res.success) {
                            // unhighlight UI
                            $item.removeClass('fw-bold');

                            // update badge count safely
                            var $badge = $('#notificationDropdown .badge');
                            if ($badge.length) {
                                var raw = $.trim($badge.text()) || "0";
                                var count = parseInt(raw, 10);
                                if (!isNaN(count) && count > 0) {
                                    if (count > 1) {
                                        $badge.text(count - 1);
                                    } else {
                                        $badge.remove();
                                    }
                                }
                            }

                            // redirect to target link (if present)
                            if (href && href !== '#') {
                                window.location.href = href;
                            } else {
                                // fallback: go to notifications index if link missing
                                window.location.href =
                                    "#";
                            }
                        } else {
                            // fallback navigation even on failure
                            if (href && href !== '#') {
                                window.location.href = href;
                            } else {
                                window.location.href =
                                    "#";
                            }
                        }
                    },
                    error: function(xhr) {
                        // log and still navigate
                        console.error('Notification mark read failed', xhr);
                        if (href && href !== '#') {
                            window.location.href = href;
                        } else {
                            window.location.href = "#";
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.notification-link', function(e) {
                e.preventDefault();

                const $link = $(this);
                const $item = $link.closest('.notification-item');
                const id = $item.data('id');
                const href = $link.attr('href') || '#';

                // If already read, go straight to link
                if (!$item.hasClass('unread-notification')) {
                    if (href && href !== '#') window.location.href = href;
                    return;
                }

                $.ajax({
                    url: `/notifications/read/${id}`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.success) {
                            // Remove highlight visually
                            $item.removeClass('unread-notification');

                            // Update unread count badge
                            const $badge = $('#notificationDropdown .badge');
                            if ($badge.length) {
                                const count = parseInt($badge.text());
                                if (count > 1) {
                                    $badge.text(count - 1);
                                } else {
                                    $badge.remove();
                                }
                            }

                            // Redirect
                            if (href && href !== '#') window.location.href = href;
                        }
                    }
                });
            });
        });
    </script>

    {{-- Dark Mode Toggle Script --}}
    <script>
        // Check for saved theme preference or default to 'light' mode
        const currentTheme = localStorage.getItem('theme') || 'light';
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');

        // Apply theme on page load
        if (currentTheme === 'dark') {
            document.body.classList.add('dark-mode');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }

        // Toggle theme on button click
        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                document.body.classList.toggle('dark-mode');

                // Update icon
                if (document.body.classList.contains('dark-mode')) {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                    localStorage.setItem('theme', 'dark');
                } else {
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                    localStorage.setItem('theme', 'light');
                }
            });
        }
    </script>

    @yield('script')
</body>

</html>
