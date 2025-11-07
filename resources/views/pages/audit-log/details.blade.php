@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Logs'])

    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .cursor-pointer {
            cursor: pointer;
        }

        .max-width-100vw {
            max-width: 100vw;
        }

        .bg-fail {
            background-color: #FFEBEB;
            color: red;
        }
    </style>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div>
                            <h5 class="mb-0">{{ $title }}</h5>
                        </div>
                    </div>

                    <div class="card-body px-4">
                        <div class="row g-3 align-items-end mb-3">
                            <div class="col-md-4">
                                <label for="search_account" class="form-label">Search Account</label>
                                <input type="search" class="form-control form-control-sm search-field" id="search_account"
                                    value="{{ $params['search_account'] ?? '' }}">
                            </div>
                            <div class="col-md-auto">
                                <button type="button" class="btn btn-sm btn-dark uppercase mb-0"
                                    id="searchButton">Search</button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover w-full">
                                <thead>
                                    <tr class="text-sm">
                                        <th scope="col" class="px-3">Model / ID</th>
                                        <th scope="col" class="px-3">Event</th>
                                        <th scope="col" class="px-3">Account (Login)</th>
                                        <th scope="col" class="px-3">IP Address (Login)</th>
                                        <th scope="col" class="px-3">Device Type (Login)</th>
                                        <th scope="col" class="px-3">Login Time</th>
                                        <th scope="col" class="px-3">Field</th>
                                        <th scope="col" class="px-3">Old Value</th>
                                        <th scope="col" class="px-3">New Value</th>
                                        <th scope="col" class="px-3">Change By</th>
                                        <th scope="col" class="px-3">Change Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($logs && count($logs) > 0)
                                        @foreach ($logs as $log)
                                            <tr class="text-xs {{ $log['status'] == 'fail' ? 'bg-fail' : '' }}">
                                                <td class="px-3">{{ class_basename($log['auditable_type']) }} /
                                                    {{ $log['auditable_id'] }} </td>
                                                <td class="px-3">{{ $log['event'] }}</td>
                                                <td class="px-3">
                                                    {{ $log['event'] == 'login' || $log['event'] == 'external_login' ? $log['user']->email : '-' }}
                                                </td>
                                                <td class="px-3">
                                                    {{ $log['event'] == 'login' || $log['event'] == 'external_login' ? json_decode($log->new_values)->ip_address : '-' }}
                                                </td>
                                                <td class="px-3">
                                                    {{ $log['event'] == 'login' || $log['event'] == 'external_login' ? json_decode($log->new_values)->device_type : '-' }}
                                                </td>
                                                <td class="px-3">
                                                    {{ $log['event'] == 'login' || $log['event'] == 'external_login' ? $log['created_at'] : '-' }}
                                                </td>
                                                <td class="px-3">{{ $log['field'] ?? '-' }}</td>
                                                <td class="px-3">
                                                    @if ($log['event'] == 'role_permissions_updated')
                                                        <ul class="mb-0">
                                                            @foreach ($log['old_value'] as $oldValue)
                                                                <li>{{ $oldValue ?? '-' }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        @if ($log['field'] == 'roles' && $log['old_value'])
                                                            <ul class="mb-0">
                                                                @foreach ($log['old_value'] as $oldValue)
                                                                    <li>{{ $oldValue ?? '-' }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            {{ $log['old_value'] ?? '-' }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="px-3">
                                                    @if ($log['event'] == 'role_permissions_updated')
                                                        <ul class="mb-0">
                                                            @foreach ($log['new_value'] as $oldValue)
                                                                <li>{{ $oldValue ?? '-' }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        @if ($log['field'] == 'roles' && $log['new_value'])
                                                            <ul class="mb-0">
                                                                @foreach ($log['new_value'] as $oldValue)
                                                                    <li>{{ $oldValue ?? '-' }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            {{ $log['new_value'] ?? '-' }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="px-3">{{ $log['email'] ?? $log['user']->email }}</td>
                                                <td class="px-3">{{ $log['date'] ?? $log['created_at'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-xs">
                                            <td colspan="12" class="px-3 text-center">No Data</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>

                        @if ($logs && count($logs) > 0)
                            <div class="py-4">
                                {{ $logs->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        const handleSearch = () => {
            const searchAccount = document.getElementById('search_account').value;

            const data = {
                search_account: searchAccount
            };

            const filteredData = {};
            for (const key in data) {
                if (data[key]) {
                    filteredData[key] = data[key];
                }
            }

            const params = new URLSearchParams(filteredData).toString();
            const url = `/audit-logs/details${params ? '?' + params : ''}`;

            window.location.href = url;

        }

        const searchButton = document.getElementById('searchButton');
        if (searchButton) {
            searchButton.addEventListener('click', handleSearch);
        }
    </script>
@endsection
