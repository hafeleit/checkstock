@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Import Document'])
<div class="container-fluid py-4">
    <div class="card">
        <div class="p-4">
            <h2 class="h5 mb-0"> Upload Master Data</h2>
            <p class="text-sm text-secondary mb-0">
                Upload Excel files to import master data into the system.
            </p>
        </div>

        <div class="px-4">
            <form id="import-form" action="{{ route('invoice-trackings.imports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col">
                    <div class="mb-2 col-6">
                        <label for="type" class="form-label required">Type</label>
                        <select class="form-select form-select-sm" id="type" name="type" required>
                            <option value="" selected disabled>Select type</option>
                            <option value="address">Address data</option>
                            <option value="hu_detail">HU Detail data</option>
                            <option value="invoice">Invoice data</option>
                        </select>
                    </div>
                    <div class="mb-2 col-6">
                        <label for="type" class="form-label required">Upload File</label>
                        <div class="flex items-center space-x-2">
                            <input class="hidden" id="file_input" type="file" name="file" accept=".xlsx" required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Only Excel files (.xlsx) are supported.
                        </p>
                    </div>
                </div>

                <div class="d-grid">
                    <button id="submit-button" type="submit" class="btn btn-primary uppercase d-flex align-items-center justify-content-center gap-2">
                        <i class="fa fa-plus-circle"></i>
                        <span>Upload data</span>
                    </button>
                </div>
            </form>

            <div class="card mb-5 border-0">
                <div class="card-body bg-light rounded">
                    <h5 class="card-title fw-bold">Upload History</h5>
                    <p class="card-subtitle text-muted mb-3">Recent master data uploads.</p>

                    <ul class="list-group">

                        <li class="list-group-item d-flex-col justify-content-start align-items-center mb-2 rounded border border-white p-2 shadow-sm">
                            @if($latestLogs['invoice'])
                            <div class="d-flex flex-column small">
                                <strong class="text-lg">Invoice</strong>
                                <span class="text-muted text-sm">Name: {{ $latestLogs['invoice']['file_name'] }}</span>
                                <span class="text-muted text-sm">Type: {{ $latestLogs['invoice']['type'] }}</span>
                                <span class="text-muted text-sm">Date: {{ $latestLogs['invoice']['created_at'] }}</span>
                            </div>
                            @else
                            <div class="d-flex flex-column small text-muted">
                                <strong class="text-lg">Invoice</strong>
                                <span>No data available</span>
                            </div>
                            @endif
                        </li>
                        <li class="list-group-item d-flex-col justify-content-start align-items-center mb-2 rounded border border-white p-2 shadow-sm">
                            @if($latestLogs['address'])
                            <div class="d-flex flex-column small">
                                <strong class="text-lg">Address</strong>
                                <span class="text-muted text-sm">Name: {{ $latestLogs['address']['file_name'] }}</span>
                                <span class="text-muted text-sm">Type: {{ $latestLogs['address']['type'] }}</span>
                                <span class="text-muted text-sm">Date: {{ $latestLogs['invoice']['created_at'] }}</span>
                            </div>
                            @else
                            <div class="d-flex flex-column small text-muted">
                                <strong class="text-lg">Address</strong>
                                <span>No data available</span>
                            </div>
                            @endif
                        </li>
                        <li class="list-group-item d-flex-col justify-content-start align-items-center mb-2 rounded border border-white p-2 shadow-sm">
                            @if($latestLogs['hu_detail'])
                            <div class="d-flex flex-column small">
                                <strong class="text-lg">HU Detail</strong>
                                <span class="text-muted text-sm">Name: {{ $latestLogs['hu_detail']['file_name'] }}</span>
                                <span class="text-muted text-sm">Type: {{ $latestLogs['hu_detail']['type'] }}</span>
                                <span class="text-muted text-sm">Date: {{ $latestLogs['invoice']['created_at'] }}</span>
                            </div>
                            @else
                            <div class="d-flex flex-column small text-muted">
                                <strong class="text-lg">HU Detail</strong>
                                <span>No data available</span>
                            </div>
                            @endif
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('import-form').addEventListener('submit', function(event) {
        Swal.fire({
            title: 'uploading...',
            text: 'please wait while your file is being processed.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
</script>
@if(session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
        icon: 'error',
        showConfirmButton: true
    });
</script>
@endif
@endsection