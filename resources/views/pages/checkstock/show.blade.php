@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav', ['title' => 'Check Stock'])
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">

          <div class="table-responsive">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
              <div class="dataTable-top">
                <div class="dataTable-dropdown">
                <h3>Product Detail</h3>
              </div>
                <div class="dataTable-search">
                  <form id="form_search" class="" action="{{ route('checkstock.index' )}}" method="get">
                    <input class="dataTable-input" placeholder="Search..." type="text" id="search" name="search">
                    <a href="#" class="btn bg-gradient-primary btn-sm mb-0" id="btn_search">Search</a>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">

          <div class="row">

            <div class="col-xl-6 col-xxl-5 col-lg-6 text-center">

              <?php
                $image = '/storage/img/products/' . $product->ITEM_CODE . '.jpg';
                if (!file_exists( public_path() . $image )) {
                  $image = "/storage/img/coming_soon.jpg";
                }
               ?>
              <img class="w-100 border-radius-lg shadow-lg mx-auto img-master" src="{{ $image }}" alt="chair" width="450" height="450">
              <div class="my-gallery d-flex mt-4 pt-2" itemscope="" itemtype="" data-pswp-uid="1">
                <figure class="ms-2 me-3" itemprop="associatedMedia" itemscope="" itemtype="">
                  <a itemprop="contentUrl" data-size="500x600">
                    <img class=" min-height-100 max-height-100 border-radius-lg shadow" src="{{ $image }}" alt="Image description">
                  </a>
                </figure>
                <?php
                  $image_d = '/storage/img/product_detail/'.$product->ITEM_CODE.'/'.$product->ITEM_CODE.'_D.jpg';
                  if (file_exists( public_path() . $image_d )) {
                 ?>
                  <figure class="me-3" itemprop="associatedMedia" itemscope="" itemtype="">
                    <a itemprop="contentUrl" data-size="500x600">
                      <img class=" min-height-100 max-height-100 border-radius-lg shadow" src="{{$image_d}}" itemprop="thumbnail" alt="Image description">
                    </a>
                  </figure>
                <?php
                  }
                ?>
                <?php
                  $image_l = '/storage/img/product_detail/'.$product->ITEM_CODE.'/'.$product->ITEM_CODE.'_F.jpg';
                  if (file_exists( public_path() . $image_l )) {
                 ?>
                  <figure class="me-3" itemprop="associatedMedia" itemscope="" itemtype="">
                    <a itemprop="contentUrl" data-size="500x600">
                      <img class=" min-height-100 max-height-100 border-radius-lg shadow" src="{{$image_l}}" itemprop="thumbnail" alt="Image description">
                    </a>
                  </figure>
                <?php
                  }
                ?>
                <?php
                  $image_l = '/storage/img/product_detail/'.$product->ITEM_CODE.'/'.$product->ITEM_CODE.'_I.jpg';
                  if (file_exists( public_path() . $image_l )) {
                 ?>
                  <figure class="me-3" itemprop="associatedMedia" itemscope="" itemtype="">
                    <a itemprop="contentUrl" data-size="500x600">
                      <img class=" min-height-100 max-height-100 border-radius-lg shadow" src="{{$image_l}}" itemprop="thumbnail" alt="Image description">
                    </a>
                  </figure>
                <?php
                  }
                ?>
                <?php
                  $image_l = '/storage/img/product_detail/'.$product->ITEM_CODE.'/'.$product->ITEM_CODE.'_L.jpg';
                  if (file_exists( public_path() . $image_l )) {
                 ?>
                  <figure class="me-3" itemprop="associatedMedia" itemscope="" itemtype="">
                    <a itemprop="contentUrl" data-size="500x600">
                      <img class=" min-height-100 max-height-100 border-radius-lg shadow" src="{{$image_l}}" itemprop="thumbnail" alt="Image description">
                    </a>
                  </figure>
                <?php
                  }
                ?>
              </div>

            </div>
            <div class="col-lg-4 col-xxl-6 mx-auto">
              <h3 class="mt-lg-0 mt-4">{{ $product->ITEM_NAME }}</h3>

              <h6 class="mb-0 mt-3">Price</h6>
              <h5>฿{{ NUMBER_FORMAT($product->RATE7,2) ?? '' }}</h5>

              @if($product->STOCK_IN_HAND > 0)
                <span class="badge badge-success">In Stock</span>
              @else
                <span class="badge badge-danger badge-sm">Out of Stock</span>
              @endif

              <br>
              <br>
              <h5 class="mb-0">Description</h5>
              <br>
              <?php
                if( $product->ITEM_STATUS == '1_NEW' || $product->ITEM_STATUS == '2_ACTIVE' || $product->ITEM_STATUS == '3_INACTIVE' ){
                  $material_status = 'Active';
                }else{
                  $material_status = 'Discontinued';
                }
               ?>
              <ul class="list-group">
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">ITEM CODE:</strong> &nbsp; {{ $product['ITEM_CODE'] ?? '' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">ITEM STATUS:</strong> &nbsp; {{ $product['ITEM_STATUS'] ?? '' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">ITEM INVENTORY CODE:</strong> &nbsp; {{ $product['ITEM_INVENTORY_CODE'] ?? '' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">ITEM REPL TIME:</strong> &nbsp; {{ $product['ITEM_REPL_TIME'] ?? '' }} (Days)</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">ITEM GRADE CODE 1:</strong> &nbsp; {{ $product['ITEM_GRADE_CODE_1'] ?? '' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">ITEM UOM CODE:</strong> &nbsp; {{ $product['ITEM_UOM_CODE'] ?? '' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">FREE STOCK:</strong> &nbsp; {{ NUMBER_FORMAT($product['STOCK_IN_HAND']) ?? '' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">PROJECT ITEM:</strong> &nbsp; {{ $product['PROJECT_ITEM'] ?? '' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">PRICE LIST UOM:</strong> &nbsp; {{ $product['PRICE_LIST_UOM'] ?? '' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">PACK CONV FACTOR:</strong> &nbsp; {{ $product['PACK_CONV_FACTOR'] ?? '' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">LIST PRICE EXCLUDE VAT:</strong> &nbsp; {{ "฿".NUMBER_FORMAT($product->RATE, 2) ?? '' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">ESTIMATED TRANSFER PRICE:</strong> &nbsp; {{ ($product->CURRWAC != '') ? "฿".NUMBER_FORMAT($product->CURRWAC + (($product->CURRWAC / 100)*12),2) : 'Please check with HTH' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">CURRENT WAC:</strong> &nbsp; {{ ($product->CURRWAC != '') ? "฿".NUMBER_FORMAT($product->CURRWAC,2) : '' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">NEW WAC:</strong> &nbsp; {{ ($product->NEWWAC != '') ? "฿".NUMBER_FORMAT($product->NEWWAC,2) : '' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">NEW ITEM:</strong> &nbsp; {{ $product->NEW_ITEM ?? '' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">MATERAIL STATUS:</strong> &nbsp; {{ $material_status }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">INVENTORY TYPE:</strong> &nbsp; {{ ( $product->ITEM_INVENTORY_CODE == 'STOCK') ? 'Stock' : 'Non-stock' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">FREE STOCK:</strong> &nbsp; {{ $product->FREE_STOCK - $product->PENDING_SO }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">PACK CODE:</strong></li>
                @foreach($ppc as $row)
                  <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</strong>{{$row->IP_PACK_UOM_CODE . ' : ' .$row->IP_CONV_FACTOR}}</li>
                @endforeach


                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">SUPPLIER NAME:</strong> &nbsp; {{ ( $product->ITEM_TYPE == '0_NORMAL' ) ? $product->SUPP_NAME : 'INHOUSE' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">SUPPLIER LEAD TIME:</strong> &nbsp; {{ ( $product->ITEM_TYPE == '0_NORMAL' ) ? $product->ITEM_LEAD_TIME . ' (Days)' : 'Check with HTH' }} </li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">MOQ:</strong> &nbsp; {{ ( $product->ITEM_TYPE == '0_NORMAL' ) ? $product->MOQ : 'Check with HTH' }}</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">ITEM TYPE:</strong> &nbsp; {{ $product->ITEM_TYPE ?? '' }}</li>
              </ul>

              <?php
                $user_manual = '';
                if($product->USER_MANUAL != ''){
                  $user_manual = '/storage/img/user_manual/' . $product->USER_MANUAL;
                  if (file_exists( public_path() . $user_manual )) {
              ?>
              <div class="row mt-4">
                  <div class="col-lg-5">
                      <a href="{{ $user_manual }}" target="_blank">
                          <button class="btn btn-icon btn-outline-primary ms-2 export" data-type="csv" type="button" onclick="show_user_manual()">
                            <span class="btn-inner--icon"><i class="ni ni-folder-17"></i></span>
                            <span class="btn-inner--text">User Manual (PDF)</span>
                          </button>
                      </a>
                  </div>
              </div>
              <?php
                  }
                }
               ?>
            </div>
          </div>
          <div class="row mt-5">
            <div class="col-12">
              <h5 class="ms-3">Other Products</h5>
              <div class="table table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Item Code</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">LIST PRICE EXCLUDE VAT</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Item Status</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Item inventory code</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($product_other) > 0)
                      @foreach($product_other as $product_item)
                      <?php
                        $image = '/storage/img/products/' . $product_item->ITEM_CODE . '.jpg';
                        if (!file_exists( public_path() . $image )) {
                          $image = "/storage/img/coming_soon.jpg";
                        }
                       ?>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="{{ $image }}" class="avatar avatar-md me-3" alt="table image">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><a href="{{ route('checkstock.show',$product_item->id) }}">{{ $product_item->ITEM_NAME}}</a></h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm text-secondary mb-0">{{ $product_item->ITEM_CODE}}</p>
                      </td>
                      <td>
                        <p class="text-sm text-secondary mb-0">{{ "฿".NUMBER_FORMAT($product_item->RATE, 2) ?? '' }}</p>
                      </td>
                      <td>
                        <p class="text-sm text-secondary mb-0">{{ $product_item->ITEM_STATUS}}</p>
                      </td>
                      <td>
                        <p class="text-sm text-secondary mb-0">{{ $product_item->ITEM_INVENTORY_CODE}}</p>
                      </td>
                    </tr>
                      @endforeach
                    @endif
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

<script type="text/javascript">
$('img').on({
  'click': function() {
      var src = $(this).attr('src');
      $('.img-master').attr('src', src);
  }
});

$(function(){
  $( "#btn_search" ).on( "click", function() {
    $( "#form_search" ).trigger( "submit" );
  } );
});
</script>
@endsection