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
          <h4 class="text-white">Make the changes below</h4>

        </div>
        <div class="col-lg-6 text-end" style="z-index: 1;">
          <a href="{{ route('itasset.index') }}" type="button" class="btn btn-dark mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Cancel</a>
          <a href="{{ route('itasset.edit',$itasset->id) }}" class="btn btn-outline-white mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Edit</a>
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
                    @case('NOTEBOOK')
                      <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/macbook-pro.jpg" alt="product_image">
                    @break
                    @case('PRINTER')
                      <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/printer-fuji.jpg" alt="product_image">
                    @break
                    @case('PC')
                      <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/pc.jpg" alt="product_image">
                    @break
                    @default
                      <img class="w-100 border-radius-lg shadow-lg mt-3" src="" alt="product_image">
                  @endswitch
                </div>
                <div class="col-12 mt-5">
                  <div class="d-flex">
                    <button class="btn btn-primary btn-sm mb-0 me-2" type="button" name="button">Edit</button>
                    <button class="btn btn-outline-dark btn-sm mb-0" type="button" name="button">Remove</button>
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
                  <p class="mt-3">Computer Name</p>
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
                <div class="col-3">
                  <p class="mt-3">Type</p>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$itasset->type ?? 'n/a'}}</p>
                  </div>
                </div>
                <div class="col-3">
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
                      $wrt = '+' .substr($itasset->warranty,0,1).' year';
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
                    <span class="badge badge-success badge-md">ACTIVE</span>
                  @else
                    <span class="badge badge-danger badge-md">{{$itasset->status}}</span>
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
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-sm-4">
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

        <div class="col-sm-8 mt-sm-0 mt-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <h5 class="font-weight-bolder">Owner</h5>
                <div class="col-2">
                  <p>User</p>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itassetown[0]->user ?? 'n/a' }}</p>
                  </div>
                </div>
                <div class="col-4">
                  <p>Department</p>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ 'n/a' }}</p>
                  </div>
                </div>
                <div class="col-2">
                  <p>Main</p>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itassetown[0]->main ?? 'n/a' }}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  <p class="mt-3">User</p>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itassetown[1]->user ?? 'n/a' }}</p>
                  </div>
                </div>
                <div class="col-4">
                  <p class="mt-3">Department</p>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ 'n/a' }}</p>
                  </div>
                </div>
                <div class="col-2">
                  <p class="mt-3">Main</p>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itassetown[1]->main ?? 'n/a' }}</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  <p class="mt-3">User</p>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itassetown[2]->user ?? 'n/a' }}</p>
                  </div>
                </div>
                <div class="col-4">
                  <p class="mt-3">Department</p>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{'n/a'}}</p>
                  </div>
                </div>
                <div class="col-2">
                  <p class="mt-3">Main</p>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{ $itassetown[2]->main ?? 'n/a' }}</p>
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
        $("#pdate").flatpickr({
          disableMobile: "true",
        });
      });
    </script>

@endsection
