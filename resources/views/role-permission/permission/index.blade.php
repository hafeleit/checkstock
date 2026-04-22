@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Permissions'])

    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        * {
            box-sizing: border-box;
        }

        .eu-container {
            padding-top: 15rem;
            padding-bottom: 2rem;
        }

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

        .eu-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }

        .eu-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid #f2f2f2;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .eu-card-title {
            font-size: 0.82rem;
            font-weight: 700;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin: 0;
        }

        .rp-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.84rem;
        }

        .rp-table thead tr {
            border-bottom: 2px solid #f0f0f0;
        }

        .rp-table thead th {
            padding: 12px 16px;
            font-size: 0.72rem;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .rp-table tbody tr {
            border-bottom: 1px solid #f8f8f8;
            transition: background 0.15s;
        }

        .rp-table tbody tr:hover {
            background: #fafafa;
        }

        .rp-table tbody td {
            padding: 12px 16px;
            color: #1a1a1a;
            vertical-align: middle;
        }

        .rp-table tbody td.muted {
            color: #9ca3af;
            font-size: 0.8rem;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            border: 1.5px solid;
            transition: all 0.2s;
            background: transparent;
        }

        .btn-action-edit {
            border-color: #C8102E;
            color: #C8102E;
        }

        .btn-action-edit:hover {
            background: #C8102E;
            color: #fff;
        }

        .btn-action-delete {
            border-color: #ef4444;
            color: #ef4444;
        }

        .btn-action-delete:hover {
            background: #ef4444;
            color: #fff;
        }

        .btn-eu-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #C8102E 0%, #96091F 100%);
            color: #fff;
            font-size: 0.81rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.2s, transform 0.15s;
            box-shadow: 0 4px 14px rgba(200, 16, 46, 0.25);
        }

        .btn-eu-primary:hover {
            opacity: 0.9;
            color: #fff;
            transform: translateY(-1px);
        }

        .alert-status {
            background: rgba(16, 185, 129, 0.07);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-left: 4px solid #10b981;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 16px;
            font-size: 0.84rem;
            color: #065f46;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>

    <div class="container-fluid eu-container">
        <div class="eu-nav">
            <a href="{{ url('roles') }}" class="eu-nav-btn"><i class="fas fa-shield-alt fa-xs"></i> Roles</a>
            <a href="{{ url('permissions') }}" class="eu-nav-btn active"><i class="fas fa-key fa-xs"></i> Permissions</a>
            <a href="{{ url('users') }}" class="eu-nav-btn"><i class="fas fa-users fa-xs"></i> Users</a>
        </div>

        @if (session('status'))
            <div class="alert-status"><i class="fas fa-check-circle"></i> {{ session('status') }}</div>
        @endif

        <div class="eu-card">
            <div class="eu-card-header">
                <p class="eu-card-title">Permissions</p>
                @can('permission create')
                    <a href="{{ url('permissions/create') }}" class="btn-eu-primary">
                        <i class="fas fa-plus fa-xs"></i> Add Permission
                    </a>
                @endcan
            </div>
            <div class="table-responsive px-4">
                <table class="rp-table dataTable-table" id="permissions-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Permission Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td class="muted">{{ $permission->id }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @can('permission update')
                                            <a href="{{ url('permissions/' . $permission->id . '/edit') }}"
                                                class="btn-action btn-action-edit">
                                                <i class="fas fa-pen fa-xs"></i> Edit
                                            </a>
                                        @endcan
                                        @can('permission delete')
                                            <form action="{{ url('permissions/' . $permission->id . '/delete') }}"
                                                method="post">
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
            $("#permissions-list").DataTable({
                order: [
                    [0, 'asc']
                ]
            });
        });
    </script>
@endsection
