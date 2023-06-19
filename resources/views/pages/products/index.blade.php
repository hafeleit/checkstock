@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
<div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
    <span class="mask bg-primary opacity-6"></span>
</div>
@section('content')
    @include('layouts.navbars.guest.topnav', ['title' => 'Products'])
    <div class="container-fluid py-4">

      <div class="row">
        <div class="col-12">
          <div class="col-md-12 mb-lg-0 mb-4">
              <div class="card mt-4">
                  <div class="card-header pb-0 p-3">
                      <div class="row">
                          <div class="col-6 d-flex align-items-center">
                              <h6 class="mb-0">Check Stock  </h6>

                          </div>

                          @IF(request()->input('admin') == 'admin')
                          <div class="col-6 text-end">
                              <a class="btn bg-gradient-dark mb-0" href="{{ route('products.create') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add Product</a>
                          </div>
                          @ENDIF

                          <p class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Update Date: {{ $products[0]->created_at ?? '' }}</p>
                      </div>
                  </div>
                  <div class="card-body p-3">
                      <div class="row">
                          <div class="col-12">
                            <input id="search" name="search" type="text" class="form-control" placeholder="Search by item code or item name">
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </div>

        <div class="row">
            <div class="col-12 mt-4">
                <div class="card mb-4">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0" id="get-products">

                          <table class="table align-items-center mb-0">
                              <thead>
                                  <tr>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="padding-left: 90px;">ITEM CODE</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ITEM NAME</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM UOM CODE</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM STATUS</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NEW ITEM</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RATE</th>


                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($products as $product)

                                  <tr >
                                      <td>
                                        <a href="{{ route('products.index') .'/'. $product->ITEM_CODE }} ">
                                          <div class="d-flex px-2 py-1">
                                            <div>
                                              <?php
                                                $image = '/img/products/' . $product->ITEM_CODE . '.jpg';
                                                if (file_exists( public_path() . $image )) {
                                                    echo '<img src="/img/products/'.$product->ITEM_CODE.'.jpg" class="avatar avatar-sm me-3" alt="user1">';
                                                } else {
                                                    echo '<img src="/img/products/coming_soon.jpg" class="avatar avatar-sm me-3" alt="user1">';
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
                                      <td><a href="{{ route('products.index') .'/'. $product->ITEM_CODE }} "> <p class="text-xs font-weight-bold mb-0">{{ $product->ITEM_NAME}}</p> </a></td>
                                      <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->ITEM_UOM_CODE}}</span> </td>
                                      <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->ITEM_STATUS}}</span> </td>
                                      <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->NEW_ITEM}}</span> </td>
                                      <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ number_format($product->RATE)}}</span> </td>


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

            $( "#search" ).on( "keyup", function() {
              let search = $(this).val();

                $.ajax({
                  method: "GET",
                  url: "{{ route('products.search-ajax') }}",
                  data: {
                    _token: '{{csrf_token()}}',
                    search: search,
                  }
                }).done(function( msg ) {
                    //console.log(msg);
                  $('#get-products').html( msg );
                });

            });

          });
        </script>

    </div>
@endsection
