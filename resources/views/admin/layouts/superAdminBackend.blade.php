<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hostel Management System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
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
    <link rel="stylesheet" href="{{ asset('assets/css/dark-mode.css') }}" />
</head>
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
        <div class="main-header">
            <div class="logo">
                <a href="{{ route('admin.dashboard') }}">
                    <h5 class="text-center">HMS</h5>
                </a>
            </div>
            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div style="margin: auto"></div>
            <div class="header-part-right d-flex align-items-center">
                {{-- Theme Toggle Button --}}
                <button class="theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
                    <i class="fas fa-moon" id="themeIcon"></i>
                </button>

                {{-- Notification Dropdown --}}
                <x-notificationDropdown />

                {{-- User Avatar Dropdown --}}
                <div class="dropdown">
                    <div class="user col align-self-end">
                        <img src="{{ asset('assets/images/user.jpg') }}" id="userDropdown" alt="User"
                            data-bs-toggle="dropdown" aria-expanded="false" class="rounded-circle" width="35"
                            height="35">
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li class="dropdown-header"><i class="i-Lock-User me-1"></i> {{ Auth::user()->name }}</li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Sign Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="side-content-wrap">
            <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <ul class="navigation-left">
                    <li class="nav-item">
                        <a class="nav-item-hold" href="{{ route('admin.dashboard') }}">
                            <i class="nav-icon i-Bar-Chart"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="{{ route('admin.hostel.index') }}">
                            <i class="nav-icon i-Home1"></i>
                            <span class="nav-text">Hostel</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="{{ route('admin.system-about.index') }}">
                            <i class="nav-icon i-Receipt"></i>
                            <span class="nav-text">About</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item" data-item="faq">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon i-Home1"></i>
                            <span class="nav-text">FAQ</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="{{ route('admin.system-testimonial.index') }}">
                            <i class="nav-icon i-Approved-Window"></i>
                            <span class="nav-text">Testimonial</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="{{ route('admin.news-blog.index') }}">
                            <i class="nav-icon i-Approved-Window"></i>
                            <span class="nav-text">Blog</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="{{ route('admin.icon.index') }}">
                            <i class="nav-icon i-Tag-2"></i>
                            <span class="nav-text">Icons</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="{{ route('admin.amenity.index') }}">
                            <i class="nav-icon i-Tag-2"></i>
                            <span class="nav-text">Amenity</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="{{ route('admin.config.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="nav-text">Configuration</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-item-hold" href="{{ route('bill.index') }}">
                            <i class="nav-icon i-Receipt-4"></i>
                            <span class="nav-text">Bill</span>
                        </a>
                        <div class="triangle"></div>
                    </li> --}}
                </ul>
            </div>
            <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <ul class="childNav" data-parent="faq">
                    <li class="nav-item">
                        <a href="{{ route('admin.system-faq-category.index') }}">
                            <i class="nav-icon i-Arrow-Next"></i>
                            <span class="item-name">FAQ Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.system-faq.index') }}">
                            <i class="nav-icon i-Arrow-Next"></i>
                            <span class="item-name">FAQs</span>
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
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/jquery-ui.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/dist-assets/js/plugins/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="{{ asset('assets/dist-assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/script.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/sidebar.large.script.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/datatables.script.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/echart.options.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/dashboard.v1.script.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/customizer.script.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/tagging.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/scripts/tagging.script.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/delete-function.js') }}"></script>
    <script src="{{ asset('assets/js/publish-status.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('assets/ckeditor5/build/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/plugins/select2.min.js') }}"></script>
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
