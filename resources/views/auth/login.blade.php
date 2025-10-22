@extends('layouts.app')

@section('content')
    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .bg-hafele {
            background-image: url('/img/bg-hafele.jpg');
            background-size: cover;
        }

        .login-security-alert {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            border-radius: 0.5rem;
            padding: 5px;
            margin-top: 15px;
            text-align: center;
            font-size: 0.875rem;
            display: block;
        }
    </style>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Sign In</h4>
                                    <p class="mb-0">Enter your account and password to sign in</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('login.perform') }}">
                                        @csrf
                                        @method('post')
                                        <input type="hidden" name="from" value="{{ request()->query('from') }}">
                                        <div class="mb-3">
                                            <input autofocus type="text" name="email"
                                                class="form-control form-control-lg" value="{{ old('email') ?? '' }}"
                                                aria-label="Email" autocomplete="off">
                                            @error('email')
                                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 position-relative">
                                            <input id="password" type="password" name="password"
                                                class="form-control form-control-lg" aria-label="Password" value=""
                                                autocomplete="off">

                                            <!-- Font Awesome eye icon -->
                                            <i id="togglePassword"
                                                class="fas fa-eye absolute end-3 top-1/2 translate-middle-y cursor-pointer text-gray-400 hover:text-gray-700 position-absolute top-50"></i>

                                            @error('password')
                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
                                            const passwordInput = document.getElementById('password');
                                            const toggleIcon = document.getElementById('togglePassword');

                                            // คลิกค้าง
                                            toggleIcon.addEventListener('mousedown', function() {
                                                passwordInput.setAttribute('type', 'text');
                                                this.classList.remove('fa-eye');
                                                this.classList.add('fa-eye-slash');
                                            });

                                            // ปล่อยเมาส์ หรือเลื่อนออกจาก icon
                                            toggleIcon.addEventListener('mouseup', hidePassword);
                                            toggleIcon.addEventListener('mouseleave', hidePassword);

                                            function hidePassword() {
                                                passwordInput.setAttribute('type', 'password');
                                                toggleIcon.classList.remove('fa-eye-slash');
                                                toggleIcon.classList.add('fa-eye');
                                            }
                                        </script>

                                        <div class="login-security-alert" role="alert">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            <strong>Security Alert:</strong> Exceeding <strong>5 failed login attempts</strong> will temporarily lock your account or IP address.
                                        </div>

                                        <p class="text-center mt-2">
                                            Forgot your password or need an account? </br>Please contact
                                            <a class="text-primary"
                                                href="https://it-service.hafele.com/plugins/servlet/desk/portal/2"
                                                target="_blank">IT Service System</a>.
                                        </p>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div
                                class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden bg-hafele">
                                <span class="bg-gradient-primary opacity-6"></span>
                                <h4 class="mt-5 text-primary font-weight-bolder position-relative">HAFELE THAILAND
                                    APPLICATION</h4>
                                <p class="text-warning position-relative">Make by HTH IT</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
