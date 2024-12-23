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
            <div id="alert">
                @include('components.alert')
            </div>
            <div class="card-body">

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
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Product Name</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->product_name ?? ''}}</p>
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
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Item Type</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->item_type ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">

                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Factory Name</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->factory_name ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Factory Address</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->factory_address ?? ''}}</p>
                  </div>
                </div>
              </div>
              <h1 class="mt-3">TIS</h1>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Format ID</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->format_id ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Supplier Code</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->supplier_code ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Supplier Item</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->supplier_item ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Type</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->type ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Format</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->format ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Model</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->model ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Price</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->price ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Color</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->colour_code ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Country Code</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->country_code ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Defrosting</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->defrosting ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Gross Int</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->gross_int ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Nominal Voltage</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->nominal_voltage ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Nominal Freq</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->nominal_freq ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Defrosting Power</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->defrosting_power ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Nominal Electricity</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->nominal_electricity ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Max Power Of Lamp</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->max_power_of_lamp ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Electric Power Phase</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->electric_power_phase ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Nominal Power</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->nominal_power ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Star Rating Freezer</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->star_rating_freezer ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Energy Cons Per Year</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->energy_cons_per_year ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Climate Class</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->climate_class ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">Refrigerant</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->refrigerant ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">TIS 1</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->tis_1 ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">TIS 2</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->tis_2 ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Series Name</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->series_name ?? ''}}</p>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="mt-4 text-sm">QR-Code</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->qr_code ?? ''}}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4 text-sm">Status</label>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$productitem->status ?? ''}}</p>
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
