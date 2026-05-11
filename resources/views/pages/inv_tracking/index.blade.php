@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Delivery Tracking'])

    <link href="{{ URL::to('/') }}/assets/css/inv-tracking.css" rel="stylesheet">

    <div class="container-fluid py-4 px-2 px-md-3">
        <div class="card border-0 shadow-sm">

            {{-- Page Header --}}
            <div class="page-header-divider d-flex justify-content-between align-items-center flex-wrap gap-2 py-3 px-4">
                <div>
                    <h6 class="mb-0 fw-bold text-dark">Delivery Tracking</h6>
                    <small class="text-muted">Manage all delivery and return records</small>
                </div>
                @canany(['delivery create deliver', 'delivery create return'])
                    <div class="dropdown">
                        <button class="btn btn-sm btn-danger uppercase mb-0 px-3" type="button" id="dropdownCreateButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus me-1"></i> Create Document
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-1" aria-labelledby="dropdownCreateButton">
                            @can('delivery create deliver')
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('delivery-trackings.delivers.index') }}">
                                        <i class="fas fa-fw fa-truck me-1 text-muted"></i>Deliver
                                    </a>
                                </li>
                            @endcan
                            @can('delivery create return')
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('delivery-trackings.returns.index') }}">
                                        <i class="fas fa-fw fa-undo me-1 text-muted"></i>Return
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                @endcanany
            </div>

            {{-- Search Panel --}}
            <div class="px-4 pt-3 pb-3">
                <div class="search-panel px-3 py-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="logi_track_id" class="form-label text-xs text-uppercase fw-semibold text-muted mb-1">LogiTrack ID</label>
                            <input type="search" class="form-control form-control-sm search-field" id="logi_track_id" value="{{ $params['logi_track_id'] ?? '' }}" placeholder="e.g. D20-000001">
                        </div>
                        <div class="col-md-3">
                            <label for="driver_or_sent_to" class="form-label text-xs text-uppercase fw-semibold text-muted mb-1">Driver / Sent To</label>
                            <select class="form-control form-control-sm search-field" id="driver_or_sent_to" name="driver_or_sent_to">
                                <option value=""></option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->code }}"
                                        {{ ($params['driver_or_sent_to'] ?? '') == $driver->code ? 'selected' : '' }}>
                                        {{ $driver->code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="delivery_date" class="form-label text-xs text-uppercase fw-semibold text-muted mb-1">Delivery Date</label>
                            <input type="date" class="form-control form-control-sm search-field" id="delivery_date" value="{{ $params['delivery_date'] ?? '' }}">
                        </div>
                        <div class="col-md-auto">
                            <button type="button" class="btn btn-sm btn-dark uppercase mb-0" id="searchButton">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
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
                                <th scope="col">Driver / Sent To</th>
                                <th scope="col">Delivery Date</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Type</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($invTrackings))
                                @foreach ($invTrackings as $item)
                                    <tr>
                                        <td>
                                            @can('delivery view details')
                                                <a href="/delivery-trackings/details?logi_track_id={{ $item['logi_track_id'] }}" class="tracking-id-link">{{ $item['logi_track_id'] }}</a>
                                            @else
                                                <span class="fw-semibold">{{ $item['logi_track_id'] }}</span>
                                            @endcan
                                        </td>
                                        <td>{{ $item['driver_or_sent_to'] }}</td>
                                        <td>{{ $item['delivery_date'] ? $item['delivery_date']->format('d-m-Y H:i') : '—' }}</td>
                                        <td>{{ $item['user']['username'] ?? '—' }}</td>
                                        <td>{{ $item['created_date']->format('d-m-Y H:i') }}</td>
                                        <td>
                                            <span class="pill-type {{ $item['type'] === 'return' ? 'pill-type-return' : 'pill-type-deliver' }}">{{ $item['type'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill fw-semibold @if ($item['status'] === 'completed') bg-success @else bg-secondary @endif">{{ $item['status'] }}</span>
                                        </td>
                                        <td class="td-action">
                                            <div class="d-flex gap-1 align-items-center justify-content-end">
                                                @canany(['delivery edit deliver', 'delivery edit return'])
                                                    <a href="/delivery-trackings/{{ $item['logi_track_id'] }}/edit" class="action-icon" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                        </svg>
                                                    </a>
                                                @endcanany

                                                @if ($item['type'] == 'deliver')
                                                    @canany(['delivery export deliver report', 'delivery export rtt report'])
                                                        <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#exportModal-{{ $item['logi_track_id'] }}" title="Export">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                                <line x1="12" y1="15" x2="12"y2="3"></line>
                                                            </svg>
                                                        </a>
                                                    @endcanany
                                                @else
                                                    @can('delivery export return report')
                                                        <a href="#" class="action-icon export-btn" data-url="/delivery-trackings/returns/export?logi_track_id={{ $item['logi_track_id'] }}" data-filename="return_document_sheet_{{ $item['logi_track_id'] }}.xlsx" title="Export">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                                            </svg>
                                                        </a>
                                                    @endcan
                                                @endif

                                                @canany(['delivery delete deliver', 'delivery delete return'])
                                                    <a href="#" class="action-icon action-danger delete-item-btn" data-track-id="{{ $item['logi_track_id'] }}" title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </a>
                                                @endcanany
                                            </div>

                                            {{-- Delete form (hidden, submitted by JS) --}}
                                            @canany(['delivery delete deliver', 'delivery delete return'])
                                                <form id="delete-form-{{ $item['logi_track_id'] }}" action="{{ route('delivery-trackings.destroy', $item['logi_track_id']) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endcanany

                                            {{-- Export modal for deliver type --}}
                                            @if ($item['type'] == 'deliver')
                                                <div class="modal fade" id="exportModal-{{ $item['logi_track_id'] }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                                        <div class="modal-content border-0 shadow-lg rounded-3">
                                                            <div class="modal-body px-4 pt-4 pb-3">
                                                                <button type="button" class="btn-close position-absolute top-0 end-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>

                                                                <div class="export-modal-icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                                        <polyline points="7 10 12 15 17 10"></polyline>
                                                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                    </svg>
                                                                </div>

                                                                <p class="fw-semibold text-dark text-center mb-1">Export Report</p>
                                                                <p class="text-muted small text-center mb-3">{{ $item['logi_track_id'] }}</p>

                                                                <div class="d-flex flex-column gap-2">
                                                                    @can('delivery export deliver report')
                                                                        <button
                                                                            class="export-report-btn export-btn"
                                                                            data-url="/delivery-trackings/delivers/export?logi_track_id={{ $item['logi_track_id'] }}&report_type=summary"
                                                                            data-filename="deliver_job_sheet_{{ $item['logi_track_id'] }}.xlsx">
                                                                            <span class="btn-icon icon-blue">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                                                </svg>
                                                                            </span>
                                                                            <span class="btn-label">
                                                                                Deliver Report
                                                                                <small class="d-block">Job sheet summary</small>
                                                                            </span>
                                                                        </button>
                                                                    @endcan
                                                                    @can('delivery export rtt report')
                                                                        <button
                                                                            class="export-report-btn export-btn"
                                                                            data-url="/delivery-trackings/delivers/export-rtt?logi_track_id={{ $item['logi_track_id'] }}&report_type=detail"
                                                                            data-filename="RTT_sheet_{{ $item['logi_track_id'] }}.xlsx">
                                                                            <span class="btn-icon icon-teal">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                                                </svg>
                                                                            </span>
                                                                            <span class="btn-label">
                                                                                RTT Report
                                                                                <small class="d-block">Detail sheet</small>
                                                                            </span>
                                                                        </button>
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-0 px-4 pt-0 pb-3">
                                                                <button type="button" class="btn btn-sm btn-light w-100" data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">
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

                            <div class="opacity-0 user-select-none" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                    <rect width="18" height="18" fill="none" />
                                </svg>
                            </div>
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

    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        $(document).ready(function() {
            $('#driver_or_sent_to').select2({
                placeholder: 'Search for a driver',
                allowClear: true,
                dropdownParent: $('body')
            });
        });

        const handleSearch = () => {
            const logiTrackId = document.getElementById('logi_track_id').value;
            const driverOrSentTo = document.getElementById('driver_or_sent_to').value;
            const deliveryDate = document.getElementById('delivery_date').value;

            const data = {
                logi_track_id: logiTrackId,
                driver_or_sent_to: driverOrSentTo,
                delivery_date: deliveryDate
            };

            const filteredData = {};
            for (const key in data) {
                if (data[key]) {
                    filteredData[key] = data[key];
                }
            }

            const params = new URLSearchParams(filteredData).toString();
            const url = `/delivery-trackings${params ? '?' + params : ''}`;

            window.location.href = url;
        };

        const searchButton = document.getElementById('searchButton');
        if (searchButton) {
            searchButton.addEventListener('click', handleSearch);
        }

        function confirmDelete(logiTrackId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this record!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary',
                    actions: 'd-flex gap-2 justify-content-center'
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait, deleting the record...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    document.getElementById('delete-form-' + logiTrackId).submit();
                }
            });
        }

        document.querySelectorAll('.delete-item-btn').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const trackId = this.getAttribute('data-track-id');
                confirmDelete(trackId);
            });
        });
    </script>

    @if (session('success'))
        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
            Swal.fire({
                title: "Success!",
                text: "{{ session('success') }}",
                icon: "success",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
            Swal.fire({
                title: "Error!",
                text: "{{ session('error') }}",
                icon: "error",
                showConfirmButton: true
            });
        </script>
    @endif

@endsection
