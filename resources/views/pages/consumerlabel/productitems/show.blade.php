@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Product Item Detail'])
    <div class="container-fluid py-4">
    <form action="{{ route('product-items.update',$productitem->id) }}" method="post" >
        @csrf
        @method('PUT')
      <div class="row">
        <div class="col-lg-6" style="z-index: 1;">
        </div>
        <div class="col-lg-6 text-end" style="z-index: 1;">
          <a href="{{ route('product-items.index') }}" type="button" class="btn btn-secondary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Cancel</a>
          @can('consumerlabel update')
          <a href="{{ route('product-items.edit',$productitem->id) }}" class="btn btn-primary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Edit</a>
          @endcan
        </div>
      </div>
      <div class="row mt-4">

        <div class="col-lg-12 mt-4">
          <div class="card">
            <div class="card-body">
              @if ($message = Session::get('success'))
              <div class="alert alert-success">
                  <p>{{ $message }}</p>
              </div>
              @endif
              @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif
              <h5 class="font-weight-bolder">Product Item Information</h5>

              <div class="row mt-4">
                <div class="col-12 col-sm-6">
                  <label class="text-sm">Item Code</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->item_code ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="text-sm">Barcode</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->bar_code ?? ''}}</p>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Item Desc</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->item_desc_en ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Suggest Text</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->suggest_text ?? ''}}</p>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Made By</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->made_by ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Material Text</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->material_text ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Warning Text</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->warning_text ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">How To Text</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->how_to_text ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Warning Text</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->warning_text ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Product Name</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->product_name ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Grade Code</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->grade_code_1 ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Material Color</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->material_color ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Remark</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->remark ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Item Size</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->item_size ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Item Amout</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->item_amout ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Item Size</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->item_size ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Item Type</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->item_type ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Factory Name</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->factory_name ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Factory Address</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->factory_address ?? ''}}</p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </form>

    </div>

    <script type="text/javascript">
      $(function(){
        $("#pdate").flatpickr({
          disableMobile: "true",
        });
      });
    </script>

@endsection
