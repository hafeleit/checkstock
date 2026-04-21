@extends('layouts.app')

@section('content')
    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        * { box-sizing: border-box; }

        .login-bg {
            min-height: 100vh;
            background: #F4F5F7;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #FFFFFF;
            border-radius: 20px;
            padding: 44px 40px 36px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        }

        .login-logo {
            display: block;
            margin: 0 auto 32px;
            height: 32px;
            width: auto;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0;
            letter-spacing: -0.3px;
        }

        .login-subtitle {
            font-size: 0.83rem;
            color: #6D6E71;
            margin-bottom: 20px;
        }

        .input-group-glass {
            position: relative;
            margin-bottom: 14px;
        }

        .login-card .form-control {
            background: #FFFFFF;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            color: #1a1a1a;
            padding: 12px 16px;
            font-size: 0.88rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 100%;
        }

        .login-card .form-control::placeholder {
            color: #9ca3af;
        }

        .login-card .form-control:focus {
            outline: none;
            background: #FFFFFF;
            border-color: #C8102E;
            box-shadow: 0 0 0 3px rgba(200, 16, 46, 0.15);
            color: #1a1a1a;
        }

        .login-card .form-control[readonly] {
            background: #f9f9f9;
            color: #6D6E71;
            cursor: default;
        }

        .pw-toggle-icon {
            right: 14px;
            cursor: pointer;
            color: #9ca3af;
            transition: color 0.15s;
        }

        .pw-toggle-icon:hover {
            color: #C8102E;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #C8102E 0%, #96091F 100%);
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.4px;
            margin-top: 20px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(200, 16, 46, 0.35);
        }

        .btn-login:hover {
            opacity: 0.92;
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(200, 16, 46, 0.45);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 4px 16px rgba(200, 16, 46, 0.25);
        }

        .btn-cancel {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            background: transparent;
            color: #6D6E71;
            font-size: 0.88rem;
            font-weight: 500;
            margin-top: 10px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }

        .btn-cancel:hover {
            background: #F4F5F7;
            color: #1a1a1a;
            border-color: #c0c0c0;
        }

        .error-notice {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            background: rgba(200, 16, 46, 0.07);
            border: 1px solid rgba(200, 16, 46, 0.2);
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 20px;
            font-size: 0.8rem;
            color: #C8102E;
            line-height: 1.4;
        }

        .text-danger-glass {
            color: #C8102E;
            font-size: 0.78rem;
            margin-top: 4px;
        }
    </style>

    <div class="login-bg">
        <div class="login-card">
            <img src="/img/hafele-logo.png" alt="Hafele" class="login-logo">

            <p class="login-title">Change Password</p>
            <p class="login-subtitle">Set a new password for your account</p>

            @if (session('error'))
                <div class="error-notice">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form role="form" method="post" action="{{ route('change.perform') }}">
                @csrf
                @method('put')
                <input type="hidden" name="email" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}">

                <div class="input-group-glass">
                    <input type="text" class="form-control" placeholder="Email"
                        value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" readonly>
                    @error('email')
                        <p class="text-danger-glass">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-group-glass position-relative">
                    <input id="password" type="password" name="password"
                        class="form-control" placeholder="Current Password" autocomplete="off">
                    <i id="togglePassword" class="fas fa-eye position-absolute top-50 translate-middle-y pw-toggle-icon"></i>
                    @error('password')
                        <p class="text-danger-glass">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-group-glass position-relative">
                    <input id="new_password" type="password" name="new_password"
                        class="form-control" placeholder="New Password" autocomplete="off">
                    <i id="toggleNewPassword" class="fas fa-eye position-absolute top-50 translate-middle-y pw-toggle-icon"></i>
                    @error('new_password')
                        <p class="text-danger-glass">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-group-glass position-relative">
                    <input id="new_password_confirmation" type="password" name="new_password_confirmation"
                        class="form-control" placeholder="Confirm New Password" autocomplete="off">
                    <i id="toggleConfirmPassword" class="fas fa-eye position-absolute top-50 translate-middle-y pw-toggle-icon"></i>
                    @error('new_password_confirmation')
                        <p class="text-danger-glass">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-login">Change Password</button>
            </form>

            @if (request('from') === 'profile')
                <a href="{{ route('profile') }}" type="submit" class="btn-cancel text-center">Cancel</a>
            @else
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-cancel">Cancel</button>
                </form>
            @endif
        </div>
    </div>

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

            icon.addEventListener('touchstart', function(e) { e.preventDefault(); showPw(); });
            icon.addEventListener('touchend', function(e) { e.preventDefault(); hidePw(); });
        }

        setupPasswordToggle('password', 'togglePassword');
        setupPasswordToggle('new_password', 'toggleNewPassword');
        setupPasswordToggle('new_password_confirmation', 'toggleConfirmPassword');
    </script>
@endsection
