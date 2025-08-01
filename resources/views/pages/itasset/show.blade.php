@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Detail Asset'])
<div class="container-fluid py-4">
  @if ($message = Session::get('success'))
  <div class="alert alert-success">
    <p>{{ $message }}</p>
  </div>
  @endif

  @csrf
  <div class="row">
    <div class="col-lg-6" style="z-index: 1;">
      <a href="{{ route('itasset.index') }}" type="button" class="btn btn-dark mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Back</a>
    </div>
    <div class="col-lg-6 text-end" style="z-index: 1;">
      @can('itasset update')
      <a href="{{ route('itasset.edit',$itasset->id) }}" class="btn btn-primary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Edit</a>
      @endcan
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="font-weight-bolder">Asset Image</h5>
          <div class="row">
            <div class="col-12">
              @switch($itasset->type)
              @case('T01')
              <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/macbook-pro.jpg" alt="macbook">
              @break
              @case('T03')
              <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/printer-fuji.jpg" alt="product_image">
              @break
              @case('T02')
              <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/pc.jpg" alt="product_image">
              @break
              @case('T05')
              <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/headset.jpg" alt="product_image">
              @break
              @case('T06')
              <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/telephone_sim.jpg" alt="telephone_sim">
              @break
              @case('T07')
              <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/tv.png" alt="tv">
              @break
              @case('T08')
              <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/copy_machine.png" alt="copy_machine">
              @break
              @case('T09')
              <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/handheld.png" alt="handheld">
              @break
              @case('T10')
              <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/mobile_printer.jpg" alt="mobile_printer">
              @break
              @case('T11')
              <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/pos.png" alt="pos">
              @break
              @case('T12')
              <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/phone_number.png" alt="phone_number">
              @break
              @default
              <img class="w-100 border-radius-lg shadow-lg mt-3" src="" alt="product_image">
              @endswitch
            </div>
            <div class="col-12 mt-5">
              <div class="d-flex">
                <!--
                    <button class="btn btn-primary btn-sm mb-0 me-2" type="button" name="button">Edit</button>
                    <button class="btn btn-outline-dark btn-sm mb-0" type="button" name="button">Remove</button>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-8 mt-lg-0 mt-4">
      <div class="card">
        <div class="card-body">
          <h5 class="font-weight-bolder">Asset Information</h5>
          <div class="row">
            <div class="col-12 col-sm-6">
              <p class="mt-3">Device Name</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->computer_name ?? 'n/a'}}</p>
              </div>
            </div>
            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
              <p class="mt-3">Serial Number</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->serial_number ?? 'n/a'}}</p>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
              <p class="mt-3">Old Device Name</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->old_device_name ?? 'n/a'}}</p>
              </div>
            </div>
            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
              <p class="mt-3">Type</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->type_desc ?? 'n/a'}}</p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
              <p class="mt-3">Color</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->color ?? 'n/a'}}</p>
              </div>
            </div>
            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
              <p class="mt-3">Model</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->model ?? 'n/a'}}</p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6">
              <p class="mt-3">Fixed Asset No.</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->fixed_asset_no ?? 'n/a'}}</p>
              </div>
            </div>
            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
              <p class="mt-3">Purchase Date</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->purchase_date ?? 'n/a'}}</p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6">
              <p class="mt-3">Warranty</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->warranty ?? 'n/a'}}</p>
              </div>
            </div>
            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
              <p class="mt-3">Expire Date</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <?php
                $wrt = '+' . substr($itasset->warranty, 0, 1) . ' year';
                //echo date('Y-m-d', strtotime($wrt, strtotime($itasset->purchase_date)));
                ?>
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ date('Y-m-d', strtotime($wrt, strtotime($itasset->purchase_date))) ?? 'n/a'}}</p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6">
              <p class="mt-3">Status</p>
              @if($itasset->status == 'ACTIVE')
              <span class="badge badge-success badge-md">{{$itasset->status}}</span>
              @elseif($itasset->status == 'SPARE')
              <span class="badge badge-info badge-md">{{$itasset->status}}</span>
              @else
              <span class="badge badge-danger badge-md">{{$itasset->status}}</span>
              @endif

              @if($itasset->reason_broken != '')
              <span class="text-sm">&nbsp Reason: </span> <span class="text-sm font-weight-bold my-auto ps-sm-2 text-danger">{{$itasset->reason_broken}}</span>
              @endif
            </div>
            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
              <p class="mt-3">Location</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->location ?? 'n/a'}}</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-sm-6">
              <p class="mt-3">Create By</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->create_by ?? 'n/a'}}</p>
              </div>
            </div>
            <div class="col-12 col-sm-6 mt-sm-0">
              <p class="mt-3">Create Date</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->created_at ?? 'n/a'}}</p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6">
              <p class="mt-3">Update By</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->update_by ?? 'n/a'}}</p>
              </div>
            </div>
            <div class="col-12 col-sm-6 mt-sm-0">
              <p class="mt-3">Update Date</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->updated_at ?? 'n/a'}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-sm-2">
      <div class="card">
        <div class="card-body">
          <h5 class="font-weight-bolder">Spec</h5>
          <p class="mt-3">Cpu</p>
          <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
            <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itassetspec->cpu ?? 'n/a' }}</p>
          </div>
          <p class="mt-3">Ram</p>
          <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
            <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itassetspec->ram ?? 'n/a' }}</p>
          </div>
          <p class="mt-3">Storage</p>
          <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
            <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itassetspec->storage ?? 'n/a' }}</p>
          </div>

        </div>
      </div>
    </div>

    <div class="col-sm-5 mt-sm-0 mt-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <h5 class="font-weight-bolder">Software</h5>
            <div class="col-4">
              <label>Software Name</label>
            </div>
            <div class="col-3">
              <label>License Type</label>
            </div>
            <div class="col-4">
              <label>License expire date</label>
            </div>
          </div>
          @foreach($softwares as $key => $value)
          <div class="row mt-2">
            <div class="col-4">
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ str_replace('_',' ',$value->software_name) ?? ''}}</p>
              </div>
            </div>
            <div class="col-3">
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $value->license_type ?? ''}}</p>
              </div>
            </div>
            <div class="col-4">
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $value->license_expire_date ?? ''}}</p>
              </div>
            </div>
          </div>
          @endforeach

        </div>
      </div>
    </div>

    <div class="col-sm-5 mt-sm-0 mt-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <h5 class="font-weight-bolder">Owner</h5>
            <div class="col-3">
              <p class="mt-3">User</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itassetown[0]->user ?? 'n/a' }}</p>
              </div>
            </div>
            <div class="col-4">
              <p class="mt-3">Name</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itassetown[0]->name_en ?? 'n/a' }}</p>
              </div>
            </div>
            <div class="col-5">
              <p class="mt-3">Department</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itassetown[0]->dept ?? 'n/a' }}</p>
              </div>
            </div>
          </div>
          <p></p>
          <div class="row">
            <h5 class="font-weight-bolder">Old Owner</h5>
            <div class="col-3">
              <p class="mt-3">User</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itasset->old_user ?? 'n/a' }}</p>
              </div>
            </div>
            <div class="col-4">
              <p class="mt-3">Name</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itasset->old_name ?? 'n/a' }}</p>
              </div>
            </div>
            <div class="col-5">
              <p class="mt-3">Department</p>
              <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itasset->old_department ?? 'n/a' }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  $(function() {
    $("#pdate").flatpickr({
      disableMobile: "true",
    });
  });
</script>

@endsection