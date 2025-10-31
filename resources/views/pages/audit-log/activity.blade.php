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
                                        <th scope="col" class="px-3">ID</th>
                                        <th scope="col" class="px-3">Model</th>
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
                                                <td class="px-3">{{ $log['auditable_id'] }}</td>
                                                <td class="px-3">{{ class_basename($log['auditable_type']) }}</td>
                                                <td class="px-3">{{ $log['event'] }}</td>
                                                <td class="px-3">{{ $log['field'] }}</td>
                                                <td class="px-3">{{ $log['old_value'] }}</td>
                                                <td class="px-3">{{ $log['new_value'] }}</td>
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
