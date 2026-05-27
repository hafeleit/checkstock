@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Import Document'])

<link href="{{ URL::to('/') }}/assets/css/inv-tracking.css" rel="stylesheet">

<div class="container-fluid py-4 px-2 px-md-3">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">

            {{-- Upload Form Card --}}
            <div class="card import-card mb-4">
                <div class="import-card-header">
                    <h5 class="mb-1 fw-bold text-dark">Upload Master Data</h5>
                    <p class="text-sm text-secondary mb-0">
                        Import master data into the system via Excel file (.xlsx).
                    </p>
                </div>
                <div class="import-card-body">
                    <form id="import-form" action="{{ route('delivery-trackings.imports.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="type" class="form-label fw-semibold text-dark required">Data Type</label>
                            <select class="form-select form-select-sm" id="type" name="type" required>
                                <option value="" selected disabled>Select data type...</option>
                                <option value="address">Address data</option>
                                <option value="hu_detail">HU Detail data</option>
                                <option value="invoice">Invoice data</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark required">Upload File</label>
                            <input class="d-none" id="file_input" type="file" name="file" accept=".xlsx" required>
                            <div class="upload-zone" id="upload-zone">
                                <div class="upload-icon">
                                    <i class="fas fa-cloud-upload-alt" id="upload-icon-el"></i>
                                </div>
                                <p class="upload-label mb-1">
                                    <span id="upload-zone-text">Drag &amp; drop your file here, or <strong>browse</strong></span>
                                </p>
                                <p class="upload-hint" id="upload-hint">Only .xlsx files are accepted</p>
                                <p class="file-name d-none" id="file-name-display"></p>
                            </div>
                        </div>

                        <button id="submit-button" type="submit" class="btn btn-primary btn-sm w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-upload"></i>
                            <span>Upload Data</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Upload History Card --}}
            <div class="card import-card mb-5">
                <div class="import-card-header">
                    <h5 class="mb-1 fw-bold text-dark">Upload History</h5>
                    <p class="text-sm text-secondary mb-0">Latest upload for each data type.</p>
                </div>
                <div class="import-card-body">

                    {{-- Invoice --}}
                    <div class="history-item">
                        <div class="history-icon {{ $latestLogs['invoice'] ? '' : 'empty' }}">
                            <i class="fas fa-file-excel"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-semibold text-dark history-type-label">Invoice</div>
                            @if($latestLogs['invoice'])
                                <div class="history-meta text-truncate">
                                    <span>{{ $latestLogs['invoice']['file_name'] }}</span>
                                    <span>{{ $latestLogs['invoice']['created_at'] }}</span>
                                </div>
                            @else
                                <div class="history-meta">No uploads yet</div>
                            @endif
                        </div>
                        @if($latestLogs['invoice'])
                            <span class="badge bg-success text-white history-badge">Uploaded</span>
                        @else
                            <span class="badge bg-light text-secondary border history-badge">None</span>
                        @endif
                    </div>

                    {{-- Address --}}
                    <div class="history-item">
                        <div class="history-icon {{ $latestLogs['address'] ? '' : 'empty' }}">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-semibold text-dark history-type-label">Address</div>
                            @if($latestLogs['address'])
                                <div class="history-meta text-truncate">
                                    <span>{{ $latestLogs['address']['file_name'] }}</span>
                                    <span>{{ $latestLogs['address']['created_at'] }}</span>
                                </div>
                            @else
                                <div class="history-meta">No uploads yet</div>
                            @endif
                        </div>
                        @if($latestLogs['address'])
                            <span class="badge bg-success text-white history-badge">Uploaded</span>
                        @else
                            <span class="badge bg-light text-secondary border history-badge">None</span>
                        @endif
                    </div>

                    {{-- HU Detail --}}
                    <div class="history-item">
                        <div class="history-icon {{ $latestLogs['hu_detail'] ? '' : 'empty' }}">
                            <i class="fas fa-cubes"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-semibold text-dark history-type-label">HU Detail</div>
                            @if($latestLogs['hu_detail'])
                                <div class="history-meta text-truncate">
                                    <span>{{ $latestLogs['hu_detail']['file_name'] }}</span>
                                    <span>{{ $latestLogs['hu_detail']['created_at'] }}</span>
                                </div>
                            @else
                                <div class="history-meta">No uploads yet</div>
                            @endif
                        </div>
                        @if($latestLogs['hu_detail'])
                            <span class="badge bg-success text-white history-badge">Uploaded</span>
                        @else
                            <span class="badge bg-light text-secondary border history-badge">None</span>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    var zone = document.getElementById('upload-zone');
    var fileInput = document.getElementById('file_input');
    var fileNameDisplay = document.getElementById('file-name-display');
    var uploadIconEl = document.getElementById('upload-icon-el');
    var uploadZoneText = document.getElementById('upload-zone-text');
    var uploadHint = document.getElementById('upload-hint');

    zone.addEventListener('click', function() { fileInput.click(); });

    zone.addEventListener('dragover', function(e) {
        e.preventDefault();
        zone.classList.add('dragover');
    });
    zone.addEventListener('dragleave', function() {
        zone.classList.remove('dragover');
    });
    zone.addEventListener('drop', function(e) {
        e.preventDefault();
        zone.classList.remove('dragover');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            updateFileDisplay(e.dataTransfer.files[0]);
        }
    });

    fileInput.addEventListener('change', function() {
        if (fileInput.files.length) updateFileDisplay(fileInput.files[0]);
    });

    function updateFileDisplay(file) {
        zone.classList.add('has-file');
        uploadIconEl.className = 'fas fa-check-circle';
        uploadZoneText.innerHTML = 'File selected';
        uploadHint.classList.add('d-none');
        fileNameDisplay.textContent = file.name;
        fileNameDisplay.classList.remove('d-none');
    }

    document.getElementById('import-form').addEventListener('submit', function() {
        Swal.fire({
            title: 'Uploading...',
            text: 'Please wait while your file is being processed.',
            allowOutsideClick: false,
            didOpen: function() { Swal.showLoading(); }
        });
    });
</script>
@if(session('success'))
<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    Swal.fire({
        title: 'Success!',
        text: "{{ session('success') }}",
        icon: 'success',
        showConfirmButton: true
    });
</script>
@endif

@if(session('error'))
<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    Swal.fire({
        title: 'Error!',
        text: "{{ session('error') }}",
        icon: 'error',
        showConfirmButton: true
    });
</script>
@endif
@endsection
