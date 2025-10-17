@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav', ['title' => 'Role'])

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
</style>

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
                <div class="card-header">
                    <h4>Edit User</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('users/'.$user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-3 mb-3">
                                <label class="" for="emp_code">Employee Code</label>
                                <input type="text" name="emp_code" value="{{ $user->emp_code }}" class="form-control" maxlength="5"  />
                                @error('emp_code') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-9 mb-3">
                                <label for="username" class="required">Name</label>
                                <input type="text" name="username" value="{{ $user->username }}" class="form-control" required />
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="required">Account</label>
                            <input type="text" name="email" readonly value="{{ $user->email }}" class="form-control" required />
                            @error('email') <span class="text-danger">{{ $email }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" />
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="supp_code">Supplier Code</label>
                            <input type="text" name="supp_code" value="{{ $user->supp_code }}" class="form-control" />
                            @error('supp_code') <span class="text-danger">{{ $supp_code }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="roles-select" class="required">roles</label>
                            <select name="roles[]" class="form-select" id="roles-select" data-placeholder="Choose anything" multiple>
                                <option value="">select role</option>
                                @foreach ($roles as $role)
                                <option
                                    value="{{ $role }}"
                                    {{ in_array($role, $userRoles) ? 'selected':'' }}>
                                    {{ $role }}
                                </option>
                                @endforeach
                            </select>
                            @error('roles') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="type-select" class="required">Type</label>
                            <select name="type" id="type-select" class="form-control" data-placeholder="Choose type">
                                <option value="">select type</option>
                                <option value="employee" @if($user->type == 'employee') selected @endif>Employee</option>
                                <option value="customer" @if($user->type == 'customer') selected @endif>Customer</option>
                            </select>
                        </div>
                        <div class="card__active_status mb-4">
                            <div>
                                <h6 class="mb-0">Active Status</h6>
                                <p class="mb-0">Enable or disable this user account</p>
                            </div>
                            <div>
                                <input name="is_active" type="checkbox"
                                    {{ $user->is_active ? 'checked' : '' }}
                                    data-toggle="toggle"
                                    data-on="Active"
                                    data-off="Inactive"
                                    data-onstyle="success">
                            </div>
                        </div>
                        <div class="float-end">
                            <a href="{{ url('users') }}" class="btn btn-secondary btn-lg mb-0">Back</a>
                            <button type="submit" class="btn btn-primary btn-lg mb-0">Update</button>
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
</script>
@endsection
