@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'SO Status'])
    <style>
    .loader{
      display: block;
      position: relative;
      height: 12px;
      width: 100%;
      border: 1px solid #fff;
      border-radius: 10px;
      overflow: hidden;
    }
    .loader::after {
      content: '';
      width: 40%;
      height: 100%;
      background: #FF3D00;
      position: absolute;
      top: 0;
      left: 0;
      box-sizing: border-box;
      animation: animloader 2s linear infinite;
    }

    @keyframes animloader {
      0% {
        left: 0;
        transform: translateX(-100%);
      }
      100% {
        left: 100%;
        transform: translateX(0%);
      }
    }

</style>

    <div class="container-fluid" >
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

                          <div class="col-sm-2">
                          <span class="text-xs font-weight-bold">SO NUMBER</span>
                          </div>
                          <div class="col-sm-2">
                            <input type="text" class="form-control" id="soh_no" name="soh_no" value="{{Request::input('soh_no') ?? '717608889'}}">
                          </div>
                          <div class="col-sm-2">
                            <span class="text-xs font-weight-bold">PO NUMBER</span>
                          </div>
                          <div class="col-sm-2">
                            <input type="text" class="form-control" id="po_number" name="po_number" value="{{Request::input('po_number') ?? ''}}">
                          </div>

                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group row">
                          <div class="col-sm-2">
                          <span class="text-xs font-weight-bold">CUSTOMER CODE</span>
                          </div>
                          <div class="col-sm-1">
                            <input type="text" class="form-control" id="soh_cust_code" name="soh_cust_code" value="{{Request::input('soh_cust_code') ?? ''}}">
                          </div>
                          <div class="col-sm-2">
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
                          <button type="submit" class="btn btn-primary btn-sm ms-auto text-uppercase text-xxs btn-submit" onclick="loader_data()">SEARCH</button>

                          &nbsp
                          <button type="button" id='btn-reset' class="btn btn-light btn-sm ms-auto text-uppercase text-secondary text-xxs">CLEAR</button>
                      </div>
                      <script type="text/javascript">
                        $(function(){
                          $('#btn-reset').click(function(){
                             $('input[type="text"]').val('');
                             $("#soh_txn_code").prop('selectedIndex', 0);
                          });
                        });
                      </script>
                      </form>
                      <span class="" id="loader_data"></span>
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
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STATUS</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">PO NUMBER</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SO DATE</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">CUSTOMER NAME</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">SALES NAME</th>
                                  </tr>
                              </thead>
                              <tbody>

                                  @if(isset($data))
                                    @if(count($data))
                                      @foreach ($data as $value)
                                      <tr>
                                        <td>
                                          <a onclick="get_sodetail('{{$value->id}}' , '{{$value->SOH_NO}}', '{{$value->SOH_TXN_CODE}}')">
                                            <div class="d-flex flex-column justify-content-center">
                                              <h6 class="mb-0 text-sm">
                                                <input type="hidden" name="search" id="search" value="1">
                                                <span class="btn btn-link text-danger text-gradient px-3 mb-0">{{$value->SOH_TXN_CODE.'-'.$value->SOH_NO}}</span>
                                              </h6>
                                            </div>
                                          </a>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                          @if($value->OVERALL_STATUS == 'Completed')
                                          <span class="badge badge-sm text-xs bg-gradient-faded-success">{{$value->OVERALL_STATUS}}</span>
                                          @else
                                          <span class="badge badge-sm text-xs bg-gradient-faded-dark-vertical">{{$value->OVERALL_STATUS}}</span>
                                          @endif
                                        </td>
                                        <td><span class="text-xs font-weight-bold">{{$value->SOH_LPO_NO}}</span></td>
                                        <td class="align-middle text-center"><span class="text-xs font-weight-bold">{{$value->SOH_DT}}</span></td>
                                        <td><span class="text-xs font-weight-bold">{{$value->SOH_CUST_CODE . '-' . $value->SOH_CUST_NAME}}</span></td>
                                        <td><span class="text-xs font-weight-bold">{{$value->SOH_SM_CODE.'-'.$value->SM_NAME}}</span></td>
                                      </tr>
                                      @endforeach
                                    @else
                                    <tr>
                                      <td colspan="6" class="text-center"></td>
                                    </tr>
                                    @endif
                                  @endif
                              </tbody>
                          </table>
                          @if(count($data))
                          <div class="card-footer pb-0">
                            {!! $data->appends(Request::except('page'))->links('pagination::bootstrap-4') !!}
                          </div>
                          <div class="card-footer pb-0">
                            <p class="small text-muted"> Showing {{ $page*$data->currentpage()-$page+1 }} to {{ $page*$data->currentpage() }} of {{ $data->total() }} results </p>
                            <span class="" id="loader_detail"></span>
                          </div>
                          @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sostatus-detail"></div>
        <div id="load_detail"></div>
        </div>

        <script type="text/javascript">

          $(function(){
            //$('#myModal').modal('show');
            if($('#search').val() == 1){
              load_buttom();
            }
          });

          function loader_data(){
            $('#loader_data').addClass('loader');
            //$('.btn-submit').prop('disabled',true);
            $('.btn-submit').attr('disabled', 'disabled');
            $('.btn-submit').parents('form').submit();
          }

          function load_buttom(){
            $('html,body').animate({ scrollTop: 9999 }, 'fast');
          }

          function get_sodetail(id,soh_no,soh_txn_code){
            $('#loader_detail').addClass('loader');
            let url = "{{ config('app.url').'/so-status/' }}" + id +'?SOH_NO=' + soh_no +'&SOH_TXN_CODE=' + soh_txn_code;
            $.ajax({
              method: "GET",
              url: url,
              data: {
              }
            }).done(function( msg ) {
              $('#loader_detail').removeClass('loader');
              $('.sostatus-detail').html(msg);
              load_buttom();
              //console.log(msg);
            });

          }
        </script>

    </div>
@endsection
