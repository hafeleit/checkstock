@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'New Asset'])
    <div class="container-fluid py-4">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
          <p>{{ $message }}</p>
      </div>
      @endif
      <form action="{{ route('itasset.store') }}" method="post" >
        @csrf
      <div class="row">
        <div class="col-lg-6" style="z-index: 1;">
          <h4 class="text-white">Make the changes below</h4>

        </div>
        <div class="col-lg-6 text-end" style="z-index: 1;">
          <a href="{{ route('itasset.index') }}" type="button" class="btn btn-dark mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Cancel</a>
          <button type="submit" class="btn btn-outline-white mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Save</button>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-4">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="font-weight-bolder">Asset Image</h5>
              <div class="row">
                <div class="col-12">
                  <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/no-image.jpg" alt="product_image">
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
                  <label>Computer Name <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="computer_name" placeholder="HTHBKKNB333" required>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label>Serial Number</label>
                  <input class="form-control" type="text" name="serial_number" placeholder="SNTEST000001">
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <label class="mt-4">Type <span class="text-danger">*</span></label>
                  <select class="form-control" name="type" required>
                    <option value="NOTEBOOK">NOTEBOOK</option>
                    <option value="PC">PC</option>
                    <option value="PRINTER">PRINTER</option>
                    <option value="SERVER">SERVER</option>
                  </select>
                </div>
                <div class="col-3">
                  <label class="mt-4">Color</label>
                  <select class="form-control" name="color">
                    <option value="GREEN">GREEN</option>
                    <option value="BLUE">BLUE</option>
                    <option value="RED">RED</option>
                  </select>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4">Model <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="model" placeholder="DELL" required>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4">Fixed Asset No.</label>
                  <input class="form-control" type="text" name="fixed_asset_no" placeholder="RS8898569565">
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4">Purchase Date</label>
                  <input class="form-control datepicker" id="pdate" name="purchase_date" placeholder="Please select date" type="text" >
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4">Warranty</label>
                  <select class="form-control" name="warranty">
                    <option value="1 Years">1 Years</option>
                    <option value="2 Years">2 Years</option>
                    <option value="3 Years">3 Years</option>
                    <option value="4 Years">4 Years</option>
                    <option value="5 Years">5 Years</option>
                  </select>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4">Expire Date</label>
                  <input class="form-control" type="text" value="" readonly>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4">Status <span class="text-danger">*</span></label>
                  <select class="form-control" name="status" required>
                    <option value="ACTIVE">ACTIVE</option>
                    <option value="BROKEN">BROKEN</option>
                    <option value="SPARE">SPARE</option>
                  </select>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                  <label class="mt-4">Location</label>
                  <select class="form-control" name="location">
                    <option value="HTH 64">HTH 64</option>
                    <option value="HTH DC">HTH DC</option>
                    <option value="HTH SALES">HTH SALES</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="mt-4">Create By</label>
                  <input class="form-control" type="text" name="create_by" readonly>
                </div>
                <div class="col-12 col-sm-6 mt-sm-0">
                  <label class="mt-4">Create Date</label>
                  <input class="form-control" type="text" readonly>
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
              <label>Cpu</label>
              <input class="form-control" type="text" name="cpu" value="" placeholder="INTEL 9">
              <label class="mt-3">Ram</label>
              <input class="form-control" type="text" name="ram" value="" placeholder="16GB">
              <label class="mt-3">Storage</label>
              <input class="form-control" type="text" name="storage" value="" placeholder="1TB">
            </div>
          </div>
        </div>

        <div class="col-sm-8 mt-sm-0 mt-4">
          <div class="card">
            <div class="card-body">

              <div class="row">
                <h5 class="font-weight-bolder">Owner</h5>
                <div class="col-2">
                  <label>User</label>
                  <input class="form-control" name="user[]" type="text" placeholder="7213">
                </div>
                <div class="col-4">
                  <label>Department</label>
                  <input class="form-control" type="text" value="" readonly>
                </div>
                <div class="col-2">
                  <label>Main</label>
                  <select class="form-control" name="own_main[]">
                    <option value="N">No</option>
                    <option value="Y">Yes</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  <label>User</label>
                  <input class="form-control" name="user[]" type="text" placeholder="7213">
                </div>
                <div class="col-4">
                  <label>Department</label>
                  <input class="form-control" type="text" value="" readonly>
                </div>
                <div class="col-2">
                  <label>Main</label>
                  <select class="form-control" name="own_main[]">
                    <option value="N">No</option>
                    <option value="Y">Yes</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  <label>User</label>
                  <input class="form-control" name="user[]" type="text" placeholder="7213">
                </div>
                <div class="col-4">
                  <label>Department</label>
                  <input class="form-control" type="text" value="" readonly>
                </div>
                <div class="col-2">
                  <label>Main</label>
                  <select class="form-control" name="own_main[]">
                    <option value="N">No</option>
                    <option value="Y">Yes</option>
                  </select>
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
