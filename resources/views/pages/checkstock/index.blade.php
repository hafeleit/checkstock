@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav', ['title' => 'Check Stock'])
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-lg-flex">
            <div>
              <h5 class="mb-0">Products List</h5>
            </div>
            <div class="ms-auto my-auto mt-lg-0 mt-4">

            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-0 mt-3">
          <div class="table-responsive">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
              <div class="dataTable-top">
                <div class="dataTable-dropdown">
                  <label>
                    <form id="form_search" class="" action="{{ route('checkstock.index' )}}" method="get">
                    <select class="dataTable-selector" id="perpage" name="perpage">
                      <option value="5" {{ (request()->perpage == '5' ? 'selected' : '') }}>5</option>
                      <option value="10" {{ (request()->perpage == '10' ? 'selected' : '') }}>10</option>
                      <option value="20" {{ (request()->perpage == '20' ? 'selected' : '') }}>20</option>
                      <option value="50" {{ (request()->perpage == '50' ? 'selected' : '') }}>50</option>
                      <option value="100" {{ (request()->perpage == '100' ? 'selected' : '') }}>100</option>
                    </select> entries per page {{ request()->perpage }}</label>
                </div>

                <div class="dataTable-search">

                    <input class="dataTable-input" placeholder="Search..." type="text" id="search" name="search" value="{{request()->search ?? ''}}">
                    <a href="#" class="btn bg-gradient-primary btn-sm mb-0" id="btn_search">Search</a>
                  </form>
                </div>

              </div>
              <div class="dataTable-container">
                <table class="table table-flush dataTable-table" id="products-list">
                  <thead class="thead-light">
                    <tr>
                      <th class="">Product</th>
                      <th>Item code</th>
                      <th>Price (Incl.VAT)</th>
                      <th>Inventory code</th>
                      <th>Quantity</th>
                      <th>Status</th>
                      <th>Action</th>

                    </tr>
                  </thead>

                  <tbody id="tbody">
                    @if(count($products) > 0)
                      @foreach($products as $product)

                        <tr>
                          <td>
                            <div class="d-flex">
                              <?php
                                $image = '/storage/img/products/' . $product->ITEM_CODE . '.jpg';
                                if (!file_exists( public_path() . $image )) {
                                  $image = "/storage/img/coming_soon.jpg";
                                }
                                echo '<img class="w-10" src="'.$image.'" >';
                               ?>
                              <h6 class="my-auto ms-3"><a href="{{ route('checkstock.show',$product->id) }}">{{ $product->ITEM_NAME ?? '' }}</a></h6>
                            </div>
                          </td>
                          <td class="text-sm">{{ $product->ITEM_CODE ?? '' }}</td>
                          <td class="text-sm">฿{{ NUMBER_FORMAT($product->RATE7,2) ?? '' }}</td>
                          <td class="text-sm">{{ $product->ITEM_INVENTORY_CODE ?? '' }}</td>
                          <td class="text-sm">{{ ($product->STOCK_IN_HAND != '') ? NUMBER_FORMAT($product->STOCK_IN_HAND) : '0'  }}</td>
                          <td>
                            @if($product->STOCK_IN_HAND > 0)
                              <span class="badge badge-success">In Stock</span>
                            @else
                              <span class="badge badge-danger badge-sm">Out of Stock</span>
                            @endif
                          </td>
                          <td class="text-sm">
                            <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Preview product">
                              <i class="fas fa-eye text-secondary" aria-hidden="true"></i>
                            </a>
                            <a href="javascript:;" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit product">
                              <i class="fas fa-user-edit text-secondary" aria-hidden="true"></i>
                            </a>
                            <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete product">
                              <i class="fas fa-trash text-secondary" aria-hidden="true"></i>
                            </a>
                          </td>
                        </tr>
                      @endforeach

                    @else
                    <tr>
                      <td colspan="7">No data.</td>
                    </tr>
                    @endif
                  </tbody>
                </table>

              </div>
              <div class="dataTable-bottom">
                <div class="dataTable-info">{{ "Showing " .  $products->firstItem() . " to " . $products->lastItem() . " of " . $products->total() . " entries"}}</div>
                {!! $products->withQueryString()->links('pagination::bootstrap-4') !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<script type="text/javascript">

  $(function(){

   /*$('#perpage').on('change', function(){

      let text = document.location.href;
      const myArray = text.split("?");
      let word = myArray[0];
      var url = word+"?perpage="+$(this).val();
      window.location.replace(url);

    });*/

    $( "#perpage" ).on( "change", function() {
      $( "#form_search" ).trigger( "submit" );
    } );

    $( "#btn_search" ).on( "click", function() {
      $( "#form_search" ).trigger( "submit" );
    } );

  });

</script>
@endsection
