@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    @include('layouts.navbars.auth.topnav', ['title' => 'Create User'])

    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        * {
            box-sizing: border-box;
        }

        .eu-container {
            padding-top: 15rem;
            padding-bottom: 2rem;
        }

        /* ── Nav pills ── */
        .eu-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .eu-nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 10px;
            font-size: 0.81rem;
            font-weight: 500;
            text-decoration: none;
            border: 1.5px solid #e0e0e0;
            background: #fff;
            color: #4a4a4a;
            transition: background 0.2s, border-color 0.2s, color 0.2s;
        }

        .eu-nav-btn:hover {
            background: #f4f5f7;
            border-color: #bbb;
            color: #1a1a1a;
        }

        .eu-nav-btn.active {
            background: linear-gradient(135deg, #C8102E 0%, #96091F 100%);
            border-color: transparent;
            color: #fff;
            box-shadow: 0 4px 12px rgba(200, 16, 46, 0.25);
        }

        /* ── Card ── */
        .eu-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }

        .eu-card-header {
            padding: 20px 28px 16px;
            border-bottom: 1px solid #f2f2f2;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .eu-card-title {
            font-size: 0.82rem;
            font-weight: 700;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin: 0;
        }

        .eu-card-body {
            padding: 24px 28px 8px;
        }

        /* ── Section label ── */
        .section-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: #C8102E;
            text-transform: uppercase;
            letter-spacing: 0.9px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #f0f0f0;
        }

        /* ── Inputs ── */
        .eu-group {
            margin-bottom: 14px;
        }

        .eu-label {
            display: block;
            font-size: 0.74rem;
            font-weight: 500;
            color: #6D6E71;
            margin-bottom: 5px;
        }

        .eu-label .required-dot {
            color: #C8102E;
            margin-left: 2px;
        }

        .eu-input {
            width: 100%;
            background: #fff;
            border: 1px solid #e2e2e2;
            border-radius: 10px;
            color: #1a1a1a;
            padding: 10px 14px;
            font-size: 0.86rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .eu-input:focus {
            border-color: #C8102E;
            box-shadow: 0 0 0 3px rgba(200, 16, 46, 0.12);
        }

        .eu-select {
            width: 100%;
            background: #fff;
            border: 1px solid #e2e2e2;
            border-radius: 10px;
            color: #1a1a1a;
            padding: 10px 14px;
            font-size: 0.86rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
        }

        .eu-select:focus {
            border-color: #C8102E;
            box-shadow: 0 0 0 3px rgba(200, 16, 46, 0.12);
        }

        .field-error {
            font-size: 0.75rem;
            color: #C8102E;
            margin-top: 4px;
        }

        /* ── Password input group ── */
        .pw-group {
            display: flex;
            border: 1px solid #e2e2e2;
            border-radius: 10px;
            overflow: hidden;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .pw-group:focus-within {
            border-color: #C8102E;
            box-shadow: 0 0 0 3px rgba(200, 16, 46, 0.12);
        }

        .pw-group .eu-input {
            border: none;
            border-radius: 0;
            box-shadow: none;
            flex: 1;
        }

        .pw-group .eu-input:focus {
            box-shadow: none;
        }

        .pw-btn {
            flex-shrink: 0;
            background: #f8f8f8;
            border: none;
            border-left: 1px solid #e2e2e2;
            padding: 0 14px;
            color: #6D6E71;
            font-size: 0.85rem;
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
        }

        .pw-btn:hover {
            background: #f0f0f0;
            color: #1a1a1a;
        }

        .pw-btn:last-child {
            border-radius: 0 10px 10px 0;
        }

        /* ── Active status card ── */
        .eu-status-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            background: #fafafa;
            margin-bottom: 16px;
        }

        .eu-status-info h6 {
            font-size: 0.86rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 2px;
        }

        .eu-status-info p {
            font-size: 0.76rem;
            color: #9ca3af;
            margin: 0;
        }

        .toggle.btn {
            margin: 0;
        }

        .toggle-handle {
            background-color: #fff !important;
        }

        .toggle.btn.off {
            background-color: #e2e2e2 !important;
            border-color: #e2e2e2 !important;
        }

        .toggle.btn.on {
            background-color: #C8102E !important;
            border-color: #C8102E !important;
        }

        /* ── Validation errors list ── */
        .eu-errors {
            background: rgba(200, 16, 46, 0.06);
            border: 1px solid rgba(200, 16, 46, 0.18);
            border-left: 4px solid #C8102E;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
            font-size: 0.84rem;
            color: #C8102E;
        }

        .eu-errors ul {
            margin: 0;
            padding-left: 18px;
        }

        .eu-errors li {
            line-height: 1.8;
        }

        /* ── Footer ── */
        .eu-card-footer {
            padding: 16px 28px 24px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            border-top: 1px solid #f2f2f2;
            margin-top: 8px;
        }

        .eu-card-footer .btn-eu-secondary,
        .eu-card-footer .btn-eu-primary {
            width: 100%;
            justify-content: center;
        }

        @media (min-width: 768px) {
            .eu-card-footer {
                flex-direction: row;
                justify-content: flex-end;
                align-items: center;
            }

            .eu-card-footer .btn-eu-secondary,
            .eu-card-footer .btn-eu-primary {
                width: auto;
            }
        }

        .btn-eu-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            border: 1.5px solid #ddd;
            border-radius: 10px;
            background: transparent;
            color: #4a4a4a;
            font-size: 0.83rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s, color 0.2s;
        }

        .btn-eu-secondary:hover {
            background: #f4f5f7;
            border-color: #bbb;
            color: #1a1a1a;
        }

        .btn-eu-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 24px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #C8102E 0%, #96091F 100%);
            color: #fff;
            font-size: 0.83rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(200, 16, 46, 0.28);
        }

        .btn-eu-primary:hover {
            opacity: 0.92;
            transform: translateY(-1px);
            box-shadow: 0 6px 22px rgba(200, 16, 46, 0.38);
            color: #fff;
        }

        .btn-eu-primary:active {
            transform: translateY(0);
        }
    </style>

    <div class="container-fluid eu-container">

        {{-- Nav pills --}}
        <div class="eu-nav">
            <a href="{{ url('roles') }}" class="eu-nav-btn">
                <i class="fas fa-shield-alt fa-xs"></i> Roles
            </a>
            <a href="{{ url('permissions') }}" class="eu-nav-btn">
                <i class="fas fa-key fa-xs"></i> Permissions
            </a>
            <a href="{{ url('users') }}" class="eu-nav-btn active">
                <i class="fas fa-users fa-xs"></i> Users
            </a>
        </div>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="eu-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form card --}}
        <div class="eu-card col-md-6">
            <div class="eu-card-header">
                <p class="eu-card-title">Create User</p>
            </div>

            <form action="{{ url('users') }}" method="POST" id="createUserForm">
                @csrf

                <div class="eu-card-body">

                    {{-- Identity --}}
                    <div class="section-label">Identity</div>
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-4">
                            <div class="eu-group">
                                <label class="eu-label">Employee Code</label>
                                <input type="text" name="emp_code" value="{{ old('emp_code') }}" class="eu-input"
                                    maxlength="5">
                                @error('emp_code')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8">
                            <div class="eu-group">
                                <label class="eu-label">Name <span class="required-dot">*</span></label>
                                <input type="text" name="username" value="{{ old('username') }}" class="eu-input"
                                    required>
                                @error('username')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="eu-group">
                                <label class="eu-label">Account (Email) <span class="required-dot">*</span></label>
                                <input type="text" name="email" value="{{ old('email') }}" class="eu-input" required>
                                @error('email')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Credentials --}}
                    <div class="section-label mt-4">Credentials</div>
                    <div class="eu-group">
                        <label class="eu-label">Password <span class="required-dot">*</span></label>
                        <div class="pw-group">
                            <input type="text" name="password" id="password" class="eu-input"
                                placeholder="Click generate to create a strong password" required>
                            <button class="pw-btn" type="button" id="copyPasswordBtn" title="Copy to clipboard">
                                <i class="fa-regular fa-clipboard"></i>
                            </button>
                            <button class="pw-btn" type="button" id="generatePasswordBtn" title="Generate password">
                                <i class="fa-solid fa-repeat"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Access --}}
                    <div class="section-label mt-4">Access</div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="eu-group">
                                <label class="eu-label">Roles <span class="required-dot">*</span></label>
                                <select name="roles[]" id="roles-select" class="eu-input" data-placeholder="Choose roles"
                                    multiple required>
                                    <option value="">select role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="eu-group">
                                <label class="eu-label">Type <span class="required-dot">*</span></label>
                                <select name="type" id="type-select" class="eu-select" required>
                                    <option value="">select type</option>
                                    <option value="employee" selected>Employee</option>
                                    <option value="customer">Customer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="eu-group">
                                <label class="eu-label">Supplier Code</label>
                                <input type="text" name="supp_code" value="{{ old('supp_code') }}" class="eu-input">
                                @error('supp_code')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="section-label mt-4">Account Status</div>
                    <div class="eu-status-card">
                        <div class="eu-status-info">
                            <h6>Active Status</h6>
                            <p>Enable or disable this user account</p>
                        </div>
                        <input name="is_active" type="checkbox" checked data-toggle="toggle" data-on="Active"
                            data-off="Inactive" data-onstyle="success">
                    </div>

                </div>

                <div class="eu-card-footer">
                    <a href="{{ url('users') }}" class="btn btn-eu-secondary m-0">
                        <i class="fas fa-arrow-left fa-xs"></i> Back
                    </a>
                    <button type="submit" class="btn btn-eu-primary m-0">
                        <i class="fas fa-user-plus fa-xs"></i> Create User
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script src="{{ asset('js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-toggle.min.css') }}">

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        $('#roles-select').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });

        const createUserForm = document.getElementById('createUserForm');

        function isPasswordStrong(password) {
            const minLength = 15;
            const hasLowerCase = /[a-z]+/.test(password);
            const hasUpperCase = /[A-Z]+/.test(password);
            const hasNumber = /[0-9]+/.test(password);
            const hasSymbol = /[!@#$%^&*()_+\-=\[\]{}|;:,.<>?]+/.test(password);

            if (password.length < minLength) {
                return {
                    valid: false,
                    message: `Must be at least ${minLength} characters long.`
                };
            }
            if (!hasLowerCase) {
                return {
                    valid: false,
                    message: 'Must include at least one lowercase letter.'
                };
            }
            if (!hasUpperCase) {
                return {
                    valid: false,
                    message: 'Must include at least one uppercase letter.'
                };
            }
            if (!hasNumber) {
                return {
                    valid: false,
                    message: 'Must include at least one number.'
                };
            }
            if (!hasSymbol) {
                return {
                    valid: false,
                    message: 'Must include at least one special character (e.g., !@#$).'
                };
            }

            return {
                valid: true,
                message: 'Password meets policy.'
            };
        }

        document.addEventListener('DOMContentLoaded', () => {
            const passwordField = document.getElementById('password');
            const generatePasswordBtn = document.getElementById('generatePasswordBtn');
            const copyPasswordBtn = document.getElementById('copyPasswordBtn');

            function generateStrongPassword(length = 15) {
                const lowerCase = 'abcdefghijklmnopqrstuvwxyz';
                const upperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                const numbers = '0123456789';
                const symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';
                const allChars = lowerCase + upperCase + numbers + symbols;

                let password = '';
                password += lowerCase[Math.floor(Math.random() * lowerCase.length)];
                password += upperCase[Math.floor(Math.random() * upperCase.length)];
                password += numbers[Math.floor(Math.random() * numbers.length)];
                password += symbols[Math.floor(Math.random() * symbols.length)];

                for (let i = password.length; i < length; i++) {
                    password += allChars[Math.floor(Math.random() * allChars.length)];
                }

                return password.split('').sort(() => 0.5 - Math.random()).join('');
            }

            generatePasswordBtn.addEventListener('click', () => {
                passwordField.value = generateStrongPassword(15);
            });

            copyPasswordBtn.addEventListener('click', () => {
                if (passwordField.value) {
                    navigator.clipboard.writeText(passwordField.value)
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Copied!',
                                text: 'Password copied to clipboard.',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        })
                        .catch(err => {
                            console.error('Could not copy:', err);
                            passwordField.select();
                            document.execCommand('copy');
                        });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Nothing to copy',
                        text: 'Please generate a password first.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            });

            // Auto-generate password on page load
            generatePasswordBtn.click();

            if (createUserForm) {
                createUserForm.addEventListener('submit', function(event) {
                    const password = passwordField.value;
                    const validation = isPasswordStrong(password);

                    if (!validation.valid) {
                        event.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Password Policy Violation',
                            html: `The password does not meet the policy:<br><br><strong>${validation.message}</strong>`,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    </script>
@endsection
