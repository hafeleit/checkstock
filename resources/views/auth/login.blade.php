@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/auth-login.css') }}" rel="stylesheet">

    <div class="login-bg">
        <div class="login-card">
            <img src="/img/hafele-logo.png" alt="Hafele" class="login-logo">

            <p class="login-title">Häfele Application <span class="badge-th">TH</span></p>
            <p class="login-subtitle">Sign in to your account to continue</p>

            @php
                $activeLoginTab = old('email') ? 'external' : 'employee';
            @endphp

            <div class="login-tabs">
                <button type="button" class="login-tab {{ $activeLoginTab === 'employee' ? 'active' : '' }}" data-tab="employee">Employee</button>
                <button type="button" class="login-tab {{ $activeLoginTab === 'external' ? 'active' : '' }}" data-tab="external">External</button>
            </div>

            <div class="login-panel {{ $activeLoginTab === 'employee' ? 'active' : '' }}" id="employee-panel">
                <a href="{{ route('microsoft.redirect') }}" class="btn-sso">
                    <svg class="h-4 w-4" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1" y="1" width="9" height="9" fill="#F25022"/>
                        <rect x="11" y="1" width="9" height="9" fill="#7FBA00"/>
                        <rect x="1" y="11" width="9" height="9" fill="#00A4EF"/>
                        <rect x="11" y="11" width="9" height="9" fill="#FFB900"/>
                    </svg>
                    Sign in with Microsoft
                </a>
                @error('email')
                    @if ($activeLoginTab === 'employee')
                        <p class="text-danger-glass">{{ $message }}</p>
                    @endif
                @enderror

                <div class="login-notice" role="alert">
                    <i class="fas fa-shield-alt"></i>
                    <span>Employees sign in using their company Microsoft account.</span>
                </div>
            </div>

            <div class="login-panel {{ $activeLoginTab === 'external' ? 'active' : '' }}" id="external-panel">
                <form role="form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group-glass">
                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') ?? '' }}" autocomplete="off">
                        @error('email')
                            @if ($activeLoginTab === 'external')
                                <p class="text-danger-glass">{{ $message }}</p>
                            @endif
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
            </div>

            <p class="login-footer mb-0">
                Need an account or forgot your password?<br>
                <a href="https://hafele.refined.site/" target="_blank">Contact IT Service System</a>
            </p>
        </div>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        const loginTabs = document.querySelectorAll('.login-tab');
        const loginPanels = {
            employee: document.getElementById('employee-panel'),
            external: document.getElementById('external-panel'),
        };

        loginTabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                loginTabs.forEach(function(t) { t.classList.remove('active'); });
                tab.classList.add('active');

                Object.keys(loginPanels).forEach(function(key) {
                    loginPanels[key].classList.toggle('active', key === tab.dataset.tab);
                });
            });
        });

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
