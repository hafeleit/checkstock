@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Product Item'])
    <div class="container-fluid py-4">
    <form action="{{ route('product-items.update',$productitem->id) }}" method="post" >
        @csrf
        @method('PUT')
      <div class="row">
        <div class="col-lg-6" style="z-index: 1;">
        </div>
        <div class="col-lg-6 text-end" style="z-index: 1;">
          <a href="{{ route('product-items.show',$productitem->id) }}" type="button" class="btn btn-secondary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Cancel</a>
          <button type="submit" class="btn btn-primary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Save</button>
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
                  <input class="form-control" type="text" name="item_desc_en" value="{{$productitem->item_desc_en ?? ''}}">
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Suggest Text</label>
                  <input class="form-control" type="text" name="suggest_text" value="{{$productitem->suggest_text ?? ''}}">
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Made By</label>
                  <input class="form-control" type="text" name="made_by" value="{{$productitem->made_by ?? ''}}">
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Material Text</label>
                  <input class="form-control" type="text" name="material_text" value="{{$productitem->material_text ?? ''}}">
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Warning Text</label>
                  <input class="form-control" type="text" name="warning_text" value="{{$productitem->warning_text ?? ''}}">
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">How To Text</label>
                  <input class="form-control" type="text" name="how_to_text" value="{{$productitem->how_to_text ?? ''}}">
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Warning Text</label>
                  <input class="form-control" type="text" name="warning_text" value="{{$productitem->warning_text ?? ''}}">
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Product Name</label>
                  <input class="form-control" type="text" name="product_name" value="{{$productitem->product_name ?? ''}}">
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Grade Code</label>
                  <input class="form-control" type="text" name="grade_code_1" value="{{$productitem->grade_code_1 ?? ''}}">
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Material Color</label>
                  <input class="form-control" type="text" name="material_color" value="{{$productitem->material_color ?? ''}}">
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Remark</label>
                  <input class="form-control" type="text" name="remark" value="{{$productitem->remark ?? ''}}">
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Item Size</label>
                  <input class="form-control" type="text" name="item_size" value="{{$productitem->item_size ?? ''}}">
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Item Amout</label>
                  <input class="form-control" type="text" name="item_amout" value="{{$productitem->item_amout ?? ''}}">
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Item Size</label>
                  <input class="form-control" type="text" name="item_size" value="{{$productitem->item_size ?? ''}}">
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Item Type</label>
                  <input class="form-control" type="text" name="item_type" value="{{$productitem->item_type ?? ''}}">
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Factory Name</label>
                  <input class="form-control" type="text" name="factory_name" value="{{$productitem->factory_name ?? ''}}">
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Factory Address</label>
                  <input class="form-control" type="text" name="factory_address" value="{{$productitem->factory_address ?? ''}}">
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </form>


      <!-- delete modal -->
      <div class="row mt-3">
        <div class="col-12 text-end">

            {{-- <button type="button" class="btn btn-outline-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#import"> Delete </button>--}}

            <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog mt-lg-10">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="{{ route('product-items.destroy',$productitem->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                  <div class="modal-body text-start">
                      <p>Are you sure you want to delete this item?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-sm bg-gradient-secondary " data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm bg-gradient-danger" name="button">Confirm</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
      </div>

    </div>

    <script type="text/javascript">
      $(function(){
        $("#pdate").flatpickr({
          disableMobile: "true",
        });
      });
    </script>

@endsection
