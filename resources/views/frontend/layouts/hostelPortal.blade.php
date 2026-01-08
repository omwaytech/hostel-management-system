<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dist-assets/css/toastr.min.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- html2pdf.js for PDF generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/hostelPortal.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F9FAFB] min-h-screen flex flex-col">
    @include('frontend.layouts.hostelPortalNavbar')
    <main class="flex-grow mt-[88px]">
        @yield('body')
    </main>
    <div>
        @include('frontend.layouts.hostelPortalFooter')
    </div>

    <script src="{{ asset('assets/dist-assets/js/plugins/jquery-3.3.1.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="{{ asset('assets/dist-assets/js/toastr.min.js') }}"></script>
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
</body>

</html>
