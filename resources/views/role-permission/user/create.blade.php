@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
    .card-header__user,
    .card__active_status {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card__active_status {
        box-shadow: none;
        padding: 20px;
        border: 1px solid #d2d6da;
        border-radius: 0.5rem;
    }

    .toggle.btn {
        margin: 0;
    }

    .toggle-handle {
        background-color: #ffffff !important;
    }

    .toggle.btn.off {
        background-color: #e9ecef !important;
        border-color: #e9ecef !important;
    }

    .toggle.btn.on {
        background-color: #212529 !important;
        border-color: #212529 !important;
    }

    .btn-password-copy {
        box-shadow: none;
        border-top: 1px solid #d2d6da !important;
        border-bottom: 1px solid #d2d6da !important;
        border-radius: 0;
        
    }

    .btn-password-generate {
        box-shadow: none;
        background-color: gainsboro;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    
    .input-password {
        border-right: none;
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
</style>

@include('layouts.navbars.auth.topnav', ['title' => 'Role'])

<div class="card shadow-lg mx-4 card-profile-bottom">
    <div class="card-body p-3">
        <div class="row gx-4">
            <div class="col-auto">
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <p class="mb-0 font-weight-bold text-sm mt-3">

                        <a href="{{ url('roles') }}" class="btn btn-primary mx-1">Roles</a>
                        <a href="{{ url('permissions') }}" class="btn btn-info mx-1">Permissions</a>
                        <a href="{{ url('users') }}" class="btn btn-success mx-1">Users</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">

            @if ($errors->any())
            <ul class="alert alert-warning">
                @foreach ($errors->all() as $error)
                <li class="text-white mx-3">{{$error}}</li>
                @endforeach
            </ul>
            @endif

            <div class="card">
                <div class="card-header card-header__user">
                    <h4 class="mb-0">Create User</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('users') }}" method="POST" id="createUserForm">
                        @csrf

                        <div class="row">
                            <div class="col-3 mb-3">
                                <label class="" for="emp_code">Employee Code</label>
                                <input type="text" name="emp_code" class="form-control" maxlength="5"  />
                            </div>
                            <div class="col-9 mb-3">
                                <label for="username" class="required">Name</label>
                                <input type="text" name="username" class="form-control" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="required">Account</label>
                            <input type="text" name="email" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="required">password</label>
                            <div class="d-flex">
                                <input type="text" name="password" id="password" class="form-control input-password" required placeholder="click refresh to generate password" />
                                <button class="btn btn-password-copy mb-0" type="button" id="copyPasswordBtn" title="copy password to clipboard">
                                    <i class="fa-regular fa-clipboard"></i>
                                </button>
                                <button class="btn btn-password-generate mb-0" type="button" id="generatePasswordBtn" title="generate new password">
                                    <i class="fa-solid fa-repeat"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="supp_code">Supplier Code</label>
                            <input type="text" name="supp_code" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="roles-select" class="required">Roles</label>
                            <select name="roles[]" class="form-select" id="roles-select" data-placeholder="Choose anything" multiple required>
                                <option value="">select role</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="type-select" class="required">Type</label>
                            <select name="type" id="type-select" class="form-control" data-placeholder="Choose type" required>
                                <option value="">select type</option>
                                <option value="employee" selected>Employee</option>
                                <option value="customer">Customer</option>
                            </select>
                        </div>
                        <div class="card__active_status mb-4">
                            <div>
                                <h6 class="mb-0">Active Status</h6>
                                <p class="mb-0">Enable or disable this user account</p>
                            </div>
                            <div>
                                <input name="is_active" type="checkbox"
                                    checked
                                    data-toggle="toggle"
                                    data-on="Active"
                                    data-off="Inactive"
                                    data-onstyle="success">
                            </div>
                        </div>
                        <div class="float-end">
                            <a href="{{ url('users') }}" class="btn btn-secondary btn-lg mb-0">Back</a>
                            <button type="submit" class="btn btn-primary btn-lg mb-0">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
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
            return { valid: false, message: `Must be at least ${minLength} characters long.` };
        }
        if (!hasLowerCase) {
            return { valid: false, message: 'Must include at least one lowercase letter.' };
        }
        if (!hasUpperCase) {
            return { valid: false, message: 'Must include at least one uppercase letter.' };
        }
        if (!hasNumber) {
            return { valid: false, message: 'Must include at least one number.' };
        }
        if (!hasSymbol) {
            return { valid: false, message: 'Must include at least one special character (e.g., !@#$).' };
        }

        return { valid: true, message: 'password meets policy.' };
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

            password = password.split('').sort(() => 0.5 - Math.random()).join('');

            return password;
        }

        generatePasswordBtn.addEventListener('click', () => {
            const newPassword = generateStrongPassword(15);
            passwordField.value = newPassword;
        });

        copyPasswordBtn.addEventListener('click', () => {
            if (passwordField.value) {
                navigator.clipboard.writeText(passwordField.value)
                    .then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'copied!',
                            text: 'password copied to clipboard!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    })
                    .catch(err => {
                        console.error('could not copy text: ', err);
                        passwordField.select();
                        document.execCommand('copy');
                        alert('password copied to clipboard! (fallback)');
                    });
            } else {
                alert('nothing to copy. please generate a password first.');
            }
        });

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
                        html: `The generated password does not meet the strong password policy:<br><br><strong>${validation.message}</strong><br><br>Please click the refresh button to generate a new one.`,
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
    
</script>
@endsection
