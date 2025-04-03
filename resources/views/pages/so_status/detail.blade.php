        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                      <?php
                      /*$param_search = '?';
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
                      </a> <?php */ ?>
                    </div>
                    <div class="card-body">
                      <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <span class="mb-2 text-xs">SO NUMBER: <span class="text-danger font-weight-bold ms-sm-2">{{$data[0]->SOH_TXN_CODE.'-'.$data[0]->SOH_NO}}</span></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                  <span class="mb-2 text-xs">SO STATUS:
                                  @if($data[0]->OVERALL_STATUS == 'Completed')
                                  <span class="badge badge-sm text-xs bg-gradient-faded-success">{{$data[0]->OVERALL_STATUS}}</span>
                                  @else
                                  <span class="badge badge-sm text-xs bg-gradient-faded-dark-vertical">{{$data[0]->OVERALL_STATUS}}</span>
                                  @endif
                                  </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                              <div class="form-group">
                                  <span class="mb-2 text-xs">SO DATE: <span class="text-dark font-weight-bold ms-sm-2">{{$data[0]->SOH_DT}}</span></span>
                              </div>
                          </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="mb-2 text-xs">CUSTOMER: <span class="text-dark font-weight-bold ms-sm-2">{{$data[0]->SOH_CUST_CODE .'-' .$data[0]->SOH_CUST_NAME}}</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="mb-2 text-xs">SALES CODE: <span class="text-dark font-weight-bold ms-sm-2">{{$data[0]->SOH_SM_CODE.'-'.$data[0]->SM_NAME}}</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <hr class="horizontal dark">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                              <h6>Detail</h6>
                              <div class="table-responsive p-0">
                                  <table class="table align-items-center mb-0">
                                      <thead>
                                          <tr>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ITEM CODE</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ITEM DESC</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">SO</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">PENDING QTY</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">DO QTY</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">DELIVERY NUMBER</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">DELIVERY DATE</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">WAVE DATE</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">WAVE STATUS</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">INVOICE NUMBER</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">INVOICE DATE</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">POD STATUS</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php $chk_dup_item = []; ?>
                                          @foreach($data as $value)

                                          <tr>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->SOI_ITEM_CODE}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->SOI_ITEM_DESC}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->SOI_QTY}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->INV_QTY}}</p></td>

                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->INV_QTY}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->DO_NO}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->DO_DT}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->WWH_DT}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->WAVE_STS}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->INV_NO}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->INV_DT}}</p></td>
                                              <td><p class="text-secondary text-xs font-weight-bold">{{$value->POD_STATUS}}</p></td>
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
