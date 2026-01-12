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
                        <div class="d-flex align-items-center justify-between">
                            <div>
                                <div class="d-md-flex align-items-center justify-between">
                                    <h6 class="mb-0 h3">Product Information</h6>
                                </div>
                                @php
                                    $yesterday = date('d/m/Y', strtotime('-1 day'));
                                @endphp
                                <p class="text-uppercase text-secondary text-xxs font-weight-bolder">LAST UPDATE:
                                    {{ $yesterday }} 20:00</p>
                            </div>
                            <div>
                                <a href="" id="backButton" type="button"
                                    class="btn btn-secondary d-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        fill="currentColor" class="bi bi-arrow-bar-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5" />
                                    </svg>
                                    <div>BACK</div>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="card-body pt-0">
                        <div>
                            <h4>Item Code : 000.00.000</h4>
                        </div>
                        <div class="detail-info col-12 mb-lg-0 mt-4">
                            {{-- Project item / Super ceed / Spare part --}}
                            @include('pages.sales_usi.product-info._info-product')

                            {{-- Image --}}
                            @include('pages.sales_usi.product-info._info-image')

                            {{-- Catalog --}}
                            @include('pages.sales_usi.product-info._info-catalog')

                            {{-- Manual --}}
                            @include('pages.sales_usi.product-info._info-manual')
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
            const backButton = document.getElementById('backButton');

            // จัดการปุ่ม BACK
            if (backButton) {
                backButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.history.back();
                });
            }

            // Event Listeners สำหรับการค้นหา
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

            // ฟังก์ชันการค้นหา
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
