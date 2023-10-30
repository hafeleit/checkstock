@extends('layouts.appguest', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                      <?php
                      $param_search = '?';
                      $param_search .= (session()->has('soh_txn_code')) ? 'soh_txn_code=' . Session::get('soh_txn_code') .'&' : '';
                      $param_search .= (session()->has('soh_no')) ? 'soh_no=' . Session::get('soh_no') .'&' : '';
                      $param_search .= (session()->has('soh_cust_code')) ? 'soh_cust_code=' . Session::get('soh_cust_code') .'&' : '';
                      $param_search .= (session()->has('soh_cust_name')) ? 'soh_cust_name=' . Session::get('soh_cust_name') .'&' : '';
                      $param_search .= (session()->has('soh_sm_code')) ? 'soh_sm_code=' . Session::get('soh_sm_code') .'&' : '';
                      $param_search .= (session()->has('sm_name')) ? 'sm_name=' . Session::get('sm_name') .'&' : '';
                      $param_search .= (session()->has('po_number')) ? 'po_number=' . Session::get('po_number') .'&' : '';
                      ?>
                      <a href="{{ ROUTE('so-status.index') . $param_search}}">
                        <div class="">
                            <button class="btn btn-primary btn-sm ms-auto">BACK</button>
                        </div>
                      </a>
                    </div>
                    <div class="card-body">
                        <h4 class="text-uppercase text-sm">SO NUMBER:<span class="text-info"> {{$data[0]['SOH_TXN_CODE'].'-'.$data[0]['SOH_NO']}}</span></h4>
                        <h4 class="text-uppercase text-sm">PLO STATUS:<span class="text-danger"> {{$data[0]['POD_STATUS']}}</span></h4>
                        <hr class="horizontal dark">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span class="mb-2 text-xs">TRANS DATE: <span class="text-dark font-weight-bold ms-sm-2">{{$data[0]['SOH_DT']}}</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="mb-2 text-xs">CUSTOMER: <span class="text-dark font-weight-bold ms-sm-2">{{$data[0]['SOH_CUST_CODE'] .'-' .$data[0]['SOH_CUST_NAME']}}</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="mb-2 text-xs">SALES CODE: <span class="text-dark font-weight-bold ms-sm-2">{{$data[0]['SOH_SM_CODE'].'-'.$data[0]['SM_NAME']}}</span></span>
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
                                          <?php
                                            $chk_dup_item[] = $value->SOI_ITEM_CODE;
                                           ?>
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
