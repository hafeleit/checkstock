@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'New Asset'])
<div class="container-fluid py-4">
  <form action="{{ route('itasset.store') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-lg-6" style="z-index: 1;">
        <h4 class="text-white">Make the changes below</h4>

      </div>
      <div class="col-lg-6 text-end" style="z-index: 1;">
        <a href="{{ route('itasset.index') }}" type="button" class="btn btn-secondary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Cancel</a>
        <button type="submit" class="btn btn-primary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Save</button>
      </div>
    </div>
    <div class="row mt-4">

      <div class="col-lg-12 mt-lg-0 mt-4">
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
            <h5 class="font-weight-bolder">Asset Information</h5>
            <div class="row">
              <div class="col-12 col-sm-6">
                <label>Device Name <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="computer_name" placeholder="ex.HTHBKKNB333" value="{{ old('computer_name') }}" required>
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label>Serial Number</label>
                <input class="form-control" type="text" name="serial_number" placeholder="ex.SNTEST000001" value="{{ old('serial_number') }}">
              </div>
              <div class="col-12 mt-3">
                <label>Old Device Name</label>
                <input class="form-control" type="text" name="old_device_name" placeholder="ex.HTHBKKNB222" value="{{ old('old_device_name') }}">
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <label class="mt-4">Type <span class="text-danger">*</span></label>
                <select class="form-control" name="type" required>
                  <option value="">-- Select --</option>
                  @foreach($types as $type)
                  <option value="{{$type->type_code}}">{{$type->type_desc}}</option>
                  @endforeach
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
                <input class="form-control" type="text" name="model" placeholder="ex.DELL" value="{{ old('model') }}" required>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6">
                <label class="mt-4">Fixed Asset No.</label>
                <input class="form-control" type="text" name="fixed_asset_no" placeholder="ex.RS8898569565" value="{{ old('fixed_asset_no') }}">
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4">Purchase Date</label>
                <input class="form-control datepicker" id="pdate" name="purchase_date" placeholder="Please select date" type="text" value="{{ old('purchase_date') }}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6">
                <label class="mt-4">Warranty</label>
                <select class="form-control" name="warranty">
                  <option value="1 Years">1 Years</option>
                  <option value="2 Years">2 Years</option>
                  <option value="3 Years" selected>3 Years</option>
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
                <select class="form-control" name="status" id="status" required>
                  <option value="ACTIVE">ACTIVE</option>
                  <option value="BROKEN">BROKEN</option>
                  <option value="SPARE">SPARE</option>
                </select>
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4">Location</label>
                <select class="form-control" name="location">
                  <option value=""></option>
                  <option value="HTH Chiangmai Showroom">HTH Chiangmai Showroom</option>
                  <option value="HTH Huahin Showroom">HTH Huahin Showroom</option>
                  <option value="HTH Pattaya Showroom">HTH Pattaya Showroom</option>
                  <option value="HTH Phuket Showroom">HTH Phuket Showroom</option>
                  <option value="HTH Bangpho Showroom">HTH Bangpho Showroom</option>
                  <option value="HTH Warehouse Bangpho">HTH Warehouse Bangpho</option>
                  <option value="HTH Warehouse Chiangmai">HTH Warehouse Chiangmai</option>
                  <option value="HTH Warehouse Hunhin">HTH Warehouse Hunhin</option>
                  <option value="HTH Warehouse Pattaya">HTH Warehouse Pattaya</option>
                  <option value="HTH Warehouse Phuket">HTH Warehouse Phuket</option>
                  <option value="HTH64_Admin">HTH64_Admin</option>
                  <option value="HTH64_Bangkok Showroom">HTH64_Bangkok Showroom</option>
                  <option value="HTH64_BKK Warehouse">HTH64_BKK Warehouse</option>
                  <option value="HTH64_BROKEN">HTH64_BROKEN</option>
                  <option value="HTH64_Customer Services">HTH64_Customer Services</option>
                  <option value="HTH64_E-Commerce">HTH64_E-Commerce</option>
                  <option value="HTH64_Finance">HTH64_Finance</option>
                  <option value="HTH64_HR">HTH64_HR</option>
                  <option value="HTH64_Inventory">HTH64_Inventory</option>
                  <option value="HTH64_IT">HTH64_IT</option>
                  <option value="HTH64_Marketing">HTH64_Marketing</option>
                  <option value="HTH64_MD Office">HTH64_MD Office</option>
                  <option value="HTH64_PM">HTH64_PM</option>
                  <option value="HTH64_Purchase">HTH64_Purchase</option>
                  <option value="HTH64_QA">HTH64_QA</option>
                  <option value="HTH64_Sales">HTH64_Sales</option>
                  <option value="HTH64_Smart Technology">HTH64_Smart Technology</option>
                  <option value="HTH64_Spare">HTH64_Spare</option>
                  <option value="HTH64_Supply Chain">HTH64_Supply Chain</option>
                  <option value="HTH64_Maintenance">HTH64_Maintenance</option>
                  <option value="HTHDC_Site Management">HTHDC_Site Management</option>
                  <option value="HTHDC_Delivery">HTHDC_Delivery</option>
                  <option value="HTHDC_Despatch">HTHDC_Despatch</option>
                  <option value="HTHDC_Logistics">HTHDC_Logistics</option>
                  <option value="HTHDC_Master Key">HTHDC_Master Key</option>
                  <option value="HTHDC_Packing">HTHDC_Packing</option>
                  <option value="HTHDC_Packing DIY">HTHDC_Packing DIY</option>
                  <option value="HTHDC_Packing UPC">HTHDC_Packing UPC</option>
                  <option value="HTHDC_Pool Function">HTHDC_Pool Function</option>
                  <option value="HTHDC_Product Return">HTHDC_Product Return</option>
                  <option value="HTHDC_Workshop">HTHDC_Workshop</option>
                  <option value="HTHDC_Maintenance">HTHDC_Maintenance</option>
                  <option value="HTHDC_E-Commerce Warehouse">HTHDC_E-Commerce Warehouse</option>
                  <option value="HTHDC_IG">HTHDC_IG</option>
                  <option value="HTHHA">HTHHA</option>

                </select>
              </div>
            </div>
            <div class="row reason_broken" style="display: none">
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-danger">Reason Broken</label>
                <input class="form-control" type="text" name="reason_broken">
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
      <div class="col-sm-2">
        <div class="card">
          <div class="card-body">
            <h5 class="font-weight-bolder">Spec</h5>
            <label>Cpu</label>
            <input class="form-control" type="text" name="cpu" placeholder="ex.INTEL 9" value="{{ old('cpu') }}">
            <label class="mt-3">Ram</label>
            <input class="form-control" type="text" name="ram" placeholder="ex.16GB" value="{{ old('ram') }}">
            <label class="mt-3">Storage</label>
            <input class="form-control" type="text" name="storage" placeholder="ex.1TB" value="{{ old('storage') }}">
          </div>
        </div>
      </div>

      <div class="col-sm-5 mt-sm-0 mt-4">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <h5 class="font-weight-bolder">Software</h5>
              <button id="addSoftwareBtn" class="btn btn-sm mb-0" type="button" style="position: absolute;width: 100px; right: 40px;">Add</button>

              <div class="col-4">
                <label>Software Name</label>
              </div>
              <div class="col-2">
                <label>License Type</label>
              </div>
              <div class="col-4">
                <label>License expire date</label>
              </div>
            </div>


            <script type="text/javascript">
              $("#addSoftwareBtn").click(function() {

                let content = '<div class="row mt-2">\
                                  <div class="col-4">\
                                    <select class="form-control" name="software_name[]" required>\
                                      <option value=""></option>\
                                      <option value="Auto_CAD_2024">Auto CAD 2024</option>\
                                      <option value="AutoCAD_LT">AutoCAD LT</option>\
                                      <option value="Adobe_Creative_Cloud">Adobe Creative Cloud</option>\
                                      <option value="WinRAR">WinRAR</option>\
                                      <option value="TeamViewer">TeamViewer</option>\
                                      <option value="PDF_XChange_Editor">PDF XChange Editor</option>\
                                      <option value="SketchUp_Pro">SketchUp Pro</option>\
                                      <option value="FreeCAD">FreeCAD</option>\
                                      <option value="DIALUX">DIALUX</option>\
                                    </select>\
                                  </div>\
                                  <div class="col-2">\
                                    <select class="form-control" name="license_type[]" required>\
                                      <option value=""></option>\
                                      <option value="Yearly">Yearly</option>\
                                      <option value="Permanent">Permanent</option>\
                                      <option value="Free">Free</option>\
                                    </select>\
                                  </div>\
                                  <div class="col-4">\
                                    <input class="form-control datepicker" id="license_expiry_date" name="license_expiry_date[]">\
                                  </div>\
                                  <div class="col-2">\
                                    <button id="deleteBtn" class="btn mb-0 deleteBtn" type="button">-</button>\
                                  </div>\
                                </div>';
                $("#add_software_name").append(content);

                $("#pdate, #license_expiry_date").flatpickr({
                  disableMobile: "true",
                });
              });

              $(document).on('click', '.deleteBtn', function() {
                // ลบองค์ประกอบที่มีปุ่มลบที่ถูกคลิก
                $(this).parent().parent().remove();
              });
            </script>

            <div id="add_software_name">

            </div>

          </div>
        </div>
      </div>

      <div class="col-sm-5 mt-sm-0 mt-4">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <h5 class="font-weight-bolder">Current Owner</h5>
              <div class="col-3">
                <label>User</label>
                <input class="form-control" name="user[]" type="text" placeholder="ex.7213" value="{{ old('user[0]') }}">
              </div>
              <div class="col-4">
                <label>Name</label>
                <input class="form-control" type="text" placeholder="Auto" readonly>
              </div>
              <div class="col-5">
                <label>Department</label>
                <input class="form-control" type="text" placeholder="Auto" readonly>
              </div>
            </div>
            <p></p>
            <div class="row">
              <h5 class="font-weight-bolder">Old Owner</h5>
              <div class="col-3">
                <label>User</label>
                <input class="form-control" name="old_user" type="text" placeholder="ex.7213" value="{{ old('old_user') }}">
              </div>
              <div class="col-4">
                <label>Name</label>
                <input class="form-control" name="old_name" type="text" placeholder="" value="{{ old('old_name') }}">
              </div>
              <div class="col-5">
                <label>Department</label>
                <input class="form-control" name="old_department" type="text" placeholder="" value="{{ old('old_department') }}">
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </form>
</div>

<script type="text/javascript">
  $(function() {
    $("#pdate, #license_expiry_date").flatpickr({
      disableMobile: "true",
    });

    $('#status').on('change', function() {
      if ($(this).val() == 'BROKEN') {
        $('.reason_broken').css('display', 'block');
      } else {
        $('.reason_broken').css('display', 'none');
      }
    });

  });
</script>

@endsection