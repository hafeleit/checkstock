<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>audit logs</title>

    <link id="pagestyle" href="{{ URL::to('/') }}/assets/css/argon-dashboard.css" rel="stylesheet" />
    <link id="pagestyle" href="{{ URL::to('/') }}/assets/css/checkstock.css" rel="stylesheet" />

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
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
</head>

<body>
    <div class="px-6 py-4">
        <h2>Audit Logs</h2>
        <div class="table-responsive">
            <table class="table table-hover w-full">
                <thead>
                    <tr class="text-sm">
                        <th scope="col" class="px-3">status</th>
                        <th scope="col" class="px-3">event</th>
                        <th scope="col" class="px-3">auditable type</th>
                        <th scope="col" class="px-3">auditable ID</th>
                        <th scope="col" class="px-3">file name</th>
                        <th scope="col" class="px-3">file size</th>
                        <th scope="col" class="px-3">error message</th>
                        <th scope="col" class="px-3">Created By ID</th>
                        <th scope="col" class="px-3">created at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr class="text-xs {{ $log->status === 'fail' ? 'bg-fail' : '' }} cursor-pointer" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $log->id }}" aria-expanded="false" aria-controls="collapse-{{ $log->id }}">
                        <td class="px-3">
                            @if ($log->status === 'pass')
                            <span class="badge rounded-pill bg-success">{{ $log->status }}</span>
                            @endif
                            @if ($log->status === 'fail')
                            <span class="badge rounded-pill bg-danger">{{ $log->status }}</span>
                            @endif
                        </td>
                        <td class="px-3">{{ $log->event }}</td>
                        <td class="px-3">{{ $log->auditable_type }}</td>
                        <td class="px-3">{{ $log->auditable_id }}</td>
                        <td class="px-3">{{ $log->file_name }}</td>
                        <td class="px-3">{{ $log->file_size }}</td>
                        <td class="px-3">{{ $log->error_message }}</td>
                        <td class="px-3">{{ $log->user_id }}</td>
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
</body>

</html>