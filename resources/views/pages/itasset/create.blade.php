@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'New Asset'])

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
        <form action="{{ route('itasset.store') }}" method="post">
            @csrf

            {{-- header --}}
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 z-1">
                    <h4 class="text-white mb-0">Create IT Asset</h4>
                    <p class="text-white text-sm opacity-8 mb-0">Make the changes below</p>
                </div>
                <div class="col-lg-6 text-end z-1 mt-lg-0 mt-3">
                    <a href="{{ route('itasset.index') }}" type="button" class="btn btn-secondary mb-0 me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary mb-0">Save</button>
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
                {{-- left column (main info) --}}
                <div class="col-lg-8">

                    {{-- asset information --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title"><i class="fas fa-desktop me-2"></i>Asset Information</h5>

                            <div class="row">
                                <div class="col-md-6 form-group mt-2">
                                    <label>Device Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="computer_name" placeholder="ex.HTHBKKNB333" value="{{ old('computer_name') }}" required>
                                </div>
                                <div class="col-md-6 form-group mt-2">
                                    <label>Serial Number</label>
                                    <input class="form-control" type="text" name="serial_number"
                                        placeholder="ex.SNTEST000001" value="{{ old('serial_number') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mt-2">
                                    <label>Old Device Name</label>
                                    <input class="form-control" type="text" name="old_device_name" placeholder="ex.AP-5CD242KKN4" value="{{ old('old_device_name') }}">
                                </div>
                                <div class="col-md-6 form-group mt-2">
                                    <label>Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="type" id="type" required>
                                        <option value="">-- Select --</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->type_code }}">{{ $type->type_desc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mt-2">
                                    <label>Color</label>
                                    <select class="form-control" name="color">
                                        <option value="GREEN">GREEN</option>
                                        <option value="BLUE">BLUE</option>
                                        <option value="RED">RED</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mt-2">
                                    <label>Model <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="model" placeholder="ex.DELL" value="{{ old('model') }}" required>
                                </div>
                            </div>

                            <div class="row d-none bg-light border-radius-md p-2 mt-2 mx-0" id="col-tel">
                                <div class="col-md-6 form-group mb-0">
                                    <label>Phone Number</label>
                                    <input class="form-control" type="text" name="tel" value="{{ old('tel') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- purchase & warranty --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title"><i class="fas fa-file-invoice-dollar me-2"></i>Purchase & Warranty
                            </h5>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label>Fixed Asset No.</label>
                                    <input class="form-control" type="text" name="fixed_asset_no" placeholder="ex.RS8898569565" value="{{ old('fixed_asset_no') }}">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Purchase Date</label>
                                    <input class="form-control datepicker bg-white" id="pdate" name="purchase_date" placeholder="Select date" type="text" value="{{ old('purchase_date') }}">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 form-group">
                                    <label>Warranty</label>
                                    <select class="form-control" name="warranty" id="warranty">
                                        <option value="1 Years">1 Years</option>
                                        <option value="2 Years">2 Years</option>
                                        <option value="3 Years" selected>3 Years</option>
                                        <option value="4 Years">4 Years</option>
                                        <option value="5 Years">5 Years</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Expire Date</label>
                                    <input class="form-control bg-light" id="edate" type="text" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ownership --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title"><i class="fas fa-users me-2"></i>Ownership Information</h5>

                            <h6 class="text-sm text-primary mb-0 mt-3">Current Owner</h6>
                            <div class="row">
                                <div class="col-md-3 form-group mt-2">
                                    <label>User</label>
                                    <input class="form-control" name="user[]" type="text" placeholder="ex.7213" value="{{ old('user[0]') }}">
                                </div>
                                <div class="col-md-5 form-group mt-2">
                                    <label>Name</label>
                                    <input class="form-control bg-light" type="text" placeholder="Auto" readonly>
                                </div>
                                <div class="col-md-4 form-group mt-2">
                                    <label>Department</label>
                                    <input class="form-control bg-light" type="text" placeholder="Auto" readonly>
                                </div>
                            </div>

                            <hr class="horizontal dark mt-3 mb-3">

                            <h6 class="text-sm text-secondary mb-0">Old Owner</h6>
                            <div class="row">
                                <div class="col-md-3 form-group mt-2">
                                    <label>User</label>
                                    <input class="form-control" name="old_user" type="text" placeholder="ex.7213" value="{{ old('old_user') }}">
                                </div>
                                <div class="col-md-5 form-group mt-2">
                                    <label>Name</label>
                                    <input class="form-control" name="old_name" type="text" value="{{ old('old_name') }}">
                                </div>
                                <div class="col-md-4 form-group mt-2">
                                    <label>Department</label>
                                    <input class="form-control" name="old_department" type="text" value="{{ old('old_department') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- software --}}
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

                            <div id="add_software_name"></div>
                        </div>
                    </div>

                </div>

                {{-- right column (status, spec) --}}
                <div class="col-lg-4">

                    {{-- status & location --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title"><i class="fas fa-info-circle me-2"></i>Status & Location</h5>
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="ACTIVE">ACTIVE</option>
                                    <option value="BROKEN">BROKEN</option>
                                    <option value="SPARE">SPARE</option>
                                </select>
                            </div>

                            <div class="form-group reason_broken d-none mt-3">
                                <label class="text-danger">Reason Broken</label>
                                <input class="form-control" type="text" name="reason_broken">
                            </div>

                            <div class="form-group mt-3">
                                <label>Location</label>
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

                            <hr class="horizontal dark mt-4">
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label>Create By</label>
                                    <input class="form-control bg-light" type="text" name="create_by" readonly>
                                </div>
                                <div class="col-6 form-group">
                                    <label>Create Date</label>
                                    <input class="form-control bg-light" type="text" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- spec --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title"><i class="fas fa-microchip me-2"></i>Spec</h5>
                            <div class="form-group">
                                <label>Cpu</label>
                                <input class="form-control" type="text" name="cpu" placeholder="ex.INTEL 9" value="{{ old('cpu') }}">
                            </div>
                            <div class="form-group mt-2">
                                <label>Ram</label>
                                <input class="form-control" type="text" name="ram" placeholder="ex.16GB" value="{{ old('ram') }}">
                            </div>
                            <div class="form-group mt-2">
                                <label>Storage</label>
                                <input class="form-control" type="text" name="storage" placeholder="ex.1TB" value="{{ old('storage') }}">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
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
                $('.reason_broken').toggleClass('d-none', $(this).val() !== 'BROKEN');
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
                      <input class="form-control datepicker bg-white" id="license_expiry_date" name="license_expiry_date[]" placeholder="Select date">
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
            const eDateInput = document.getElementById('edate') || document.querySelector('input[readonly]');

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
                        eDateInput.value = `${year}-${month}-${day}`;
                    }
                }
            }

            calculateExpireDate();
            warrantySelect.addEventListener('change', calculateExpireDate);
            pDateInput.addEventListener('change', calculateExpireDate);
            pDateInput.addEventListener('blur', calculateExpireDate);
        });
    </script>
@endsection
