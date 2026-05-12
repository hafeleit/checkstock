@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Delivery Tracking'])

    <link href="{{ URL::to('/') }}/assets/css/inv-tracking.css" rel="stylesheet">

    <div class="container-fluid py-4 px-2 px-md-3">
        <div class="card border-0 shadow-sm">

            {{-- Page Header --}}
            <div class="page-header-divider d-flex justify-content-between align-items-center flex-wrap gap-2 py-3 px-4">
                <div>
                    <h6 class="mb-0 fw-bold text-dark">Delivery Tracking — Details</h6>
                    <small class="text-muted">Line item view across all delivery documents</small>
                </div>
                @if (!$params)
                    <div class="d-flex align-items-center gap-2">
                        @can('delivery export overall report')
                            <button
                                class="btn btn-sm btn-export btn-month-export d-flex align-items-center gap-1"
                                data-bs-toggle="modal"
                                data-bs-target="#exportMonthModal"
                                data-export-url="/delivery-trackings/export-overall"
                                data-export-filename="overall-report">
                                <i class="fas fa-file-excel"></i>
                                <span>Overall Report</span>
                            </button>
                        @endcan
                        @can('delivery export pending report')
                            <button
                                class="btn btn-sm btn-export btn-month-export d-flex align-items-center gap-1"
                                data-bs-toggle="modal"
                                data-bs-target="#exportMonthModal"
                                data-export-url="/delivery-trackings/export-pending"
                                data-export-filename="pending-report">
                                <i class="fas fa-file-excel"></i>
                                <span>Pending ERP Report</span>
                            </button>
                        @endcan
                    </div>
                @endif
            </div>

            {{-- Search Panel --}}
            <div class="px-4 pt-3 pb-3">
                <div class="search-panel px-3 py-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3 col-sm-6">
                            <label for="logi_track_id" class="form-label text-xs text-uppercase fw-semibold text-muted mb-1">LogiTrack ID</label>
                            <input type="search" class="form-control form-control-sm search-field" id="logi_track_id" value="{{ $params['logi_track_id'] ?? '' }}" placeholder="e.g. D20-000001">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label for="driver_or_sent_to" class="form-label text-xs text-uppercase fw-semibold text-muted mb-1">Driver / Sent To</label>
                            <select class="form-control form-control-sm search-field" id="driver_or_sent_to" name="driver_or_sent_to">
                                <option value=""></option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->code }}" {{ ($params['driver_or_sent_to'] ?? '') == $driver->code ? 'selected' : '' }}>
                                        {{ $driver->code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label for="erp_document" class="form-label text-xs text-uppercase fw-semibold text-muted mb-1">Outbound No.</label>
                            <input type="search" class="form-control form-control-sm search-field" id="erp_document" value="{{ $params['erp_document'] ?? '' }}" placeholder="Outbound document no.">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label for="bill_no" class="form-label text-xs text-uppercase fw-semibold text-muted mb-1">Invoice No.</label>
                            <input type="search" class="form-control form-control-sm search-field" id="bill_no" value="{{ $params['invoice_id'] ?? '' }}" placeholder="Invoice no.">
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label for="type" class="form-label text-xs text-uppercase fw-semibold text-muted mb-1">Type</label>
                            <select class="form-select form-select-sm search-field" id="type" name="type">
                                <option value="">All</option>
                                <option value="return" {{ (isset($params['type']) && $params['type'] === 'return') ? 'selected' : '' }}>Return</option>
                                <option value="deliver" {{ (isset($params['type']) && $params['type'] === 'deliver') ? 'selected' : '' }}>Deliver</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label for="status" class="form-label text-xs text-uppercase fw-semibold text-muted mb-1">Status</label>
                            <select class="form-select form-select-sm search-field" id="status" name="status">
                                <option value="">All</option>
                                <option value="pending" {{ (isset($params['status']) && $params['status'] === 'pending') ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ (isset($params['status']) && $params['status'] === 'completed') ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label for="delivery_date" class="form-label text-xs text-uppercase fw-semibold text-muted mb-1">Delivery Date</label>
                            <input type="date" class="form-control form-control-sm search-field" id="delivery_date" value="{{ $params['delivery_date'] ?? '' }}">
                        </div>
                        <div class="col-md-auto col-sm-6">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-dark uppercase mb-0" id="searchButton">
                                    <i class="fas fa-search me-1"></i> Search
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary uppercase mb-0" id="clearButton">
                                    Clear
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="px-4 pb-4">
                <div class="table-responsive custom-shadow rounded">
                    <table class="table table-hover mb-0 tracking-table">
                        <thead>
                            <tr>
                                <th scope="col">Logi Track ID</th>
                                <th scope="col">Outbound No.</th>
                                <th scope="col">Invoice No.</th>
                                <th scope="col">Driver / Sent To</th>
                                <th scope="col">Delivery Date</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Type</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($invTrackings))
                                @foreach ($invTrackings as $item)
                                    <tr>
                                        <td class="fw-semibold">{{ $item['logi_track_id'] }}</td>
                                        <td>{{ $item['erp_document'] }}</td>
                                        <td>{{ $item['invoice_id'] ?? '—' }}</td>
                                        <td>{{ $item['driver_or_sent_to'] }}</td>
                                        <td>{{ $item['delivery_date'] ? $item['delivery_date']->format('d-m-Y H:i') : '—' }}</td>
                                        <td>{{ $item['user']['username'] ?? '—' }}</td>
                                        <td>{{ $item['created_date']->format('d-m-Y H:i') }}</td>
                                        <td>
                                            <span class="pill-type {{ $item['type'] === 'return' ? 'pill-type-return' : 'pill-type-deliver' }}">
                                                {{ $item['type'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill fw-semibold @if($item['status'] === 'completed') bg-success @else bg-secondary @endif">
                                                {{ $item['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="empty-state">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="d-block mx-auto">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                                <polyline points="10 9 9 9 8 9"></polyline>
                                            </svg>
                                            <p class="text-muted small mb-0">No records found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $invTrackings->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Export Month Picker Modal --}}
    <div class="modal fade" id="exportMonthModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-body px-4 pt-4 pb-3">
                    <button type="button" class="btn-close position-absolute top-0 end-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>

                    <div class="export-modal-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>

                    <p class="fw-semibold text-dark text-center mb-1">Select Export Month</p>
                    <p class="text-muted small text-center mb-3">Report will include records from the selected month only</p>

                    <div>
                        <label for="exportMonth" class="form-label text-xs text-uppercase fw-semibold text-muted mb-1">Month</label>
                        <input type="month" class="form-control form-control-sm" id="exportMonth">
                        <div class="invalid-feedback">Please select a month.</div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pt-0 pb-3 gap-2">
                    <button type="button" class="btn btn-sm btn-light flex-fill" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-dark flex-fill" id="exportMonthConfirm">
                        <i class="fas fa-file-excel me-1"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}" nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}" nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        $(document).ready(function() {
            $('#driver_or_sent_to').select2({
                placeholder: 'Search for a driver',
                allowClear: true,
                dropdownParent: $('body')
            });
        });

        const handleSearch = () => {
            const params = {
                logi_track_id: document.getElementById('logi_track_id').value,
                driver_or_sent_to: document.getElementById('driver_or_sent_to').value,
                erp_document: document.getElementById('erp_document').value,
                invoice_id: document.getElementById('bill_no').value,
                type: document.getElementById('type').value,
                status: document.getElementById('status').value,
                delivery_date: document.getElementById('delivery_date').value,
            };

            const query = Object.keys(params)
                .filter(key => params[key])
                .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`)
                .join('&');

            window.location.href = `${window.location.pathname}?${query}`;
        };

        function handleClear() {
            document.getElementById('logi_track_id').value = '';
            document.getElementById('driver_or_sent_to').value = '';
            document.getElementById('erp_document').value = '';
            document.getElementById('bill_no').value = '';
            document.getElementById('type').value = '';
            document.getElementById('status').value = '';
            document.getElementById('delivery_date').value = '';

            window.location.href = window.location.pathname;
        }

        const searchButton = document.getElementById('searchButton');
        const clearButton = document.getElementById('clearButton');

        if (searchButton) {
            searchButton.addEventListener('click', handleSearch);
        }

        if (clearButton) {
            clearButton.addEventListener('click', handleClear);
        }

        document.querySelectorAll('.search-field').forEach(field => {
            field.addEventListener('change', handleSearch);
            if (field.type === 'search' || field.type === 'text') {
                field.addEventListener('blur', handleSearch);
            }
        });

        // Month export modal
        let _exportUrl = '';
        let _exportFilename = '';

        document.querySelectorAll('.btn-month-export').forEach(function(btn) {
            btn.addEventListener('click', function() {
                _exportUrl = this.dataset.exportUrl;
                _exportFilename = this.dataset.exportFilename;
            });
        });

        document.getElementById('exportMonthModal').addEventListener('show.bs.modal', function() {
            const input = document.getElementById('exportMonth');
            input.classList.remove('is-invalid');
            if (!input.value) {
                const now = new Date();
                input.value = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0');
            }
        });

        document.getElementById('exportMonthConfirm').addEventListener('click', async function() {
            const input = document.getElementById('exportMonth');
            const month = input.value;

            if (!month) {
                input.classList.add('is-invalid');
                return;
            }
            input.classList.remove('is-invalid');

            const url = _exportUrl + '?month=' + month;
            const filename = _exportFilename + '-' + month.replace('-', '') + '.xlsx';

            bootstrap.Modal.getInstance(document.getElementById('exportMonthModal')).hide();

            const loader = document.getElementById('loader-wrapper');
            try {
                loader.classList.remove('loader-hidden');
                loader.style.display = 'flex';

                const response = await fetch(url);
                if (!response.ok) throw new Error('Export failed');

                const blob = await response.blob();
                const downloadUrl = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = downloadUrl;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(downloadUrl);
            } catch (error) {
                alert('Export error. Please try again.');
                console.error(error);
            } finally {
                loader.classList.add('loader-hidden');
                loader.style.display = 'none';
            }
        });
    </script>

@endsection
