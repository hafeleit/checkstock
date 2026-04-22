@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

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
            flex-wrap: wrap;
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

        .eu-card-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
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

        .btn-eu-dark {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border: none;
            border-radius: 10px;
            background: #1a1a1a;
            color: #fff;
            font-size: 0.81rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .btn-eu-dark:hover {
            opacity: 0.85;
            color: #fff;
        }

        .search-wrap {
            padding: 16px 24px;
            border-bottom: 1px solid #f2f2f2;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .search-input-wrap {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
            min-width: 200px;
            max-width: 320px;
        }

        .search-label {
            font-size: 0.72rem;
            font-weight: 500;
            color: #6D6E71;
        }

        .search-input {
            background: #fff;
            border: 1px solid #e2e2e2;
            border-radius: 10px;
            color: #1a1a1a;
            padding: 8px 12px;
            font-size: 0.84rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
            width: 100%;
        }

        .search-input:focus {
            border-color: #C8102E;
            box-shadow: 0 0 0 3px rgba(200, 16, 46, 0.12);
        }

        .btn-search {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 16px;
            border: none;
            border-radius: 10px;
            background: #1a1a1a;
            color: #fff;
            font-size: 0.81rem;
            font-weight: 500;
            cursor: pointer;
            transition: opacity 0.2s;
            align-self: flex-end;
        }

        .btn-search:hover {
            opacity: 0.85;
        }

        .um-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.83rem;
        }

        .um-table thead tr {
            border-bottom: 2px solid #f0f0f0;
        }

        .um-table thead th {
            padding: 10px 14px;
            font-size: 0.71rem;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .um-table tbody tr {
            border-bottom: 1px solid #f8f8f8;
            transition: background 0.15s;
        }

        .um-table tbody tr:hover {
            background: #fafafa;
        }

        .um-table tbody td {
            padding: 11px 14px;
            color: #1a1a1a;
            vertical-align: middle;
        }

        .um-table tbody td.muted {
            color: #9ca3af;
            font-size: 0.78rem;
        }

        .badge-role {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 600;
            background: rgba(200, 16, 46, 0.08);
            color: #C8102E;
            margin: 1px;
        }

        .badge-active {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.74rem;
            font-weight: 600;
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        .badge-inactive {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.74rem;
            font-weight: 600;
            background: #f3f4f6;
            color: #9ca3af;
        }

        .btn-action-edit {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            border: 1.5px solid #C8102E;
            color: #C8102E;
            background: transparent;
            transition: all 0.2s;
        }

        .btn-action-edit:hover {
            background: #C8102E;
            color: #fff;
        }

        .badge-active i,
        .badge-inactive i {
            font-size: 6px;
        }

        .modal-content-rounded {
            border-radius: 16px;
            overflow: hidden;
        }

        .alert-modern {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 16px;
            border-radius: 12px;
            border: 1px solid transparent;
            border-left-width: 4px;
            font-size: 0.86rem;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .alert-modern-success {
            background: rgba(16, 185, 129, 0.07);
            border-color: rgba(16, 185, 129, 0.2);
            border-left-color: #10b981;
            color: #065f46;
        }

        .alert-modern-error {
            background: rgba(200, 16, 46, 0.06);
            border-color: rgba(200, 16, 46, 0.18);
            border-left-color: #C8102E;
            color: #C8102E;
        }
    </style>

    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])

    <div class="container-fluid eu-container">
        <div class="eu-nav">
            <a href="{{ url('roles') }}" class="eu-nav-btn"><i class="fas fa-shield-alt fa-xs"></i> Roles</a>
            <a href="{{ url('permissions') }}" class="eu-nav-btn"><i class="fas fa-key fa-xs"></i> Permissions</a>
            <a href="{{ url('users') }}" class="eu-nav-btn active"><i class="fas fa-users fa-xs"></i> Users</a>
        </div>

        @if (session('status'))
            <div class="alert-modern alert-modern-success"><i class="fas fa-check-circle"></i> {{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-modern alert-modern-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </span>
            </div>
        @endif

        <div class="eu-card">
            <div class="eu-card-header">
                <p class="eu-card-title">User Management</p>
                <div class="eu-card-actions">
                    @can('user import')
                        <button type="button" class="btn-eu-dark" data-bs-toggle="modal" data-bs-target="#importUsersModal">
                            <i class="fa-solid fa-upload fa-xs"></i> Import
                        </button>
                        <form action="{{ route('users.import-users') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal fade" id="importUsersModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content modal-content-rounded">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Import Users</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input class="form-control" type="file" name="user_file" accept=".xlsx,.xls">
                                        </div>
                                        @can('user import')
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Import</button>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endcan
                    @can('user create')
                        <a href="{{ url('users/create') }}" class="btn-eu-primary">
                            <i class="fas fa-user-plus fa-xs"></i> Add User
                        </a>
                    @endcan
                </div>
            </div>

            <div class="search-wrap">
                <div class="search-input-wrap">
                    <label class="search-label">Search</label>
                    <input type="search" class="search-input" id="search" value="{{ $params['search'] ?? '' }}"
                        placeholder="Employee code, name, account">
                </div>
                <button type="button" class="btn-search" id="searchButton">
                    <i class="fas fa-search fa-xs"></i> Search
                </button>
            </div>

            <div class="table-responsive">
                <table class="um-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Emp Code</th>
                            <th>Name</th>
                            <th>Account</th>
                            <th>Roles</th>
                            <th>Type</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($users))
                            @foreach ($users as $user)
                                <tr>
                                    <td class="muted">{{ $user->id }}</td>
                                    <td class="muted">{{ $user->emp_code ?? '—' }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td class="muted">{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->getRoleNames() as $role)
                                            <span class="badge-role">{{ $role }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ ucfirst($user->type) }}</td>
                                    <td class="muted">{{ $user->last_logged_in_at ?? '—' }}</td>
                                    <td>
                                        @if ($user->is_active)
                                            <span class="badge-active"><i class="fas fa-circle"></i>
                                                Active</span>
                                        @else
                                            <span class="badge-inactive"><i class="fas fa-circle"
                                                    style="font-size:6px;"></i> Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @can('user update')
                                            <a href="{{ url('users/' . $user->id . '/edit') }}" class="btn-action-edit">
                                                <i class="fas fa-pen fa-xs"></i> Edit
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center muted py-5">No users found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3">
                {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        const handleSearch = () => {
            const search = document.getElementById('search').value;
            const params = new URLSearchParams(search ? {
                search
            } : {}).toString();
            window.location.href = `/users${params ? '?' + params : ''}`;
        };

        const searchButton = document.getElementById('searchButton');
        if (searchButton) {
            searchButton.addEventListener('click', handleSearch);
        }

        document.getElementById('search').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') handleSearch();
        });
    </script>
@endsection
