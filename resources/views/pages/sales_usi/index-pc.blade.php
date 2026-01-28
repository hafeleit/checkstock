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

        .item-link-trigger {
            cursor: pointer;
            text-decoration: underline;
        }

        .item-link-trigger:hover {
            color: #0d47a1;
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
                            <div class="col-12">
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
                            </div>

                            <div class="col-12 col-lg-9 text-sm">
                                <div class="row">
                                    <div class="col-12 mt-2">
                                        <span>Item Code : <label class="m-0 item_code"></label></span>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <span>Item Desc : <label class="m-0 item_desc"></label></span>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <span>Item Brand : <label class="m-0 item_brand"></label></span>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <span>Supp Repl Time : <label class="m-0 repl_time"></label></span>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <span>Item Status : <label class="m-0 item_status py-1 text-xs"></label></span>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <span>Storage Indicator : <label class="m-0 inventory_code text-xs badge bg-success py-1"></label></span>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <span>Base Price : <label class="m-0 zpl"></label></span>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <span>Retail Selling Price : <label class="m-0 zplv"></label></span>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <span>Available Stock : <label class="m-0 available_stock"></label></span>
                                    </div>
                                </div>

                                <div class="card-body p-2">
                                    <div class="row mt-3 bom_show_flg" >
                                    <div class="col-auto">
                                        <div class="form-check fs-5">
                                        <input class="form-check-input no-click" type="checkbox" id="chk_parent" name="option" value="P">
                                        <label class="form-check-label" for="chk_parent">P</label>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="form-check fs-5">
                                        <input class="form-check-input no-click" type="checkbox" id="chk_comp" name="option" value="C">
                                        <label class="form-check-label" for="chk_comp">C</label>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="form-check fs-5">
                                        <input class="form-check-input no-click" type="checkbox" id="chk_pp" name="option" value="P/P">
                                        <label class="form-check-label" for="chk_pp">P/P</label>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-3">
                                <div class="col-md-12 d-none" id="product-image-container">
                                    <div class="img-container">
                                        <div class="d-flex justify-center">
                                            <img id="item_preview" src="" class="img-thumbnail img-product" width="450">
                                            <div class="img-thumbnail py-5 d-flex align-items-center justify-content-center w-100" id="item_preview_placeholder">
                                                <div class="text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-image text-muted" viewBox="0 0 16 16">
                                                        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                                        <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                                                    </svg>
                                                    <p class="text-muted m-0">No Image</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="#" id="info-link" target="_blank" type="button" class="button-product-info btn btn-sm btn-dark mt-3">
                                                Product Information
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- BOM Informations --}}
                            <div class="col-lg-6 mb-lg-0 mt-4 bom_show_flg">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <div>
                                            <label class="text-lg mx-0">BOM Informations</label>
                                            <span class="float-end">No.of Parent can be made from available components <label class="text-lg text-primary bom_cal">0</label></span>
                                        </div>
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="table-responsive">
                                            <table id="bom_table" class="table align-items-center ">
                                                <thead>
                                                    <tr>
                                                        <th class="p-2 text-uppercase text-sm font-weight-bolder">Parent</th>
                                                        <th class="p-2 text-center border-usi text-uppercase text-sm font-weight-bolder">Parent Qty</th>
                                                        <th class="p-2 border-usi text-center text-uppercase text-sm font-weight-bolder">Comp</th>
                                                        <th class="p-2 border-usi text-center text-uppercase text-sm font-weight-bolder">Comp Qty</th>
                                                        <th class="p-2 d-none border-usi text-center text-uppercase text-sm font-weight-bolder">Price/Unit</th>
                                                        <th class="p-2 border-usi text-center text-uppercase text-sm font-weight-bolder">Comp STK</th>
                                                        <th class="p-2 border-usi text-center text-uppercase text-sm font-weight-bolder">Cal STK</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Week --}}
                            <div class="col-lg-6 mb-lg-0 mt-4">
                                <div class="card h-475">
                                    <div class="table-responsive">
                                        <table id="wss_table" class="table align-items-center ">
                                            <thead>
                                                <tr>
                                                    <th class="p-2 text-uppercase text-sm font-weight-bolder"> Week</th>
                                                    <th class="p-2 text-center border-usi text-uppercase text-sm font-weight-bolder ps-2"> Inbound</th>
                                                    <th class="p-2 border-usi text-center text-uppercase text-sm font-weight-bolder"> Outbound</th>
                                                    <th class="p-2 border-usi text-center text-uppercase text-sm font-weight-bolder"> Available</th>
                                                    <th class="p-2 border-usi text-center text-uppercase text-sm font-weight-bolder"> Reserved</th>
                                                    <th class="p-2 border-usi text-center text-uppercase text-sm font-weight-bolder"> Forecast</th>
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
                if (event.which === 13) {
                    event.preventDefault();
                    search_usi();
                }
            });
            $('#item_code').focus();
        });

        $('#item_code').mask('000.00.000');
        $('.bom_show_flg').hide();

        // Search button
        const searchButton = document.getElementById('searchButton');
        if (searchButton) {
            searchButton.addEventListener('click', (event) => {
                event.preventDefault();
                search_usi();
            });
        }

        $(document).on('click', '.search-parent-item', function(e) {
            let parentCode = $(this).data('item-code');
            if (parentCode) {
                $('#item_code').val(parentCode);
                search_usi();
            }
        });

        // Function: Search USI
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
                    $("#bom_table > tbody").html("");
                    $("#wss_table > tbody").html("");

                    $('#product-image-container').addClass('d-none');
                    $('#errorModal').modal('show');
                    $('#errorModal').on('shown.bs.modal', function() {
                        $('#btnCloseModal').focus();
                    });
                    $('#product_img').attr('src', '/storage/img/products/coming_soon.jpg');
                    $('.card-body div div span label').text('');
                    return false;
                } else {
                    let code = item_code;
                    let newUrl = '/product-infos/' + code;

                    $('#product-image-container').removeClass('d-none');
                    $('.button-product-info').attr('href', newUrl);
                }

                // IMAGE: product information
                if (res['imgPath']) {
                    $(".img-product").attr("src", res['imgPath']).show();
                    $('#item_preview_placeholder').addClass('d-none');
                } else {
                    $('.img-product').hide();
                    $('#item_preview_placeholder').removeClass('d-none');
                }

                // Item Status
                var item_status_value = res['data'][0]['NSU_ITEM_STATUS'];
                var $item_status = $('.item_status');
                $item_status.html(item_status_value);
                $item_status.removeClass('badge bg-success bg-danger');
                if (item_status_value === 'Active') {
                    $item_status.addClass('badge bg-success');
                } else {
                    $item_status.addClass('badge bg-danger');
                }

                $('.item_code').html(res['data'][0]['NSU_ITEM_CODE']); // Item Code
                $('.item_desc').html(res['data'][0]['NSU_ITEM_NAME']); // Item Desc
                $('.item_brand').html(res['data'][0]['NSU_ITEM_BRAND']); // Item Brand
                $('.repl_time').html(res['data'][0]['NSU_SUPP_REPL_TIME']); // Supp Repl Time
                $('.inventory_code').html(res['data'][0]['NSU_ITEM_INV_CODE']); // Storage Indicator
                $('.zpl').html(res['uom'][0]["IUW_PRICE"]); // Base Price (ZPL)
                $('.zplv').html(res['uom'][0]["NEW_ZPLV_COST"]); // RSP (ZPLV)

                // Available Stock
                let totalOutbound = res['wss'].reduce((sum, item) => sum + Number(item.WSS_RES_QTY), 0);
                let finalStock = Number(res['stocks']['TH02'] - totalOutbound);
                let color = finalStock >= 0 ? 'green' : 'red';
                $('.available_stock').html(finalStock.toLocaleString())
                    .css({
                        'color': color,
                        'font-size': '16px',
                        'font-weight': 'bold'
                    });

                // chk_parent, chk_comp, chk_pp
                if (res['bom'] && res['bom'].length > 0) {
                    let flg = res['bom'][0]['flg'];
                    let bom_usg = res['bom'][0]['bom_usg'];

                    $('#chk_parent, #chk_comp, #chk_pp').prop('checked', false);

                    if (flg === 'material' && bom_usg == 1) {
                        $('#chk_parent').prop('checked', true);
                    }

                    if (flg === 'component') {
                        $('#chk_comp').prop('checked', true);
                    }

                    if (bom_usg == 5) {
                        if (flg != 'component') {
                            $('#chk_pp').prop('checked', true);
                        }
                    }
                }

                // BOM Information
                $("#bom_table > tbody").html("");
                if (res['bom'] && res['bom'].length > 0) {
                    $('.bom_show_flg').show();
                    $.each(res['bom'], function(key, val) {
                    let tbody = '<tr>\
                        <td class="border-usi">\
                            <span class="item-link-trigger search-parent-item" \
                                data-item-code="' + val["parent"] + '">\
                                <p class="text-start text-xs font-weight-bold mb-0 d-inline">' + val["parent"] + '</p>\
                            </span>\
                        </td>\
                        <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0">'+val["parent_qty"]+'</p></td>\
                        <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0">'+val["comp"]+'</p></td>\
                        <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0">'+val["comp_qty"]+'</p></td>\
                        <td class="d-none border-usi"><p class="float-end text-xs font-weight-bold mb-0">'+val["price_per_unit"]+'</p></td>\
                        <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0">'+val["comp_stk"]+'</p></td>\
                        <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0">'+val["cal_stk"]+'</p></td>\
                    </tr>';
                    $('#bom_table').append(tbody);
                    });
                } else{
                    $('.bom_show_flg').hide();
                }

                // Week inbound/outbound
                $("#wss_table > tbody").html("");
                $.each(res['wss'], function(key, val) {
                    let text_danger_in = '';
                    let text_danger_out = '';

                    if(parseInt(val["WSS_INCOMING_QTY"]) > 0) {
                        text_danger_in = 'text-danger';
                    }

                    if(val["WSS_RES_QTY"] > 0) {
                        text_danger_out = 'text-danger';
                    }

                    if(key == 0) {
                        forecast = val["WSS_AVAIL_QTY"];
                    }

                    forecast = forecast + parseInt(val["WSS_INCOMING_QTY"]) - val["WSS_RES_QTY"];

                    let tbody = '<tr>\
                        <td class="border-usi">\
                            <p class="text-start text-xs font-weight-bold mb-0">'+val["year_number"]+'/'+val["week_number"]+'</p>\
                        </td>\
                        <td class="border-usi">\
                            @can('salesusi iodetail')\
                            <p data-week-number="'+val["week_number"]+'" class="'+text_danger_in+' wss-table text-end text-xs font-weight-bold mb-0 inbound-link">'+parseInt(val["WSS_INCOMING_QTY"])+'</p>\
                            @else\
                            <p class="wss-table '+text_danger_in+' text-end text-xs font-weight-bold mb-0">'+parseInt(val["WSS_INCOMING_QTY"])+'</p>\
                            @endcan\
                        </td>\
                        <td class="border-usi">\
                            @can('salesusi iodetail')\
                            <p data-week-number="'+val["week_number"]+'" data-year-number="'+val["year_number"]+'" class="'+text_danger_out+' wss-table text-end text-xs font-weight-bold mb-0 outbound-link">'+val["WSS_RES_QTY"]+'</p>\
                            @else\
                            <p class="wss-table '+text_danger_out+' text-end text-xs font-weight-bold mb-0">'+val["WSS_RES_QTY"]+'</p>\
                            @endcan\
                        </td>\
                        <td class="border-usi">\
                            <p class="text-start text-xs font-weight-bold mb-0">'+val["WSS_AVAIL_QTY"]+'</p>\
                        </td>\
                        <td class="border-usi">\
                            <p class="text-end text-xs font-weight-bold mb-0">'+val["WSS_RES_QTY"]+'</p>\
                        </td>\
                        <td class="border-usi">\
                            <p class="text-end text-xs font-weight-bold mb-0">'+forecast+'</p>\
                        </td>\
                    </tr>';
                    $('#wss_table').append(tbody);
                });

                $("#po_table > tbody").html("");
                $("#so_table > tbody").html("");


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
