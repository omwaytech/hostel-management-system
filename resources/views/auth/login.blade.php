@extends('layouts.app')
<style>
    .gradient-custom {
        background: #663399;
    }
</style>
@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-light text-black" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">User Login</h2>
                                <p class="text-black-50 mb-5">Please enter your email and password!</p>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div data-mdb-input-init class="form-outline form-black mb-4">
                                        <input type="email" id="email" name="email"
                                            class="form-control form-control-lg" placeholder="Email"
                                            value="{{ old('email') }}" autocomplete="email" />

                                        <div style="min-height: 1.4em;">
                                            @error('email')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div data-mdb-input-init class="form-outline form-black mb-4">
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-lg" placeholder="Password"
                                            autocomplete="current-password" />
                                        <button type="button" id="showPassword" class="btn btn-outline-transparent mt-2"
                                            style="position: absolute; top: 56%; right: 60px; transform: translateY(-50%); background: none; border: none; padding: 0; cursor: pointer;">
                                            <img src="{{ asset('assets/images/open.jpeg') }}" id="toggle-icon"
                                                style="width: 20px; height: 20px;" alt="Show Password" class="toggle-icon">
                                        </button>
                                        <div style="min-height: 1.4em;">
                                            @error('password')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <button data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-outline-dark btn-lg px-5" type="submit">
                                        Login
                                    </button>
                                    {{-- <div class="mt-4">
                                        <a href="{{ route('login.google') }}" class="btn btn-danger btn-lg px-5"
                                            style="background:#db4437; color:white;">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg"
                                                alt="Google Logo"
                                                style="width:24px; height:24px; margin-right:8px; vertical-align:middle;">
                                            Login with Google
                                        </a>
                                    </div> --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $('#showPassword').click(function() {
            let type = $('#password').attr('type') === 'password' ? 'text' : 'password';
            $('#password').attr('type', type);
            let icon = $('#toggle-icon');
            let newIcon = icon.attr('src') === '{{ asset('assets/images/open.jpeg') }}' ?
                '{{ asset('assets/images/close.jpeg') }}' :
                '{{ asset('assets/images/open.jpeg') }}';
            icon.attr('src', newIcon);
        });
    </script>
@endsection
