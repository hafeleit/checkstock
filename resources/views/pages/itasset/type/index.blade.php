@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Asset Type List'])

    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .dt-layout-row {
            padding: 1.5rem;
        }

        .dt-layout-row.dt-layout-table {
            padding: 0rem;
            overflow: auto;
        }

        /* Custom UI Styles */
        .table-flush td,
        .table-flush th {
            vertical-align: middle;
            padding: 1rem 0.75rem;
            border-bottom: 1px solid #e9ecef;
        }

        .table-flush th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
            color: #8392ab;
        }

        .action-btn {
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }

        .action-btn:hover {
            background-color: #f8f9fa;
        }

        .action-btn.view:hover {
            color: #17c1e8 !important;
        }

        .action-btn.edit:hover {
            color: #cb0c9f !important;
        }
    </style>

    <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="col-12 px-0">
                <div class="card shadow-sm border-0">

                    {{-- Card Header & Actions --}}
                    <div class="card-header border-bottom pb-3 pt-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <div class="mb-3 mb-md-0">
                                <h5 class="mb-0"><i class="fas fa-tags me-2 text-primary"></i>All Asset Types</h5>
                                <p class="text-sm text-muted mb-0 mt-1">Manage and categorize different types of IT assets</p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @can('itasset_type create')
                                    <a href="{{ route('asset_types.create') }}" class="btn btn-primary btn-sm mb-0 shadow-sm">
                                        <i class="fas fa-plus me-1"></i> New Asset Type
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    {{-- Table Body --}}
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <table class="table table-flush table-hover w-100" id="products-list">
                                <thead class="bg-light rounded">
                                    <tr>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7">ID</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 ps-2">Type Code</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 ps-2">Type Description</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 ps-2">Status</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assetTypes as $assetType)
                                        <tr>
                                            <td class="text-sm font-weight-bold text-dark ps-3">{{ $assetType->id }}</td>
                                            <td>
                                                <span class="badge bg-light text-dark border">{{ $assetType->type_code }}</span>
                                            </td>
                                            <td class="text-sm font-weight-bold">{{ $assetType->type_desc }}</td>
                                            <td>
                                                @if (strtoupper($assetType->type_status) == 'ACTIVE')
                                                    <span class="badge badge-sm bg-success px-3">{{ $assetType->type_status }}</span>
                                                @elseif(strtoupper($assetType->type_status) == 'INACTIVE')
                                                    <span class="badge badge-sm bg-danger px-3">{{ $assetType->type_status }}</span>
                                                @else
                                                    <span class="badge badge-sm bg-secondary px-3">{{ $assetType->type_status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('asset_types.show', $assetType->id) }}" class="action-btn view text-secondary" data-bs-toggle="tooltip" data-bs-original-title="View Type">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('asset_types.edit', $assetType->id) }}" class="action-btn edit text-secondary ms-1" data-bs-toggle="tooltip" data-bs-original-title="Edit Type">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        $(document).ready(function() {
            // Initialize DataTable with UI refinements
            $("#products-list").DataTable({
                "language": {
                    "paginate": {
                        "previous": "<i class='fas fa-angle-left'></i>",
                        "next": "<i class='fas fa-angle-right'></i>"
                    }
                },
                "drawCallback": function() {
                    // Re-initialize tooltips
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                }
            });
        });
    </script>
@endsection
