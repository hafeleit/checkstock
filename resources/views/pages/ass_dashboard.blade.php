<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ env('APP_URL') }}/img/hafele_logo.png">
    <link rel="icon" type="../image/png" href="{{ env('APP_URL') }}/img/hafele_logo.png">
    <title>
        HAFELE APPLICATION
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ env('APP_URL') }}/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ env('APP_URL') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ env('APP_URL') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ env('APP_URL') }}/assets/css/argon-dashboard.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style media="screen">

      th {
        background-color: rgb(214 51 51);
        border: 1px solid rgb(211 159 159);
         font-weight: normal;
         text-align: center;
         color: white;
      }

      td {
        padding: .5em;
        vertical-align: middle;
        border: 1px solid rgb(211 159 159);
        text-align: center;
      }

      tbody,
      tr,
      th,
      td {
        padding: 0;
      }

      .color-crimson{
        color: crimson;
      }
    </style>
</head>

<body class="{{ $class ?? '' }}">


  <div class="position-absolute w-100" style="height:65%; background: linear-gradient(0deg, #fafafa , #ad001e );"></div>
    <div class="container-fluid py-4">
        <div class="row">
          <div class="col-12" style="z-index: 9;text-align: center;margin-bottom: 14px;">
            <h3 class="font-weight-bolder text-white mb-0">Dashboard Tecnicial Capacity</h3>
            <h3 class="font-weight-bolder text-white mb-0">
              <a href="{{ route('ass_dashboard') . '?from_date=' . $pre_month}}" style="color:#f29090"><&nbsp&nbsp&nbsp</a>
              {{ $curr_date }}
              <a href="{{ route('ass_dashboard') . '?from_date=' . $next_month}}" style="color:#f29090">&nbsp&nbsp&nbsp></a></h3>
          </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-80">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h5 class="text-capitalize color-crimson">Northeastern region</h5>
                    </div>
                    <table class="">
                      <thead>
                        <tr>
                          <th rowspan="2" style="background: brown;"></th>
                          <th colspan="{{$lastday+1}}">DAY</th>
                        </tr>
                        <tr>
                          @for($i=0;$i<$lastday;$i++)
                          <th>{{ $i+1 }}</th>
                          @endfor
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($northeastern as $value)
                        <tr>
                          <?php
                          for ($i=0; $i <= $lastday; $i++) {
                            if(isset($value[$i])){
                              echo '<td>'.$value[$i].'</td>';
                            }else{
                              echo '<td>0</td>';
                            }
                          }
                          ?>
                        </tr>
                        @endforeach

                      </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-80">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h5 class="text-capitalize color-crimson">South</h5>
                    </div>
                    <table>
                      <thead>
                        <tr>
                          <th rowspan="2" style="background: brown;"></th>
                          <th colspan="{{$lastday+1}}">DAY</th>
                        </tr>
                        <tr>
                          @for($i=0;$i<$lastday;$i++)
                          <th>{{ $i+1 }}</th>
                          @endfor
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($south as $value)
                        <tr>
                          <?php
                          for ($i=0; $i <= $lastday; $i++) {
                            if(isset($value[$i])){
                              echo '<td>'.$value[$i].'</td>';
                            }else{
                              echo '<td>0</td>';
                            }
                          }
                          ?>
                        </tr>
                        @endforeach

                      </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="row mt-4">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-80">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h5 class="text-capitalize color-crimson">Central region</h5>
                    </div>
                    <table>
                      <thead>
                        <tr>
                          <th rowspan="2" style="background: brown;"></th>
                          <th colspan="{{$lastday+1}}">DAY</th>
                        </tr>
                        <tr>
                          @for($i=0;$i<$lastday;$i++)
                          <th>{{ $i+1 }}</th>
                          @endfor
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($central as $value)
                        <tr>
                          <?php
                          for ($i=0; $i <= $lastday; $i++) {
                            if(isset($value[$i])){
                              echo '<td>'.$value[$i].'</td>';
                            }else{
                              echo '<td>0</td>';
                            }
                          }
                          ?>
                        </tr>
                        @endforeach

                      </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-80">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h5 class="text-capitalize color-crimson">HTH</h5>
                    </div>
                    <table>
                      <thead>
                        <tr>
                          <th rowspan="2" style="background: brown;"></th>
                          <th colspan="{{$lastday+1}}">DAY</th>
                        </tr>
                        <tr>
                          @for($i=0;$i<$lastday;$i++)
                          <th>{{ $i+1 }}</th>
                          @endfor
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($hth as $value)
                        <tr>
                          <?php
                          for ($i=0; $i <= $lastday; $i++) {
                            if(isset($value[$i])){
                              echo '<td>'.$value[$i].'</td>';
                            }else{
                              echo '<td>0</td>';
                            }
                          }
                          ?>
                        </tr>
                        @endforeach

                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
