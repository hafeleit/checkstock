@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'New Asset'])
    <div class="container-fluid py-4">
      <form action="{{ route('asset_types.store') }}" method="post" >
      @csrf
      <div class="row">

        <div class="col-lg-6" style="z-index: 1;">
          <a href="{{ route('asset_types.index') }}" type="button" class="btn btn-dark mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Back</a>
        </div>
        <div class="col-lg-6 text-end" style="z-index: 1;">
          @can('itasset update')
          <a href="{{ route('asset_types.edit',$assetType->id) }}" class="btn btn-primary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Edit</a>
          @endcan
        </div>
      </div>
      <div class="row mt-4">

        <div class="col-lg-12 mt-lg-0 mt-4">
          <div class="card">
            <div class="card-body">
              <h5 class="font-weight-bolder">Asset Type Information</h5>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <p class="mt-3">Asset Type Description</p>
                  <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                    <p class="text-sm font-weight-bold my-auto ps-sm-2">{{$assetType->type_desc ?? 'n/a'}}</p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>


      </form>
    </div>

@endsection
