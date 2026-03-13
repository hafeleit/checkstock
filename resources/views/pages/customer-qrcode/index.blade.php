@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'QR Code Customer'])
    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .icon-search {
            position: absolute;
            top: 7%;
            right: 1%;
        }

        .relative {
            position: relative;
        }

        .btn-qr-trigger {
            border-radius: .45rem;
            font-size: 14px;
            border: none !important;
            outline: none !important;
            transition: all 0.2s ease;
            box-shadow: none !important;
            background: transparent;
            padding: 0;
        }
        .btn-qr-trigger:hover {
            color: #0B5ED7;
            box-shadow: none !important;
            background: transparent;
        }

        .btn-qr-trigger:active, 
        .btn-qr-trigger:focus, 
        .btn-qr-trigger:focus-visible {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
            transform: scale(0.97);
        }

        .td-hover:hover {
            background: #f9f9f9;
        }

        .badge-customer-code {
            font-size: 14px;
            font-weight: 500;
            background-color: #eeeff0;
        }

        .table-responsive {
            border-radius: .5rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            width: 100%;
            display: block;
        }

        .table {
            margin-bottom: 0;
            border: none !important;
        }

        .qr-modal-content {
            border-radius: 20px !important;
            border: none !important;
        }

        .qr-header-title {
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #636e72;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }

        .qr-img-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .qr-img-container img {
            width: 200px;
            border-radius: 10px;
        }

        .qr-info-table {
            margin-left: auto;
            margin-right: auto;
            width: auto;
            min-width: 200px;
        }

        .qr-info-table td {
            padding: 5px 10px;
            font-size: 14px;
        }

        .qr-label {
            color: #636e72;
            text-align: left;
            padding-right: 20px;
            text-transform: uppercase;
        }

        .qr-value {
            font-weight: bold;
            color: #2d3436;
        }

        .qr-customer-name {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .qr-footer-date {
            text-align: center;
            font-size: 12px;
            color: #b2bec3;
            margin: 20px 0;
        }

        .qr-header-title, .qr-img-container {
            text-align: center;
        }

        .btn-download-pdf {
            border-radius: 10px !important;
        }

        .btn-close-custom {
            position: absolute;
            top: 15px;
            right: 15px;
            background: transparent;
            border: none;
            color: #888;
            z-index: 10;
            cursor: pointer;
            transition: color 0.2s;
        }

        .btn-close-custom:hover {
            color: #000000;
        }

        .btn-download-icon {
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-download-icon:hover {
            background: #c5a059;
            color: #000;
        }

        .swal2-styled.swal2-confirm {
            background-color: #2152ff !important;
            border-radius: .25em !important;
        }

        @media (max-width: 576px) {
            .pagination .page-item {
                all: unset;
                display: inline-block;
            }
            
            .pagination .page-link {
                all: unset;
                cursor: pointer;
                padding: 5px 10px;
                color: #FB6340
            }

            .pagination .disabled {
                color: #6c757d;
                pointer-events: none;
            }
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-md-flex align-items-center justify-between">
                            <h6 class="mb-0 h3">Customer List</h6>
                            <div class="d-flex align-items-center gap-2">
                                @can('qrcode import')
                                <button type="button" class="btn btn-sm btn-outline-primary m-0" data-bs-toggle="modal" data-bs-target="#updateQrCodeModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-upload mx-1" viewBox="0 0 16 16">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                        <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z" />
                                    </svg>
                                    Import QR Code Customer
                                </button>
                                @endcan
                                @can('qrcode create')
                                <a href="/qr-code-customers/create" type="button" class="btn btn-sm btn-primary m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                    </svg>
                                    Add QR Code Customer
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="card-body mt-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-8 col-md-6">
                                <input type="search" class="form-control form-control-sm search-field" id="search-input" value="{{ $params['search'] ?? '' }}" placeholder="Search by name or code...">
                            </div>
                            <div class="col-4 col-md-auto">
                                <button type="button" class="btn btn-sm btn-dark uppercase mb-0" id="searchButton">search</button>
                            </div>
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table border mb-0">
                                <thead class="table-light text-sm">
                                    <tr>
                                        <th class="py-2 px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hash" viewBox="0 0 16 16">
                                                    <path d="M8.39 12.648a1 1 0 0 0-.015.18c0 .305.21.508.5.508.266 0 .492-.172.555-.477l.554-2.703h1.204c.421 0 .617-.234.617-.547 0-.312-.188-.53-.617-.53h-.985l.516-2.524h1.265c.43 0 .618-.227.618-.547 0-.313-.188-.524-.618-.524h-1.046l.476-2.304a1 1 0 0 0 .016-.164.51.51 0 0 0-.516-.516.54.54 0 0 0-.539.43l-.523 2.554H7.617l.477-2.304c.008-.04.015-.118.015-.164a.51.51 0 0 0-.523-.516.54.54 0 0 0-.531.43L6.53 5.484H5.414c-.43 0-.617.22-.617.532s.187.539.617.539h.906l-.515 2.523H4.609c-.421 0-.609.219-.609.531s.188.547.61.547h.976l-.516 2.492c-.008.04-.015.125-.015.18 0 .305.21.508.5.508.265 0 .492-.172.554-.477l.555-2.703h2.242zm-1-6.109h2.266l-.515 2.563H6.859l.532-2.563z"/>
                                                </svg>
                                                <p class="m-0 text-sm fw-bold">Customer Code</p>
                                            </div>
                                        </th>
                                        <th class="py-2 px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-buildings" viewBox="0 0 16 16">
                                                    <path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022M6 8.694 1 10.36V15h5zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5z"/>
                                                    <path d="M2 11h1v1H2zm2 0h1v1H4zm-2 2h1v1H2zm2 0h1v1H4zm4-4h1v1H8zm2 0h1v1h-1zm-2 2h1v1H8zm2 0h1v1h-1zm2-2h1v1h-1zm0 2h1v1h-1zM8 7h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zM8 5h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zm0-2h1v1h-1z"/>
                                                </svg>
                                                <p class="m-0 text-sm fw-bold">Customer Name</p>
                                            </div>
                                        </th>
                                        <th class="py-2 px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <p class="m-0 text-sm fw-bold">Download QR Code</p>
                                            </div>
                                        </th>
                                        <th class="py-2 px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar4-week" viewBox="0 0 16 16">
                                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                                                    <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
                                                </svg>
                                                <p class="m-0 text-sm fw-bold">Create Date</p>
                                            </div>
                                        </th>
                                        <th class="py-2 px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                                </svg>
                                                <p class="m-0 text-sm fw-bold">Create By</p>
                                            </div>
                                        </th>
                                        <th class="py-2 px-4"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$customers->isEmpty())
                                        @foreach ($customers as $customer)
                                            <tr class="text-sm td-hover">
                                                <td class="py-3 px-4">
                                                    <span class="badge badge-secondary badge-customer-code">{{ $customer->customer_code }}</span>
                                                </td>
                                                <td class="py-3 px-4">{{ $customer->customer_name }}</td>
                                                <td class="py-3 px-4">
                                                    <button type="button" 
                                                        class="btn-qr-trigger d-inline-flex align-items-center gap-2 px-3 py-1 m-0 border-0"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#qrCodeModal"
                                                        data-id="{{ $customer->id }}"
                                                        data-code="{{ $customer->customer_code }}"
                                                        data-name="{{ $customer->customer_name }}"
                                                        data-qr-url="{{ route('qr-code-customers.png', $customer->id) }}"
                                                        data-url="{{ route('qr-code-customers.pdf', $customer->id) }}">
                                                        
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                                                            <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M4 4h1v1H4z"/>
                                                            <path d="M7 2H2v5h5zM3 3h3v3H3zm2 8H4v1h1z"/>
                                                            <path d="M7 9H2v5h5zM3 10h3v3H3zm8-6h1v1h-1z"/>
                                                            <path d="M9 2h5v5H9zM10 3h3v3h-3zm1 10h1v1h-1z"/>
                                                            <path d="M14 9h-5v5h5zM10 10h3v3h-3zm4 1h-1v1h1z"/>
                                                        </svg>
                                                        <span class="fw-medium">Click Show</span>
                                                    </button>
                                                </td>
                                                <td class="py-3 px-4">{{ $customer->created_date }}</td>
                                                <td class="py-3 px-4">{{ $customer->creator->email }}</td>
                                                <td class="py-3 px-4">
                                                    @can('qrcode delete')
                                                    <a href="#" id="delete-qr-code" data-id="{{ $customer->id }}" class="text-danger d-inline-flex align-items-center gap-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                        </svg>
                                                    </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-sm">
                                            <td colspan="5" class="text-muted text-center py-3">No customer QR code</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-4">
                            {{ $customers->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal import --}}
        <div class="modal fade" id="updateQrCodeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateQrCodeModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateQrCodeModalLabel">Update QR Code</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-x" viewBox="0 0 16 16">
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <p class="text-secondary small mb-2">
                                You can download the template to prepare your data for importing into the system from the link below.
                            </p>
                            <button
                                class="export-template-btn btn btn-sm btn-outline-secondary m-0"
                                data-url="qr-code-customers/export-template" 
                                data-filename="Customer_QR_Code_Template.xlsx" >
                                <i class="fas fa-print"></i>
                                <span>Download template (.xlsx)</span>
                            </button>
                        </div>

                        <hr class="text-secondary opacity-25">

                        <form method="post" id="qrCodeForm">
                            @csrf
                            <div>
                                <label class="form-label fw-bold required">Select file to import</label>
                                <input class="form-control" type="file" id="import-qr-code-file"
                                    accept=".xlsx, .xls">
                                <div class="form-text text-xs">Only .xlsx, or .xls files are supported.</div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="uploadQrCodeBtn" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Qr Code --}}
        <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content qr-modal-content">
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                        </svg>
                    </button>

                    <div class="modal-body p-4">
                        <div class="qr-header-title">QR Code Payment</div>
                        
                        <div class="qr-img-container">
                            <img id="modalQrImg" src="" alt="qr code">
                        </div>

                        <table class="qr-info-table">
                            <tr>
                                <td class="qr-label">Customer Code (REF1):</td>
                                <td class="qr-value" id="modalRef1"></td>
                            </tr>
                            <tr>
                                <td class="qr-label">Customer Name:</td>
                                <td class="qr-value" id="modalCustomerName"></td>
                            </tr>
                        </table>

                        <div class="qr-footer-date">Generated on {{ date('F d, Y') }}</div>

                        <hr>

                        <a href="#" id="modalDownloadBtn" target="_blank" class="btn-download-icon float-end" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download PDF">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        const handleSearch = () => {
            const searchInput = document.getElementById('search-input').value;
            const data = { search: searchInput };

            const filteredData = {};
            for (const key in data) {
                if (data[key]) {
                    filteredData[key] = data[key];
                }
            }

            const params = new URLSearchParams(filteredData).toString();
            const url = `/qr-code-customers${params ? '?' + params : ''}`;

            window.location.href = url;
        };

        const searchButton = document.getElementById('searchButton');
        if (searchButton) {
            searchButton.addEventListener('click', handleSearch);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const qrModal = document.getElementById('qrCodeModal');
            const uploadButton = document.getElementById('uploadQrCodeBtn');
            
            if (qrModal) {
                qrModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    
                    const qrUrl = button.getAttribute('data-qr-url');
                    const customerCode = button.getAttribute('data-code');
                    const customerName = button.getAttribute('data-name');
                    const downloadUrl = button.getAttribute('data-url');
                    
                    document.getElementById('modalRef1').textContent = customerCode;
                    document.getElementById('modalCustomerName').textContent = customerName;
                    document.getElementById('modalDownloadBtn').href = downloadUrl;
                    
                    const qrImgElement = document.getElementById('modalQrImg');
                    qrImgElement.src = qrUrl;
                });
            }

            uploadButton.addEventListener('click', function () {
                const fileInput = document.getElementById('import-qr-code-file');
                const file = fileInput.files[0];

                if (!file) {
                    Swal.fire('No file selected', 'Please choose a file to upload.', 'warning');
                    return;
                }

                const formData = new FormData();
                formData.append('file', file);

                Swal.fire({
                    title: 'Uploading...',
                    text: 'Please wait while the file is being uploaded.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                axios.post('/qr-code-customers/import', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    Swal.fire('Success', response.data.message || 'File uploaded successfully.', 'success')
                        .then(() => {
                            window.location.reload();
                        });
                })
                .catch(error => {
                    console.log(error);
                    const msg = error.response?.data?.message || 'Something went wrong';
                    Swal.fire('Error', msg, 'error');
                });
            });
        });

            // Handle delete QR code
        document.addEventListener('click', function (event) {
            if (event.target.closest('#delete-qr-code')) {
                event.preventDefault();
                const button = event.target.closest('#delete-qr-code');
                const customerId = button.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to delete?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    reverseButtons: true,
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        try {
                            await axios.delete(`/qr-code-customers/${customerId}`);
                        } catch (error) {
                            console.log(error)
                            const msg = error.response?.data?.message || 'Something went wrong';
                            Swal.showValidationMessage(`Request failed: ${msg}`);
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Deleted!', 'QR code has been deleted.', 'success')
                            .then(() => {
                                window.location.reload();
                            });
                    }
                });
            }
        });

        // handle loader wrapper
        document.querySelectorAll('.export-template-btn').forEach(button => {
            button.addEventListener('click', async function () {
                const loader = document.getElementById('loader-wrapper');
                try {
                    loader.classList.remove('loader-hidden');
                    loader.style.display = 'flex';
                    const url = this.dataset.url;
                    const filename = this.dataset.filename;
                    const response = await fetch(url);
                    if (!response.ok) {
                        throw new Error('Export failed');
                    }
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
                    alert('Export error');
                    console.error(error);
                } finally {
                    loader.classList.add('loader-hidden');
                    loader.style.display = 'none';
                }
            });
        });
    </script>
@endsection
