@extends('layouts.appguest', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-9 mt-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0">SALES USI</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Item Code</label>
                                    <input class="form-control" type="text" value="589.34.244">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Item Desc</label>
                                    <input class="form-control" type="text" value="HANDSHOWER ABS CHR.POL.3 FUNC.">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Grade1</label>
                                    <input class="form-control" type="text" value="STD">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Grade2</label>
                                    <input class="form-control" type="text" value="G2">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Purchaser</label>
                                    <input class="form-control" type="text" value="HATHAIPAT BU">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Cust Item Code</label>
                                    <input class="form-control" type="text" value="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">PM Contact</label>
                                    <input class="form-control" type="text" value="TASSANEE KILL">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Uom</label>
                                    <input class="form-control" type="text" value="PC">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Pack Code</label>
                                    <input class="form-control" type="text" value="BOX">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">PC</label>
                                    <input class="form-control" type="text" value="30">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">New Item</label>
                                    <input class="form-control" type="text" value="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Weight-Volume</label>
                                    <input class="form-control" type="text" value="16.800">
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Contact Information</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Address</label>
                                    <input class="form-control" type="text"
                                        value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">City</label>
                                    <input class="form-control" type="text" value="New York">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Country</label>
                                    <input class="form-control" type="text" value="United States">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Postal code</label>
                                    <input class="form-control" type="text" value="437300">
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">About me</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">About me</label>
                                    <input class="form-control" type="text"
                                        value="A beautiful Dashboard for Bootstrap 5. It is Free and Open Source.">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-4">
                <div class="card card-profile ">
                    <img src="/storage/img/products/coming_soon.jpg" alt="Image placeholder" class="card-img-top">

                    <div class="card-body pt-0">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card ">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2">Sales by Country</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center ">
                            <tbody>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/flags/US.png" alt="Country flag">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Country:</p>
                                                <h6 class="text-sm mb-0">United States</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Sales:</p>
                                            <h6 class="text-sm mb-0">2500</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Value:</p>
                                            <h6 class="text-sm mb-0">$230,900</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <div class="col text-center">
                                            <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                                            <h6 class="text-sm mb-0">29.9%</h6>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/flags/DE.png" alt="Country flag">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Country:</p>
                                                <h6 class="text-sm mb-0">Germany</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Sales:</p>
                                            <h6 class="text-sm mb-0">3.900</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Value:</p>
                                            <h6 class="text-sm mb-0">$440,000</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <div class="col text-center">
                                            <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                                            <h6 class="text-sm mb-0">40.22%</h6>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/flags/GB.png" alt="Country flag">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Country:</p>
                                                <h6 class="text-sm mb-0">Great Britain</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Sales:</p>
                                            <h6 class="text-sm mb-0">1.400</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Value:</p>
                                            <h6 class="text-sm mb-0">$190,700</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <div class="col text-center">
                                            <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                                            <h6 class="text-sm mb-0">23.44%</h6>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/flags/BR.png" alt="Country flag">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Country:</p>
                                                <h6 class="text-sm mb-0">Brasil</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Sales:</p>
                                            <h6 class="text-sm mb-0">562</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Value:</p>
                                            <h6 class="text-sm mb-0">$143,960</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <div class="col text-center">
                                            <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                                            <h6 class="text-sm mb-0">32.14%</h6>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Categories</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-mobile-button text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Devices</h6>
                                        <span class="text-xs">250 in stock, <span class="font-weight-bold">346+
                                                sold</span></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                            class="ni ni-bold-right" aria-hidden="true"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-tag text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Tickets</h6>
                                        <span class="text-xs">123 closed, <span class="font-weight-bold">15
                                                open</span></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                            class="ni ni-bold-right" aria-hidden="true"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-box-2 text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Error logs</h6>
                                        <span class="text-xs">1 is active, <span class="font-weight-bold">40
                                                closed</span></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                            class="ni ni-bold-right" aria-hidden="true"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-satisfied text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Happy users</h6>
                                        <span class="text-xs font-weight-bold">+ 430</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                            class="ni ni-bold-right" aria-hidden="true"></i></button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
