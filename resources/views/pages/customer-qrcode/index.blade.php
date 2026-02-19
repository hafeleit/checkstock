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

        .btn-qr {
            color: #0D6EFD;
            border-radius: .45rem;
            font-size: 14px;
            border: none;
            transition: all 0.2s ease;
            box-shadow: none;
        }

        .btn-qr:hover {
            background-color: #D0E4FF;
            color: #0B5ED7;
            box-shadow: none;
        }

        .btn-qr:active {
            transform: scale(0.97);
        }

        .td-hover:hover {
            background: #f9f9f9;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-md-flex align-items-center justify-between">
                            <h6 class="mb-0 h3">Customer List</h6>
                            <a href="/qr-code-customers/create" type="button" class="btn btn-sm btn-primary m-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                                Add QR Code Customer
                            </a>
                        </div>
                        <p class="text-uppercase text-secondary text-xxs">5 customers registered</p>
                    </div>

                    <div class="card-body pt-0">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <input type="search" class="form-control form-control-sm search-field" id="search" value="{{ $params['search'] ?? '' }}" placeholder="Search by name or code...">
                            </div>
                            <div class="col-md-auto">
                                <button type="button" class="btn btn-sm btn-dark uppercase mb-0" id="searchButton">search</button>
                            </div>
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table border mb-0">
                                <thead class="table-light text-sm">
                                    <tr>
                                        <th class="p-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-buildings" viewBox="0 0 16 16">
                                                    <path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022M6 8.694 1 10.36V15h5zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5z"/>
                                                    <path d="M2 11h1v1H2zm2 0h1v1H4zm-2 2h1v1H2zm2 0h1v1H4zm4-4h1v1H8zm2 0h1v1h-1zm-2 2h1v1H8zm2 0h1v1h-1zm2-2h1v1h-1zm0 2h1v1h-1zM8 7h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zM8 5h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zm0-2h1v1h-1z"/>
                                                </svg>
                                                <p class="m-0 text-sm fw-bold">Customer Name</p>
                                            </div>
                                        </th>
                                        <th class="p-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hash" viewBox="0 0 16 16">
                                                    <path d="M8.39 12.648a1 1 0 0 0-.015.18c0 .305.21.508.5.508.266 0 .492-.172.555-.477l.554-2.703h1.204c.421 0 .617-.234.617-.547 0-.312-.188-.53-.617-.53h-.985l.516-2.524h1.265c.43 0 .618-.227.618-.547 0-.313-.188-.524-.618-.524h-1.046l.476-2.304a1 1 0 0 0 .016-.164.51.51 0 0 0-.516-.516.54.54 0 0 0-.539.43l-.523 2.554H7.617l.477-2.304c.008-.04.015-.118.015-.164a.51.51 0 0 0-.523-.516.54.54 0 0 0-.531.43L6.53 5.484H5.414c-.43 0-.617.22-.617.532s.187.539.617.539h.906l-.515 2.523H4.609c-.421 0-.609.219-.609.531s.188.547.61.547h.976l-.516 2.492c-.008.04-.015.125-.015.18 0 .305.21.508.5.508.265 0 .492-.172.554-.477l.555-2.703h2.242zm-1-6.109h2.266l-.515 2.563H6.859l.532-2.563z"/>
                                                </svg>
                                                <p class="m-0 text-sm fw-bold">Customer Code</p>
                                            </div>
                                        </th>
                                        <th class="p-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <p class="m-0 text-sm fw-bold">Download QR Code</p>
                                            </div>
                                        </th>
                                        <th class="p-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar4-week" viewBox="0 0 16 16">
                                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                                                    <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
                                                </svg>
                                                <p class="m-0 text-sm fw-bold">Create Date</p>
                                            </div>
                                        </th>
                                        <th class="p-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                                </svg>
                                                <p class="m-0 text-sm fw-bold">Create By</p>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($customers))
                                        @foreach ($customers as $customer)
                                            <tr class="text-sm td-hover">
                                                <td class="py-3">{{ $customer->customer_name }}</td>
                                                <td class="py-3">
                                                    <span class="badge badge-secondary">{{ $customer->customer_code }}</span>
                                                </td>
                                                <td class="py-3">
                                                    <a href="{{ route('qr-code-customers.pdf', $customer->id) }}" target="_blank" class="btn-qr d-inline-flex align-items-center gap-2 px-3 py-1 m-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                                                            <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z"/>
                                                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                                        </svg>
                                                        <span class="fw-medium">PDF</span>
                                                    </a>
                                                </td>
                                                <td class="py-3">{{ $customer->created_date }}</td>
                                                {{-- <td class="py-3">{{ $customer->creator->email }}</td> --}}
                                                <td class="py-3">Admin</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
