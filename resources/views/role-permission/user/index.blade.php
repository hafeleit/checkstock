@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
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
        .badge-success {
            background-color: #ddfff0;
            color: #009b58;
        }
    </style>

    @include('layouts.navbars.auth.topnav', ['title' => 'User'])

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
                            @can('user import')
                                <!-- Import user button -->
                                <button type="button" class="btn btn-dark m-0" data-bs-toggle="modal"
                                    data-bs-target="#importUsersModal">
                                    <div class="d-flex gap-2 align-items-center">
                                        <i class="fa-solid fa-upload"></i>
                                        <span>Import Users</span>
                                    </div>
                                </button>
                                <form action="{{ route('users.import-users') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal fade" id="importUsersModal" tabindex="-1"
                                        aria-labelledby="importUsersModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="importUsersModalLabel">Import Users</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input class="form-control" type="file" id="formFile" name="user_file"
                                                        accept=".xlsx, .xls">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">CANCEL</button>
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
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label for="search" class="form-label">Search</label>
                                <input type="search" class="form-control form-control-sm search-field" id="search" value="{{ $params['search'] ?? '' }}" placeholder="Search: employee code, name, account">
                            </div>
                            <div class="col-md-auto">
                                <button type="button" class="btn btn-sm btn-dark uppercase mb-0" id="searchButton">search</button>
                            </div>
                        </div>
                        
                        <div class="table-responsive rounded mt-3">
                            <table class="table table-hover mb-0">
                                <thead class="text-sm text-muted fw-bold">
                                    <tr>
                                        <th scope="col" class="py-3 px-3">
                                            <a href="{{ url()->current() }}?sort=id&direction={{ request('direction') === 'asc' ? 'desc' : 'asc' }}" class="text-decoration-none text-muted fw-bold">
                                                ID
                                                @if (request('sort') === 'id')
                                                    @if (request('direction') === 'asc')
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                                                    @endif
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-up-down"><polyline points="7 15 12 20 17 15"></polyline><polyline points="17 9 12 4 7 9"></polyline></svg>
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" class="py-3 px-3">Employee Code</th>
                                        <th scope="col" class="py-3 px-3">Name</th>
                                        <th scope="col" class="py-3 px-3">Account</th>
                                        <th scope="col" class="py-3 px-3">Roles</th>
                                        <th scope="col" class="py-3 px-3">Type</th>
                                        <th scope="col" class="py-3 px-3">Last Logged in</th>
                                        <th scope="col" class="py-3 px-3">Status</th>
                                        <th scope="col" class="py-3 px-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($users))
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="px-3">{{ $user->id }}</td>
                                                <td class="px-3">{{ $user->emp_code }}</td>
                                                <td class="px-3">{{ $user->username }}</td>
                                                <td class="px-3">{{ $user->email }}</td>
                                                <td class="px-3">
                                                    @if (!empty($user->getRoleNames()))
                                                        @foreach ($user->getRoleNames() as $role)
                                                            <label
                                                                class="badge bg-primary mx-1 my-0">{{ $role }}</label>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="px-3">{{ ucfirst($user->type) }}</td>
                                                <td class="text-center">{{ $user->last_logged_in_at ?? '-' }}</td>
                                                <td class="px-3">
                                                    @if ($user->is_active)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="px-3">
                                                    @can('user update')
                                                        <a href="{{ url('users/' . $user->id . '/edit') }}" class="my-0 py-1 btn btn-outline-primary btn-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                            </svg>
                                                            <span class="mx-2">Edit</span>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center">No Data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination Links -->
                    <div class=" m-3">
                        {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        const handleSearch = () => {
            const search = document.getElementById('search').value;
            const data = { search: search };

            const filteredData = {};
            for (const key in data) {
                if (data[key]) {
                    filteredData[key] = data[key];
                }
            }

            const params = new URLSearchParams(filteredData).toString();
            const url = `/users${params ? '?' + params : ''}`;

            window.location.href = url;
        };

        const searchButton = document.getElementById('searchButton');
        if (searchButton) {
            searchButton.addEventListener('click', handleSearch);
        }

        document.querySelectorAll('.search-field').forEach(field => {
            field.addEventListener('change', handleSearch);
            if (field.type === 'search' || field.type === 'text') {
                field.addEventListener('blur', handleSearch); 
            }
        });
    </script>
@endsection
