@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav', ['title' => 'Customer Label'])
<style media="screen">
  a.disabled {
    pointer-events: none;
    cursor: default;
  }
</style>
<div id="alert">
    @include('components.alert')
</div>
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-lg-flex">
            <div>
              <h5 class="mb-0">Product Items</h5>
            </div>
            <div class="ms-auto my-auto mt-lg-0 mt-4">
              <div class="ms-auto my-auto">
                {{-- <button type="button" class="btn btn-outline-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#import"> Import </button> --}}

                <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog mt-lg-10">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">Import CSV</h5>
                        <i class="fas fa-upload ms-3" aria-hidden="true"></i>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="{{ route('product-new-price-list-import') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-body">
                        <p>You can browse your computer for a file.</p>
                        <input type="file" placeholder="Browse file..." class="form-control mb-3" name="file">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary btn-sm">Upload</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>

                {{-- <a class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" id="btn_export" href="{{ route('checkstockhww-export') }}">Export</a> --}}
              </div>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-0 mt-3">
          <div class="table-responsive">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
              <div class="dataTable-top">
                <div class="dataTable-dropdown">
                  <label>
                    <form id="form_search" class="" action="{{ route('product-items.index' )}}" method="get">
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
                <table class="table table-flush dataTable-table" id="productitems-list">
                  <thead class="thead-light">
                    <tr>
                      <th>item_code</th>
                      <th>Item Desc</th>
                      <th>Product Name</th>
                      <th>Made by</th>
                      <th>สคบ.</th>
                      <th>TIS</th>
                      <th>ITEM Barcode</th>
                      <th></th>
                    </tr>
                  </thead>

                  <tbody id="tbody">
                    @if(count($productitems) > 0)
                      @foreach($productitems as $product)
                        <tr>
                          <td class="text-sm">{{ $product->item_code ?? '' }}</td>
                          <td class="text-sm">{{ $product->item_desc_en ?? '' }}</td>
                          <td class="text-sm">{{ $product->product_name ?? '' }}</td>
                          <td class="text-sm">{{ $product->made_by ?? '' }}</td>
                          <td class="text-sm">
                            <a href="{{ route('product-items.edit',$product->id) }}" data-bs-toggle="tooltip" data-bs-original-title="Download Barcode">
                              <i class="fas fa-barcode text-lg text-danger" aria-hidden="true"></i>
                            </a>
                          </td>
                          <td class="text-sm">
                            <a href="{{ route('product-items.edit',$product->id) }}" data-bs-toggle="tooltip" data-bs-original-title="Download Barcode">
                              <i class="fas fa-barcode text-lg text-info" aria-hidden="true"></i>
                            </a>
                          </td>
                          <td class="text-sm">
                            <a href="{{ route('product-items.edit',$product->id) }}" data-bs-toggle="tooltip" data-bs-original-title="Download Barcode">
                              <i class="fas fa-barcode text-lg text-secondary" aria-hidden="true"></i>
                            </a>
                          </td>
                          <td class="text-sm">
                            <a  href="{{ route('product-items.show',$product->id) }}" data-bs-toggle="tooltip" data-bs-original-title="Preview Product">
                              <i class="fas fa-eye text-secondary" aria-hidden="true"></i>
                            </a>
                            @can('consumerlabel update')
                            <a href="{{ route('product-items.edit',$product->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Product">
                              <i class="fas fa-pen text-secondary" aria-hidden="true"></i>
                            </a>
                            @endcan
                          </td>
                        </tr>
                      @endforeach
                    @else
                    <tr>
                      <td colspan="4">No data.</td>
                    </tr>
                    @endif
                  </tbody>
                </table>

              </div>
              <div class="dataTable-bottom">
                <div class="dataTable-info">{{ "Showing " .  $productitems->firstItem() . " to " . $productitems->lastItem() . " of " . $productitems->total() . " entries"}}</div>
                {!! $productitems->withQueryString()->links('pagination::bootstrap-4') !!}
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


    $( "#perpage" ).on( "change", function() {
      $( "#form_search" ).trigger( "submit" );
    } );

    $( "#btn_search" ).on( "click", function() {
      $( "#form_search" ).trigger( "submit" );
    } );

  });

</script>
@endsection
