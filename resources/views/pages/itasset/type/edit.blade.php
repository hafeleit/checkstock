@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'New Asset'])
    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
      .z-1{
        z-index: 1;
      }

    </style>
    <div class="container-fluid py-4">
      <form action="{{ route('asset_types.update',$assetType->id) }}" method="post" >
        @csrf
        @method('PUT')
      <div class="row">
        <div class="col-lg-6 z-1">

        </div>
        <div class="col-lg-6 text-end z-1">
          <a href="{{ route('asset_types.index') }}" type="button" class="btn btn-secondary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Cancel</a>
          <button type="submit" class="btn btn-primary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Save</button>
        </div>
      </div>
      <div class="row mt-4">

        <div class="col-lg-12 mt-lg-0 mt-4">
          <div class="card">
            <div class="card-body">

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
              <h5 class="font-weight-bolder">Asset Type Information</h5>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label>Asset Type Description <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="type_desc" placeholder="" value="{{ $assetType->type_desc }}" required>
                </div>
                <div class="col-12 col-sm-6">
                  <label>Status</label>
                  <select class="form-control" name="type_status" required>
                    <option value="Active" {{ ($assetType->type_status == 'Active') ? 'selected' : '' }} >Active</option>
                    <option value="Inactive" {{ ($assetType->type_status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                  </select>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>


      </form>
    </div>

@endsection
