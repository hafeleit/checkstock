@extends('layouts.appguest', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    <div class="container-fluid py-4">

        <div class="row">

            <div class="col-12" style="z-index: 9;text-align: center;margin-bottom: 14px;">
              <h3 class="font-weight-bolder text-white mb-0">Big Clearance Sale 2025</h3>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">

                <div class="card">

                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Day 1</p>
                                    <h2 class="font-weight-bolder">
                                        {{ ($clr_total['day1_total'] > 0) ? number_format($clr_total['day1_total']) : '-' }}
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
                                        {{ ($clr_total['day2_total'] > 0) ? number_format($clr_total['day2_total']) : '-' }}
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
                                        {{ ($clr_total['day3_total'] > 0) ? number_format($clr_total['day3_total']) : '-' }}
                                        <p class="mb-0" style="position: absolute;bottom: 4px;right: 20px;font-size: 14px;"></p>
                                        <?php /* <p class="mb-0" style="position: absolute;bottom: 4px;right: 20px;font-size: 14px;">Last update: 20:00</p> */ ?>
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
                                        {{ ($clr_total['day_total'] > 0) ? number_format($clr_total['day_total']) : '-' }}
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
                <div class="card z-index-2 h-80">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Turnover All</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line2" class="chart-canvas" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-80">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Turnover (POS,ZOS)</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php  /* ?>
        <div class="row mt-4">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-body p-3">
                        <h6 class="text-capitalize">Amount Summary (Today)</h6>
                        <div class="chart">
                            <canvas id="BarChart" class="chart-canvas" height="70"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-body p-3">
                        <h6 class="text-capitalize">Transaction Summary (Today)</h6>
                        <div class="chart">
                            <canvas id="BarChart2" class="chart-canvas" height="70"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">

            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-body p-3">
                        <div class="progress-info" style="display: flex;margin-bottom: 0.5rem;align-items: center;justify-content: space-between;">
                          <div class="progress-label">
                            <span>Target Mission</span>
                          </div>
                          <div class="progress-percentage">
                            <span>90%</span>
                          </div>
                        </div>
                        <div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 90%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php */ ?>
        <div class="row mt-4">
          <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="card " style="height: 100%;">
                  <div class="card-header pb-0 p-3">
                      <div class="d-flex justify-content-between">
                          <h6 class="mb-2">Summary All (POS,ZOS)</h6>
                      </div>
                  </div>
                  <div class="table-responsive">
                      <table class="table align-items-center ">
                          <tbody>

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
                                          <h3 class="mb-0">{{ number_format($clr_total['pos_total']) }}</h3>
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
                                              <p class="text-xs font-weight-bold mb-0">Type</p>
                                              <h6 class="text-sm mb-0">ZOS</h6>
                                          </div>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">Total</p>
                                          <h3 class="mb-0">{{ number_format($clr_total['orion_total']) }}</h3>
                                      </div>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
            <div class="col-lg-6">
                <div class="card card-carousel overflow-hidden h-100 p-0 ">
                    <div class="table-responsive">
                        <div class="card-header pb-0 p-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-2">Day Summary</h6>
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
                                            <h3 class="mb-0 text-primary">{{ number_format($clr_total['day1_pos']) }}</h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY2</p>
                                            <h3 class="mb-0 text-primary">{{ number_format($clr_total['day2_pos']) }}</h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY3</p>
                                            <h3 class="mb-0 text-primary">{{ number_format($clr_total['day3_pos']) }}</h3>
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
                                                <h4 class="mb-0">ZOS</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY1</p>
                                            <h3 class="mb-0 text-success">{{ number_format($clr_total['day1_orion_in_clr']) }}</h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY2</p>
                                            <h3 class="mb-0 text-success">{{ number_format($clr_total['day2_orion_in_clr']) }}</h3></h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY3</p>
                                            <h3 class="mb-0 text-success">{{ number_format($clr_total['day3_orion_in_clr']) }}</h3></h3>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
              <div class="card ">
                  <div class="card-header pb-0 p-3">
                      <div class="d-flex justify-content-between">
                          <h6 class="mb-2">Summary (Today)</h6>
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
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[0]->BY_CUST ?? 0 }}) #1</p>
                                          <h6 class="mb-0">{{ number_format($pos_today[0]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[0]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[1]->BY_CUST ?? 0 }}) #2</p>
                                          <h6 class="mb-0">{{ number_format($pos_today[1]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[1]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[2]->BY_CUST ?? 0 }}) #3</p>
                                          <h6 class="mb-0">{{ number_format($pos_today[2]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[2]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[3]->BY_CUST ?? 0 }}) #4</p>
                                          <h6 class="mb-0">{{ number_format($pos_today[3]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[3]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[4]->BY_CUST ?? 0 }}) #5</p>
                                          <h6 class="mb-0">{{ number_format($pos_today[4]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[4]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[5]->BY_CUST ?? 0 }}) #6</p>
                                          <h6 class="mb-0">{{ number_format($pos_today[5]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[5]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[6]->BY_CUST ?? 0 }}) #7</p>
                                          <h6 class="mb-0">{{ number_format($pos_today[6]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[6]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[7]->BY_CUST ?? 0 }}) #8</p>
                                          <h6 class="mb-0">{{ number_format($pos_today[7]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[7]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pos_today[8]->BY_CUST ?? 0 }}) #9</p>
                                          <h6 class="mb-0">{{ number_format($pos_today[8]->SUM_IN_VAT ?? 0) }} / {{ number_format($pos_today[8]->CNT_IN_VAT ?? 0) }}</h6>
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
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[0]->BY_CUST ?? 0 }}) #1</p>
                                          <h6 class="mb-0">{{ number_format($pri_today[0]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[0]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[1]->BY_CUST ?? 0 }}) #2</p>
                                          <h6 class="mb-0">{{ number_format($pri_today[1]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[1]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[2]->BY_CUST ?? 0 }}) #3</p>
                                          <h6 class="mb-0">{{ number_format($pri_today[2]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[2]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[3]->BY_CUST ?? 0 }}) #4</p>
                                          <h6 class="mb-0">{{ number_format($pri_today[3]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[3]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[4]->BY_CUST ?? 0 }}) #5</p>
                                          <h6 class="mb-0">{{ number_format($pri_today[4]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[4]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[5]->BY_CUST ?? 0 }}) #6</p>
                                          <h6 class="mb-0">{{ number_format($pri_today[5]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[5]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[6]->BY_CUST ?? 0 }}) #7</p>
                                          <h6 class="mb-0">{{ number_format($pri_today[6]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[6]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $pri_today[7]->BY_CUST ?? 0 }}) #8</p>
                                          <h6 class="mb-0">{{ number_format($pri_today[7]->SUM_IN_VAT ?? 0) }} / {{ number_format($pri_today[7]->CNT_IN_VAT ?? 0) }}</h6>
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
                                          <p class="text-xs font-weight-bold mb-0">({{ $clr_today[0]->BY_CUST ?? 0 }}) #1</p>
                                          <h6 class="mb-0">{{ number_format($clr_today[0]->SUM_IN_VAT ?? 0) }} / {{ number_format($clr_today[0]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $clr_today[1]->BY_CUST ?? 0 }}) #2</p>
                                          <h6 class="mb-0">{{ number_format($clr_today[1]->SUM_IN_VAT ?? 0) }} / {{ number_format($clr_today[1]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">({{ $clr_today[2]->BY_CUST ?? 0 }}) #3</p>
                                          <h6 class="mb-0">{{ number_format($clr_today[2]->SUM_IN_VAT ?? 0) }} / {{ number_format($clr_today[2]->CNT_IN_VAT ?? 0) }}</h6>
                                      </div>
                                  </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
              </div>
            </div>
        </div>-->

    </div>
@endsection

@push('js')
    <script src="{{ env('APP_URL') }}/assets/js/plugins/chartjs.min.js"></script>
    <script>
       setTimeout(function(){
           window.location.reload();
       }, 600000);
        var ctx1 = document.getElementById("chart-line").getContext("2d");
        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
        gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');

        new Chart(ctx1, {
            type: "line",
            data: {
                //labels: ["Day1", "Day2", "Day3"],
                labels: ["zero","Day1", "Day2", "Day3"],
                datasets: [{
                    label: "POS",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#fb6340",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    //data: [{{ $clr_total['day1_pos'] }}, {{ $clr_total['day2_pos'] }}, {{ $clr_total['day3_pos'] }}],
                    data: [ 0,{{ $clr_total['day1_pos'] }}, {{ $clr_total['day2_pos'] }}, {{ $clr_total['day3_pos'] }}],
                    maxBarThickness: 6

                },
                {
                    label: "ZOS",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#20c997",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [
                      0,
                      {{ $clr_total['day1_orion_in_clr'] + $clr_total['day1_orion_so_pri'] + $clr_total['day1_orion_in_dep'] }},
                      {{ $clr_total['day2_orion_in_clr'] + $clr_total['day2_orion_so_pri'] + $clr_total['day2_orion_in_dep'] }},
                      {{ $clr_total['day3_orion_in_clr'] + $clr_total['day3_orion_so_pri'] + $clr_total['day3_orion_in_dep'] }},
                    ],
                    maxBarThickness: 6

                }],

            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
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
                            color: '#69707b',
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

        var ctx_2 = document.getElementById("chart-line2").getContext("2d");
        var gradientStroke_2 = ctx_2.createLinearGradient(0, 230, 0, 50);
        gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');

        new Chart(ctx_2, {
            type: "line",
            data: {
                //labels: ["Day1", "Day2", "Day3"],
                labels: ["zero","Day1", "Day2", "Day3"],
                datasets: [{
                    label: "TOTAL",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#fb6340",
                    backgroundColor: gradientStroke_2,
                    borderWidth: 3,
                    fill: true,
                    //data: [{{ $clr_total['day1_total'] }}, {{ $clr_total['day2_total'] }}, {{ $clr_total['day3_total'] }}],
                    data: [0,{{ $clr_total['day1_total'] }}, {{ $clr_total['day2_total'] }}, {{ $clr_total['day3_total'] }}],
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
                            color: '#69707b',
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

        /* Bar chart */
        const ctx = document.getElementById('BarChart');

        new Chart(ctx, {
         type: 'bar',
         data: {
           labels: ['Counter 1', 'Counter 2', 'Counter 3', 'Counter 4', 'Counter 5', 'Counter 6', 'Counter 7', 'Counter 8', 'Counter 9'],
           datasets: [
             {
               label: 'POS',
               data: [{{$pos_today[0]->SUM_IN_VAT ?? 0}}, {{$pos_today[1]->SUM_IN_VAT ?? 0}}, {{$pos_today[2]->SUM_IN_VAT ?? 0}}, {{$pos_today[3]->SUM_IN_VAT ?? 0}}, {{$pos_today[4]->SUM_IN_VAT ?? 0}}, {{$pos_today[5]->SUM_IN_VAT ?? 0}}, {{$pos_today[6]->SUM_IN_VAT ?? 0}}, {{$pos_today[7]->SUM_IN_VAT ?? 0}}, {{$pos_today[8]->SUM_IN_VAT ?? 0}}],
               backgroundColor: [
                'rgba(255, 159, 64, 0.2)',
              ],borderColor: [
                'rgb(255, 99, 132)',
              ],borderWidth: 1
            },
            {
              label: 'ORION(IN_CLR)',
              data: [{{$clr_today[0]->SUM_IN_VAT ?? 0}}, {{$clr_today[1]->SUM_IN_VAT ?? 0}}, {{$clr_today[2]->SUM_IN_VAT ?? 0}}, {{$clr_today[3]->SUM_IN_VAT ?? 0}}, {{$clr_today[4]->SUM_IN_VAT ?? 0}}, {{$clr_today[5]->SUM_IN_VAT ?? 0}}, {{$clr_today[6]->SUM_IN_VAT ?? 0}}, {{$clr_today[7]->SUM_IN_VAT ?? 0}}],
              backgroundColor: [
              'rgba(75, 192, 192, 0.2)',
             ],borderColor: [
               'rgb(75, 192, 192)',
             ],borderWidth: 1
           },
           {
             label: 'ORION(SO_PRI)',
             data: [{{$pri_today[0]->SUM_IN_VAT ?? 0}}, {{$pri_today[1]->SUM_IN_VAT ?? 0}}, {{$pri_today[2]->SUM_IN_VAT ?? 0}}, {{$pri_today[3]->SUM_IN_VAT ?? 0}}, {{$pri_today[4]->SUM_IN_VAT ?? 0}}, {{$pri_today[5]->SUM_IN_VAT ?? 0}}, {{$pri_today[6]->SUM_IN_VAT ?? 0}}, {{$pri_today[7]->SUM_IN_VAT ?? 0}}, {{$pri_today[8]->SUM_IN_VAT ?? 0}}],
             backgroundColor: [
              'rgba(54, 162, 235, 0.2)',

            ],borderColor: [
              'rgb(54, 162, 235)',
            ],borderWidth: 1
          }
         ]
         },
         options: {
           scales: {
             y: {
               beginAtZero: true
             }
           }
         }
        });

        const ctx2 = document.getElementById('BarChart2');

        new Chart(ctx2, {
         type: 'bar',
         data: {
           labels: ['Counter 1', 'Counter 2', 'Counter 3', 'Counter 4', 'Counter 5', 'Counter 6', 'Counter 7', 'Counter 8', 'Counter 9'],
           datasets: [
             {
               label: 'POS',
               data: [{{ $pos_today[0]->CNT_IN_VAT ?? 0 }}, {{ $pos_today[1]->CNT_IN_VAT ?? 0 }}, {{ $pos_today[2]->CNT_IN_VAT ?? 0 }}, {{ $pos_today[3]->CNT_IN_VAT ?? 0 }}, {{ $pos_today[4]->CNT_IN_VAT ?? 0 }}, {{ $pos_today[5]->CNT_IN_VAT ?? 0 }}, {{ $pos_today[6]->CNT_IN_VAT ?? 0 }}, {{ $pos_today[7]->CNT_IN_VAT ?? 0 }}, {{ $pos_today[8]->CNT_IN_VAT ?? 0 }}],
               backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
              ],borderColor: [
                'rgb(255, 99, 132)',
              ],borderWidth: 1
            },
            {
              label: 'ORION(IN_CLR)',
              data: [{{ $clr_today[0]->CNT_IN_VAT ?? 0 }}, {{ $clr_today[1]->CNT_IN_VAT ?? 0 }}, {{ $clr_today[2]->CNT_IN_VAT ?? 0 }}, {{ $clr_today[3]->CNT_IN_VAT ?? 0 }}, {{ $clr_today[4]->CNT_IN_VAT ?? 0 }}, {{ $clr_today[5]->CNT_IN_VAT ?? 0 }}, {{ $clr_today[6]->CNT_IN_VAT ?? 0 }}, {{ $clr_today[7]->CNT_IN_VAT ?? 0 }}, {{ $clr_today[8]->CNT_IN_VAT ?? 0 }}],
              backgroundColor: [
              'rgba(255, 205, 86, 0.2)',
             ],borderColor: [
               'rgb(255, 205, 86)',
             ],borderWidth: 1
           },
           {
             label: 'ORION(SO_PRI)',
             data: [{{ $pri_today[0]->CNT_IN_VAT ?? 0 }}, {{ $pri_today[1]->CNT_IN_VAT ?? 0 }}, {{ $pri_today[2]->CNT_IN_VAT ?? 0 }}, {{ $pri_today[3]->CNT_IN_VAT ?? 0 }}, {{ $pri_today[4]->CNT_IN_VAT ?? 0 }}, {{ $pri_today[5]->CNT_IN_VAT ?? 0 }}, {{ $pri_today[6]->CNT_IN_VAT ?? 0 }}, {{ $pri_today[7]->CNT_IN_VAT ?? 0 }}, {{ $pri_today[8]->CNT_IN_VAT ?? 0 }}],
             backgroundColor: [
              'rgba(153, 102, 255, 0.2)',

            ],borderColor: [
              'rgb(153, 102, 255)',
            ],borderWidth: 1
          }
         ]
         },
         options: {
           scales: {
             y: {
               beginAtZero: true
             }
           }
         }
        });
    </script>
@endpush
