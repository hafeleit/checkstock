@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Roles'])

    <div class="container-fluid eu-container">
        <div class="eu-nav">
            <a href="{{ url('roles') }}" class="eu-nav-btn active"><i class="fas fa-shield-alt fa-xs"></i> Roles</a>
            <a href="{{ url('permissions') }}" class="eu-nav-btn"><i class="fas fa-key fa-xs"></i> Permissions</a>
            <a href="{{ url('users') }}" class="eu-nav-btn"><i class="fas fa-users fa-xs"></i> Users</a>
        </div>

        @if (session('status'))
            <div class="alert-status"><i class="fas fa-check-circle"></i> {{ session('status') }}</div>
        @endif

        <div class="eu-card">
            <div class="eu-card-header">
                <p class="eu-card-title">Roles</p>
                @can('role create')
                    <a href="{{ url('roles/create') }}" class="btn-eu-primary">
                        <i class="fas fa-plus fa-xs"></i> Add Role
                    </a>
                @endcan
            </div>
            <div class="table-responsive px-4">
                <table class="rp-table dataTable-table" id="roles-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td class="muted">{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <div class="d-flex gap-2 flex-nowrap">
                                        <a href="{{ url('roles/' . $role->id . '/give-permissions') }}"
                                            class="btn-action btn-action-perm">
                                            <i class="fas fa-key fa-xs"></i> Permissions
                                        </a>
                                        @can('role update')
                                            <a href="{{ url('roles/' . $role->id . '/edit') }}"
                                                class="btn-action btn-action-edit">
                                                <i class="fas fa-pen fa-xs"></i> Edit
                                            </a>
                                        @endcan
                                        @can('role delete')
                                            <form action="{{ url('roles/' . $role->id . '/delete') }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn-action btn-action-delete py-2">
                                                    <i class="fas fa-trash fa-xs"></i> Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        $(document).ready(function() {
            $("#roles-list").DataTable({
                order: [
                    [0, 'asc']
                ]
            });
        });
    </script>
@endsection
