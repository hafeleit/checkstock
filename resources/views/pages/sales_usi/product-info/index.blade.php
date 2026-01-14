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
                            @include('pages.sales_usi.product-info._add-new')
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
                                    <form id="searchProductForm" action="" method="GET">
                                        <input class="form-control" id="item_code" name="item_code" type="text"
                                            placeholder="item code" title="กรอกตัวเลขในรูปแบบ 123.12.123"
                                            autocomplete="off">
                                        <a href="#" id="searchButton">
                                            <img src="/img/icons/search.png" alt="country flag" width="25px" class="icon-search">
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover text-sm">
                                <thead>
                                    <tr class="table-secondary ">
                                        <th class="px-2">Item Code</th>
                                        <th class="px-2">Project Item</th>
                                        <th class="px-2">Superseded</th>
                                        <th class="px-2">Spare Parts</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>000.00.001</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>101.22.001</td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li>100.00.101</li>
                                                <li>100.00.102</li>
                                                <li>100.00.103</li>
                                                <li>100.00.104</li>
                                            </ul>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('sales-usi.product-info.edit', '101.22.001') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>000.00.002</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>101.22.002</td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li>100.00.101</li>
                                                <li>100.00.102</li>
                                            </ul>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('sales-usi.product-info.edit', '101.22.001') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>000.00.003</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>101.22.003</td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li>100.00.101</li>
                                            </ul>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('sales-usi.product-info.edit', '101.22.001') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>000.00.004</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>101.22.004</td>
                                        <td>-</td>
                                        <td class="text-end">
                                            <a href="{{ route('sales-usi.product-info.edit', '101.22.001') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>000.00.005</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>101.22.005</td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li>100.00.101</li>
                                                <li>100.00.102</li>
                                            </ul>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('sales-usi.product-info.edit', '101.22.001') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>000.00.006</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>101.22.006</td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li>100.00.101</li>
                                                <li>100.00.102</li>
                                                <li>100.00.103</li>
                                            </ul>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('sales-usi.product-info.edit', '101.22.001') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>000.00.007</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>101.22.007</td>
                                        <td>-</td>
                                        <td class="text-end">
                                            <a href="{{ route('sales-usi.product-info.edit', '101.22.001') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>000.00.008</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>101.22.008</td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li>100.00.101</li>
                                                <li>100.00.102</li>
                                                <li>100.00.103</li>
                                                <li>100.00.104</li>
                                            </ul>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('sales-usi.product-info.edit', '101.22.001') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>000.00.009</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>101.22.009</td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li>100.00.101</li>
                                                <li>100.00.102</li>
                                            </ul>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('sales-usi.product-info.edit', '101.22.001') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    $(function() {
        const $itemInput = $('#item_code');
        const $tableRows = $('tbody tr');
        const $searchButton = $('#searchButton');

        function performSearch() {
            const searchText = $itemInput.val().trim();

            // sample data search
            $tableRows.each(function() {
                const itemCode = $(this).find('td:first').text().trim();
                if (searchText === "" || itemCode.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        $searchButton.on('click', function(e) {
            e.preventDefault();
            performSearch();
        });

        $itemInput.on('keypress', function(event) {
            if (event.which === 13) {
                event.preventDefault();
                performSearch();
            }
        });

        $itemInput.focus();
        $itemInput.mask('000.00.000');
    });
</script>
@endsection
