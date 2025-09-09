@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Invoice Tracking'])

<style>
    .custom-shadow {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .text-primary-custom {
        color: #dc3545 !important;
    }

    .bg-primary-custom {
        background-color: #dc3545 !important;
    }

    .btn-export {
        background-color: #17a2b8;
        color: white;
    }

    .btn-export:hover {
        background-color: #017587;
        color: white;
    }

    .capitalize {
        text-transform: capitalize;
    }

    .uppercase {
        text-transform: uppercase;
    }

    .select2-container--default .select2-selection--single {
        height: 30px !important;
        border: 1px solid #d2d6da !important;
        border-radius: 8px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        font-size: 12px !important;
    }

    p.text-sm.text-gray-700.leading-5.dark\:text-gray-400 {
        margin-bottom: 0px;
    }

    .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
        margin-top: 12px;
    }
</style>

<div class="container-fluid py-4">
    <div class="card">
        <div class="my-3 px-4">
            <!-- Search form -->
            <div class="row gx-3 align-items-end">
                <div class="col-md-3">
                    <label for="logi_track_id" class="form-label">LogiTrack ID</label>
                    <input onchange="handleSearch()" type="search" class="form-control form-control-sm" id="logi_track_id" value="{{ $params['logi_track_id'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="driver_or_sent_to" class="form-label">Driver/Sent To</label>
                    <select class="form-control form-control-sm" id="driver_or_sent_to" name="driver_or_sent_to" style="width: 100%" onchange="handleSearch()">
                        <option value=""></option>
                        @foreach($drivers as $driver)
                        <option value="{{ $driver->code }}" {{ ($params['driver_or_sent_to'] ?? '') == $driver->code ? 'selected' : '' }}>
                            {{ $driver->code }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="erp_document" class="form-label">Outbound No.</label>
                    <input onchange="handleSearch()" type="search" class="form-control form-control-sm" id="erp_document" value="{{ $params['erp_document'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="bill_no" class="form-label">Invoice No.</label>
                    <input onchange="handleSearch()" type="search" class="form-control form-control-sm" id="bill_no" value="{{ $params['invoice_id'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">Type</label>
                    <select onchange="handleSearch()" class="form-select form-select-sm" id="type" name="type">
                        <option value="">All</option>
                        <option value="return" {{ (isset($params['type']) && $params['type'] === 'return') ? 'selected' : '' }}>Return</option>
                        <option value="deliver" {{ (isset($params['type']) && $params['type'] === 'deliver') ? 'selected' : '' }}>Deliver</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select onchange="handleSearch()" class="form-select form-select-sm" id="status" name="status">
                        <option value="">All</option>
                        <option value="pending" {{ (isset($params['status']) && $params['status'] === 'pending') ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ (isset($params['status']) && $params['status'] === 'completed') ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="delivery_date" class="form-label">Delivery Date</label>
                    <input onchange="handleSearch()" type="date" class="form-control form-control-sm" id="delivery_date" value="{{ $params['delivery_date'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-dark uppercase mb-0" onclick="handleSearch()">search</button>
                    <button type="button" class="btn btn-outline-dark uppercase mb-0" onclick="handleClear()">clear</button>
                </div>
            </div>
        </div>

        <div class="px-4 py-4">

            <div class="d-flex align-items-center justify-content-end gap-2">
                @can('delivery export overall report')
                <a href="/invoice-trackings/export-overall" class="btn btn-export btn-sm d-flex align-items-center gap-2">
                    <i class="fas fa-print"></i>
                    <span>Overall report</span>
                </a>
                @endcan
                @can('delivery export pending report')
                <a href="/invoice-trackings/export-pending" class="btn btn-export btn-sm d-flex align-items-center gap-2">
                    <i class="fas fa-print"></i>
                    <span>Pending ERP report</span>
                </a>
                @endcan
            </div>

            <div class="table-responsive custom-shadow rounded">
                <table class="table table-hover mb-0">
                    <thead class="text-xs text-muted text-uppercase bg-light">
                        <tr>
                            <th scope="col" class="py-3 px-3">Logi Track ID</th>
                            <th scope="col" class="py-3 px-3">Outbound No.</th>
                            <th scope="col" class="py-3 px-3">Invoice No.</th>
                            <th scope="col" class="py-3 px-3">Driver/Sent To</th>
                            <th scope="col" class="py-3 px-3">Delivery Date</th>
                            <th scope="col" class="py-3 px-3">Created By</th>
                            <th scope="col" class="py-3 px-3">Created Date</th>
                            <th scope="col" class="py-3 px-3">Type</th>
                            <th scope="col" class="py-3 px-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($invTrackings))
                        @foreach ($invTrackings as $item)
                        <tr>
                            <td class="py-3 px-3">{{ $item['logi_track_id'] }}</td>
                            <td class="py-3 px-3">{{ $item['erp_document'] }}</td>
                            <td class="py-3 px-3">{{ $item['invoice_id'] ?? null }}</td>
                            <td class="py-3 px-3">{{ $item['driver_or_sent_to'] }}</td>
                            <td class="py-3 px-3">{{ $item['delivery_date'] ? $item['delivery_date']->format('d-m-Y') : '-' }}</td>
                            <td class="py-3 px-3">{{ $item['user']['username'] }}</td>
                            <td class="py-3 px-3">{{ $item['created_date']->format('d-m-Y') }}</td>
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
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-center py-3">No Data</td>
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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#driver_or_sent_to').select2({
            placeholder: 'Search for a driver',
            allowClear: true
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
</script>

@endsection