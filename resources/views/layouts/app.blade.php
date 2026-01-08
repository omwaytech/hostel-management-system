<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="">
    <title>Login</title>

    <!-- Fonts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900">
    <link rel="stylesheet" href="{{ asset('assets/dist-assets/css/bootstrap.min.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/dist-assets/css/themes/lite-purple.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/dist-assets/css/toastr.min.css') }}">
    <!-- Scripts -->
</head>

<body>
    <div id="app">
        <main class="py-0">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('assets/dist-assets/js/plugins/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/dist-assets/js/toastr.min.js') }}"></script>

    {{-- toastr --}}
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
    </script>

    @yield('scripts')
</body>
</html>
