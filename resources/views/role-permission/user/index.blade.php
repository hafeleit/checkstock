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
            <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="card mt-3">
                <div class="card-header card-header__user pb-0">
                    <h5 class="mb-0">Users</h5>
                    @can('user create')
                    <a href="{{ url('users/create') }}" class="btn btn-primary float-end mb-0">Add User</a>
                    @endcan
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

                                    @can('user delete')
                                    <a href="{{ url('users/'.$user->id.'/delete') }}" class="btn btn-danger mx-2 my-0">Delete</a>
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

        $('.').addClass('dataTable-top');
    });
</script>
@endsection