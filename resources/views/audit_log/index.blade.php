<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>audit logs</title>

    <link id="pagestyle" href="{{ URL::to('/') }}/assets/css/argon-dashboard.css" rel="stylesheet" />

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>

<body>
    <div class="px-6 py-4">
        <h2>Audit Logs</h2>

        <table class="table overflow-hidden">
            <thead>
                <tr>
                    <th scope="col">user ID</th>
                    <th scope="col">status</th>
                    <th scope="col">event</th>
                    <th scope="col">auditable type</th>
                    <th scope="col">auditable ID</th>
                    <th scope="col">values</th>
                    <th scope="col">file name</th>
                    <th scope="col">file size</th>
                    <th scope="col">error message</th>
                    <th scope="col">created at</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr class="text-sm">
                    <td class="px-4">{{ $log->user_id }}</td>
                    <td class="px-4">
                        @if ($log->status === 'pass')
                        <span class="badge rounded-pill bg-success">{{ $log->status }}</span>
                        @endif
                        @if ($log->status === 'fail')
                        <span class="badge rounded-pill bg-danger">{{ $log->status }}</span>
                        @endif
                    </td>
                    <td class="px-4">{{ $log->event }}</td>
                    <td class="px-4">{{ $log->auditable_type }}</td>
                    <td class="px-4">{{ $log->auditable_id }}</td>
                    <td class="px-4">
                        <button class="btn btn-xs btn-primary mb-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $log->id }}" aria-expanded="false" aria-controls="collapse-{{ $log->id }}">
                            show values
                        </button>
                    </td>
                    <td class="px-4">{{ $log->file_name }}</td>
                    <td class="px-4">{{ $log->file_size }}</td>
                    <td class="px-4">{{ $log->error_message }}</td>
                    <td class="px-4">{{ $log->created_at->format('y-m-d h:i:s') }}</td>
                </tr>
                <tr id="collapse-{{ $log->id }}" class="collapse">
                    <td colspan="10">
                        <div class="card card-body">
                            <div>
                                <strong>old values:</strong>
                                <pre style="white-space: pre-wrap">{{ json_encode($log->old_values) }}</pre>
                            </div>
                            <div>
                                <strong>new values:</strong>
                                <pre style="white-space: pre-wrap">{{ json_encode($log->new_values) }}</pre>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>