@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')


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
