@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'SALES USI'])
    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .border-usi {
            border-left: 1px solid #e9ecef !important;
        }

        .form-check-input.no-click {
            pointer-events: none;
            transform: scale(1.4);
            margin-right: 0.5rem;
        }

        .h-400 {
            height: 400px;
        }

        .icon-search {
            position: absolute;
            top: 18%;
            right: 3%;
        }

        .relative {
            position: relative;
        }

        .h-475 {
            height: 475px;
        }

        .wss-table {
            text-decoration: underline;
            cursor: pointer;
        }

        .pt-0 {
            padding-top: 0px;
        }

        .img-container {
            position: relative;
        }

        .button-product-info {
            width: 100%;
        }

        #item_preview {
            width: 100%;
        }

        @media (min-width: 768px) {
            #product-image-container {
                max-width: 250px;
                overflow: hidden;
            }
            #item_preview {
                width: 250px;
            }
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 h3">SALES USI - PC</h6>
                        </div>
                        @php
                            $yesterday = date('d/m/Y', strtotime('-1 day'));
                        @endphp
                        <p class="text-uppercase text-secondary text-xxs font-weight-bolder">LAST UPDATE: {{ $yesterday }} 20:00</p>
                    </div>

                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-12 col-lg-9 text-sm">
                                <div class="col-md-6">
                                    <div class="form-group relative">
                                        <form id="searchForm" action="" method="post">
                                            @csrf
                                            <input class="form-control" id="item_code" name="item_code" type="text"
                                                placeholder="item code" title="กรอกตัวเลขในรูปแบบ 123.12.123"
                                                autocomplete="off">
                                            <a href="#" id="searchButton">
                                                <img src="/img/icons/search.png" alt="country flag" width="25px" class="icon-search">
                                            </a>
                                        </form>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <span>Item Code : <label class="item_code"></label></span>
                                    </div>
                                    <div class="col-12">
                                        <span>Item Desc : <label class="item_desc"></label></span>
                                    </div>
                                    <div class="col-12">
                                        <span>Item Status : <label class="item_status mb-0 py-1 text-xs"></label></span>
                                    </div>
                                    <div class="col-12">
                                        <span>Barcode : <label class="barcode"></label></span>
                                    </div>
                                    <div class="col-12">
                                        <span>Supp Repl Time : <label class="repl_time"></label></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-3">
                                <div class="col-md-12 d-none" id="product-image-container">
                                    <div class="img-container">
                                        <div class="d-flex justify-center">
                                            <img id="item_preview" src="/img/495.06.101.jpg" class="img-thumbnail" width="450">
                                        </div>
                                        <div>
                                            <a href="#" id="info-link" type="button" class="button-product-info btn btn-sm btn-dark mt-3">
                                                Product Information
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-lg-0 mt-4">
                            <div class="card ">
                                <div class="table-responsive">
                                    <table id="stk_table" class="table align-items-center ">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-sm font-weight-bolder ">TH02-DC</th>
                                                <th class="text-end text-uppercase text-sm font-weight-bolder">THS2-BKK DIY</th>
                                                <th class="text-end text-uppercase text-sm font-weight-bolder">THS3-Pattaya S/R</th>
                                                <th class="text-end text-uppercase text-sm font-weight-bolder">THS4-Phuket S/R</th>
                                                <th class="text-end text-uppercase text-sm font-weight-bolder">THS5-HuaHin S/R</th>
                                                <th class="text-end text-uppercase text-sm font-weight-bolder">THS6-ChiangMai S/R</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">No Data Found</h5>
                </div>
                <div class="modal-body">
                    Sorry, we couldn't find any results for your search. Please check your search term or try again later.
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnCloseModal" class="btn btn-danger error-close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        $(function() {
            $('#item_code').on('keypress', function(event) {
                if (event.which === 13) { // 13 คือ keycode ของ Enter
                    event.preventDefault(); // ป้องกันการ submit form
                    search_usi();
                }
            });
            $('#item_code').focus();
        });

        $('#item_code').mask('000.00.000');
        $('.bom_show_flg').hide();

        // ค้นหา Element ของปุ่ม search
        const searchButton = document.getElementById('searchButton');
        if (searchButton) {
            searchButton.addEventListener('click', (event) => {
                event.preventDefault();
                search_usi();
            });
        }

        function search_usi() {
            let item_code = $('#item_code').val();
            let _token = $('#searchForm input[name="_token"]').val();

            Swal.fire({
                title: 'กำลังค้นหา...',
                text: 'โปรดรอสักครู่',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                method: 'POST',
                url: '{{ ROUTE('search_usi') }}',
                data: {
                    item_code: item_code,
                    _token: _token
                }
            }).done(function(res) {
                Swal.close();
                if (res['count'] == 0) {
                    $('#product-image-container').addClass('d-none');

                    $("#stk_table > tbody").html("");
                    $('#errorModal').modal('show');
                    $('#errorModal').on('shown.bs.modal', function() {
                        $('#btnCloseModal').focus();
                    });
                    $('#product_img').attr('src', '/storage/img/products/coming_soon.jpg');
                    $('.card-body div div span label').text('');
                    return false;
                } else {
                    let code = item_code;
                    let newUrl = '/sales-usi/product-info?item_code=' + code;

                    $('#product-image-container').removeClass('d-none');
                    $('.button-product-info').attr('href', newUrl);
                }

                // Badge color : item_status
                var item_status_value = res['data'][0]['NSU_ITEM_STATUS'];
                var $item_status = $('.item_status');
                $item_status.html(item_status_value);
                $item_status.removeClass('badge bg-success bg-danger');
                if (item_status_value === 'Active') {
                    $item_status.addClass('badge bg-success');
                } else {
                    $item_status.addClass('badge bg-danger');
                }

                $('.item_code').html(res['data'][0]['NSU_ITEM_CODE']);
                $('.item_desc').html(res['data'][0]['NSU_ITEM_NAME']);
                $('.repl_time').html(res['data'][0]['NSU_SUPP_REPL_TIME']);
                $('.barcode').html(res['data'][0]['ean_upc']);
                $("#stk_table > tbody").html("");

                let tbody = '<tr><td><p class="text-xs font-weight-bold mb-0 px-3">' + res['stocks']['TH02'] + '</p></td>\
                        <td><p class="text-end text-xs font-weight-bold mb-0 px-3">' + res['stocks']['THS2'] + ' </p></td>\
                        <td><p class="text-end text-xs font-weight-bold mb-0 px-3">' + res['stocks']['THS3'] + ' </p></td>\
                        <td><p class="text-end text-xs font-weight-bold mb-0 px-3">' + res['stocks']['THS4'] + ' </p></td>\
                        <td><p class="text-end text-xs font-weight-bold mb-0 px-3">' + res['stocks']['THS5'] + ' </p></td>\
                        <td><p class="text-end text-xs font-weight-bold mb-0 px-3">' + res['stocks']['THS6'] +
                    ' </p></td></tr>';

                $('#stk_table').append(tbody);

            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == '419') {
                    const currentPath = window.location.pathname + window.location.search;
                    const loginUrl = `/login?redirect=${encodeURIComponent(currentPath)}`;

                    Swal.fire({
                        title: 'หมดเวลาการใช้งาน',
                        html: `<p>เนื่องจากไม่มีการใช้งานระบบเกิน 15 นาที <strong>เพื่อรักษาความปลอดภัยของข้อมูล</strong> ระบบจึงได้ออกจากระบบโดยอัตโนมัติ</p>`,
                        icon: 'warning',
                        confirmButtonText: 'ตกลง',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        willClose: () => {
                            window.location.href = loginUrl;
                        }
                    });
                } else {
                    Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถโหลดข้อมูลได้: ' + errorThrown, 'error');
                }
            });
        }

        $(function() {
            $(".error-close").on("click", function() {
                $("#errorModal").modal('hide');
                $('#item_code').focus();
            });
        });
    </script>
@endsection
