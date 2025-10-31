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
                        <div class="table-responsive">
                            <table class="table table-hover w-full">
                                <thead>
                                    <tr class="text-sm">
                                        <th scope="col" class="px-3">Account</th>
                                        <th scope="col" class="px-3">Login Time</th>
                                        <th scope="col" class="px-3">IP Address</th>
                                        <th scope="col" class="px-3">Fail Reason</th>
                                        <th scope="col" class="px-3">Device Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($logs && count($logs) > 0)
                                        @foreach ($logs as $log)
                                            <tr class="text-xs {{ $log->status === 'fail' ? 'text-danger' : '' }}">
                                                <td class="px-3">{{ $log->user->email }}</td>
                                                <td class="px-3">{{ $log->created_at }}</td>
                                                <td class="px-3">{{ (json_decode($log->new_values))->ip_address ?? null }}</td>
                                                <td class="px-3">{{ $log->error_message ?? null }}</td>
                                                <td class="px-3">{{ (json_decode($log->new_values))->device_type ?? null }}</td>
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
