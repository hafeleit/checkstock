@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Edit Asset'])
<div class="container-fluid py-4">
  <form action="{{ route('itasset.update',$itasset->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="row">
      <div class="col-lg-6" style="z-index: 1;">
        <h4 class="text-white">Make the changes below</h4>
      </div>
      <div class="col-lg-6 text-end" style="z-index: 1;">
        <a href="{{ route('itasset.show',$itasset->id) }}" type="button" class="btn btn-secondary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Cancel</a>
        <button type="submit" class="btn btn-primary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Save</button>
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
                <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/printer-fuji.jpg" alt="printer">
                @break
                @case('T02')
                <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/pc.jpg" alt="pc">
                @break
                @case('T05')
                <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{ URL::to('/') }}/img/itasset/headset.jpg" alt="headset">
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
                <input class="form-control" type="text" name="computer_name" value="{{$itasset->computer_name}}">
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label>Serial Number</label>
                <input class="form-control" type="text" name="serial_number" value="{{$itasset->serial_number}}">
              </div>

            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4">Old Device Name</label>
                <input class="form-control" type="text" name="old_device_name" placeholder="ex.AP-5CD242KKN4" value="{{$itasset->old_device_name}}">
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4">Type <span class="text-danger">*</span></label>
                <select class="form-control" name="type" required>
                  <option value="">-- Select --</option>
                  @foreach($types as $type)
                  <option value="{{ $type->type_code }}"
                    {{ $itasset->type == $type->type_code ? 'selected' : '' }}>
                    {{ $type->type_desc }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4">Color</label>
                <select class="form-control" name="color">
                  <option value="GREEN" {{ $itasset->color == 'GREEN' ? 'selected' : '' }}>GREEN</option>
                  <option value="BLUE" {{ $itasset->color == 'BLUE' ? 'selected' : '' }}>BLUE</option>
                  <option value="RED" {{ $itasset->color == 'RED' ? 'selected' : '' }}>RED</option>
                </select>
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4">Model <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="model" value="{{$itasset->model}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6">
                <label class="mt-4">Fixed Asset No.</label>
                <input class="form-control" type="text" name="fixed_asset_no" value="{{$itasset->fixed_asset_no}}">
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4">Purchase Date</label>
                <input class="form-control datepicker" id="pdate" name="purchase_date" value="{{$itasset->purchase_date}}" type="text">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6">
                <label class="mt-4">Warranty</label>
                <select class="form-control" name="warranty">
                  <option value="1 Years" {{ $itasset->warranty == '1 Years' ? 'selected' : '' }}>1 Years</option>
                  <option value="2 Years" {{ $itasset->warranty == '2 Years' ? 'selected' : '' }}>2 Years</option>
                  <option value="3 Years" {{ $itasset->warranty == '3 Years' ? 'selected' : '' }}>3 Years</option>
                  <option value="4 Years" {{ $itasset->warranty == '4 Years' ? 'selected' : '' }}>4 Years</option>
                  <option value="5 Years" {{ $itasset->warranty == '5 Years' ? 'selected' : '' }}>5 Years</option>
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
                  <option value="ACTIVE" {{ $itasset->status == 'ACTIVE' ? 'selected' : '' }}>ACTIVE</option>
                  <option value="BROKEN" {{ $itasset->status == 'BROKEN' ? 'selected' : '' }}>BROKEN</option>
                  <option value="SPARE" {{ $itasset->status == 'SPARE' ? 'selected' : '' }}>SPARE</option>
                </select>
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mt-4">Location</label>
                <select class="form-control" name="location">
                  <option value="HTH Chiangmai Showroom" {{ $itasset->location == 'HTH Chiangmai Showroom' ? 'selected' : '' }}>HTH Chiangmai Showroom</option>
                  <option value="HTH Huahin Showroom" {{ $itasset->location == 'HTH Huahin Showroom' ? 'selected' : '' }}>HTH Huahin Showroom</option>
                  <option value="HTH Pattaya Showroom" {{ $itasset->location == 'HTH Pattaya Showroom' ? 'selected' : '' }}>HTH Pattaya Showroom</option>
                  <option value="HTH Phuket Showroom" {{ $itasset->location == 'HTH Phuket Showroom' ? 'selected' : '' }}>HTH Phuket Showroom</option>
                  <option value="HTH Bangpho Showroom" {{ $itasset->location == 'HTH Bangpho Showroom' ? 'selected' : '' }}>HTH Bangpho Showroom</option>
                  <option value="HTH Warehouse Bangpho" {{ $itasset->location == 'HTH Warehouse Bangpho' ? 'selected' : '' }}>HTH Warehouse Bangpho</option>
                  <option value="HTH Warehouse Chiangmai" {{ $itasset->location == 'HTH Warehouse Chiangmai' ? 'selected' : '' }}>HTH Warehouse Chiangmai</option>
                  <option value="HTH Warehouse Hunhin" {{ $itasset->location == 'HTH Warehouse Hunhin' ? 'selected' : '' }}>HTH Warehouse Hunhin</option>
                  <option value="HTH Warehouse Pattaya" {{ $itasset->location == 'HTH Warehouse Pattaya' ? 'selected' : '' }}>HTH Warehouse Pattaya</option>
                  <option value="HTH Warehouse Phuket" {{ $itasset->location == 'HTH Warehouse Phuket' ? 'selected' : '' }}>HTH Warehouse Phuket</option>
                  <option value="HTH64_Admin" {{ $itasset->location == 'HTH64_Admin' ? 'selected' : '' }}>HTH64_Admin</option>
                  <option value="HTH64_Bangkok Showroom" {{ $itasset->location == 'HTH64_Bangkok Showroom' ? 'selected' : '' }}>HTH64_Bangkok Showroom</option>
                  <option value="HTH64_BKK Warehouse" {{ $itasset->location == 'HTH64_BKK Warehouse' ? 'selected' : '' }}>HTH64_BKK Warehouse</option>
                  <option value="HTH64_BROKEN" {{ $itasset->location == 'HTH64_BROKEN' ? 'selected' : '' }}>HTH64_BROKEN</option>
                  <option value="HTH64_Customer Services" {{ $itasset->location == 'HTH64_Customer Services' ? 'selected' : '' }}>HTH64_Customer Services</option>
                  <option value="HTH64_E-Commerce" {{ $itasset->location == 'HTH64_E-Commerce' ? 'selected' : '' }}>HTH64_E-Commerce</option>
                  <option value="HTH64_Finance" {{ $itasset->location == 'HTH64_Finance' ? 'selected' : '' }}>HTH64_Finance</option>
                  <option value="HTH64_HR" {{ $itasset->location == 'HTH64_HR' ? 'selected' : '' }}>HTH64_HR</option>
                  <option value="HTH64_Inventory" {{ $itasset->location == 'HTH64_Inventory' ? 'selected' : '' }}>HTH64_Inventory</option>
                  <option value="HTH64_IT" {{ $itasset->location == 'HTH64_IT' ? 'selected' : '' }}>HTH64_IT</option>
                  <option value="HTH64_Marketing" {{ $itasset->location == 'HTH64_Marketing' ? 'selected' : '' }}>HTH64_Marketing</option>
                  <option value="HTH64_MD Office" {{ $itasset->location == 'HTH64_MD Office' ? 'selected' : '' }}>HTH64_MD Office</option>
                  <option value="HTH64_PM" {{ $itasset->location == 'HTH64_PM' ? 'selected' : '' }}>HTH64_PM</option>
                  <option value="HTH64_Purchase" {{ $itasset->location == 'HTH64_Purchase' ? 'selected' : '' }}>HTH64_Purchase</option>
                  <option value="HTH64_QA" {{ $itasset->location == 'HTH64_QA' ? 'selected' : '' }}>HTH64_QA</option>
                  <option value="HTH64_Sales" {{ $itasset->location == 'HTH64_Sales' ? 'selected' : '' }}>HTH64_Sales</option>
                  <option value="HTHDC_Site Management" {{ $itasset->location == 'HTHDC_Site Management' ? 'selected' : '' }}>HTHDC_Site Management</option>
                  <option value="HTH64_Smart Technology" {{ $itasset->location == 'HTH64_Smart Technology' ? 'selected' : '' }}>HTH64_Smart Technology</option>
                  <option value="HTH64_Spare" {{ $itasset->location == 'HTH64_Spare' ? 'selected' : '' }}>HTH64_Spare</option>
                  <option value="HTH64_Supply Chain" {{ $itasset->location == 'HTH64_Supply Chain' ? 'selected' : '' }}>HTH64_Supply Chain</option>
                  <option value="HTH64_Maintenance" {{ $itasset->location == 'HTH64_Maintenance' ? 'selected' : '' }}>HTH64_Maintenance</option>
                  <option value="HTHDC_Delivery" {{ $itasset->location == 'HTHDC_Delivery' ? 'selected' : '' }}>HTHDC_Delivery</option>
                  <option value="HTHDC_Despatch" {{ $itasset->location == 'HTHDC_Despatch' ? 'selected' : '' }}>HTHDC_Despatch</option>
                  <option value="HTHDC_Logistics" {{ $itasset->location == 'HTHDC_Logistics' ? 'selected' : '' }}>HTHDC_Logistics</option>
                  <option value="HTHDC_Master Key" {{ $itasset->location == 'HTHDC_Master Key' ? 'selected' : '' }}>HTHDC_Master Key</option>
                  <option value="HTHDC_Packing" {{ $itasset->location == 'HTHDC_Packing' ? 'selected' : '' }}>HTHDC_Packing</option>
                  <option value="HTHDC_Packing DIY" {{ $itasset->location == 'HTHDC_Packing DIY' ? 'selected' : '' }}>HTHDC_Packing DIY</option>
                  <option value="HTHDC_Packing UPC" {{ $itasset->location == 'HTHDC_Packing UPC' ? 'selected' : '' }}>HTHDC_Packing UPC</option>
                  <option value="HTHDC_Pool Function" {{ $itasset->location == 'HTHDC_Pool Function' ? 'selected' : '' }}>HTHDC_Pool Function</option>
                  <option value="HTHDC_Product Return" {{ $itasset->location == 'HTHDC_Product Return' ? 'selected' : '' }}>HTHDC_Product Return</option>
                  <option value="HTHDC_Workshop" {{ $itasset->location == 'HTHDC_Workshop' ? 'selected' : '' }}>HTHDC_Workshop</option>
                  <option value="HTHDC_Maintenance" {{ $itasset->location == 'HTHDC_Maintenance' ? 'selected' : '' }}>HTHDC_Maintenance</option>
                  <option value="HTHDC_E-Commerce Warehouse" {{ $itasset->location == 'HTHDC_E-Commerce Warehouse' ? 'selected' : '' }}>HTHDC_E-Commerce Warehouse</option>
                  <option value="HTHDC_IG" {{ $itasset->location == 'HTHDC_IG' ? 'selected' : '' }}>HTHDC_IG</option>
                  <option value="HTHHA" {{ $itasset->location == 'HTHHA' ? 'selected' : '' }}>HTHHA</option>
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="row reason_broken" style="display:{{ ($itasset->status == 'BROKEN') ? 'block' : 'none' }}">
              <div class="col-12 col-sm-6">
                <label class="mt-4 text-danger">Reason Broken</label>
                <input class="form-control" type="text" name="reason_broken" id="reason_broken" value="{{$itasset->reason_broken}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6">
                <label class="mt-4">Create By</label>
                <input class="form-control" type="text" name="create_by" value="{{$itasset->create_by}}" readonly>
              </div>
              <div class="col-12 col-sm-6 mt-sm-0">
                <label class="mt-4">Create Date</label>
                <input class="form-control" type="text" value="{{$itasset->created_at}}" readonly>
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
            <label class="">Cpu</label>
            <input class="form-control" type="text" name="cpu" value="{{$itassetspec->cpu ?? 'n/a'}}" placeholder="INTEL 9">
            <label class="mt-3">Ram</label>
            <input class="form-control" type="text" name="ram" value="{{$itassetspec->ram ?? 'n/a'}}" placeholder="16GB">
            <label class="mt-3">Storage</label>
            <input class="form-control" type="text" name="storage" value="{{$itassetspec->storage ?? 'n/a'}}" placeholder="1TB">
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
            @foreach($softwares as $key => $value)
            <div class="row mt-2">

              <div class="col-4">
                <select class="form-control" name="software_name[]">
                  <option value=""></option>
                  <option value="Auto_CAD_2024" {{ $value->software_name == 'Auto_CAD_2024' ? 'selected' : '' }}>Auto CAD 2024</option>
                  <option value="AutoCAD_LT" {{ $value->software_name == 'AutoCAD_LT' ? 'selected' : '' }}>AutoCAD LT</option>
                  <option value="Adobe_Creative_Cloud" {{ $value->software_name == 'Adobe_Creative_Cloud' ? 'selected' : '' }}>Adobe Creative Cloud</option>
                  <option value="WinRAR" {{ $value->software_name == 'WinRAR' ? 'selected' : '' }}>WinRAR</option>
                  <option value="TeamViewer" {{ $value->software_name == 'TeamViewer' ? 'selected' : '' }}>TeamViewer</option>
                  <option value="PDF_XChange_Editor" {{ $value->software_name == 'PDF_XChange_Editor' ? 'selected' : '' }}>PDF XChange Editor</option>
                  <option value="SketchUp_Pro" {{ $value->software_name == 'SketchUp_Pro' ? 'selected' : '' }}>SketchUp Pro</option>
                  <option value="FreeCAD" {{ $value->software_name == 'FreeCAD' ? 'selected' : '' }}>FreeCAD</option>
                  <option value="DIALUX" {{ $value->software_name == 'DIALUX' ? 'selected' : '' }}>DIALUX</option>
                </select>
              </div>
              <div class="col-2">
                <select class="form-control" name="license_type[]">
                  <option value=""></option>
                  <option value="Yearly" {{ $value->license_type == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                  <option value="Permanent" {{ $value->license_type == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                  <option value="Free" {{ $value->license_type == 'Free' ? 'selected' : '' }}>Free</option>
                </select>
              </div>
              <div class="col-4">
                <input class="form-control datepicker" id="license_expiry_date" name="license_expiry_date[]" value="{{ $value->license_expire_date}}">
              </div>

              <div class="col-2">
                <button id="deleteBtn" class="btn mb-0 deleteBtn" type="button">-</button>
              </div>

            </div>
            @endforeach
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
                <input class="form-control" name="user[]" type="text" placeholder="ex.7213" value="{{ $itassetown[0]->user ?? '' }}">
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
                <input class="form-control" name="old_user" type="text" placeholder="7213" value="{{$itasset->old_user}}">
              </div>
              <div class="col-4">
                <label>Name</label>
                <input class="form-control" name="old_name" type="text" value="{{$itasset->old_name}}">
              </div>
              <div class="col-5">
                <label>Department</label>
                <input class="form-control" name="old_department" type="text" value="{{$itasset->old_department}}">
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
      @can('itasset delete')
      <button type="button" class="btn btn-outline-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#import"> Delete </button>
      @endcan
      <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog mt-lg-10">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ModalLabel">Delete</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('itasset.destroy',$itasset->id) }}" method="POST">
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
  $(function() {

    $("#pdate, #license_expiry_date").flatpickr({
      disableMobile: "true",
    });

    $('#status').on('change', function() {
      if ($(this).val() == 'BROKEN') {
        $('.reason_broken').css('display', 'block');
      } else {
        $('.reason_broken').css('display', 'none');
        $('#reason_broken').val('');
      }
    });

    $("#addSoftwareBtn").click(function() {

      let content = '<div class="row mt-2">\
                            <div class="col-4">\
                              <select class="form-control" name="software_name[]">\
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
                              <select class="form-control" name="license_type[]">\
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
  });
</script>

@endsection
