@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Asset List'])

    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .dt-layout-row {
            padding: 1.5rem 0;
        }

        .dt-layout-row.dt-layout-table {
            padding: 0rem;
            overflow: auto;
        }

        /* custom ui styles */
        .card-summary {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-summary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        }

        .avatar-asset {
            width: 45px;
            height: 45px;
            object-fit: contain;
            background-color: #f8f9fa;
            padding: 0.25rem;
            border-radius: 0.5rem;
            border: 1px solid #e9ecef;
        }

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
        {{-- summary cards --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card shadow-sm card-summary h-100">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-xs mb-1 text-uppercase font-weight-bold text-muted">Total Asset</p>
                                    <h4 class="font-weight-bolder text-dark mb-0">{{ NUMBER_FORMAT($itassets_cnt) ?? '0' }}</h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-primary text-white shadow-sm text-center rounded-circle d-flex justify-content-center">
                                    <i class="fas fa-boxes text-lg" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card shadow-sm card-summary h-100">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-xs mb-1 text-uppercase font-weight-bold text-muted">Notebooks / Spare</p>
                                    <h4 class="font-weight-bolder text-dark mb-0">
                                        {{ NUMBER_FORMAT($total_notebook) ?? '0' }} <span class="text-sm font-weight-normal text-secondary">/ {{ NUMBER_FORMAT($total_notebook_spare) ?? '0' }}</span>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-success text-white shadow-sm text-center rounded-circle d-flex justify-content-center">
                                    <i class="fas fa-laptop text-lg" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card shadow-sm card-summary h-100">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-xs mb-1 text-uppercase font-weight-bold text-muted">PC / Spare</p>
                                    <h4 class="font-weight-bolder text-dark mb-0">
                                        {{ NUMBER_FORMAT($total_pc) ?? '0' }} <span class="text-sm font-weight-normal text-secondary">/ {{ NUMBER_FORMAT($total_pc_spare) ?? '0' }}</span>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-warning text-white shadow-sm text-center rounded-circle d-flex justify-content-center">
                                    <i class="fas fa-desktop text-lg" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card shadow-sm card-summary h-100">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-xs mb-1 text-uppercase font-weight-bold text-muted">Total Spare</p>
                                    <h4 class="font-weight-bolder text-dark mb-0">
                                        {{ NUMBER_FORMAT($total_spare) ?? '0' }}
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-danger text-white shadow-sm text-center rounded-circle d-flex justify-content-center">
                                    <i class="fas fa-tools text-lg" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- main table card --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">

                    {{-- card header & actions --}}
                    <div class="card-header border-bottom pb-3 pt-4">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success text-white">
                                <p class="mb-0">{{ $message }}</p>
                            </div>
                        @endif

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <div class="mb-3 mb-md-0">
                                <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Asset Inventory</h5>
                                <p class="text-sm text-muted mb-0 mt-1">Manage and track all IT assets in the system</p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button class="export-itasset-btn btn btn-outline-success btn-sm mb-0" data-url="/itasset-export" data-filename="ITAsset.xlsx">
                                    <i class="fas fa-file-excel me-1"></i> Export
                                </button>

                                @can('itasset create')
                                    <a href="{{ route('itasset.create') }}" class="btn btn-primary btn-sm mb-0 shadow-sm" target="_blank">
                                        <i class="fas fa-plus me-1"></i> New Asset
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    {{-- import modal --}}
                    <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog mt-lg-10">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title" id="ModalLabel">Import CSV Data</h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('usermaster-import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="text-center mb-4">
                                            <i class="fas fa-cloud-upload-alt text-primary fa-3x mb-3"></i>
                                            <p class="text-sm mb-0">Select a CSV file to upload asset data.</p>
                                        </div>
                                        <input type="file" class="form-control mb-3" name="file" required>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button type="button" class="btn btn-light btn-sm mb-0" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary btn-sm mb-0"><i class="fas fa-upload me-1"></i> Upload Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- table body --}}
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <table class="table table-flush table-hover w-100" id="products-list">
                                <thead class="bg-light rounded">
                                    <tr>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Computer Name</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 ps-2">Current User</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 ps-2">Software Name</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 ps-2">Serial Number</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 ps-2">Type</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 ps-2">Status</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($itassets as $itasset)
                                        <tr>
                                            <td>
                                                <a href="{{ route('itasset.show', $itasset->id) }}">
                                                    <div class="d-flex align-items-center">
                                                        @php
                                                            $images = [
                                                                'T01' => 'macbook-pro.jpg',
                                                                'T02' => 'pc.jpg',
                                                                'T03' => 'printer-fuji.jpg',
                                                                'T05' => 'headset.jpg',
                                                                'T06' => 'telephone_sim.jpg',
                                                                'T07' => 'tv.png',
                                                                'T08' => 'copy_machine.png',
                                                                'T09' => 'handheld.png',
                                                                'T10' => 'mobile_printer.jpg',
                                                                'T11' => 'pos.png',
                                                                'T12' => 'phone_number.png',
                                                                'T13' => 'microphone.png',
                                                                'T14' => 'usb_flash_drive.png',
                                                                'T15' => 'video_conference.png',
                                                                'T16' => 'speaker.png',
                                                                'T17' => 'mobile_phone.png',
                                                                'T18' => 'tablet.png',
                                                            ];
                                                            $image = $images[$itasset->type] ?? null;
                                                        @endphp

                                                        @if ($image)
                                                            <img class="avatar-asset" src="{{ URL::to('/') . '/img/itasset/' . $image }}" alt="Asset Image">
                                                        @else
                                                            <div class="avatar-asset d-flex align-items-center justify-content-center bg-gray-200">
                                                                <i class="fas fa-desktop text-secondary"></i>
                                                            </div>
                                                        @endif

                                                        <div class="ms-3">
                                                            <h6 class="mb-0 text-sm font-weight-bold text-dark">{{ $itasset->computer_name }}</h6>
                                                            <p class="text-xs text-muted mb-0">{{ $itasset->model ?? '' }}</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $itasset->name_en ?? 'N/A' }}</p>
                                                <p class="text-xs text-muted mb-0">{{ $itasset->user }}</p>
                                            </td>
                                            <td>
                                                <span class="text-sm">{{ $itasset->software_name ? str_replace('_', ' ', $itasset->software_name) : '-' }}</span>
                                            </td>
                                            <td>
                                                <span class="text-sm font-weight-bold">{{ $itasset->serial_number ?: '-' }}</span>
                                            </td>
                                            <td>
                                                <span class="text-sm">{{ $itasset->type_desc }}</span>
                                            </td>
                                            <td>
                                                @if ($itasset->status == 'ACTIVE')
                                                    <span class="badge badge-sm bg-success px-3">{{ $itasset->status }}</span>
                                                @elseif($itasset->status == 'SPARE')
                                                    <span class="badge badge-sm bg-info px-3">{{ $itasset->status }}</span>
                                                @else
                                                    <span class="badge badge-sm bg-danger px-3">{{ $itasset->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('itasset.show', $itasset->id) }}" class="action-btn view text-secondary" data-bs-toggle="tooltip" data-bs-original-title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @can('itasset update')
                                                    <a href="{{ route('itasset.edit', $itasset->id) }}" class="action-btn edit text-secondary ms-1" data-bs-toggle="tooltip" data-bs-original-title="Edit Asset">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
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
            // initialize datatable with ui refinements
            $("#products-list").DataTable({
                "language": {
                    "paginate": {
                        "previous": "<i class='fas fa-angle-left'></i>",
                        "next": "<i class='fas fa-angle-right'></i>"
                    }
                },
                "drawCallback": function() {
                    // re-initialize tooltips
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                }
            });
        });
    </script>
@endsection
