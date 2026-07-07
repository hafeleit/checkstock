@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav', ['title' => 'Products 360°'])
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

  .item-link-trigger {
      cursor: pointer;
      text-decoration: underline;
  }

  .item-link-trigger:hover {
      color: #0d47a1;
  }

  .text-blue-600 {
    color: #3182ce;
  }

  .btn-faq {
    display: inline-flex;
    align-items: center;
    gap: 2px;
    padding: 6px 14px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.03em;
    color: #fff;
    background: #5e72e4;
    border: 1.5px solid #5e72e4;
    border-radius: 20px;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .btn-faq:hover {
    color: #fff;
    box-shadow: 0 4px 12px rgba(94, 114, 228, 0.35);
    text-decoration: none;
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
            <div class="col-md-12 mt-4 px-0">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 h3">Products 360°</h6>
                            @if($manualFaq)
                            <a href="{{ route('page-manual-faqs.show', 'product360') }}" target="_blank" class="btn-faq ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                                </svg>
                                คู่มือ - FAQ
                            </a>
                            @endif
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
                              <span>Project Item : <label class="m-0 project_item item-link-trigger search-project-item"></label></span>
                            </div>
                            <div class="col-12 col-sm-6 py-1">
                              <span>Superseded : <label class="m-0 superseded item-link-trigger search-superseded"></label></span>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-lg-3">
                          <div class="col-md-12 d-none" id="product-image-container">
                            <div class="img-container">
                              <div class="d-flex justify-center">
                                <img id="item_preview" src="" class="img-thumbnail img-product" width="450" >
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

                    <p class="text-sm fw-bold text-danger d-flex align-items-center gap-2 px-4 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        ข้อมูล ณ วันที่ {{ $yesterday }} เวลา 20:00 น. ถ้าคุณต้องการดูข้อมูล Stock realtime ให้กดปุ่ม Realtime Stock by Location ด้านล่าง
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-4 mb-lg-0 mt-4">
              <div class="card h-100">
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
              <div class="card h-100">
                  <div class="card-header pb-0 d-flex align-items-center gap-3 py-2">
                      <span class="text-uppercase text-secondary text-xxs font-weight-bolder">Stock by Location</span>
                      <button id="btn-realtime-stock" class="btn btn-primary mb-0" disabled>
                          <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                              <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                              <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                          </svg>
                          Realtime Stock by Location
                      </button>
                  </div>
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

    <!-- Realtime Stock Modal -->
    <div class="modal fade" id="realtimeStockModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="rt-header-inner">
              <div>
                <p class="rt-eyebrow">Realtime Stock</p>
                <h6 class="rt-item-code" id="realtime-item-label">—</h6>
                <p class="rt-as-of" id="realtime-fetch-time"></p>
              </div>
              <div class="rt-qty-block">
                <p class="rt-eyebrow">Total QTY</p>
                <h6 class="rt-total-qty" id="realtime-total-qty">—</h6>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="d-flex flex-column align-items-center justify-content-center py-5" id="realtime-loading">
              <div class="spinner-border rt-spinner" role="status"></div>
              <p class="rt-loading-text mb-0">Fetching live data...</p>
            </div>
            <div id="realtime-stock-content" class="d-none">
              <table class="table mb-0 rt-table">
                <thead>
                  <tr>
                    <th>Location</th>
                    <th class="text-end">Qty</th>
                  </tr>
                </thead>
                <tbody id="realtime-stock-rows"></tbody>
              </table>
            </div>
            <div class="d-none text-center py-4" id="realtime-stock-error">
              <p class="rt-error-text mb-0" id="realtime-error-msg">Unable to load data.</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn rt-close-btn ms-auto" data-dismiss="modal">Close</button>
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
  $(function(){
    const searchForm = document.getElementById('searchForm');
    const searchButton = document.getElementById('searchButton');
    const itemInput = document.getElementById('item_code');

    if (searchButton) {
        searchButton.addEventListener('click', search_usi);
    }

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

    // search if item_code in url parameter
    const urlParams = new URLSearchParams(window.location.search);
    const itemCodeParam = urlParams.get('item_code');
    if (itemCodeParam) {
        $('#item_code').val(itemCodeParam).trigger('input');
        search_usi();
    }
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

  $(document).on('click', '.search-parent-item', function(e) {
    let parentCode = $(this).data('item-code');
    if (parentCode) {
      $('#item_code').val(parentCode);
      search_usi();
    }
  });

  $(document).on('click', '.search-comp-item', function(e) {
    let compCode = $(this).data('item-code');
    if (compCode) {
      $('#item_code').val(compCode);
      search_usi();
    }
  });

  $(document).on('click', '.search-project-item', function(e) {
    let itemCode = $(this).text().trim();
    if (itemCode && itemCode !== '-') {
      $('#item_code').val(itemCode);
      search_usi();
    }
  });

  $(document).on('click', '.search-superseded', function(e) {
    let itemCode = $(this).text().trim();
    if (itemCode && itemCode !== '-') {
      $('#item_code').val(itemCode);
      search_usi();
    }
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

      // Remove item_code from URL
      const url = new URL(window.location);
      if (url.searchParams.has('item_code')) {
          url.searchParams.delete('item_code');
          window.history.replaceState({}, document.title, url.pathname);
      }

      if(res['count'] == 0){
        $('#product-image-container').addClass('d-none');
        $('#btn-realtime-stock').prop('disabled', true);

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
        let newUrl = '/product-infos/' + code;

        $('#product-image-container').removeClass('d-none');
        $('.button-product-info').attr('href', newUrl);
      }

      $("#po_table > tbody").html("");
      $("#so_table > tbody").html("");

      // IMAGE: product information
      if (res['imgPath']) {
          $(".img-product").attr("src", res['imgPath']).show();
          $('#item_preview_placeholder').addClass('d-none');
      } else {
          $('.img-product').hide();
          $('#item_preview_placeholder').removeClass('d-none');
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
      $('.project_item').html(res['productInfo'] && res['productInfo']['project_item'] ? res['productInfo']['project_item'] : '-');
      $('.superseded').html(res['productInfo'] && res['productInfo']['superseded'] ? res['productInfo']['superseded'] : '-');

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
          let tbody = '<tr>\
            <td class="border-usi">\
                <span class="item-link-trigger search-parent-item" \
                    data-item-code="' + val["parent"] + '">\
                    <p class="text-start text-xs font-weight-bold mb-0 px-3">' + val["parent"] + '</p>\
                </span>\
            </td>\
            <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0 px-3">'+val["parent_qty"]+'</p></td>\
            <td class="border-usi">\
                <span class="item-link-trigger search-comp-item" \
                    data-item-code="' + val["comp"] + '">\
                    <p class="text-center text-xs font-weight-bold mb-0 px-3">' + val["comp"] + '</p>\
                </span>\
            </td>\
            <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0 px-3">'+val["comp_qty"]+'</p></td>\
            <td class="d-none border-usi"><p class="float-end text-xs font-weight-bold mb-0 px-3">'+val["price_per_unit"]+'</p></td>\
            <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0 px-3">'+val["comp_stk"]+'</p></td>\
            <td class="border-usi"><p class="text-center text-xs font-weight-bold mb-0 px-3">'+val["cal_stk"]+'</p></td>\
          </tr>';
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


      let tbody = '<tr><td><p class="text-xs font-weight-bold mb-0 px-3">'+addCommas(res['stocks']['TH02'])+'</p></td>\
                    <td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(res['stocks']['THS2'])+' </p></td>\
                    <td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(res['stocks']['THS3'])+' </p></td>\
                    <td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(res['stocks']['THS4'])+' </p></td>\
                    <td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(res['stocks']['THS5'])+' </p></td>\
                    <td><p class="text-end text-xs font-weight-bold mb-0 px-3">'+addCommas(res['stocks']['THS6'])+' </p></td></tr>';
      $('#stk_table').append(tbody);
      $('#btn-realtime-stock').prop('disabled', false);
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

    $(document).on('click', '#realtimeStockModal .rt-close-btn, #realtimeStockModal .rt-close-x', function() {
      $('#realtimeStockModal').modal('hide');
    });
  });

  $('#btn-realtime-stock').on('click', function() {
    const itemCode = $('#item_code').val();
    if (!itemCode) return;

    $('#realtime-item-label').text(itemCode);
    $('#realtime-loading').removeClass('d-none');
    $('#realtime-stock-content').addClass('d-none');
    $('#realtime-stock-error').addClass('d-none');
    $('#realtime-stock-rows').html('');
    $('#realtime-fetch-time').text('');
    $('#realtime-total-qty').text('—');

    $('#realtimeStockModal').modal('show');

    $.ajax({
      method: 'GET',
      url: '{{ route("sales-usi.realtime-stock") }}',
      data: { item_code: itemCode }
    }).done(function(res) {
      $('#realtime-loading').addClass('d-none');

      if (!res.status) {
        $('#realtime-stock-error').removeClass('d-none');
        $('#realtime-error-msg').text(res.message || 'No data found.');
        return;
      }

      const articles = res.data ? res.data : [];
      let rows = '';
      let totalQty = 0;

      if (articles.length > 0) {
        $.each(articles, function(i, art) {
          const locLabel = art.LocationName || '-';
          const qty = art.Atpquantity != null ? art.Atpquantity : 0;
          totalQty += qty;
          rows += '<tr>' +
            '<td class="ps-3 py-2 rt-row-loc">' + locLabel + '</td>' +
            '<td class="text-end pe-3 py-2 rt-row-qty">' + addCommas(qty) + '</td>' +
            '</tr>';
        });
      } else {
        rows = '<tr><td colspan="2" class="text-center text-secondary py-3 rt-empty">No stock data available.</td></tr>';
      }

      $('#realtime-stock-rows').html(rows);
      $('#realtime-total-qty').text(addCommas(totalQty));
      $('#realtime-stock-content').removeClass('d-none');

      const now = new Date();
      const pad = n => String(n).padStart(2, '0');
      const asOf = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
      $('#realtime-fetch-time').text('As of Time' + asOf);

    }).fail(function(jqXHR) {
      $('#realtime-loading').addClass('d-none');
      $('#realtime-stock-error').removeClass('d-none');
      const msg = (jqXHR.responseJSON && jqXHR.responseJSON.message)
        ? jqXHR.responseJSON.message
        : 'Unable to connect to realtime service.';
      $('#realtime-error-msg').text(msg);
    });
  });

</script>
@endsection
