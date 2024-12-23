@extends('layouts.appguest', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<style media="screen">
  .border-usi{
    border-left: 1px solid #e9ecef !important;
  }

</style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 mt-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0">SALES USI</h6>
                        </div>
                        <p class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">LAST UPDATE: {{ $created_at ?? '' }}</p>
                    </div>

                    <div class="card-body" style="padding-top: 0px">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <span class="mb-2 text-sm">Item Code: </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="position: relative;">
                                    <input class="form-control" id="item_code" name="item_code" type="text" value="">
                                    <a href="javascript:;" onclick="search_usi()">
                                      <img src="./img/icons/search.png" alt="Country flag" width="25px" style="position: absolute;top: 18%;right: 5%;">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">Item Desc: </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light item_desc text-input"></span>
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">Purchaser:</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light purchaser text-input"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">PM Contact:</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light pm_contact text-input"></span>
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">Uom:</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light uom text-input"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">Pack Code:</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light pack_code1 text-input"></span>
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light pack_code2 text-input"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">Item Status:</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light item_status text-input"></span>
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">Weight-Volume:</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light weight_volume1 text-input"></span>
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light weight_volume2 text-input"></span>
                                </div>
                            </div>

                          </div>
                          <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">RepL Time:</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light repl_time text-input"></span>
                                </div>
                            </div>
                          </div>
                          <div class="row">


                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">Purchase MOQ:</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light purchase_moq text-input"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">Inventory Code:</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light inventory_code text-input"></span>
                                </div>
                            </div>

                          </div>
                          <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">Project Item:</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light project_item text-input"></span>
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">Item Brand:</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light item_brand text-input"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">New Item Code:</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light new_item_code text-input"></span>
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-sm">Exclusivity Remark:</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light exclusivity_remark text-input" style="text-wrap: wrap;text-align: left;"></span>
                                </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="text-dark ms-sm-2 font-weight-bold badge btn-light free_stk_at_others1 text-input"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mt-4">
                <div class="card card-profile ">
                    <img id="product_img" src="/storage/img/products/coming_soon.jpg" alt="Image placeholder" class="card-img-top">

                    <div class="card-body pt-0">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-10 mb-lg-0 mt-4">
              <div class="card ">
                  <div class="table-responsive">
                      <table id="uom_table" class="table align-items-center ">
                          <thead>
                              <tr>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 "> UOM</th>
                                  <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Conv Fact</th>
                                  <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Max Loose</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 "> Price List</th>
                                  <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Price</th>
                                  <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Discount</th>
                                  <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Net Value</th>
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
              <div class="card " style="height: 475px;">
                  <div class="table-responsive">
                      <table id="mss_table" class="table align-items-center ">
                          <thead>
                              <tr>
                                  <th class="text-secondary opacity-7"></th>
                                  <th colspan="2" class="border-usi text-center text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> Tot. Qty</th>
                                  <th colspan="2" class="border-usi text-center text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> Sold Qty.</th>
                                  <th class="border-usi text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Inv Count</th>
                                  <th class="border-usi text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Cust</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
          <div class="col-lg-6 mb-lg-0 mt-4">
              <div class="card" style="height: 475px;">
                  <div class="table-responsive">
                      <table id="wss_table" class="table align-items-center ">
                          <thead>
                              <tr>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Week</th>
                                  <th colspan="2" class="text-center border-usi text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> Inbound</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Status</th>
                                  <th colspan="2" class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Outbound</th>
                                  <th colspan="2" class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Avaliable</th>
                                  <th colspan="2" class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Received</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> +/</th>
                                  <th colspan="2" class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Forecast</th>
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
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Document</th>
                                  <th class="border-usi text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> Document Date</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> UOM</th>
                                  <th colspan="2" class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Qty</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Mode of Ship</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Locn Code</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> ETS</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> ETA</th>
                                  <th class="border-usi text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Status</th>
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
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> SO Detail</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> SO Date</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Uom</th>
                                  <th colspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Order Qty</th>
                                  <th colspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Resv Qty</th>
                                  <th colspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Delivered</th>
                                  <th colspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Invoiced</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Delivery Date</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Del Locn</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Current</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Rate</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Value</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Admin</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Rep</th>
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
        return false;
      }
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
      $('.purchase_moq').html(addCommas(res['data']['NSU_PURC_MOQ']));
      $('.inventory_code').html(res['data']['NSU_ITEM_INV_CODE']);
      $('.supplier_item_code').html(res['data']['NSU_SUPP_ITEM_CODE']);
      $('.item_brand').html(res['data']['NSU_ITEM_BRAND']);
      $('.exclusivity_remark').html(res['data']['NSU_EXCL_REMARK']);
      $('.new_item_code').html(res['data']['NSU_NEW_ITEM_CODE']);

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

      $.each(res['wss'], function(key, val) {
        let wss = val["WSS_WEEK_NO"].split(" ").join("");
        let week_no = "'" + wss.split("/").join("") + "'";
        let text_danger_in = '';
        let text_danger_out = '';
        if(val["WSS_INCOMING_QTY"] > 0){
          text_danger_in = 'text-danger';
        }
        if(val["WSS_RES_QTY"] > 0){
          text_danger_out = 'text-danger';
        }
        //alert(week_no);
        let tbody = '<tr><td class="border-usi"><p class="text-xs font-weight-bold mb-0 px-3">'+val["WSS_WEEK_NO"]+'</p></td><td class="border-usi"><p style="text-decoration: underline;cursor: pointer;" onclick="search_usi_inbound('+week_no+')" class="'+text_danger_in+' text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["WSS_INCOMING_QTY"])+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+addCommas(val["WSS_INCOMING_QTY_LS"])+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["WSS_STATUS"]+'</p></td><td class="border-usi"><p style="text-decoration: underline;cursor: pointer;" onclick="search_usi_outbound('+week_no+')" class="'+text_danger_out+' text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["WSS_RES_QTY"])+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+addCommas(val["WSS_RES_QTY_LS"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["WSS_AVAIL_QTY"])+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+addCommas(val["WSS_AVAIL_QTY_LS"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["WSS_RCV_QTY"])+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+addCommas(val["WSS_RCV_QTY_LS"])+'</p></td><td class="border-usi"><p class="text-xs font-weight-bold mb-0 px-3">'+val["WSS_PLUSMINUS"]+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["WSS_FREE_QTY"])+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+addCommas(val["WSS_FREE_QTY_LS"])+'</p></td></tr>';
        $('#wss_table').append(tbody);
      });

      $.each(res['uom'], function(key, val) {
        let tbody = '<tr><td><p class="text-xs font-weight-bold mb-0 px-3">'+val["IUW_UOM_CODE"]+'</p></td><td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["IUW_CONV_FACTOR"])+'</p></td><td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["IUW_MAX_LOOSE"])+'</p></td><td><p class="text-xs font-weight-bold mb-0 px-3">'+val["IUW_PRICE_LIST"]+'</p></td><td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommasD2(val["IUW_PRICE"])+'</p></td><td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommasD2(val["IUW_DISC_PRICE"])+'</p></td><td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommasD2(val["IUW_NET_PRICE"])+'</p></td></tr>';
        $('#uom_table').append(tbody);
      });

      $.each(res['t20_3'], function(key, val) {
        let tbody = '<tr><td><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["LTC_CUST_CODE"]+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["LTC_CUST_NAME"]+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["LTC_ORD_QTY"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["LTC_ORD_QTY_LS"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["LTC_ORD_VAL"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["LTC_GC_PERC"])+'</p></td></tr>';
        $('#t20_3_table').append(tbody);
      });

      $.each(res['t20_12'], function(key, val) {
        let tbody = '<tr><td><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["LT_CUST_CODE"]+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["LT_CUST_NAME"]+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["LT_ORD_QTY"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["LT_ORD_QTY_LS"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["LT_ORD_VAL"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["LT_GC_PERC"])+'</p></td></tr>';
        $('#t20_12_table').append(tbody);
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
        let tbody = '<tr><td><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_DOC_NO"]+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_DOC_DT"]+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_UOM_CODE"]+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["IPD_QTY"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["IPD_QTY_LS"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+val["IPD_MODE_OF_SHIP"]+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+val["IPD_DEL_LOCN_CODE"]+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_ETS"]+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_ETA"]+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["IPD_STATUS"]+'</p></td></tr>';
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
        let tbody = '<tr><td><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_DOC_NO"]+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_DOC_DT"]+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_UOM_CODE"]+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_ORD_QTY"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_ORD_QTY_LS"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_RESV_QTY"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_RESV_QTY_LS"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_DEL_QTY"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_DEL_QTY_LS"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_INV_QTY"])+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_INV_QTY_LS"])+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_DEL_DT"]+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_DEL_LOCN_CODE"]+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_CURR_CODE"]+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_RATE"]+'</p></td><td class="border-usi"><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(val["ISD_VALUE"])+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_ADMIN"]+'</p></td><td class="border-usi"><p class="text-start text-xs font-weight-bold mb-0 px-3">'+val["ISD_REP"]+'</p></td></tr>';
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
