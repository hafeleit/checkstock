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
  .w-20 {
    width: 20%;
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
                            <h6 class="mb-0 h3">SALES USI</h6>
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
                                  <input class="form-control" id="item_code" name="item_code" type="text" placeholder="item code" title="กรอกตัวเลขในรูปแบบ 123.12.123" autocomplete="off" >
                                  <a href="#" id="searchButton">
                                      <img src="./img/icons/search.png" alt="country flag" width="25px" class="icon-search">
                                  </a>
                              </form>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 col-lg-9 text-sm">
                          <div class="row">
                            <div class="col-12 col-sm-6 py-1">
                              <span>Item Code : <label class="m-0 item_code"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>MOQ : <label class="m-0 purchase_moq"></label></span>
                            </div>
                            <div class="col-12 py-1">
                              <span>Item Desc : <label class="m-0 item_desc"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Supp Repl Time : <label class="m-0 repl_time"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Purchasing Group : <label class="m-0 purchaser"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>UOM Code : <label class="m-0 uom"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Conv Base UOM : <label class="m-0 pack_code2"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Product Manager : <label class="m-0 pm_contact"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>New Item Code : <label class="m-0 new_item_code"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Pack Volume : <label class="m-0 weight_volume2"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Excl Remark : <label class="m-0 exclusivity_remark"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Item Brand : <label class="m-0 item_brand"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Pack Weight : <label class="m-0 weight_volume1"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>MRP : <label class="m-0 mrp_desc text-xs badge bg-success py-1"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Item Status : <label class="m-0 item_status text-xs py-1"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Barcode : <label class="m-0 barcode"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Storage Indicator : <label class="m-0 inventory_code text-xs badge bg-success py-1"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Project Item : <label class="m-0 project_item py-1"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Superseded : <label class="m-0 superseded"></label></span>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-lg-3">
                          <div class="col-md-12 d-none" id="product-image-container">
                            <div class="img-container">
                              <div class="d-flex justify-center">
                                <img id="item_preview" src="/img/495.06.101.jpg" class="img-thumbnail" width="450" >
                              </div>
                              <div>
                                <a href="#" target="_blank" id="info-link" type="button" class="button-product-info btn btn-sm btn-dark mt-3">
                                  Product Information
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card-body pt-0">
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
            </div>
        </div>
        <div class="row">
          <div class="col-lg-4 mb-lg-0 mt-4">
              <div class="card ">
                  <div class="table-responsive">
                      <table id="uom_table" class="table align-items-center ">
                          <thead>
                              <tr>
                                  <th class="text-uppercase text-sm font-weight-bolder "> UOM</th>
                                  <th class="text-end text-uppercase text-sm font-weight-bolder"> Base Price (ZPL)</th>
                                  <th class="text-end text-uppercase text-sm font-weight-bolder"> RSP (ZPLV)</th>
                                  @can('salesusi manager')
                                  <th class="text-end text-uppercase text-sm font-weight-bolder"> ZPE</th>
                                  <th class="text-end text-uppercase text-sm font-weight-bolder"> MAP</th>
                                  @endcan
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
          <div class="col-lg-8 mb-lg-0 mt-4">
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
        <div class="row">
          <div class="col-lg-6 mb-lg-0 mt-4 bom_show_flg">
              <div class="card h-475">
                  <div class="card-header pb-0">
                      <div class="">
                        <label class="text-lg">BOM Informations</label>
                          <span class="float-end">No.of Parent can be made from available components <label class="text-lg text-primary bom_cal">0</label></span>
                      </div>

                  </div>
                  <div class="table-responsive">
                      <table id="bom_table" class="table align-items-center ">
                          <thead>
                              <tr>
                                  <th class="text-uppercase text-sm font-weight-bolder"> Parent</th>
                                  <th class="text-center border-usi text-uppercase text-sm font-weight-bolder ps-2"> Parent Qty</th>
                                  <th class="border-usi text-center text-uppercase text-sm font-weight-bolder"> Comp</th>
                                  <th class="border-usi text-center text-uppercase text-sm font-weight-bolder"> Comp Qty</th>
                                  <th class="d-none border-usi text-center text-uppercase text-sm font-weight-bolder"> Price/Unit</th>
                                  <th class="border-usi text-center text-uppercase text-sm font-weight-bolder"> Comp STK</th>
                                  <th class="border-usi text-center text-uppercase text-sm font-weight-bolder"> Cal STK</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
          <div class="col-lg-6 mb-lg-0 mt-4">
              <div class="card h-475">
                  <div class="table-responsive">
                      <table id="wss_table" class="table align-items-center ">
                          <thead>
                              <tr>
                                  <th class="text-uppercase text-sm font-weight-bolder"> Week</th>
                                  <th class="text-center border-usi text-uppercase text-sm font-weight-bolder ps-2"> Inbound</th>
                                  <th class="border-usi text-center text-uppercase text-sm font-weight-bolder"> Outbound</th>
                                  <th class="border-usi text-center text-uppercase text-sm font-weight-bolder"> Available</th>
                                  <th class="border-usi text-center text-uppercase text-sm font-weight-bolder"> Reserved</th>
                                  <th class="border-usi text-center text-uppercase text-sm font-weight-bolder"> Forecast</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>

        </div>
        @can('salesusi iodetail')
        <div class="row">
          <div class="col-lg-6 mb-lg-0 mt-4">
              <div class="card h-400">
                  <div class="card-header pb-0">
                      <h6>PO Details</h6>
                  </div>
                  <div class="table-responsive">
                      <table id="po_table" class="table align-items-center ">
                          <thead>
                              <tr>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder"> Document</th>
                                  <th class="border-usi text-uppercase text-secondary text-xxs font-weight-bolder ps-2"> Document Date</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder"> UOM</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Qty</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder"> ETA</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
              </div>
            </div>
            <div class="col-lg-6 mb-lg-0 mt-4">
                <div class="card h-400">
                    <div class="card-header pb-0">
                        <h6>SO Details</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="so_table" class="table align-items-center ">
                            <thead>
                                <tr>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder"> SO Detail</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2"> SO Date</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Uom</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Order Qty</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Confirmed</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Delivered</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Invoiced</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Pending</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Delivery Date</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Admin</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Rep</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
        </div>
        @endcan
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
  $(function(){
    const searchForm = document.getElementById('searchForm');
    const searchButton = document.getElementById('searchButton');
    const itemInput = document.getElementById('item_code');

    // จัดการการกด Enter ในช่อง input
    $('#item_code').on('keypress', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            search_usi();
        }
    });

    $('#item_code').focus();
    $('#item_code').mask('000.00.000');
    $('.bom_show_flg').hide();
  });

  $('#wss_table').on('click', '.inbound-link', function() {
    const weekNumber = $(this).data('week-number');
    search_usi_inbound(weekNumber);
  })

  $('#wss_table').on('click', '.outbound-link', function() {
    const weekNumber = $(this).data('week-number');
    const yearNumber = $(this).data('year-number');
    search_usi_outbound(weekNumber, yearNumber);
  });

  function addCommas(nStr)
  {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
  }

  function addCommasD2(nStr)
  {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    res = x1 + x2;
    res = parseFloat(res).toFixed(2);

    return res;
  }

  function search_usi(){
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
      url: '{{ ROUTE('search_usi')}}',
      data:{
        item_code: item_code,
        _token: _token
      }
    }).done(function(res){
      Swal.close();
      if(res['count'] == 0){
        $('#product-image-container').addClass('d-none');

        $('.text-input').html('');
        $(':checkbox').prop('checked', false);
        $("#uom_table > tbody").html("");
        $("#bom_table > tbody").html("");
        $(".bom_cal").html("");
        $("#stk_table > tbody").html("");
        $("#mss_table > tbody").html("");
        $("#po_table > tbody").html("");
        $("#so_table > tbody").html("");
        $("#wss_table > tbody").html("");
        $("#t20_3_table > tbody").html("");
        $("#t20_12_table > tbody").html("");
        $('#errorModal').modal('show');
        $('#errorModal').on('shown.bs.modal', function () {$('#btnCloseModal').focus();});
        $('#product_img').attr('src','/storage/img/products/coming_soon.jpg');
        $('.card-body div div span label').text('');
        return false;
      } else {
        let code = item_code;
        let newUrl = 'sales-usi/product-info/' + code;

        $('#product-image-container').removeClass('d-none');
        $('.button-product-info').attr('href', newUrl);
      }

      $("#po_table > tbody").html("");
      $("#so_table > tbody").html("");

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
      $('.item_dm').html(res['data'][0]['NSU_ITEM_DM']);
      $('.mrp_desc').html(res['data'][0]['NSU_ITEM_DM_DESC']);
      $('.purchaser').html(res['data'][0]['NSU_PURCHASER']);
      $('.pm_contact').html(res['data'][0]['NSU_PROD_MGR']);
      $('.uom').html(res['data'][0]['NSU_ITEM_UOM_CODE']);
      $('.pack_code2').html(res['data'][0]['NSU_CONV_BASE_UOM'] + ' ' + res['data'][0]['NSU_ITEM_UOM_CODE']);
      $('.weight_volume1').html(res['data'][0]['NSU_PACK_WEIGHT']);
      $('.weight_volume2').html(res['data'][0]['NSU_PACK_VOLUME']);
      $('.repl_time').html(res['data'][0]['NSU_SUPP_REPL_TIME']);
      $('.purchase_moq').html(addCommas(res['data'][0]['NSU_PURC_MOQ']));
      $('.inventory_code').html(res['data'][0]['NSU_ITEM_INV_CODE']);
      $('.barcode').html(res['data'][0]['ean_upc']);
      $('.supplier_item_code').html(res['data'][0]['NSU_SUPP_ITEM_CODE']);
      $('.item_brand').html(res['data'][0]['NSU_ITEM_BRAND']);
      $('.exclusivity_remark').html(res['data'][0]['NSU_EXCL_REMARK']);
      $('.new_item_code').html(res['data'][0]['NSU_NEW_ITEM_CODE']);
      $('.free_stk_qty').html(res['data'][0]['NSU_FREE_STK_QTY']);
      $('.project_item').html('000.00.000');
      $('.superseded').html('000.00.000');

      let path_img = '/storage/img/products/' + item_code + '.jpg';
      $('#product_img').attr('src',path_img);

      const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      var d = new Date();
      $("#uom_table > tbody").html("");
      $("#bom_table > tbody").html("");
      $(".bom_cal").html("");
      $("#stk_table > tbody").html("");
      $("#mss_table > tbody").html("");
      $("#wss_table > tbody").html("");
      $("#t20_3_table > tbody").html("");
      $("#t20_12_table > tbody").html("");

      $.each(res['mss']['cust'], function(key, val) {
        var cust = val;
        var inv = res['mss']['inv'][key];
        var tot_qty = res['mss']['tot']['qty'][key];
        var tot_qty_ls = res['mss']['tot']['ls'][key];
        var sold_qty = res['mss']['sold']['qty'][key];
        var sold_qty_ls = res['mss']['sold']['ls'][key];
        var seq_month = d.getMonth() - key;
        var seq_year = d.getFullYear().toString().substr(-2);
        if(seq_month < 0){
          seq_month = (12 - key) + d.getMonth();
          seq_year = seq_year - 1;
        }
        var date = monthNames[seq_month] + '-' + seq_year;
        if(key == 12){
          date = '';
        }
        let tbody = '<tr><td><p class="text-end text-xs font-weight-bold mb-0">'+date+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(tot_qty)+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+addCommas(tot_qty_ls)+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(sold_qty)+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+addCommas(sold_qty_ls)+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+inv+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+cust+'</p></td></tr>';

        $('#mss_table').append(tbody);
      });
      let forecast = 0;

      $.each(res['wss'], function(key, val) {
        let text_danger_in = '';
        let text_danger_out = '';
        if(parseInt(val["WSS_INCOMING_QTY"]) > 0){
          text_danger_in = 'text-danger';
        }
        if(val["WSS_RES_QTY"] > 0){
          text_danger_out = 'text-danger';
        }

        if(key == 0){
          forecast = val["WSS_AVAIL_QTY"];
        }
        forecast = forecast + parseInt(val["WSS_INCOMING_QTY"]) - val["WSS_RES_QTY"];

        let tbody = '<tr>\
            <td class="border-usi">\
                <p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["year_number"]+'/'+val["week_number"]+'</p>\
            </td>\
            <td class="border-usi">\
                @can('salesusi iodetail')
                <p data-week-number="'+val["week_number"]+'" class="'+text_danger_in+' wss-table text-end text-xs font-weight-bold mb-0 px-3 inbound-link">'+parseInt(val["WSS_INCOMING_QTY"])+'</p>\
                @else
                <p class="wss-table '+text_danger_in+' text-end text-xs font-weight-bold mb-0 px-3">'+parseInt(val["WSS_INCOMING_QTY"])+'</p>\
                @endcan
            </td>\
            <td class="border-usi">\
                @can('salesusi iodetail')
                <p data-week-number="'+val["week_number"]+'" data-year-number="'+val["year_number"]+'" class="'+text_danger_out+' wss-table text-end text-xs font-weight-bold mb-0 px-3 outbound-link">'+val["WSS_RES_QTY"]+'</p>\
                @else
                <p class="wss-table '+text_danger_out+' text-end text-xs font-weight-bold mb-0 px-3">'+val["WSS_RES_QTY"]+'</p>\
                @endcan
            </td>\
            <td class="border-usi">\
                <p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["WSS_AVAIL_QTY"]+'</p>\
            </td>\
            <td class="border-usi">\
                <p class="text-end text-xs font-weight-bold mb-0 px-3">'+val["WSS_RES_QTY"]+'</p>\
            </td>\
            <td class="border-usi">\
                <p class="text-end text-xs font-weight-bold mb-0 px-3">'+forecast+'</p>\
            </td>\
        </tr>';
        $('#wss_table').append(tbody);
      });

      $.each(res['uom'], function(key, val) {
        let tbody = '<tr><td><p class="text-xs font-weight-bold mb-0 px-3">'+val["IUW_UOM_CODE"]+'</p></td>\
                      <td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+val["IUW_PRICE"]+'</p></td>\
                      <td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+val["NEW_ZPLV_COST"]+'</p></td>\
                      @can('salesusi manager')<td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+val["NEW_ZPE_COST"]+' THB</p></td>\
                      <td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+val["NEW_MAP_COST"]+' THB</p></td>@endcan</tr>';
        $('#uom_table').append(tbody);
      });

      if (res['bom'] && res['bom'].length > 0) {
        $('.bom_show_flg').show();
        $.each(res['bom'], function(key, val) {
          let tbody = '<tr><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["parent"]+'</p></td>\
          <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0 px-3">'+val["parent_qty"]+'</p></td>\
          <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0 px-3">'+val["comp"]+'</p></td>\
          <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0 px-3">'+val["comp_qty"]+'</p></td>\
          <td class="d-none border-usi"><p class="float-end text-xs font-weight-bold mb-0 px-3">'+val["price_per_unit"]+'</p></td>\
          <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0 px-3">'+val["comp_stk"]+'</p></td>\
          <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0 px-3">'+val["cal_stk"]+'</p></td></tr>';
          $('#bom_table').append(tbody);
        });
      }else{
        $('.bom_show_flg').hide();
      }

      if (res['bom'] && res['bom'].length > 0 && res['bom'][0]['flg'] === 'material') {
          $('.bom_cal').html(res['bom'][0]['cal_stk']);
      } else {
          $('.bom_cal').html(0);
      }

      if (res['bom'] && res['bom'].length > 0) {
        let flg = res['bom'][0]['flg'];
        let bom_usg = res['bom'][0]['bom_usg'];

        // เคลียร์การติ๊กทุกช่องก่อน
        $('#chk_parent, #chk_comp, #chk_pp').prop('checked', false);

        // เงื่อนไขตามที่คุณต้องการ
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

      let tbody = '<tr><td><p class="text-xs font-weight-bold mb-0 px-3">'+res['stocks']['TH02']+'</p></td>\
                    <td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+res['stocks']['THS2']+' </p></td>\
                    <td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+res['stocks']['THS3']+' </p></td>\
                    <td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+res['stocks']['THS4']+' </p></td>\
                    <td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+res['stocks']['THS5']+' </p></td>\
                    <td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+res['stocks']['THS6']+' </p></td></tr>';
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

  function search_usi_inbound(week_no){
    let _token = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
        title: 'กำลังค้นหา...',
        text: 'โปรดรอสักครู่',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    $("#po_table > tbody").html("");

    $.ajax({
      method: 'POST',
      url: '{{ ROUTE('search_inbound') }}',
      data: {
        item_code: $('#item_code').val(),
        ipd_week_no: week_no,
        _token: _token
      }
    }).done(function(res){
      Swal.close();
      if(res['count'] == 0){ return false; }
      $.each(res['data'], function(key, val) {
        let tbody = '<tr>\
          <td><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_DOC_NO"]+'</p></td>\
          <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_DOC_DT"]+'</p></td>\
          <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_UOM_CODE"]+'</p></td>\
          <td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+val["IPD_QTY"]+'</p></td>\
          <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_ETA"]+'</p></td>\
          </tr>';
        $('#po_table').append(tbody);
      });

      $('html, body').animate({
          scrollTop: $("#po_table").offset().top
      }, 500);

    }).fail(function(jqXHR, textStatus, errorThrown) {
        Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถโหลดข้อมูลได้: ' + errorThrown, 'error');
    });
  }

  function search_usi_outbound(week_no, year_no){
    let _token = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
        title: 'กำลังค้นหา...',
        text: 'โปรดรอสักครู่',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    $("#so_table > tbody").html("");
    $.ajax({
      method: 'POST',
      url: '{{ ROUTE('search_outbound') }}',
      data: {
        item_code: $('#item_code').val(),
        week_no: week_no,
        year_no: year_no,
        _token: _token
      }
    }).done(function(res){
      Swal.close();
      if(res['count'] == 0){ return false; }
      $.each(res['data'], function(key, val) {
        let tbody = '<tr>\
        <td><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_DOC_NO"]+'</p></td>\
        <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_DOC_DT"]+'</p></td>\
        <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_UOM_CODE"]+'</p></td>\
        <td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_ORD_QTY"])+'</p></td>\
        <td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_RESV_QTY"])+'</p></td>\
        <td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_DEL_QTY"])+'</p></td>\
        <td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_INV_QTY"])+'</p></td>\
        <td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+(val["ISD_ORD_QTY"] - val["ISD_INV_QTY"])+'</p></td>\
        <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_DEL_DT"]+'</p></td>\
        <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_ADMIN"]+'</p></td>\
        <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_REP"]+'</p></td>\
        <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["sold_to_party"]+'-'+val["name1"]+'</p></td>\
        </tr>';
        $('#so_table').append(tbody);
      });

      $('html, body').animate({
          scrollTop: $("#so_table").offset().top
      }, 500);

    }).fail(function(jqXHR, textStatus, errorThrown) {
        Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถโหลดข้อมูลได้: ' + errorThrown, 'error');
    });
  }

  $(function(){
    $( ".error-close" ).on( "click", function() {
      $("#errorModal").modal('hide');
      $('#item_code').focus();
    } );
  });

</script>
@endsection
