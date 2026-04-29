@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Asset'])

    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .z-1 {
            z-index: 1;
        }

        .form-group label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            color: #344767;
        }

        .card-header h5 {
            margin-bottom: 0;
        }

        .software-row {
            border-bottom: 1px dashed #e9ecef;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .software-row:last-child {
            border-bottom: none;
        }

        .btn-add {
            border-radius: 50px;
            padding: 0.25rem 1rem;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #344767;
            border-bottom: 2px solid #f0f2f5;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
    </style>

    <div class="container-fluid py-4">
        <form action="{{ route('itasset.update', $itasset->id) }}" method="post">
            @csrf
            @method('PUT')

            {{-- Header --}}
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 z-1">
                    <h4 class="text-white mb-0">Edit IT Asset</h4>
                    <p class="text-white text-sm opacity-8 mb-0">Make the changes below</p>
                </div>
                <div class="col-lg-6 text-end z-1 mt-lg-0 mt-3 d-flex justify-content-end align-items-center">
                    @can('itasset delete')
                        <button type="button" class="btn btn-danger mb-0 me-3" data-bs-toggle="modal" data-bs-target="#import">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    @endcan
                    <a href="{{ route('itasset.show', $itasset->id) }}" type="button" class="btn btn-secondary mb-0 me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary mb-0">Save Changes</button>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success text-white">
                    <p class="mb-0">{{ $message }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger text-white">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                {{-- Left Column (Main Info) --}}
                <div class="col-lg-8">

                    {{-- Asset Information --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title"><i class="fas fa-desktop me-2"></i>Asset Information</h5>

                            <div class="row">
                                <div class="col-md-6 form-group mt-2">
                                    <label>Device Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="computer_name" value="{{ $itasset->computer_name }}" required>
                                </div>
                                <div class="col-md-6 form-group mt-2">
                                    <label>Serial Number</label>
                                    <input class="form-control" type="text" name="serial_number" value="{{ $itasset->serial_number }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mt-2">
                                    <label>Old Device Name</label>
                                    <input class="form-control" type="text" name="old_device_name" value="{{ $itasset->old_device_name }}">
                                </div>
                                <div class="col-md-6 form-group mt-2">
                                    <label>Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="type" id="type" required>
                                        <option value="">-- Select --</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->type_code }}"
                                                {{ $itasset->type == $type->type_code ? 'selected' : '' }}>
                                                {{ $type->type_desc }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mt-2">
                                    <label>Color</label>
                                    <select class="form-control" name="color">
                                        <option value="GREEN" {{ $itasset->color == 'GREEN' ? 'selected' : '' }}>GREEN</option>
                                        <option value="BLUE" {{ $itasset->color == 'BLUE' ? 'selected' : '' }}>BLUE</option>
                                        <option value="RED" {{ $itasset->color == 'RED' ? 'selected' : '' }}>RED</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mt-2">
                                    <label>Model <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="model" value="{{ $itasset->model }}"required>
                                </div>
                            </div>

                            <div class="row d-none bg-light border-radius-md p-2 mt-2 mx-0" id="col-tel">
                                <div class="col-md-6 form-group mb-0">
                                    <label>Phone Number</label>
                                    <input class="form-control" type="text" name="tel" value="{{ $itasset->tel }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Purchase & Warranty --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title"><i class="fas fa-file-invoice-dollar me-2"></i>Purchase & Warranty
                            </h5>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label>Fixed Asset No.</label>
                                    <input class="form-control" type="text" name="fixed_asset_no" value="{{ $itasset->fixed_asset_no }}">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Purchase Date</label>
                                    <input class="form-control datepicker bg-white" id="pdate" name="purchase_date" type="text" value="{{ $itasset->purchase_date }}">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 form-group">
                                    <label>Warranty</label>
                                    <select class="form-control" name="warranty" id="warranty">
                                        <option value="1 Years" {{ $itasset->warranty == '1 Years' ? 'selected' : '' }}>1 Years</option>
                                        <option value="2 Years" {{ $itasset->warranty == '2 Years' ? 'selected' : '' }}>2 Years</option>
                                        <option value="3 Years" {{ $itasset->warranty == '3 Years' ? 'selected' : '' }}>3 Years</option>
                                        <option value="4 Years" {{ $itasset->warranty == '4 Years' ? 'selected' : '' }}>4 Years</option>
                                        <option value="5 Years" {{ $itasset->warranty == '5 Years' ? 'selected' : '' }}>5 Years</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Expire Date</label>
                                    <input class="form-control bg-light" id="edate" type="text" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Ownership --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title"><i class="fas fa-users me-2"></i>Ownership Information</h5>

                            <h6 class="text-sm text-primary mb-0 mt-3">Current Owner</h6>
                            <div class="row">
                                <div class="col-md-3 form-group mt-2">
                                    <label>User</label>
                                    <input class="form-control" name="user[]" type="text" placeholder="ex.7213" value="{{ $itassetown->user ?? '' }}">
                                </div>
                                <div class="col-md-5 form-group mt-2">
                                    <label>Name</label>
                                    <input class="form-control bg-light" type="text" placeholder="Auto" value="{{ $itassetown?->owner?->name_en ?? '' }}" readonly>
                                </div>
                                <div class="col-md-4 form-group mt-2">
                                    <label>Department</label>
                                    <input class="form-control bg-light" type="text" placeholder="Auto" value="{{ $itassetown?->owner?->dept ?? '' }}" readonly>
                                </div>
                            </div>

                            <hr class="horizontal dark mt-3 mb-3">

                            <h6 class="text-sm text-secondary mb-0">Old Owner</h6>
                            <div class="row">
                                <div class="col-md-3 form-group mt-2">
                                    <label>User</label>
                                    <input class="form-control" name="old_user" type="text" placeholder="ex.7213" value="{{ $itasset->old_user }}">
                                </div>
                                <div class="col-md-5 form-group mt-2">
                                    <label>Name</label>
                                    <input class="form-control" name="old_name" type="text" value="{{ $itasset->old_name }}">
                                </div>
                                <div class="col-md-4 form-group mt-2">
                                    <label>Department</label>
                                    <input class="form-control" name="old_department" type="text" value="{{ $itasset->old_department }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Software --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="section-title mb-0 border-0"><i class="fas fa-layer-group me-2"></i>Software</h5>
                                <button id="addSoftwareBtn" class="btn btn-sm btn-outline-info btn-add mb-0" type="button">+ Add</button>
                            </div>

                            <div class="row d-none d-md-flex text-muted mb-2 px-2">
                                <div class="col-md-4"><label class="mb-0">Software Name</label></div>
                                <div class="col-md-3"><label class="mb-0">License Type</label></div>
                                <div class="col-md-4"><label class="mb-0">License Expire Date</label></div>
                            </div>

                            {{-- Existing Software Loop --}}
                            @foreach ($softwares as $key => $value)
                                <div class="row software-row align-items-end gx-2 px-2 mt-2">
                                    <div class="col-md-4 form-group mb-2">
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
                                    <div class="col-md-3 form-group mb-2">
                                        <select class="form-control" name="license_type[]">
                                            <option value=""></option>
                                            <option value="Yearly" {{ $value->license_type == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                                            <option value="Permanent" {{ $value->license_type == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                            <option value="Free" {{ $value->license_type == 'Free' ? 'selected' : '' }}>Free</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group mb-2">
                                        <input class="form-control datepicker bg-white" name="license_expiry_date[]" value="{{ $value->license_expire_date }}">
                                    </div>
                                    <div class="col-md-1 mb-2 text-end">
                                        <button class="btn btn-link text-danger mb-0 px-2 deleteBtn" type="button">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            <div id="add_software_name"></div>
                        </div>
                    </div>

                </div>

                {{-- Right Column (Image, Status, Spec) --}}
                <div class="col-lg-4">

                    {{-- Asset Image --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <h5 class="section-title text-start"><i class="fas fa-image me-2"></i>Asset Image</h5>
                            @php
                                $images = [
                                    'T01' => 'macbook-pro.jpg',
                                    'T02' => 'pc.jpg',
                                    'T03' => 'printer-fuji.jpg',
                                    'T05' => 'headset.jpg',
                                    'T06' => 'telephone_sim.jpg',
                                    'T07' => 'tv.png',
                                    'T08' => 'copy_machine.png',
                                    'T09' => 'handheld.png',
                                    'T10' => 'mobile_printer.jpg',
                                    'T11' => 'pos.png',
                                    'T12' => 'phone_number.png',
                                    'T13' => 'microphone.png',
                                    'T14' => 'usb_flash_drive.png',
                                    'T15' => 'video_conference.png',
                                    'T16' => 'speaker.png',
                                    'T17' => 'mobile_phone.png',
                                    'T18' => 'tablet.png',
                                ];
                                $image = $images[$itasset->type] ?? null;
                            @endphp
                            @if ($image)
                                <img class="w-75 border-radius-lg shadow-sm mt-3" src="{{ URL::to('/') . '/img/itasset/' . $image }}" alt="itasset">
                            @else
                                <div class="p-5 bg-light border-radius-lg text-muted mt-3">
                                    <i class="fas fa-laptop fa-3x mb-2"></i><br>
                                    <small>No image available</small>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Status & Location --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title"><i class="fas fa-info-circle me-2"></i>Status & Location</h5>
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="ACTIVE" {{ $itasset->status == 'ACTIVE' ? 'selected' : '' }}>ACTIVE</option>
                                    <option value="BROKEN" {{ $itasset->status == 'BROKEN' ? 'selected' : '' }}>BROKEN</option>
                                    <option value="SPARE" {{ $itasset->status == 'SPARE' ? 'selected' : '' }}>SPARE</option>
                                </select>
                            </div>

                            <div class="form-group reason_broken mt-3 {{ $itasset->status == 'BROKEN' ? '' : 'd-none' }}">
                                <label class="text-danger">Reason Broken</label>
                                <input class="form-control" type="text" name="reason_broken" id="reason_broken" value="{{ $itasset->reason_broken }}">
                            </div>

                            <div class="form-group mt-3">
                                <label>Location</label>
                                <select class="form-control" name="location">
                                    <option value=""></option>
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
                                    <option value="HTH64_Bangkok Showroom" {{ $itasset->location == 'HTH64_Bangkok Showroom' ? 'selected' : '' }}> HTH64_Bangkok Showroom</option>
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
                                    <option value="HTH64_Smart Technology" {{ $itasset->location == 'HTH64_Smart Technology' ? 'selected' : '' }}>HTH64_Smart Technology</option>
                                    <option value="HTH64_Spare" {{ $itasset->location == 'HTH64_Spare' ? 'selected' : '' }}>HTH64_Spare</option>
                                    <option value="HTH64_Supply Chain" {{ $itasset->location == 'HTH64_Supply Chain' ? 'selected' : '' }}>HTH64_Supply Chain</option>
                                    <option value="HTH64_Maintenance" {{ $itasset->location == 'HTH64_Maintenance' ? 'selected' : '' }}>HTH64_Maintenance</option>
                                    <option value="HTHDC_Site Management" {{ $itasset->location == 'HTHDC_Site Management' ? 'selected' : '' }}>HTHDC_Site Management</option>
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
                                </select>
                            </div>

                            <hr class="horizontal dark mt-4">
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label>Create By</label>
                                    <input class="form-control bg-light" type="text" name="create_by" value="{{ $itasset->create_by }}" readonly>
                                </div>
                                <div class="col-6 form-group">
                                    <label>Create Date</label>
                                    <input class="form-control bg-light" type="text" value="{{ $itasset->created_at }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Spec --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title"><i class="fas fa-microchip me-2"></i>Spec</h5>
                            <div class="form-group">
                                <label>Cpu</label>
                                <input class="form-control" type="text" name="cpu" value="{{ $itassetspec->cpu ?? '' }}" placeholder="ex.INTEL 9">
                            </div>
                            <div class="form-group mt-2">
                                <label>Ram</label>
                                <input class="form-control" type="text" name="ram" value="{{ $itassetspec->ram ?? '' }}" placeholder="ex.16GB">
                            </div>
                            <div class="form-group mt-2">
                                <label>Storage</label>
                                <input class="form-control" type="text" name="storage" value="{{ $itassetspec->storage ?? '' }}" placeholder="ex.1TB">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        {{-- Delete Modal --}}
        <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog mt-lg-10">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">Delete Asset</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('itasset.destroy', $itasset->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body text-start">
                            <p>Are you sure you want to delete this asset? This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm bg-gradient-danger">Confirm Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript" nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        $(function() {
            $(".datepicker").flatpickr({
                disableMobile: "true",
                allowInput: true,
                dateFormat: "Y-m-d",
            });

            function toggleTelField() {
                let val = $('#type').val();
                if (val === 'T17' || val === 'T18') {
                    $('#col-tel').removeClass('d-none');
                } else {
                    $('#col-tel').addClass('d-none');
                }
            }

            toggleTelField();
            $('#type').on('change', toggleTelField);

            $('#status').on('change', function() {
                if ($(this).val() == 'BROKEN') {
                    $('.reason_broken').removeClass('d-none');
                } else {
                    $('.reason_broken').addClass('d-none');
                    $('#reason_broken').val('');
                }
            });

            $("#addSoftwareBtn").click(function() {
                let content = `
                    <div class="row software-row align-items-end gx-2 px-2 mt-2">
                    <div class="col-md-4 form-group mb-2">
                        <select class="form-control" name="software_name[]" required>
                        <option value=""></option>
                        <option value="Auto_CAD_2024">Auto CAD 2024</option>
                        <option value="AutoCAD_LT">AutoCAD LT</option>
                        <option value="Adobe_Creative_Cloud">Adobe Creative Cloud</option>
                        <option value="WinRAR">WinRAR</option>
                        <option value="TeamViewer">TeamViewer</option>
                        <option value="PDF_XChange_Editor">PDF XChange Editor</option>
                        <option value="SketchUp_Pro">SketchUp Pro</option>
                        <option value="FreeCAD">FreeCAD</option>
                        <option value="DIALUX">DIALUX</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-2">
                        <select class="form-control" name="license_type[]" required>
                        <option value=""></option>
                        <option value="Yearly">Yearly</option>
                        <option value="Permanent">Permanent</option>
                        <option value="Free">Free</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group mb-2">
                        <input class="form-control datepicker bg-white" name="license_expiry_date[]" placeholder="Select date">
                    </div>
                    <div class="col-md-1 mb-2 text-end">
                        <button class="btn btn-link text-danger mb-0 px-2 deleteBtn" type="button"><i class="fas fa-trash"></i></button>
                    </div>
                    </div>`;

                $("#add_software_name").append(content);

                $(".datepicker").flatpickr({
                    disableMobile: "true",
                    allowInput: true,
                    dateFormat: "Y-m-d",
                });
            });

            $(document).on('click', '.deleteBtn', function() {
                $(this).closest('.software-row').remove();
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const pDateInput = document.getElementById('pdate');
            const warrantySelect = document.querySelector('select[name="warranty"]');
            const eDateInput = document.getElementById('edate');

            function calculateExpireDate() {
                const purchaseDateValue = pDateInput.value;
                const match = warrantySelect.value.match(/\d+/);
                const yearsToAdd = match ? parseInt(match[0]) : 0;

                if (purchaseDateValue && !isNaN(yearsToAdd)) {
                    const date = new Date(purchaseDateValue);
                    if (!isNaN(date.getTime())) {
                        date.setFullYear(date.getFullYear() + yearsToAdd);
                        const year = date.getFullYear();
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const day = String(date.getDate()).padStart(2, '0');
                        if (eDateInput) eDateInput.value = `${year}-${month}-${day}`;
                    }
                }
            }

            calculateExpireDate();
            if (warrantySelect) warrantySelect.addEventListener('change', calculateExpireDate);
            if (pDateInput) {
                pDateInput.addEventListener('change', calculateExpireDate);
                pDateInput.addEventListener('blur', calculateExpireDate);
            }
        });
    </script>
@endsection
