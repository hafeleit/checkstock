@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
<div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
    <span class="mask bg-primary opacity-6"></span>
</div>
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-4 mt-4">
                <div class="card">
                  <?php
                  $image = '/img/products/' . $product->ITEM_CODE . '.jpg';
                  if (file_exists( public_path() . $image )) {
                      echo '<img src="/img/products/'.$product->ITEM_CODE.'.jpg" alt="Image placeholder" class="card-img-top">';
                  } else {
                      echo '<img src="/img/products/coming_soon.jpg" alt="Image placeholder" class="card-img-top">';
                  }
                   ?>
                    <div class="card-body pt-0">
                    </div>
                </div>

            </div>
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header pb-0 px-3">
                        <a class="opacity-9 text-white" href="{{ route('products.index') }}"><button type="button" class="btn btn-primary">Back</button></a>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-3 text-sm">Product Information</h6>
                                    <span class="mb-2 text-sm">ITEM CODE:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['ITEM_CODE'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM NAME:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['ITEM_NAME'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM STATUS:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['ITEM_STATUS'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM INVENTORY CODE:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['ITEM_INVENTORY_CODE'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM REPL TIME:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['ITEM_REPL_TIME'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM GRADE CODE 1:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['ITEM_GRADE_CODE_1'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM UOM CODE:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['ITEM_UOM_CODE'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PACK CONV FACTOR:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['PACK_CONV_FACTOR'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PACK PARENT UOM CODE:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['PACK_PARENT_UOM_CODE'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">LOCN CODE:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['LOCN_CODE'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">LOCN NAME:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['LOCN_NAME'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">FREESTOCK:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['FREESTOCK'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">RATE:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['RATE'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">NEW ITEM:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product['NEW_ITEM'] }}</span>
                                    </span>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                              <div class="d-flex flex-column">
                                <h6 class="mb-3 text-sm">Catalog</h6>
                                <span class="mb-2 text-sm">Comming soon
                                </span>
                              </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
