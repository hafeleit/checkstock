@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    @include('layouts.navbars.auth.topnav', ['title' => 'Create User'])


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
