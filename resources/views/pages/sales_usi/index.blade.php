@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav', ['title' => 'SALES USI'])
<style media="screen">
  .border-usi{
    border-left: 1px solid #e9ecef !important;
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
                        <p class="text-uppercase text-secondary text-xxs font-weight-bolder">LAST UPDATE: {{ $created_at ?? '' }}</p>
                    </div>

                    <div class="card-body" style="padding-top: 0px">
                        <div class="row">
                          <!--
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <span class="mb-2 text-sm">Item Code: </span>
                                </div>
                            </div> -->
                            <div class="col-md-4">
                                <div class="form-group" style="position: relative;">
                                    <input class="form-control" id="item_code" name="item_code" type="text" placeholder="Search..." value="311.03.101">
                                    <a href="javascript:;" onclick="search_usi()">
                                      <img src="./img/icons/search.png" alt="Country flag" width="25px" style="position: absolute;top: 18%;right: 5%;">
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                          <div class="col-12 col-sm-3">
                            <span>Item Code : <label class="item_code text-sm"></label></span>
                          </div>
                          <div class="col-12 col-sm-4">
                            <span>Item Desc : <label class="item_desc text-sm"></label></span>
                          </div>
                          <div class="col-12 col-sm-3">
                            <span>UOM Code : <label class="uom text-sm"></label></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-sm-3">
                            <span>New Item Code : <label class="new_item_code text-sm"></label></span>
                          </div>
                          <div class="col-12 col-sm-4">
                            <span>Supp Repl Time : <label class="repl_time text-sm"></label></span>
                          </div>
                          <div class="col-12 col-sm-3">
                            <span>Base Price : <label class="bash_price text-sm"></label></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-sm-3">
                            <span>Purchasing Group : <label class="purchaser text-sm"></label></span>
                          </div>
                          <div class="col-12 col-sm-4">
                            <span>Product group manag : <label class="pm_contact text-sm"></label></span>
                          </div>
                          <div class="col-12 col-sm-3">
                            <span>Pack Uom Code : <label class="pack_code1 text-sm"></label></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-sm-3">
                            <span>Conv Base UOM : <label class="pack_code2 text-sm"></label></span>
                          </div>
                          <div class="col-12 col-sm-4">
                            <span>Pack Weight : <label class="weight_volume1 text-sm"></label></span>
                          </div>
                          <div class="col-12 col-sm-3">
                            <span>Pack Volume : <label class="weight_volume2 text-sm"></label></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-sm-3">
                            <span>Purc Moq : <label class="purchase_moq text-sm"></label></span>
                          </div>
                          <div class="col-12 col-sm-4">
                            <span>Supp Item Code : <label class="supplier_item_code text-sm"></label></span>
                          </div>
                          <div class="col-12 col-sm-3">
                            <span>Free Stk Qty : <label class="free_stk_qty text-sm"></label></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-sm-3">
                            <span>Excl Remark : <label class="exclusivity_remark text-sm"></label></span>
                          </div>
                          <div class="col-12 col-sm-4">
                            <span>Item Status : <label class="item_status text-sm"></label></span>
                          </div>
                          <div class="col-12 col-sm-3">
                            <span>Storage indicator : <label class="inventory_code text-sm"></label></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-sm-4">
                            <span>Item Brand : <label class="item_brand text-sm"></label></span>
                          </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-8 mb-lg-0 mt-4">
              <div class="card ">
                  <div class="table-responsive">
                      <table id="uom_table" class="table align-items-center ">
                          <thead>
                              <tr>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder "> UOM</th>
                                  <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder"> Price</th>
                                  <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder"> ZPE COST</th>
                                  <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder"> MAP COST</th>
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
          <!--<div class="col-lg-6 mb-lg-0 mt-4">
              <div class="card " style="height: 475px;">
                  <div class="table-responsive">
                      <table id="mss_table" class="table align-items-center ">
                          <thead>
                              <tr>
                                  <th class="text-secondary"></th>
                                  <th colspan="2" class="border-usi text-center text-end text-uppercase text-secondary text-xxs font-weight-bolder ps-2"> Tot. Qty</th>
                                  <th colspan="2" class="border-usi text-center text-end text-uppercase text-secondary text-xxs font-weight-bolder ps-2"> Sold Qty.</th>
                                  <th class="border-usi text-end text-uppercase text-secondary text-xxs font-weight-bolder"> Inv Count</th>
                                  <th class="border-usi text-end text-uppercase text-secondary text-xxs font-weight-bolder"> Cust</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>-->
          <div class="col-lg-8 mb-lg-0 mt-4">
              <div class="card" style="height: 475px;">
                  <div class="table-responsive">
                      <table id="wss_table" class="table align-items-center ">
                          <thead>
                              <tr>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder"> Week</th>
                                  <th class="text-center border-usi text-uppercase text-secondary text-xxs font-weight-bolder ps-2"> Inbound</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Outbound</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Avaliable</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Received</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Forecast</th>
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
          <div class="col-lg-6 mb-lg-0 mt-4">
              <div class="card " style="height: 270px;">
                  <div class="card-header pb-0">
                      <h6>PO Detail</h6>
                  </div>
                  <div class="table-responsive">
                      <table id="po_table" class="table align-items-center ">
                          <thead>
                              <tr>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder"> Document</th>
                                  <th class="border-usi text-uppercase text-secondary text-xxs font-weight-bolder ps-2"> Document Date</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder"> UOM</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Qty</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder"> ETS</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Status</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
              </div>
            </div>
            <div class="col-lg-6 mb-lg-0 mt-4">
                <div class="card " style="height: 270px;">
                    <div class="card-header pb-0">
                        <h6>SO Detail</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="so_table" class="table align-items-center ">
                            <thead>
                                <tr>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder"> SO Detail</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2"> SO Date</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Uom</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Order Qty</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Resv Qty</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Delivered</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Invoiced</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Delivery Date</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Rate</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Value</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Admin</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"> Rep</th>
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

    <!-- Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Error</h5>
          </div>
          <div class="modal-body">
            No item code information found.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger error-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

<script type="text/javascript">

  $(function(){
    $('#item_code').on('keypress', function(event) {
        if (event.which === 13) { // 13 คือ keycode ของ Enter
            event.preventDefault(); // ป้องกันการ submit form
            search_usi();
        }
    });
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
    $.ajax({
      method: 'GET',
      url: '{{ ROUTE('search_usi')}}',
      data:{
        item_code: item_code
      }
    }).done(function(res){
      console.log(res);
      if(res['count'] == 0){
        $('.text-input').html('');
        $(':checkbox').prop('checked', false);
        $("#uom_table > tbody").html("");
        $("#mss_table > tbody").html("");
        $("#po_table > tbody").html("");
        $("#so_table > tbody").html("");
        $("#wss_table > tbody").html("");
        $("#t20_3_table > tbody").html("");
        $("#t20_12_table > tbody").html("");
        $('#errorModal').modal('show');
        $('#product_img').attr('src','/storage/img/products/coming_soon.jpg');
        $('.card-body div div span label').text('');
        return false;
      }
      $('.item_code').html(res['data']['NSU_ITEM_CODE']);
      $('.item_desc').html(res['data']['NSU_ITEM_NAME']);
      $('.purchaser').html(res['data']['NSU_PURCHASER']);
      $('.pm_contact').html(res['data']['NSU_PROD_MGR']);
      $('.uom').html(res['data']['NSU_ITEM_UOM_CODE']);
      $('.pack_code1').html(res['data']['NSU_PACK_UOM_CODE']);
      $('.pack_code2').html(res['data']['NSU_CONV_BASE_UOM'] + ' ' + res['data']['NSU_ITEM_UOM_CODE']);
      $('.weight_volume1').html(res['data']['NSU_PACK_WEIGHT'] + ' KG');
      $('.weight_volume2').html(res['data']['NSU_PACK_VOLUME'] + ' Dm 3');
      $('.item_status').html(res['data']['NSU_ITEM_STATUS']);
      $('.repl_time').html(res['data']['NSU_SUPP_REPL_TIME']);
      $('.bash_price').html(res['data']['NSU_BASE_PRICE'] + ' THB');
      $('.purchase_moq').html(addCommas(res['data']['NSU_PURC_MOQ']));
      $('.inventory_code').html(res['data']['NSU_ITEM_INV_CODE']);
      $('.supplier_item_code').html(res['data']['NSU_SUPP_ITEM_CODE']);
      $('.item_brand').html(res['data']['NSU_ITEM_BRAND']);
      $('.exclusivity_remark').html(res['data']['NSU_EXCL_REMARK']);
      $('.new_item_code').html(res['data']['NSU_NEW_ITEM_CODE']);
      $('.free_stk_qty').html(res['data']['NSU_FREE_STK_QTY']);

      let path_img = '/storage/img/products/' + item_code + '.jpg';
      $('#product_img').attr('src',path_img);

      const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      var d = new Date();
      $("#uom_table > tbody").html("");
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
      const year = new Date().getFullYear().toString().slice(-2);
      $.each(res['wss'], function(key, val) {
        //let wss = val["week_number"].split(" ").join("");
        //let week_no = "'" + wss.split("/").join("") + "'";
        let text_danger_in = '';
        let text_danger_out = '';
        if(val["WSS_INCOMING_QTY"] > 0){
          text_danger_in = 'text-danger';
        }
        if(val["WSS_RES_QTY"] > 0){
          text_danger_out = 'text-danger';
        }

        if(key == 0){
          forecast = val["WSS_AVAIL_QTY"];
        }
        forecast = forecast + val["WSS_INCOMING_QTY"] - val["WSS_RES_QTY"];

        let tbody = '<tr>\
          <td class="border-usi">\
            <p class="text-start text-xs font-weight-bold mb-0 px-3">'+year+'/'+val["week_number"]+'</p>\
          </td>\
          <td class="border-usi">\
            <p style="text-decoration: underline;cursor: pointer;" onclick="search_usi_inbound('+val["week_number"]+')" class="'+text_danger_in+' text-end text-xs font-weight-bold mb-0 px-3">'+val["WSS_INCOMING_QTY"]+'</p>\
          </td>\
          <td class="border-usi">\
            <p style="text-decoration: underline;cursor: pointer;" onclick="search_usi_outbound('+val["week_number"]+')" class="'+text_danger_out+' text-end text-xs font-weight-bold mb-0 px-3">'+val["WSS_RES_QTY"]+'</p>\
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
        let tbody = '<tr><td><p class="text-xs font-weight-bold mb-0 px-3">'+val["IUW_UOM_CODE"]+'</p></td><td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+val["IUW_PRICE"]+' THB</p></td><td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+val["NEW_ZPE_COST"]+' THB</p></td><td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+val["NEW_MAP_COST"]+' THB</p></td></tr>';
        $('#uom_table').append(tbody);
      });

    });
  }

  function search_usi_inbound(week_no){
    $("#po_table > tbody").html("");
    $.ajax({
      method: 'GET',
      url: '{{ ROUTE('search_inbound') }}',
      data: {
        item_code: $('#item_code').val(),
        ipd_week_no: week_no,
      }
    }).done(function(res){
      console.log(res);
      if(res['count'] == 0){ return false; }
      $.each(res['data'], function(key, val) {
        let tbody = '<tr>\
          <td><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_DOC_NO"]+'</p></td>\
          <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_DOC_DT"]+'</p></td>\
          <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_UOM_CODE"]+'</p></td>\
          <td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+val["IPD_QTY"]+'</p></td>\
          <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_ETS"]+'</p></td>\
          <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_STATUS"]+'</p></td>\
          </tr>';
        $('#po_table').append(tbody);
      });

      $('html, body').animate({
          scrollTop: $("#po_table").offset().top
      }, 500);

    });
  }

  function search_usi_outbound(week_no){
    $("#so_table > tbody").html("");
    $.ajax({
      method: 'GET',
      url: '{{ ROUTE('search_outbound') }}',
      data: {
        item_code: $('#item_code').val(),
        ipd_week_no: week_no,
      }
    }).done(function(res){
      console.log(res);
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
        <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_DEL_DT"]+'</p></td>\
        <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_RATE"]+'</p></td>\
        <td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_VALUE"])+'</p></td>\
        <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_ADMIN"]+'</p></td>\
        <td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_REP"]+'</p></td></tr>';
        $('#so_table').append(tbody);
      });

      $('html, body').animate({
          scrollTop: $("#so_table").offset().top
      }, 500);

    });
  }

  $(function(){
    $( ".error-close" ).on( "click", function() {
      $("#errorModal").modal('hide');
    } );
    //$('#p').prop('checked', true);
    //var d = new Date();
    //var month = d.getMonth()+1;
    //console.log(monthNames[d.getMonth()-1]);
  });

</script>
@endsection
