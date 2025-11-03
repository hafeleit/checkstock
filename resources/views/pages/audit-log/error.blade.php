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
                                        <th scope="col" class="px-3">status</th>
                                        <th scope="col" class="px-3">event</th>
                                        <th scope="col" class="px-3">Model / ID</th>
                                        <th scope="col" class="px-3">file name</th>
                                        <th scope="col" class="px-3">file size</th>
                                        <th scope="col" class="px-3">error message</th>
                                        <th scope="col" class="px-3">Change By</th>
                                        <th scope="col" class="px-3">created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                        <tr class="text-xs {{ $log->status === 'fail' ? 'bg-fail' : '' }} cursor-pointer"
                                            data-bs-toggle="collapse" data-bs-target="#collapse-{{ $log->id }}"
                                            aria-expanded="false" aria-controls="collapse-{{ $log->id }}">
                                            <td class="px-3">
                                                @if ($log->status === 'pass')
                                                    <span class="badge rounded-pill bg-success">{{ $log->status }}</span>
                                                @endif
                                                @if ($log->status === 'fail')
                                                    <span class="badge rounded-pill bg-danger">{{ $log->status }}</span>
                                                @endif
                                            </td>
                                            <td class="px-3">{{ $log->event }}</td>
                                            <td class="px-3">{{ class_basename($log->auditable_type) }} / {{ $log->auditable_id }}</td>
                                            <td class="px-3">{{ $log->file_name }}</td>
                                            <td class="px-3">{{ $log->file_size }}</td>
                                            <td class="px-3">{{ $log->error_message }}</td>
                                            <td class="px-3">{{ $log->user->email }}</td>
                                            <td class="px-3">{{ $log->created_at }}</td>
                                        </tr>
                                        <tr id="collapse-{{ $log->id }}" class="collapse text-xs">
                                            <td colspan="10">
                                                <div class="card card-body w-full">
                                                    <div>
                                                        <strong>old values:</strong>
                                                        <pre>{{ json_encode($log->old_values) }}</pre>
                                                    </div>
                                                    <div>
                                                        <strong>new values:</strong>
                                                        <pre>{{ json_encode($log->new_values) }}</pre>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
