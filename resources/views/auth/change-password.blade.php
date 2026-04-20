@extends('layouts.app')

@section('content')
    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .pw-toggle-icon {
            right: 12px;
            cursor: pointer;
            color: #adb5bd;
        }
        .error-badge {
            background-color: #ffe5e5;
            color: #c0392b;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 0.85rem;
        }
    </style>
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                @include('layouts.navbars.guest.navbar')
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Change password</h4>
                                    <p class="mb-0">Set a new password for your email</p>
                                </div>

                                @if (session('error'))
                                    <p class="error-badge mt-2 mb-0 mx-4">
                                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                    </p>
                                @endif

                                <div class="card-body">
                                    <form role="form" method="post" action="{{ route('change.perform') }}">
                                        @csrf
                                        @method('put')
                                        <div class="mb-3">
                                            <input type="hidden" name="email" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}">
                                            <input type="text" class="form-control form-control-lg" placeholder="Email" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" aria-label="Email" readonly>
                                            @error('email')
                                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 position-relative">
                                            <input id="password" type="password" name="password" class="form-control form-control-lg" placeholder="Current Password" aria-label="Password" autocomplete="off">
                                            <i id="togglePassword" class="fas fa-eye position-absolute top-50 translate-middle-y pw-toggle-icon"></i>
                                            @error('password')
                                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 position-relative">
                                            <input id="new_password" type="password" name="new_password" class="form-control form-control-lg" placeholder="New Password" aria-label="Password" autocomplete="off">
                                            <i id="toggleNewPassword" class="fas fa-eye position-absolute top-50 translate-middle-y pw-toggle-icon"></i>
                                            @error('new_password')
                                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 position-relative">
                                            <input id="new_password_confirmation" type="password" name="new_password_confirmation" class="form-control form-control-lg" placeholder="Confirm Password" aria-label="Password" autocomplete="off">
                                            <i id="toggleConfirmPassword" class="fas fa-eye position-absolute top-50 translate-middle-y pw-toggle-icon"></i>
                                            @error('new_password_confirmation')
                                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Change Password</button>
                                        </div>
                                    </form>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-lg btn-secondary w-100 mt-3 mb-0">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        function setupPasswordToggle(inputId, toggleId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(toggleId);

            function showPw() {
                input.setAttribute('type', 'text');
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }

            function hidePw() {
                input.setAttribute('type', 'password');
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }

            icon.addEventListener('mousedown', showPw);
            icon.addEventListener('mouseup', hidePw);
            icon.addEventListener('mouseleave', hidePw);

            icon.addEventListener('touchstart', function(e) {
                e.preventDefault();
                showPw();
            });
            icon.addEventListener('touchend', function(e) {
                e.preventDefault();
                hidePw();
            });
        }

        setupPasswordToggle('password', 'togglePassword');
        setupPasswordToggle('new_password', 'toggleNewPassword');
        setupPasswordToggle('new_password_confirmation', 'toggleConfirmPassword');
    </script>
@endsection
