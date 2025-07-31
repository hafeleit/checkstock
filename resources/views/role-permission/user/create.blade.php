@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<style media="screen">
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
                <li>{{$error}}</li>
                @endforeach
            </ul>
            @endif

            <div class="card">
                <div class="card-header card-header__user">
                    <h4 class="mb-0">Create User</h4>
                    <a href="{{ url('users') }}" class="btn btn-dark float-end mb-0">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ url('users') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="">Name</label>
                            <input type="text" name="username" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="text" name="email" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="">Supplier Code</label>
                            <input type="text" name="supp_code" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="roles-select">roles</label>
                            <select name="roles[]" class="form-select" id="roles-select" data-placeholder="Choose anything" multiple>
                                <option value="">select role</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
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
                        <div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('#roles-select').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
    });
</script>
@endsection