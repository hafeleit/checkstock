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
            max-width: 400px;
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

        /* Inputs */
        .login-card .input-group-glass {
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

        /* password toggle */
        .pw-toggle-icon {
            right: 14px;
            cursor: pointer;
            color: #9ca3af;
            transition: color 0.15s;
        }

        .pw-toggle-icon:hover {
            color: #C8102E;
        }

        /* Sign In button */
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

        /* Security notice */
        .login-notice {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            background: rgba(200, 16, 46, 0.07);
            border: 1px solid rgba(200, 16, 46, 0.2);
            border-radius: 10px;
            padding: 10px 12px;
            margin-top: 16px;
            font-size: 0.78rem;
            color: #C8102E;
            line-height: 1.4;
        }

        .login-notice i {
            margin-top: 1px;
            flex-shrink: 0;
        }

        /* Footer */
        .login-footer {
            margin-top: 22px;
            text-align: center;
            font-size: 0.77rem;
            color: #6D6E71;
        }

        .login-footer a {
            color: #C8102E;
            text-decoration: none;
        }

        .login-footer a:hover {
            color: #96091F;
        }

        .text-danger-glass {
            color: #C8102E;
            font-size: 0.78rem;
            margin-top: 4px;
        }

        .badge-th {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: linear-gradient(135deg, #C8102E, #96091F);
            color: #ffffff;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 3px 8px;
            border-radius: 20px;
            vertical-align: middle;
            position: relative;
            top: -3px;
            box-shadow: 0 2px 8px rgba(200, 16, 46, 0.4);
        }
    </style>

    <div class="login-bg">
        <div class="login-card">
            <img src="/img/hafele-logo.png" alt="Hafele" class="login-logo">

            <p class="login-title">Häfele Application <span class="badge-th">TH</span></p>
            <p class="login-subtitle">Sign in to your account to continue</p>

            <form role="form" method="POST" action="{{ route('login.perform') }}">
                @csrf
                @method('post')
                <input type="hidden" name="from" value="{{ request()->query('from') }}">
                <input type="hidden" name="redirect" value="{{ request()->query('redirect') }}">

                <div class="input-group-glass">
                    <input autofocus type="text" name="email" class="form-control" placeholder="Username" value="{{ old('email') ?? '' }}" autocomplete="off">
                    @error('email')
                        <p class="text-danger-glass">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-group-glass position-relative">
                    <input id="password" type="password" name="password" class="form-control" placeholder="Password" value="" autocomplete="off">
                    <i id="togglePassword" class="fas fa-eye position-absolute top-50 translate-middle-y pw-toggle-icon"></i>
                    @error('password')
                        <p class="text-danger-glass">{{ $message }}</p>
                    @enderror
                </div>

                <div class="login-notice" role="alert">
                    <i class="fas fa-shield-alt"></i>
                    <span>Exceeding <strong>5 failed attempts</strong> will temporarily lock your account or IP address.</span>
                </div>

                <button type="submit" class="btn-login">Sign In</button>
            </form>

            <p class="login-footer mb-0">
                Need an account or forgot your password?<br>
                <a href="https://hafele.refined.site/" target="_blank">Contact IT Service System</a>
            </p>
        </div>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePassword');

        function showPassword() {
            passwordInput.setAttribute('type', 'text');
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        }

        function hidePassword() {
            passwordInput.setAttribute('type', 'password');
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }

        toggleIcon.addEventListener('mousedown', showPassword);
        toggleIcon.addEventListener('mouseup', hidePassword);
        toggleIcon.addEventListener('mouseleave', hidePassword);

        toggleIcon.addEventListener('touchstart', function(e) { e.preventDefault(); showPassword(); });
        toggleIcon.addEventListener('touchend', function(e) { e.preventDefault(); hidePassword(); });
    </script>
@endsection
