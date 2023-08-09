@extends('layouts.appguest', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    <div class="container-fluid py-4">

        <div class="row">

            <div class="col-12" style="z-index: 9;text-align: center;margin-bottom: 14px;">
              <h3 class="font-weight-bolder text-white mb-0">Clearance Sales 2023</h3>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">

                <div class="card">

                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Day 1</p>
                                    <h2 class="font-weight-bolder">
                                        ฿{{ number_format($clr_total[0]->sum_price + $clr_total[1]->sum_price) }}
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
                                        ฿{{ number_format($clr_total[2]->sum_price + $clr_total[3]->sum_price) }}
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
                                        ฿{{ number_format($clr_total[4]->sum_price + $clr_total[5]->sum_price) }}
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
                                        ฿{{ number_format($clr_total[0]->sum_price + $clr_total[1]->sum_price + $clr_total[2]->sum_price + $clr_total[3]->sum_price + $clr_total[4]->sum_price + $clr_total[5]->sum_price) }}
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
                                                <img src="./img/icons/clr/orion.png" alt="Country flag" width="40px">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Sales</p>
                                                <h4 class="mb-0">ORION</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY1</p>
                                            <h3 class="mb-0 text-success">฿{{ number_format($clr_total[0]->sum_price) }}</h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY2</p>
                                            <h3 class="mb-0 text-success">฿{{ number_format($clr_total[2]->sum_price) }}</h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY3</p>
                                            <h3 class="mb-0 text-success">฿{{ number_format($clr_total[4]->sum_price) }}</h3>
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
                                                <p class="text-xs font-weight-bold mb-0">Sales</p>
                                                <h4 class="mb-0">POS</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY1</p>
                                            <h3 class="mb-0 text-primary">฿{{ number_format($clr_total[1]->sum_price) }}</h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY2</p>
                                            <h3 class="mb-0 text-primary">฿{{ number_format($clr_total[3]->sum_price) }}</h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">DAY3</p>
                                            <h3 class="mb-0 text-primary">฿{{ number_format($clr_total[5]->sum_price) }}</h3>
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
                          <h6 class="mb-2">POS TODAY TOTAL</h6>
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
                                              <p class="text-xs font-weight-bold mb-0">Machine</p>
                                              <h6 class="text-sm mb-0">Value</h6>
                                          </div>
                                      </div>
                                  </td>
                                  <?php
                                    function search_pos_name($value){
                                      $pos_arr = [
                                        'POS 1' => '105817',
                                        'POS 2' => '124652',
                                        'POS 3' => '124653',
                                        'POS 4' => '124654',
                                        'POS 5' => '124655',
                                        'POS 6' => '124656',
                                        'POS 7' => '127164',
                                        'POS 8' => '140734',
                                        'POS 9' => '140735',
                                      ];

                                      $key = array_search($value, $pos_arr); // $key = 2;
                                      return $key;

                                    }
                                  ?>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">{{ search_pos_name($pos_total[0]->BY_CUST) }}</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_total[0]->sum_price) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">{{ search_pos_name($pos_total[1]->BY_CUST) }}</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_total[1]->sum_price) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">{{ search_pos_name($pos_total[2]->BY_CUST) }}</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_total[2]->sum_price) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">{{ search_pos_name($pos_total[3]->BY_CUST) }}</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_total[3]->sum_price) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">{{ search_pos_name($pos_total[4]->BY_CUST) }}</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_total[4]->sum_price) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">{{ search_pos_name($pos_total[5]->BY_CUST) }}</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_total[5]->sum_price) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">{{ search_pos_name($pos_total[6]->BY_CUST) }}</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_total[6]->sum_price) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">{{ search_pos_name($pos_total[7]->BY_CUST) }}</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_total[7]->sum_price) }}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="text-center">
                                          <p class="text-xs font-weight-bold mb-0">{{ search_pos_name($pos_total[8]->BY_CUST) }}</p>
                                          <h6 class="mb-0">฿{{ number_format($pos_total[8]->sum_price) }}</h6>
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
                                            <h3 class="mb-0">฿{{ number_format($clr_total[0]->sum_price + $clr_total[2]->sum_price + $clr_total[4]->sum_price) }}</h3>
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
                                            <h3 class="mb-0">฿{{ number_format($clr_total[1]->sum_price + $clr_total[3]->sum_price + $clr_total[5]->sum_price) }}</h3>
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
                        </ul>
                    </div>
                </div>
            </div>
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
                    data: [{{ $clr_total[1]->sum_price }}, {{ $clr_total[3]->sum_price }}, {{ $clr_total[5]->sum_price }}],
                    maxBarThickness: 6

                },
                {
                    label: "ORION",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#20c997",
                    backgroundColor: gradientStroke2,
                    borderWidth: 3,
                    fill: true,
                    data: [{{ $clr_total[0]->sum_price }}, {{ $clr_total[2]->sum_price }}, {{ $clr_total[4]->sum_price }}],
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
