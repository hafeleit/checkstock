@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'SALES USI'])

    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .icon-search {
            position: absolute;
            top: 18%;
            right: 3%;
        }

        .relative {
            position: relative;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-md-flex align-items-center justify-between">
                            <h6 class="mb-0 h3">Product Information</h6>
                            @include('pages.sales_usi._add-new')
                        </div>
                        @php
                            $yesterday = date('d/m/Y', strtotime('-1 day'));
                        @endphp
                        <p class="text-uppercase text-secondary text-xxs font-weight-bolder">LAST UPDATE: {{ $yesterday }} 20:00</p>
                    </div>

                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group relative">
                                    <form id="searchForm" action="" method="post">
                                        @csrf
                                        <input class="form-control" id="item_code" name="item_code" type="text" placeholder="item code" title="กรอกตัวเลขในรูปแบบ 123.12.123" autocomplete="off">
                                        <a href="#" id="searchButton">
                                            <img src="/img/icons/search.png" alt="country flag" width="25px" class="icon-search">
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="detail-info col-12 mb-lg-0 mt-4 d-none">
                            {{-- Project item / Super ceed --}}
                            @include('pages.sales_usi._info-product')

                            {{-- Image --}}
                            @include('pages.sales_usi._info-image')

                            {{-- Catalog --}}
                            @include('pages.sales_usi._info-catalog')

                            {{-- Manual --}}
                            @include('pages.sales_usi._info-manual')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        document.addEventListener('DOMContentLoaded', () => {
            const searchForm = document.getElementById('searchForm');
            const searchButton = document.getElementById('searchButton');
            const itemInput = document.getElementById('item_code');
            const detailInfo = document.querySelector('.detail-info');

            if (itemInput) {
                $(itemInput).mask('000.00.000');
                itemInput.focus();

                itemInput.addEventListener('keypress', (event) => {
                    if (event.key === 'Enter' || event.keyCode === 13) {
                        event.preventDefault();
                        executeSearch();
                    }
                });
            }
            if (searchButton) {
                searchButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    executeSearch();
                });
            }

            async function executeSearch() {
                const itemCode = itemInput.value.trim();
                const csrfToken = document.querySelector('input[name="_token"]').value;

                if (!itemCode) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Input Required',
                        text: 'Please enter an item code to search.'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Searching...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                Swal.close();
                detailInfo.classList.remove('d-none');

                // try {
                //     const response = await fetch('/api/search-item', {
                //         method: 'POST',
                //         headers: {
                //             'Content-Type': 'application/json',
                //             'X-CSRF-TOKEN': csrfToken
                //         },
                //         body: JSON.stringify({
                //             item_code: itemCode
                //         })
                //     });

                //     const result = await response.json();

                //     if (response.ok && result.found) {
                //         Swal.close();
                //         detailInfo.classList.remove('d-none');
                //     } else {
                //         detailInfo.classList.add('d-none');
                //         Swal.fire({
                //             icon: 'info',
                //             title: 'Item Not Found',
                //             text: 'No data found for this item code. Please check your information or add a new entry.',
                //             confirmButtonText: 'OK',
                //         });
                //     }
                // } catch (error) {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Error',
                //         text: 'Unable to connect to the server. Please try again later.'
                //     });
                // }
            }
        });
    </script>
@endsection
