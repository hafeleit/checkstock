@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

<style media="screen">
    .dt-layout-row {
        padding: 1.5rem 0;
    }

    .dt-layout-row.dt-layout-table {
        padding: 0rem;
        overflow: auto;
    }

    .card-header__user {
        display: flex;
        align-items: center;
        justify-content: space-between;
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
            @if (session('status'))
            <div class="alert alert-success text-white font-weight-bold">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li class="text-white font-weight-bold mb-0">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card mt-3">
                <div class="card-header card-header__user pb-0">
                    <h5 class="mb-0">Users</h5>
                    <div class="d-flex gap-1">
                        @can('import users')
                        <!-- Import user button -->
                        <button type="button" class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#importUsersModal">
                            <div class="d-flex gap-2 align-items-center">
                                <i class="fa-solid fa-upload"></i>
                                <span>Import Users</span>
                            </div>
                        </button>
                        <form action="{{ route('users.import-users') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal fade" id="importUsersModal" tabindex="-1" aria-labelledby="importUsersModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="importUsersModalLabel">Import Users</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input class="form-control" type="file" id="formFile" name="user_file">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                                            <button type="submit" class="btn btn-primary">IMPORT</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endcan

                        <!-- Create user button -->
                        @can('user create')
                        <a href="{{ url('users/create') }}" class="btn btn-primary float-end mb-0">Add User</a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-flush dataTable-table" id="products-list">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Is Active</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $rolename)
                                    <label class="badge bg-primary mx-1 my-0">{{ $rolename }}</label>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if ($user->is_active)
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @can('user update')
                                    <a href="{{ url('users/'.$user->id.'/edit') }}" class="btn btn-success my-0">Edit</a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.0.6/js/dataTables.min.js"></script>
<link href="https://cdn.datatables.net/2.0.6/css/dataTables.dataTables.min.css" rel="stylesheet" />

<script>
    $(document).ready(function() {

        $("#products-list").DataTable({
            order: [
                [0, 'asc']
            ]
        });

        $('.dataTable-table').addClass('dataTable-top');
    });
</script>
@endsection