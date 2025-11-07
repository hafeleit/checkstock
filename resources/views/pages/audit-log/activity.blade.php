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
                                <label for="search-text" class="form-label">Search</label>
                                <input type="search" class="form-control form-control-sm search-field" id="search-text">
                            </div>
                            <div class="col-md-auto">
                                <button type="button" class="btn btn-sm btn-dark uppercase mb-0" id="searchButton">search</button>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table table-hover w-full">
                                <thead>
                                    <tr class="text-sm">
                                        <th scope="col" class="px-3">Model / ID</th>
                                        <th scope="col" class="px-3">Event</th>
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
                                            <tr class="text-xs">
                                                <td class="px-3">{{ class_basename($log['auditable_type']) }} /
                                                    {{ $log['auditable_id'] }} </td>
                                                <td class="px-3">{{ $log['event'] }}</td>
                                                <td class="px-3">{{ $log['field'] }}</td>
                                                <td class="px-3">
                                                    @if ($log['event'] == 'role_permissions_updated')
                                                        <ul>
                                                            @foreach ($log['old_value'] as $oldValue)
                                                                <li>{{ $oldValue }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        {{ $log['old_value'] }}
                                                    @endif
                                                </td>
                                                <td class="px-3">
                                                    @if ($log['event'] == 'role_permissions_updated')
                                                        <ul>
                                                            @foreach ($log['new_value'] as $oldValue)
                                                                <li>{{ $oldValue }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        {{ $log['new_value'] }}
                                                    @endif
                                                </td>
                                                <td class="px-3">{{ $log['email'] }}</td>
                                                <td class="px-3">{{ $log['date'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-xs">
                                            <td colspan="8" class="px-3 text-center">No Data</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>

                        <div class="py-4">
                            {{ $logs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
