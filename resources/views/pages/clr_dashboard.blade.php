@extends('layouts.appguest', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    <div class="container-fluid py-4">

        <div class="row">

            <div class="col-12" style="z-index: 9;text-align: center;margin-bottom: 14px;">
              <h3 class="font-weight-bolder text-white mb-0">Big Clearance Sale 2023</h3>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">

                <div class="card">

                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Day 1</p>
                                    <h2 class="font-weight-bolder">
                                        ฿{{ number_format($clr_total['day1_total']) }}
                                    </h2>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Day 2</p>
                                    <h2 class="font-weight-bolder">
                                        ฿{{ number_format($clr_total['day2_total']) }}
                                    </h2>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Day 3</p>
                                    <h2 class="font-weight-bolder">
                                        ฿{{ number_format($clr_total['day3_total']) }}
                                    </h2>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Grand Total</p>
                                    <h2 class="font-weight-bolder">
                                        ฿{{ number_format($clr_total['day_total']) }}
                                    </h2>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Sales overview</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">

                <div class="card card-carousel overflow-hidden h-100 p-0 ">
                    <div class="table-responsive">
                        <div class="card-header pb-0 p-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-2">SUMMARY</h6>
                            </div>
                        </div>
                        <table class="table align-items-center ">
                            <tbody>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/clr/pos.png" alt="Country flag" width="40px">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Sales</p>
                                                <h4 class="mb-0">POS</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY1</p>
                                            <h3 class="mb-0 text-primary">฿{{ number_format($clr_total['day1_pos']) }}</h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY2</p>
                                            <h3 class="mb-0 text-primary">฿{{ number_format($clr_total['day2_pos']) }}</h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY3</p>
                                            <h3 class="mb-0 text-primary">฿{{ number_format($clr_total['day3_pos']) }}</h3>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/clr/orion.png" alt="Country flag" width="40px">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Sales</p>
                                                <h4 class="mb-0">ORION (IN_CLR)</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY1</p>
                                            <h3 class="mb-0 text-success">฿{{ number_format($clr_total['day1_orion_in_clr']) }}</h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY2</p>
                                            <h3 class="mb-0 text-success">฿{{ number_format($clr_total['day2_orion_in_clr']) }}</h3></h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY3</p>
                                            <h3 class="mb-0 text-success">฿{{ number_format($clr_total['day3_orion_in_clr']) }}</h3></h3>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/clr/orion.png" alt="Country flag" width="40px">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Sales</p>
                                                <h4 class="mb-0">ORION (SO_PRI)</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY1</p>
                                            <h3 class="mb-0 text-info">฿{{ number_format($clr_total['day1_orion_so_pri']) }}</h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY2</p>
                                            <h3 class="mb-0 text-info">฿{{ number_format($clr_total['day2_orion_so_pri']) }}</h3></h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY3</p>
                                            <h3 class="mb-0 text-info">฿{{ number_format($clr_total['day3_orion_so_pri']) }}</h3></h3>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/clr/orion.png" alt="Country flag" width="40px">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Sales</p>
                                                <h4 class="mb-0">ORION (IN_DEP)</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY1</p>
                                            <h3 class="mb-0 text-secondary">฿{{ number_format($clr_total['day1_orion_in_dep']) }}</h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY2</p>
                                            <h3 class="mb-0 text-secondary">฿{{ number_format($clr_total['day2_orion_in_dep']) }}</h3></h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY3</p>
                                            <h3 class="mb-0 text-secondary">฿{{ number_format($clr_total['day3_orion_in_dep']) }}</h3></h3>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
              <div class="card ">
                  <div class="card-header pb-0 p-3">
                      <div class="d-flex justify-content-between">
                          <h6 class="mb-2">TODAY TOTAL</h6>
                      </div>
                  </div>
                  <div class="table-responsive">
                      <table class="table align-items-center ">
                          <tbody>
                              <tr>
                                  <td class="w-10">
                                      <div class="d-flex px-2 py-1 align-items-center">
                                          <div>
                                              <img src="./img/icons/clr/pos.png" alt="Country flag" width="40px">
                                          </div>
                                          <div class="ms-4">
                                              <p class="text-xs font-weight-bold mb-0">POS</p>
                                              <h6 class="text-sm mb-0">Total / Trans</h6>
                                          </div>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[0]->BY_CUST }}) #1</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_today[0]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[0]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[1]->BY_CUST }}) #2</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_today[1]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[1]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[2]->BY_CUST }}) #3</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_today[2]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[2]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[3]->BY_CUST }}) #4</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_today[3]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[3]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[4]->BY_CUST }}) #5</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_today[4]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[4]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[5]->BY_CUST }}) #6</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_today[5]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[5]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[6]->BY_CUST }}) #7</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_today[6]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[6]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[7]->BY_CUST }}) #8</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_today[7]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[7]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[8]->BY_CUST }}) #9</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_today[8]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[8]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td class="w-10">
                                      <div class="d-flex px-2 py-1 align-items-center">
                                          <div>
                                              <img src="./img/icons/clr/orion.png" alt="Country flag" width="40px">
                                          </div>
                                          <div class="ms-4">
                                              <p class="text-xs font-weight-bold mb-0">ORION (SO_PRI)</p>
                                              <h6 class="text-sm mb-0">Total / Trans</h6>
                                          </div>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[0]->BY_CUST }}) #1</p>
                                          <h6 class="mb-0">฿{{ number_format($pri_today[0]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[0]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[1]->BY_CUST }}) #2</p>
                                          <h6 class="mb-0">฿{{ number_format($pri_today[1]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[1]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[2]->BY_CUST }}) #3</p>
                                          <h6 class="mb-0">฿{{ number_format($pri_today[2]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[2]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[3]->BY_CUST }}) #4</p>
                                          <h6 class="mb-0">฿{{ number_format($pri_today[3]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[3]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[4]->BY_CUST }}) #5</p>
                                          <h6 class="mb-0">฿{{ number_format($pri_today[4]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[4]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[5]->BY_CUST }}) #6</p>
                                          <h6 class="mb-0">฿{{ number_format($pri_today[5]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[5]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[6]->BY_CUST }}) #7</p>
                                          <h6 class="mb-0">฿{{ number_format($pri_today[6]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[6]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[7]->BY_CUST }}) #8</p>
                                          <h6 class="mb-0">฿{{ number_format($pri_today[7]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[7]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td class="w-10">
                                      <div class="d-flex px-2 py-1 align-items-center">
                                          <div>
                                              <img src="./img/icons/clr/orion.png" alt="Country flag" width="40px">
                                          </div>
                                          <div class="ms-4">
                                              <p class="text-xs font-weight-bold mb-0">ORION (IN_CLR)</p>
                                              <h6 class="text-sm mb-0">Total / Trans</h6>
                                          </div>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $clr_today[0]->BY_CUST }}) #1</p>
                                          <h6 class="mb-0">฿{{ number_format($clr_today[0]->SUM_IN_VAT ?? 0) }} / {{ number_format($clr_today[0]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $clr_today[1]->BY_CUST }}) #2</p>
                                          <h6 class="mb-0">฿{{ number_format($clr_today[1]->SUM_IN_VAT ?? 0) }} / {{ number_format($clr_today[1]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $clr_today[2]->BY_CUST }}) #3</p>
                                          <h6 class="mb-0">฿{{ number_format($clr_today[2]->SUM_IN_VAT ?? 0) }} / {{ number_format($clr_today[2]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $clr_today[3]->BY_CUST }}) #4</p>
                                          <h6 class="mb-0">฿{{ number_format($clr_today[3]->SUM_IN_VAT ?? 0) }} / {{ number_format($clr_today[3]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $clr_today[4]->BY_CUST }}) #5</p>
                                          <h6 class="mb-0">฿{{ number_format($clr_today[4]->SUM_IN_VAT ?? 0) }} / {{ number_format($clr_today[4]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $clr_today[5]->BY_CUST }}) #6</p>
                                          <h6 class="mb-0">฿{{ number_format($clr_today[5]->SUM_IN_VAT ?? 0) }} / {{ number_format($clr_today[5]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $clr_today[6]->BY_CUST }}) #7</p>
                                          <h6 class="mb-0">฿{{ number_format($clr_today[6]->SUM_IN_VAT ?? 0) }} / {{ number_format($clr_today[6]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $clr_today[7]->BY_CUST }}) #8</p>
                                          <h6 class="mb-0">฿{{ number_format($clr_today[7]->SUM_IN_VAT ?? 0) }} / {{ number_format($clr_today[7]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $clr_today[8]->BY_CUST }}) #9</p>
                                          <h6 class="mb-0">฿{{ number_format($clr_today[8]->SUM_IN_VAT ?? 0) }} / {{ number_format($clr_today[8]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
              </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card ">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2">POS / ORION TOTAL</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center ">
                            <tbody>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/clr/orion.png" alt="Country flag" width="40px">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Type</p>
                                                <h6 class="text-sm mb-0">ORION</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Total</p>
                                            <h3 class="mb-0">฿{{ number_format($clr_total['orion_total']) }}</h3>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/clr/pos.png" alt="Country flag" width="40px">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Type</p>
                                                <h6 class="text-sm mb-0">POS</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Total</p>
                                            <h3 class="mb-0">฿{{ number_format($clr_total['pos_total']) }}</h3>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php /*<div class="col-lg-5">
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
                        </ul>
                    </div>
                </div>
            </div> */ ?>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ env('APP_URL') }}/assets/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');

        var gradientStroke2 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke2.addColorStop(1, 'rgba(45, 206, 204, 0.2)');
        gradientStroke2.addColorStop(0.2, 'rgba(45, 206, 204, 0.0)');
        gradientStroke2.addColorStop(0, 'rgba(45, 206, 204, 0)');

        var gradientStroke3 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke2.addColorStop(1, 'rgba(17, 205, 238, 0.2)');
        gradientStroke2.addColorStop(0.2, 'rgba(17, 205, 238, 0.0)');
        gradientStroke2.addColorStop(0, 'rgba(17, 205, 238, 0)');

        var gradientStroke4 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke2.addColorStop(1, 'rgba(131, 146, 171, 0.2)');
        gradientStroke2.addColorStop(0.2, 'rgba(131, 146, 171, 0.0)');
        gradientStroke2.addColorStop(0, 'rgba(131, 146, 171, 0)');
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: ["Day1", "Day2", "Day3"],
                datasets: [{
                    label: "POS",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#fb6340",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [{{ $clr_total['day1_pos'] }}, {{ $clr_total['day2_pos'] }}, {{ $clr_total['day3_pos'] }}],
                    maxBarThickness: 6

                },
                {
                    label: "ORION_IN_CLR",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#20c997",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [{{ $clr_total['day1_orion_in_clr'] }}, {{ $clr_total['day2_orion_in_clr'] }}, {{ $clr_total['day3_orion_in_clr'] }}],
                    maxBarThickness: 6

                },
                {
                    label: "ORION_SO_PRI",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#11cdef",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [{{ $clr_total['day1_orion_so_pri'] }}, {{ $clr_total['day2_orion_so_pri'] }}, {{ $clr_total['day3_orion_so_pri'] }}],
                    maxBarThickness: 6

                },
                {
                    label: "ORION_IN_DEP",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#8392ab",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [{{ $clr_total['day1_orion_in_dep'] }}, {{ $clr_total['day2_orion_in_dep'] }}, {{ $clr_total['day3_orion_in_dep'] }}],
                    maxBarThickness: 6

                }],

            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#fbfbfb',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#ccc',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    </script>
@endpush
