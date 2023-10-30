@extends('layouts.appguest', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.guest.topnav', ['title' => 'Products'])

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="col-md-12 mb-lg-0 mb-4">
              <div class="card mt-4">
                  <div class="card-header pb-0 p-3">
                      <div class="row">
                          <div class="col-6 d-flex align-items-center">
                              <h6 class="mb-0">SO STATUS</h6>
                          </div>
                          <p class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">LAST UPDATE: {{ $last_upd ?? '' }}</p>
                      </div>
                  </div>
                  <div class="card-body p-3">
                    <form action="{{ ROUTE('so-status.index')}}" method="GET">
                      <div class="row">
                        <div class="form-group row">
                          <div class="col-sm-1">
                          <span class="text-xs font-weight-bold">TRANSACTION CODE</span>
                          </div>
                          <div class="col-sm-1">
                            <select class="form-control" id="soh_txn_code" name="soh_txn_code" style="-webkit-appearance:auto">
                              <option value=''>ALL</option>
                              <option value='SO_EXP' {{ (Request::input('soh_txn_code')) == 'SO_EXP' ? 'selected' : ''}}>SO_EXP</option>
                              <option value='SO_GEN' {{ (Request::input('soh_txn_code')) == 'SO_GEN' ? 'selected' : ''}}>SO_GEN</option>
                              <option value='SO_PRI' {{ (Request::input('soh_txn_code')) == 'SO_PRI' ? 'selected' : ''}}>SO_PRI</option>
                            </select>
                          </div>
                          <div class="col-sm-1">
                          <span class="text-xs font-weight-bold">SO NUMBER</span>
                          </div>
                          <div class="col-sm-1">
                            <input type="text" class="form-control" id="soh_no" name="soh_no" value="{{Request::input('soh_no') ?? ''}}">
                          </div>
                          <div class="col-sm-1">
                            <span class="text-xs font-weight-bold">PO NUMBER</span>
                          </div>
                          <div class="col-sm-1">
                            <input type="text" class="form-control" id="po_number" name="po_number" value="{{Request::input('po_number') ?? ''}}">
                          </div>

                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group row">
                          <div class="col-sm-1">
                          <span class="text-xs font-weight-bold">CUSTOMER CODE</span>
                          </div>
                          <div class="col-sm-1">
                            <input type="text" class="form-control" id="soh_cust_code" name="soh_cust_code" value="{{Request::input('soh_cust_code') ?? ''}}">
                          </div>
                          <div class="col-sm-1">
                          <span class="text-xs font-weight-bold">CUSTOMER NAME</span>
                          </div>
                          <div class="col-sm-2">
                            <input type="text" class="form-control" id="soh_cust_name" name="soh_cust_name" value="{{Request::input('soh_cust_name') ?? ''}}">
                          </div>
                          <div class="col-sm-1">
                            <span class="text-xs font-weight-bold">SALES CODE</span>
                          </div>
                          <div class="col-sm-1">
                            <input type="text" class="form-control" id="soh_sm_code" name="soh_sm_code" value="{{Request::input('soh_sm_code') ?? ''}}">
                          </div>
                          <div class="col-sm-1">
                          <span class="text-xs font-weight-bold">SALES NAME</span>
                          </div>
                          <div class="col-sm-2">
                            <input type="text" class="form-control" id="sm_name" name="sm_name" value="{{Request::input('sm_name') ?? ''}}">
                          </div>

                        </div>
                      </div>
                      <div class="align-items-center">
                          <button type="submit" class="btn btn-primary btn-sm ms-auto text-uppercase text-xxs">SEARCH</button> &nbsp
                          <button type="button" id='btn-reset' class="btn btn-light btn-sm ms-auto text-uppercase text-secondary text-xxs">CLEAR</button>
                      </div>
                      <script type="text/javascript">
                        $(function(){
                          $('#btn-reset').click(function(){
                             $('input[type="text"]').val('');
                             document.getElementById("soh_txn_code").options.length = 0;
                          });
                        });
                      </script>
                      </form>
                  </div>
              </div>
          </div>
        </div>
      </div>

        <div class="row">
            <div class="col-12 mt-4">
                <div class="card mb-4">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0" id="get-products">

                          <table class="table align-items-center mb-0">
                              <thead>
                                  <tr>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SO NUMBER</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">PO NUMBER</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SOH DT</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SOH LPO_NO</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">CUSTOMER NAME</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">SALES NAME</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">WAVE STATUS</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">POD STATUS</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php $chk_dup_item = []; ?>
                                  @if(isset($data))
                                    @if(count($data))
                                      @foreach ($data as $value)
                                      @if(!in_array($value->SOH_NO ,$chk_dup_item))
                                      <tr>
                                        <td>
                                          <a href="{{ ROUTE('so-status.show',$value['id']) . '?SOH_NO=' . $value['SOH_NO'] . '&POD_STATUS=' . $value['POD_STATUS'] }}">
                                            <div class="d-flex flex-column justify-content-center">
                                              <h6 class="mb-0 text-sm">
                                                <span class="btn btn-link text-danger text-gradient px-3 mb-0">{{$value['SOH_TXN_CODE'].'-'.$value['SOH_NO']}}</span>
                                              </h6>
                                            </div>
                                          </a>
                                        </td>
                                        <td><span class="text-xs font-weight-bold">{{$value['SOH_LPO_NO']}}</span></td>
                                        <td class="align-middle text-center"><span class="text-xs font-weight-bold">{{$value['SOH_DT']}}</span></td>
                                        <td class="align-middle text-center"><span class="text-xs font-weight-bold">{{$value['SOH_LPO_NO']}}</span></td>
                                        <td><span class="text-xs font-weight-bold">{{$value['SOH_CUST_CODE'] . '-' . $value['SOH_CUST_NAME']}}</span></td>
                                        <td><span class="text-xs font-weight-bold">{{$value['SOH_SM_CODE'].'-'.$value['SM_NAME']}}</span></td>
                                        <td class="align-middle text-center"><span class="text-xs font-weight-bold">

                                          <?php
                                            $is_wave = 'COMPLETE';
                                            foreach ($kp[$value['SOH_NO']] as $i => $r) {
                                              if($r != 'Pigeonhole Confirmed'){
                                                $is_wave = 'NOT COMPLETE';
                                                break;
                                              }
                                            }
                                            echo $is_wave;
                                           ?>
                                        </span></td>
                                        <td class="align-middle text-center"><span class="text-xs font-weight-bold">
                                        <?php
                                          $is_deliver = 'COMPLETE';
                                          foreach ($kl[$value['SOH_NO']] as $i => $r) {
                                            if($r != 'Delivered'){
                                              $is_deliver = 'NOT COMPLETE';
                                              break;
                                            }
                                          }
                                          echo $is_deliver;
                                         ?>
                                        </span></td>
                                        @endif
                                      </tr>
                                      <?php
                                        $chk_dup_item[] = $value->SOH_NO;
                                       ?>
                                      @endforeach
                                    @else
                                    <tr>
                                      <td></td>
                                    </tr>
                                    @endif
                                  @endif
                              </tbody>
                          </table>

                          <?php /* ?><div class="card-footer pb-0">
                            {!! $data->appends(Request::except('page'))->links('pagination::bootstrap-4') !!}
                          </div>
                          <div class="card-footer pb-0">
                            <p class="small text-muted"> Showing {{ 5*$data->currentpage()-5+1 }} to {{ 5*$data->currentpage() }} of {{ $data->total() }} results </p>
                          </div> <?php */ ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <!-- Modal -->
          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modal-title"></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="card">
                              <ul class="list-group">
                                  <li class="list-group-item border-0 d-flex p-4 mb-2 border-radius-lg">
                                      <div class="d-flex flex-column">
                                          <span class="text-xs">SOH_TXN_CODE: <span class="text-dark ms-sm-2 font-weight-bold" id="SOH_TXN_CODE"></span></span>
                                          <span class="text-xs">SOH_NO: <span class="text-dark ms-sm-2 font-weight-bold" id="SOH_NO"></span></span>
                                          <span class="text-xs">SOH_DT: <span class="text-dark ms-sm-2 font-weight-bold" id="SOH_DT"></span></span>
                                          <span class="text-xs">SOH_LPO_NO: <span class="text-dark ms-sm-2 font-weight-bold" id="SOH_LPO_NO"></span></span>
                                          <span class="text-xs">SOH_CUST_CODE: <span class="text-dark ms-sm-2 font-weight-bold" id="SOH_CUST_CODE"></span></span>
                                          <span class="text-xs">SOH_CUST_NAME: <span class="text-dark ms-sm-2 font-weight-bold" id="SOH_CUST_NAME"></span></span>
                                          <span class="text-xs">SOH_SM_CODE: <span class="text-dark ms-sm-2 font-weight-bold" id="SOH_SM_CODE"></span></span>
                                          <span class="text-xs">SM_NAME: <span class="text-dark ms-sm-2 font-weight-bold" id="SM_NAME"></span></span>
                                          <span class="text-xs">POD_STATUS: <span class="text-dark ms-sm-2 font-weight-bold" id="POD_STATUS"></span></span>

                                          <div class="table-responsive p-0">
                                              <table class="table align-items-center mb-0">
                                                  <thead>
                                                      <tr>
                                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Author</th>
                                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Function</th>
                                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employed</th>
                                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Author</th>
                                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Function</th>
                                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employed</th>
                                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Author</th>
                                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Function</th>
                                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <tr>
                                                          <td class="align-middle text-center"> <span class="text-secondary text-xs font-weight-bold">23/04/18</span> </td>
                                                          <td class="align-middle text-center"> <span class="text-secondary text-xs font-weight-bold">23/04/18</span> </td>
                                                          <td class="align-middle text-center"> <span class="text-secondary text-xs font-weight-bold">23/04/18</span> </td>
                                                          <td class="align-middle text-center"> <span class="text-secondary text-xs font-weight-bold">23/04/18</span> </td>
                                                          <td class="align-middle text-center"> <span class="text-secondary text-xs font-weight-bold">23/04/18</span> </td>
                                                          <td class="align-middle text-center"> <span class="text-secondary text-xs font-weight-bold">23/04/18</span> </td>
                                                          <td class="align-middle text-center"> <span class="text-secondary text-xs font-weight-bold">23/04/18</span> </td>
                                                          <td class="align-middle text-center"> <span class="text-secondary text-xs font-weight-bold">23/04/18</span> </td>
                                                          <td class="align-middle text-center"> <span class="text-secondary text-xs font-weight-bold">23/04/18</span> </td>
                                                          <td class="align-middle text-center"> <span class="text-secondary text-xs font-weight-bold">23/04/18</span> </td>
                                                          <td class="align-middle text-center"> <span class="text-secondary text-xs font-weight-bold">23/04/18</span> </td>
                                                      </tr>

                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>
                                  </li>
                              </ul>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <script type="text/javascript">
          $(function(){
            //$('#myModal').modal('show');

          });

          function get_sodetail(id){
            let url = "{{ config('app.url').'/so-status/' }}" + id;
            $.ajax({
              method: "GET",
              url: url,
              data: {
              }
            }).done(function( msg ) {
              $('#modal-title').html(msg['data']['SOH_NO']);

              $('#SOH_TXN_CODE').html(msg['data']['SOH_TXN_CODE']);
              $('#SOH_NO').html(msg['data']['SOH_NO']);
              $('#SOH_DT').html(msg['data']['SOH_DT']);
              $('#SOH_LPO_NO').html(msg['data']['SOH_LPO_NO']);
              $('#SOH_CUST_CODE').html(msg['data']['SOH_CUST_CODE']);
              $('#SOH_CUST_NAME').html(msg['data']['SOH_CUST_NAME']);
              $('#SOH_SM_CODE').html(msg['data']['SOH_SM_CODE']);
              $('#SM_NAME').html(msg['data']['SM_NAME']);
              $('#SOI_ITEM_CODE').html(msg['data']['SOI_ITEM_CODE']);
              $('#SOI_ITEM_DESC').html(msg['data']['SOI_ITEM_DESC']);
              $('#SOI_QTY').html(msg['data']['SOI_QTY']);
              $('#WAVE_ID').html(msg['data']['WAVE_ID']);
              $('#WWH_DT').html(msg['data']['WWH_DT']);
              $('#WAVE_STS').html(msg['data']['WAVE_STS']);
              $('#DO_NO').html(msg['data']['DO_NO']);
              $('#DO_DT').html(msg['data']['DO_DT']);
              $('#INV_NO').html(msg['data']['INV_NO']);
              $('#INV_DT').html(msg['data']['INV_DT']);
              $('#POD_STATUS').html(msg['data']['POD_STATUS']);
              $('#POD_DT').html(msg['data']['POD_DT']);
              $('#CREATED_DT').html(msg['data']['CREATED_DT']);

              $('#myModal').modal('show');
              console.log(msg);
            });
          }
        </script>

    </div>
@endsection
