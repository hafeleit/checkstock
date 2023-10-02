@extends('layouts.appguest', ['class' => 'g-sidenav-show bg-gray-100'])
<div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
    <span class="mask bg-primary opacity-6"></span>
</div>
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-4 mt-4">
                <div class="card">
                  <?php
                    $image = '/storage/img/products/' . $product[0]->ITEM_CODE . '.jpg';
                    $image2 = '/storage/img/products/' . $product[0]->ITEM_CODE . '.JPG';
                    if (file_exists( public_path() . $image )) {
                        echo '<img src="'.$image.'" alt="Image placeholder" class="card-img-top">';
                    }elseif(file_exists( public_path() . $image2 )){
                        echo '<img src="'.$image2.'" alt="Image placeholder" class="card-img-top">';
                    } else {
                        echo '<img src="/storage/img/products/coming_soon.jpg" alt="Image placeholder" class="card-img-top">';
                    }
                   ?>
                    <div class="card-body pt-0">
                    </div>
                </div>

            </div>
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header pb-0 px-3">
                        <a class="opacity-9 text-white" href="{{ route('products.index') .'?view='.request()->input('view') }}"><button type="button" class="btn btn-primary">Back</button></a>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-3 text-sm">Product Information</h6>
                                    <span class="mb-2 text-sm">ITEM CODE:
                                      <span class="text-danger font-weight-bold ms-sm-2">{{ $product[0]['ITEM_CODE'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM NAME EN:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_NAME'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM STATUS:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_STATUS'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM INVENTORY CODE:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_INVENTORY_CODE'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM REPL TIME:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_REPL_TIME'] }}</span> (Days)
                                    </span>
                                    <span class="mb-2 text-sm">ITEM GRADE CODE 1:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_GRADE_CODE_1'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM UOM CODE:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_UOM_CODE'] }}</span>
                                    </span>

                                    <span class="mb-2 text-sm">FREE STOCK:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ ($product[0]['STOCK_IN_HAND'] != '') ? number_format($product[0]['STOCK_IN_HAND']) : 0 }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PROJECT ITEM:
                                      <a href="{{ route('products.index').'/'.$product[0]['PROJECT_ITEM'].'?view='.request()->view }}"><span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PROJECT_ITEM'] }}</span></a>
                                    </span>
                                    <span class="mb-2 text-sm">PRICE LIST UOM:
                                      <span class="text-success font-weight-bold ms-sm-2">{{ $product[0]['PRICE_LIST_UOM'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PACK CONV FACTOR:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PACK_CONV_FACTOR'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">LIST PRICE EXCLUDE VAT:
                                      <span class="text-danger font-weight-bolder ms-sm-2">{{ ($product[0]->RATE != '' ? number_format($product[0]->RATE, 2) : '')}}</span>
                                    </span>
                                    <span class="mb-2 text-sm">LIST PRICE INCLUDE VAT:
                                      <span class="text-danger font-weight-bolder ms-sm-2">{{ ($product[0]->RATE7 != '' ? number_format($product[0]->RATE7, 2) : '')}}</span>

                                      @if(request()->input('admin') == 'admin')
                                      {{ ' / '. $product[0]['CURRWAC'] }}
                                      @endif
                                    </span>
                                    <span class="mb-2 text-sm">NEW ITEM:
                                      <a href="{{ route('products.index').'/'.$product[0]['NEW_ITEM'].'?view='.request()->view }}"><span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['NEW_ITEM'] }}</span></a>
                                    </span>

                                    <span class="text-danger text-lg">ก่อนทำการสั่งซื้อกรุณาตรวจสอบข้อมูลกับพนักงานขายอีกครั้ง (Kindly contact the salesperson before ordering.)</span>
                                </div>
                            </li>
                            @if(isset($product[1]))
                            <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                              <div class="d-flex flex-column">
                                <span class="mb-2 text-sm">PRICE LIST UOM:
                                  <span class="text-success font-weight-bold ms-sm-2">{{ $product[1]['PRICE_LIST_UOM'] }}</span>
                                </span>
                                <span class="mb-2 text-sm">PACK CONV FACTOR:
                                  <span class="text-dark font-weight-bold ms-sm-2">{{ $product[1]['PACK_CONV_FACTOR'] }}</span>
                                </span>
                                <span class="mb-2 text-sm">LIST PRICE EXCLUDE VAT:
                                  <span class="text-danger font-weight-bolder ms-sm-2">{{ ($product[1]->RATE != '' ? number_format($product[1]->RATE, 2) : '')}}</span>
                                </span>
                                <span class="mb-2 text-sm">LIST PRICE INCLUDE VAT:
                                  <span class="text-danger font-weight-bolder ms-sm-2">{{ ($product[1]->RATE7 != '' ? number_format($product[1]->RATE7, 2) : '')}}</span>
                                </span>
                              </div>
                            </li>
                            @endif
                            @if(isset($product[2]))
                            <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                              <div class="d-flex flex-column">
                                <span class="mb-2 text-sm">PRICE LIST UOM:
                                  <span class="text-success font-weight-bold ms-sm-2">{{ $product[2]['PRICE_LIST_UOM'] }}</span>
                                </span>
                                <span class="mb-2 text-sm">PACK CONV FACTOR:
                                  <span class="text-dark font-weight-bold ms-sm-2">{{ $product[2]['PACK_CONV_FACTOR'] }}</span>
                                </span>
                                <span class="mb-2 text-sm">LIST PRICE EXCLUDE VAT:
                                  <span class="text-danger font-weight-bolder ms-sm-2">{{ ($product[2]->RATE != '' ? number_format($product[2]->RATE, 2) : '')}}</span>
                                </span>
                                <span class="mb-2 text-sm">LIST PRICE INCLUDE VAT:
                                  <span class="text-danger font-weight-bolder ms-sm-2">{{ ($product[2]->RATE7 != '' ? number_format($product[2]->RATE7, 2) : '')}}</span>
                                </span>
                              </div>
                            </li>
                            @endif
                            @if(request()->input('view') == 'sales')
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-3 text-sm">More specific details</h6>
                                    <span class="mb-2 text-sm">ITEM NAME TH:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_NAME_TH'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM BRAND:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_BRAND'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PENDING SO:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ ($product[0]['PENDING_SO'] != '') ? number_format($product[0]['PENDING_SO']) : 0 }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">AVAILABLE STOCK:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ ($product[0]['AVAILABLE_STOCK'] != '') ? number_format($product[0]['AVAILABLE_STOCK']) : 0 }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM GRADE CODE 2:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_GRADE_CODE_2'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PRODUCT CATEGORY:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PRODUCT_CATEGORY'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PRODUCT GROUP:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PRODUCT_GROUP'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PRODUCT AIS:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PRODUCT_AIS'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PURCHASER NAME:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PURCHASER_NAME'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PM NAME:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PM_NAME'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">SALES CATEGORY:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['SALES_CATEGORY'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PACK CONV FACTOR:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PACK_CONV_FACTOR'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PRICE CLR(Incl.VAT):
                                      <span class="text-danger font-weight-bolder ms-sm-2">{{ ($product[0]['PRICE_CLR'] != '') ? number_format($product[0]['PRICE_CLR']) : 0 }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">STOCK CLR:
                                      <span class="text-danger font-weight-bolder ms-sm-2">{{ ($product[0]['STOCK_CLR'] != '') ? number_format($product[0]['STOCK_CLR_CAL']) : 0 }}</span>
                                    </span>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
