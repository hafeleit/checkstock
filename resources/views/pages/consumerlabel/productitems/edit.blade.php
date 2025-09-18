@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
  .z-index-1 {
    z-index: 1;
  }
</style>
@include('layouts.navbars.auth.topnav', ['title' => 'Edit Product Item'])
<div class="container-fluid py-4">
  <form action="{{ route('product-items.update',$productitem->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="row">
      <div class="col-lg-6 z-index-1">
      </div>
      <div class="col-lg-6 text-end z-index-1">
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
                <label class="mt-4 text-sm">Barcode</label>
                <input class="form-control" type="text" name="bar_code" value="{{$productitem->bar_code ?? ''}}">
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Product Name</label>
                <input class="form-control" type="text" name="product_name" value="{{$productitem->product_name ?? ''}}">
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Suggest Text</label>
                <select class="form-control" name="suggest_text">
                  <option value="">-- Select --</option>
                  @foreach($suggestions as $suggestion)
                  <option value="{{ $suggestion->suggestion_code }}"
                    {{ $productitem->suggest_text == $suggestion->suggestion_code ? 'selected' : '' }}>
                    {{ $suggestion->suggestion_code . ' - ' . $suggestion->suggestion_description }}
                  </option>
                  @endforeach
                </select>
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
                <select class="form-control" name="warning_text">
                  <option value="">-- Select --</option>
                  @foreach($warnings as $warning)
                  <option value="{{ $warning->warning_code }}"
                    {{ $productitem->warning_text == $warning->warning_code ? 'selected' : '' }}>
                    {{ $warning->warning_code . ' - ' . $warning->warning_description }}
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">How To Text</label>
                <select class="form-control" name="how_to_text">
                  <option value="">-- Select --</option>
                  @foreach($methods as $method)
                  <option value="{{ $method->method_code }}"
                    {{ $productitem->how_to_text == $method->method_code ? 'selected' : '' }}>
                    {{ $method->method_code . ' - ' . $method->method_description }}
                  </option>
                  @endforeach
                </select>
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
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-sm">Item Type</label>
                <input class="form-control" type="text" name="item_type" value="{{$productitem->item_type ?? ''}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Factory Name</label>
                <input class="form-control" type="text" name="factory_name" value="{{$productitem->factory_name ?? ''}}">
              </div>
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-sm">Factory Address</label>
                <input class="form-control" type="text" name="factory_address" value="{{$productitem->factory_address ?? ''}}">
              </div>
            </div>
            <h1>TIS</h1>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Format ID</label>
                <input class="form-control" type="text" name="format_id" value="{{$productitem->format_id ?? ''}}">
              </div>
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-sm">Supplier Code</label>
                <input class="form-control" type="text" name="supplier_code" value="{{$productitem->supplier_code ?? ''}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Supplier Item</label>
                <input class="form-control" type="text" name="supplier_item" value="{{$productitem->supplier_item ?? ''}}">
              </div>
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-sm">Type</label>
                <input class="form-control" type="text" name="type" value="{{$productitem->type ?? ''}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Format</label>
                <input class="form-control" type="text" name="format" value="{{$productitem->format ?? ''}}">
              </div>
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-sm">Model</label>
                <input class="form-control" type="text" name="model" value="{{$productitem->model ?? ''}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Price</label>
                <input class="form-control" type="text" name="price" value="{{$productitem->price ?? ''}}">
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Color</label>
                <select class="form-control" name="color">
                  <option value="">-- เลือกสี --</option>
                  @foreach($colors as $color)
                  <option value="{{ $color->colour_code }}"
                    {{ $productitem->color == $color->colour_code ? 'selected' : '' }}>
                    {{ $color->colour_code . ' - ' . $color->colour_description }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Country Code</label>
                <select class="form-control" name="country_code">
                  <option value="">-- Select --</option>
                  @foreach($countrycodes as $countrycode)
                  <option value="{{ $countrycode->country_code }}"
                    {{ $productitem->country_code == $countrycode->country_code ? 'selected' : '' }}>
                    {{ $countrycode->country_code . ' - ' . $countrycode->country_name_in_thai }}
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-sm">Defrosting</label>
                <select class="form-control" name="defrosting">
                  <option value="">-- Select --</option>
                  @foreach($defrostings as $defrosting)
                  <option value="{{ $defrosting->defrosting_code }}"
                    {{ $productitem->defrosting == $defrosting->defrosting_code ? 'selected' : '' }}>
                    {{ $defrosting->defrosting_code . ' - ' . $defrosting->defrosting_description }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Gross Int</label>
                <input class="form-control" type="text" name="gross_int" value="{{$productitem->gross_int ?? ''}}">
              </div>
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-sm">Nominal Voltage</label>
                <input class="form-control" type="text" name="nominal_voltage" value="{{$productitem->nominal_voltage ?? ''}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Nominal Freq</label>
                <input class="form-control" type="text" name="nominal_freq" value="{{$productitem->nominal_freq ?? ''}}">
              </div>
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-sm">Defrosting Power</label>
                <input class="form-control" type="text" name="defrosting_power" value="{{$productitem->defrosting_power ?? ''}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Nominal Electricity</label>
                <input class="form-control" type="text" name="nominal_electricity" value="{{$productitem->nominal_electricity ?? ''}}">
              </div>
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-sm">Max Power Of Lamp</label>
                <input class="form-control" type="text" name="max_power_of_lamp" value="{{$productitem->max_power_of_lamp ?? ''}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Electric Power Phase</label>
                <input class="form-control" type="text" name="electric_power_phase" value="{{$productitem->electric_power_phase ?? ''}}">
              </div>
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-sm">Nominal Power</label>
                <input class="form-control" type="text" name="nominal_power" value="{{$productitem->nominal_power ?? ''}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Star Rating Freezer</label>
                <input class="form-control" type="text" name="star_rating_freezer" value="{{$productitem->star_rating_freezer ?? ''}}">
              </div>
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-sm">Energy Cons Per Year</label>
                <input class="form-control" type="text" name="energy_cons_per_year" value="{{$productitem->energy_cons_per_year ?? ''}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Climate Class</label>
                <input class="form-control" type="text" name="climate_class" value="{{$productitem->climate_class ?? ''}}">
              </div>
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-sm">Refrigerant</label>
                <input class="form-control" type="text" name="refrigerant" value="{{$productitem->refrigerant ?? ''}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">TIS 1</label>
                <input class="form-control" type="text" name="tis_1" value="{{$productitem->tis_1 ?? ''}}">
              </div>
              <!--
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">TIS 2</label>
                  <input class="form-control" type="text" name="tis_2" value="{{$productitem->tis_2 ?? ''}}">
                </div>-->
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Series Name</label>
                <input class="form-control" type="text" name="series_name" value="{{$productitem->series_name ?? ''}}">
              </div>
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-sm">QR-Code</label>
                <input class="form-control" type="text" name="qr_code" value="{{$productitem->qr_code ?? ''}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                <label class="mt-4 text-sm">Status</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="status" {{ ($productitem->status == 'Active') ? 'Checked' : '' }} value="Active">
                </div>
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

<script type="text/javascript" nonce="{{ request()->attributes->get('csp_script_nonce') }}">
  $(function() {
    $("#pdate").flatpickr({
      disableMobile: "true",
    });
  });
</script>

@endsection