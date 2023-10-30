@extends('layouts.appguest', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                      <?php
                        $all_param = '?';
                        foreach (Request::input() as $key => $value) {
                          $all_param .= $key.'='.$value.'&';
                        }
                      ?>
                      <a href="{{ ROUTE('so-status.index') . $all_param }}">
                        <div class="">
                            <button class="btn btn-primary btn-sm ms-auto">BACK</button>
                        </div>
                      </a>
                    </div>
                    <div class="card-body">
                        <h4 class="text-uppercase text-sm">SO NUMBER:<span class="text-info"> {{$data[0]['SOH_NO']}}</span></h4>
                        <h4 class="text-uppercase text-sm">PLO STATUS:<span class="text-danger"> {{$data[0]['POD_STATUS']}}</span></h4>
                        <hr class="horizontal dark">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-xs">TRANS CODE: <span class="text-dark font-weight-bold ms-sm-2">{{$data[0]['SOH_TXN_CODE']}}</span></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-xs">TRANS DATE: <span class="text-dark font-weight-bold ms-sm-2">{{$data[0]['SOH_DT']}}</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-xs">CUSTOMER CODE: <span class="text-dark font-weight-bold ms-sm-2">{{$data[0]['SOH_CUST_CODE']}}</span></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <span class="mb-2 text-xs">CUSTOMER NAME: <span class="text-dark font-weight-bold ms-sm-2">{{$data[0]['SOH_CUST_NAME']}}</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-xs">SALES CODE: <span class="text-dark font-weight-bold ms-sm-2">{{$data[0]['SOH_SM_CODE']}}</span></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <span class="mb-2 text-xs">SALES NAME: <span class="text-dark font-weight-bold ms-sm-2">{{$data[0]['SM_NAME']}}</span></span>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Detail</p>
                        <div class="row">
                            <div class="col-md-12">
                              <div class="table-responsive p-0">
                                  <table class="table align-items-center mb-0">
                                      <thead>
                                          <tr>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ITEM CODE</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ITEM DESC</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">SOI QTY</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">PENDING</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">DO QTY</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">WAVE DATE</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">WAVE STATUS</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">DELIVERY NUMBER</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">DELIVERY DATE</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">INVOICE NUMBER</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">INVOICE DATE</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">POD DT</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php $chk_dup_item = []; ?>
                                          @foreach($data as $value)

                                          <tr>
                                              <td><p class="text-secondary text-xs font-weight-bold">
                                                  @if(!in_array($value->SOI_ITEM_CODE ,$chk_dup_item))
                                                    {{ $value->SOI_ITEM_CODE }}
                                                  @endif
                                              </p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">
                                                @if(!in_array($value->SOI_ITEM_CODE ,$chk_dup_item))
                                                  {{$value->SOI_ITEM_DESC}}
                                                @endif
                                              </p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">
                                                @if(!in_array($value->SOI_ITEM_CODE ,$chk_dup_item))
                                                  {{$value->SOI_QTY}}
                                                @endif
                                              </p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">
                                                @if(!in_array($value->SOI_ITEM_CODE ,$chk_dup_item))
                                                  {{$value->SOI_QTY - array_sum($kl[$value->SOI_ITEM_CODE]) }}
                                                @endif
                                              </p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->INV_QTY}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->WWH_DT}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->WAVE_STS}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->DO_NO}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->DO_DT}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->INV_NO}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->INV_DT}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->POD_DT}}</p></td>
                                          </tr>
                                          {{ $chk_dup_item[] = $value->SOI_ITEM_CODE }}
                                          @endforeach
                                      </tbody>
                                  </table>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
