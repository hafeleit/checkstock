@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'New Asset'])
    <div class="container-fluid py-4">
      <form action="{{ route('asset_types.store') }}" method="post" >
      @csrf
      <div class="row">
        <div class="col-lg-6" style="z-index: 1;">

        </div>
        <div class="col-lg-6 text-end" style="z-index: 1;">
          <a href="{{ route('asset_types.index') }}" type="button" class="btn btn-secondary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Cancel</a>
          <button type="submit" class="btn btn-primary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Save</button>
        </div>
      </div>
      <div class="row mt-4">

        <div class="col-lg-12 mt-lg-0 mt-4">
          <div class="card">
            <div class="card-body">
              <div id="alert">
                  @include('components.alert')
              </div>
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
                  <label>Asset Type <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="type_desc" placeholder="" value="{{ old('type_desc') }}" required>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>


      </form>
    </div>

@endsection
