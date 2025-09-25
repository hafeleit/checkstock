@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Delivery Tracking'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center py-4 px-4">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="h5 mb-0">Delivery Tracking Lists</h2>
            </div>
            <!-- Dropdown create job -->
            @canany(['delivery create deliver', 'delivery create return'])
            <div class="dropdown">
                <button class="btn btn-danger dropdown-toggle uppercase mb-0" type="button" id="dropdownCreateButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Create Document
                </button>
                <ul class="dropdown-menu shadow" aria-labelledby="dropdownCreateButton">
                    @can('delivery create deliver')
                    <li><a class="dropdown-item" href="{{ route('delivery-trackings.delivers.index') }}">Deliver</a></li>
                    @endcan
                    @can('delivery create return')
                    <li><a class="dropdown-item" href="{{ route('delivery-trackings.returns.index') }}">Return</a></li>
                    @endcan
                </ul>
            </div>
            @endcanany
        </div>

        <div class="mb-3 px-4">
            <!-- Search form -->
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="logi_track_id" class="form-label">LogiTrack ID</label>
                    <input type="search" class="form-control form-control-sm search-field" id="logi_track_id" value="{{ $params['logi_track_id'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="driver_or_sent_to" class="form-label">Driver/Sent To</label>
                    <select class="form-control form-control-sm search-field" id="driver_or_sent_to" name="driver_or_sent_to">
                        <option value=""></option>
                        @foreach($drivers as $driver)
                        <option value="{{ $driver->code }}" {{ ($params['driver_or_sent_to'] ?? '') == $driver->code ? 'selected' : '' }}>
                            {{ $driver->code }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="delivery_date" class="form-label">Delivery Date</label>
                    <input type="date" class="form-control form-control-sm search-field" id="delivery_date" value="{{ $params['delivery_date'] ?? '' }}">
                </div>
                <div class="col-md-auto">
                    <button type="button" id="searchBtn" class="btn btn-dark uppercase mb-0">search</button>
                </div>
            </div>
        </div>

        <div class="px-4 py-4">
            <div class="table-responsive custom-shadow rounded">
                <table class="table table-hover mb-0">
                    <thead class="text-xs text-muted text-uppercase bg-light">
                        <tr>
                            <th scope="col" class="py-3 px-3">Logi Track ID</th>
                            <th scope="col" class="py-3 px-3">Driver/Sent To</th>
                            <th scope="col" class="py-3 px-3">Delivery Date</th>
                            <th scope="col" class="py-3 px-3">Created By</th>
                            <th scope="col" class="py-3 px-3">Created Date</th>
                            <th scope="col" class="py-3 px-3">Type</th>
                            <th scope="col" class="py-3 px-3">Status</th>
                            <th scope="col" class="py-3 px-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($invTrackings))
                        @foreach ($invTrackings as $item)
                        <tr>
                            <td class="py-3 px-3">
                                <a href="/delivery-trackings/details?logi_track_id={{ $item['logi_track_id'] }}">
                                    {{ $item['logi_track_id'] }}
                                </a>
                            </td>
                            <td class="py-3 px-3">{{ $item['driver_or_sent_to'] }}</td>
                            <td class="py-3 px-3">{{ $item['delivery_date'] ? $item['delivery_date']->format('d-m-Y H:i:s') : '-' }}</td>
                            <td class="py-3 px-3">{{ $item['user']['username'] }}</td>
                            <td class="py-3 px-3">{{ $item['created_date']->format('d-m-Y H:i:s') }}</td>
                            <td class="py-3 px-3">
                                <span class="fw-semibold capitalize @if($item['type'] === 'return') text-success @else text-muted @endif">
                                    {{ $item['type'] }}
                                </span>
                            </td>
                            <td class="py-3 px-3">
                                <span class="badge fw-semibold @if($item['status'] === 'completed') bg-success @else bg-secondary @endif">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-end d-flex gap-3 align-items-center justify-content-end">
                                @canany(['delivery edit deliver', 'delivery edit return'])
                                <a href="/delivery-trackings/{{ $item['logi_track_id'] }}/edit" class="text-dark">
                                    <!-- Edit SVG Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                                @endcanany

                                <!-- Export SVG Icon -->
                                @if ($item['type'] == 'deliver')
                                @canany(['delivery export deliver report', 'delivery export rtt report'])
                                <a href="#" class="text-dark" data-bs-toggle="modal" data-bs-target="#exportModal-{{ $item['logi_track_id'] }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </a>
                                @endcanany
                                @else
                                @can('delivery export return report')
                                <a href="/delivery-trackings/returns/export?logi_track_id={{ $item['logi_track_id'] }}" class="text-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </a>
                                @endcan
                                @endif
                                @if ($item['type'] == 'deliver')
                                <div class="modal fade" id="exportModal-{{ $item['logi_track_id'] }}" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exportModalLabel">Select Report Type</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <p>Please choose which report you want to export:</p>
                                                @can('delivery export deliver report')
                                                <a href="/delivery-trackings/delivers/export?logi_track_id={{ $item['logi_track_id'] }}&report_type=summary" class="btn btn-primary m-1">
                                                    <i class="fas fa-print"></i> Deliver Report
                                                </a>
                                                @endcan
                                                @can('delivery export rtt report')
                                                <a href="/delivery-trackings/delivers/export-rtt?logi_track_id={{ $item['logi_track_id'] }}&report_type=detail" class="btn btn-export-rtt m-1">
                                                    <i class="fas fa-print"></i> RTT Report
                                                </a>
                                                @endcan
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Delete Button -->
                                @canany(['delivery delete deliver', 'delivery delete return'])
                                <form id="delete-form-{{ $item['logi_track_id'] }}" action="{{ route('delivery-trackings.destroy', $item['logi_track_id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" class="text-danger delete-link" data-id="{{ $item['logi_track_id'] }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </a>
                                </form>
                                @endcanany
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8" class="text-center py-3">No Data</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $invTrackings->withQueryString()->links() }}
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
            allowClear: true
        });
    });

    document.querySelectorAll('.search-field').forEach(function(element) {
        element.addEventListener('change', function() {
            handleSearch();
        });
    });

    const searchBtn = document.getElementById('searchBtn');
    if (searchBtn) {
        searchBtn.addEventListener('click', function() {
            handleSearch();
        });
    }

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

    document.addEventListener('DOMContentLoaded', function() {
        const deleteLinks = document.querySelectorAll('.delete-link');
        deleteLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const logiTrackId = this.dataset.id;
                confirmDelete(logiTrackId);
            });
        });
    });

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
</script>

@if(session('success'))
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

@if(session('error'))
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