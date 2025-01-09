@extends('layouts.appguest', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.guest.topnav', ['title' => 'Products'])
    <style media="screen">
    .form-control:focus {

  border-color: #fff;

}
    </style>
    <div class="container-fluid">
      <input type="hidden" name="view" id="view" value="{{request()->input('view')}}">
      <div class="row">
        <div class="col-12">
          <div class="col-md-12 mb-lg-0">
              <div class="card mt-4">
                  <div class="card-header pb-0 p-3">
                      <div class="row">
                          <div class="col-12 d-flex align-items-center">
                              <h6 class="mb-0" style="font-size: 40px;">CHECK STOCK  </h6>

                          </div>

                          @IF(request()->input('admin') == 'admin')
                          <div class="col-6 text-end">
                              <a class="btn bg-gradient-dark mb-0" href="{{ route('products.create') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add Product</a>
                          </div>
                          @ENDIF

                          <p class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">LAST UPDATE: {{ $last_upd ?? '' }}</p>
                          <span class="text-danger text-sm">ก่อนทำการสั่งซื้อกรุณาตรวจสอบข้อมูลกับพนักงานขายอีกครั้ง (Kindly contact the salesperson before ordering.)</span>
                      </div>
                  </div>
                  <div class="card-body p-3">
                      <div class="row">
                          <div class="col-12" style="position: relative;">
                            <i class="fas fa-search opacity-3" style="position: absolute;  top: 17px;left: 24px;"></i>
                              <input id="search" name="search" type="text" class="form-control" placeholder="Search by item code or item name" autocomplete="off" style="height:50px; padding-left:40px">
                          </div>
                      </div>

                  </div>
              </div>
          </div>
        </div>
      </div>

        <div class="row">
            <div class="col-12 mt-4">
                <div class="card mb-4" >
                    <div class="card-body px-0 pt-0 pb-2" id="card-product" style="display:none">
                        <div class="table-responsive p-0" id="get-products" >

                          <table class="table align-items-center mb-0">
                              <thead>
                                  <tr>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="padding-left: 90px;">ITEM CODE</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ITEM NAME</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM UOM CODE</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM STATUS</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STOCK IN HAND</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PENDING SO</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">AVAILABLE STOCK</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NEW ITEM</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PRICE LIST UOM</th>
                                      <th class="text-end text-secondary text-xxs font-weight-bolder opacity-7">PRICE (Incl.VAT)</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($products as $product)
                                  <tr>
                                      <td>
                                        <a href="{{ route('products.index') .'/'. $product->ITEM_CODE .'?view='.request()->input('view') }} ">
                                          <div class="d-flex px-2 py-1">
                                            <div>
                                              <?php
                                                $image = '/storage/img/products/' . $product->ITEM_CODE . '.jpg';
                                                $image2 = '/storage/img/products/' . $product->ITEM_CODE . '.JPG';
                                                if (file_exists( public_path() . $image )) {
                                                    echo '<img src="'.$image.'" class="avatar avatar-sm me-3" alt="user1">';
                                                }elseif(file_exists( public_path() . $image2 )){
                                                    echo '<img src="'.$image2.'" class="avatar avatar-sm me-3" alt="user1">';
                                                } else {
                                                    echo '<img src="/storage/img/coming_soon.jpg" class="avatar avatar-sm me-3" alt="user1">';
                                                }
                                               ?>
                                             </div>
                                          <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">
                                              <span class="btn btn-link text-danger text-gradient px-3 mb-0">{{ $product->ITEM_CODE}}</span>
                                            </h6>
                                          </div>
                                        </div>
                                      </a>
                                      </td>
                                      <td><a href="{{ route('products.index') .'/'. $product->ITEM_CODE .'?view='.request()->input('view') }} "> <p class="text-xs font-weight-bold mb-0">{{ $product->ITEM_NAME}}</p></a></td>
                                      <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->ITEM_UOM_CODE}}</span></td>
                                      <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->ITEM_STATUS}}</span></td>
                                      <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->STOCK_IN_HAND != '' ? number_format($product->STOCK_IN_HAND) : '0'}}</span></td>
                                      <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->PENDING_SO != '' ? number_format($product->PENDING_SO) : '0'}}</span></td>
                                      <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->AVAILABLE_STOCK != '' ? number_format($product->AVAILABLE_STOCK) : '0'}}</span></td>
                                      <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->NEW_ITEM}}</span></td>
                                      <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->PRICE_LIST_UOM}}</span></td>
                                      <td class="align-middle text-end" style="padding-right: 20px;"> <span class="text-xs font-weight-bold">{{ ($product->RATE7 != '' ? number_format($product->RATE7, 2) : '')}}</span></td>
                                  </tr>
                                  @endforeach
                              </tbody>
                          </table>
                          <?php  /*
                          <div class="card-footer pb-0">
                            {!! $products->links('pagination::bootstrap-4') !!}
                          </div>*/
                          ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
          $(function(){

            $('#search').focus();

            $( "#search" ).on( "keyup", function() {
              let search = $(this).val();
              let view = $('#view').val();

              if(search != ''){
                $.ajax({
                  method: "GET",
                  url: "{{ route('products.search-ajax') }}",
                  data: {
                    _token: '{{csrf_token()}}',
                    search: search,
                    view: view,
                  }
                }).done(function( msg ) {
                    //console.log(msg);
                  $('#get-products').html( msg );
                  $('#card-product').css('display','unset');
                });
              }else{
                $('#card-product').css('display','none');
              }


            });

          });
        </script>

    </div>
@endsection
