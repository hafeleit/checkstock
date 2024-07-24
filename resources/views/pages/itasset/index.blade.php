@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav', ['title' => 'Asset List'])
<style media="screen">
  .dt-layout-row{
    padding: 1.5rem;
  }

  .dt-layout-row.dt-layout-table{
    padding: 0rem;
  }
</style>
<div class="container-fluid py-4">
  <div class="row">
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
              <div class="card-body p-3">
                  <div class="row">
                      <div class="col-8">
                          <div class="numbers">
                              <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Asset</p>
                              <h5 class="font-weight-bolder">
                                  {{ NUMBER_FORMAT($itassets_cnt) ?? '' }}
                              </h5>
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
                              <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Notebooks</p>
                              <h5 class="font-weight-bolder">
                                  {{ NUMBER_FORMAT($total_notebook) ?? '' }}
                              </h5>
                          </div>
                      </div>
                      <div class="col-4 text-end">
                          <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                              <i class="ni ni-laptop text-lg opacity-10" aria-hidden="true"></i>
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
                              <p class="text-sm mb-0 text-uppercase font-weight-bold">Total PC</p>
                              <h5 class="font-weight-bolder">
                                  {{ NUMBER_FORMAT($total_pc) ?? '' }}
                              </h5>
                          </div>
                      </div>
                      <div class="col-4 text-end">
                          <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                              <i class="ni ni-tv-2 text-lg opacity-10" aria-hidden="true"></i>
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
                              <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Spare</p>
                              <h5 class="font-weight-bolder">
                                  {{ NUMBER_FORMAT($total_spare) ?? '' }}
                              </h5>
                          </div>
                      </div>
                      <div class="col-4 text-end">
                          <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                              <i class="ni ni-ui-04 text-lg opacity-10" aria-hidden="true"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="row mt-4">
    <div class="col-12">

      <div class="card">
        <div class="card-header pb-0">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
          <div class="d-lg-flex">
            <div>
              <h5 class="mb-0">All Asset</h5>
            </div>
            <div class="ms-auto my-auto mt-lg-0 mt-4">
              <div class="ms-auto my-auto">
                @can('itasset create')
                <a href="{{ route('itasset.create') }}" class="btn bg-gradient-primary btn-sm mb-0" target="_blank">+&nbsp; New Asset</a>
                @endcan
                <!--<button type="button" class="btn btn-outline-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#import"> Import </button>-->

                <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog mt-lg-10">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">Import CSV</h5>
                        <i class="fas fa-upload ms-3" aria-hidden="true"></i>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="{{ route('usermaster-import') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-body">
                        <p>You can browse your computer for a file.</p>
                        <input type="file" placeholder="Browse file..." class="form-control mb-3" name="file">

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary btn-sm">Upload</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>

                <a class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" href="{{ route('itasset-export') }}">Export</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-0">
          <div class="table-responsive">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
              <div class="dataTable-container">
                <table class="table table-flush dataTable-table" id="products-list">
                  <thead class="thead-light">
                    <tr>
                      <th >
                        <a href="#" class="">ID</a>
                      </th>
                      <th >
                        <a href="#" class="">COMPUTER NAME</a>
                      </th>
                      <th >
                        <a href="#" class="">CURRENT USER</a>
                      </th>
                      <th >
                        <a href="#" class="">OLD USER</a>
                      </th>
                      <th >
                        <a href="#" class="">SERIAL NUMBER</a>
                      </th>
                      <th >
                        <a href="#" class="">FIX ASSET NO.</a>
                      </th>
                      <!--
                      <th >
                        <a href="#" class="">PURCHASE DATE</a>
                      </th>
                      <th >
                        <a href="#" class="">WARRANTY</a>
                      </th>
                      <th >
                        <a href="#" class="">EXPIRE DATE</a>
                      </th>-->
                      <th >
                        <a href="#" class="">STATUS</a>
                      </th>
                      <th >
                        <a href="#" class="">ACTION</a>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($itassets as $itasset)
                    <tr>
                      <td>{{$itasset->id}}</td>
                      <td>
                        <div class="d-flex">
                          @switch($itasset->type)
                            @case('NOTEBOOK')
                              <img class="w-10" src="{{ URL::to('/') }}/img/itasset/macbook-pro.jpg" alt="hoodie">
                            @break
                            @case('PRINTER')
                              <img class="w-10" src="{{ URL::to('/') }}/img/itasset/printer-fuji.jpg" alt="hoodie">
                            @break
                            @case('PC')
                              <img class="w-10" src="{{ URL::to('/') }}/img/itasset/pc.jpg" alt="hoodie">
                            @break
                            @default
                              <img class="w-100 border-radius-lg shadow-lg mt-3" src="" alt="product_image">
                          @endswitch
                          <a href="{{ route('itasset.show',$itasset->id) }}"><h6 class="ms-3 my-auto">{{$itasset->computer_name}}</h6></a>
                        </div>
                      </td>
                      <td class="text-sm">{{$itasset->user . ' ' .$itasset->name_en}}</td>
                      <td class="text-sm">{{$itasset->old_user . ' ' .$itasset->old_name}}</td>
                      <td class="text-sm">{{$itasset->serial_number}}</td>
                      <td class="text-sm">{{$itasset->fixed_asset_no}}</td>
                      <!--<td class="text-sm">{{$itasset->purchase_date }}</td>
                      <td class="text-sm">{{$itasset->warranty}}</td>
                      <td class="text-sm">
                          <?php
                            $wrt = '+' .substr($itasset->warranty,0,1).' year';
                            echo date('Y-m-d', strtotime($wrt, strtotime($itasset->purchase_date)));
                          ?>
                        </td>-->
                      <td>
                        @if($itasset->status == 'ACTIVE')
                        <span class="badge badge-success badge-sm">{{$itasset->status}}</span>
                        @else
                        <span class="badge badge-danger badge-sm">{{$itasset->status}}</span>
                        @endif
                      </td>
                      <td class="text-sm">
                        <a  href="{{ route('itasset.show',$itasset->id) }}" data-bs-toggle="tooltip" data-bs-original-title="Preview asset">
                          <i class="fas fa-eye text-secondary" aria-hidden="true"></i>
                        </a>
                        @can('itasset update')
                        <a href="{{ route('itasset.edit',$itasset->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit asset">
                          <i class="fas fa-user-edit text-secondary" aria-hidden="true"></i>
                        </a>
                        @endcan
                        <!--<a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete asset">
                          <i class="fas fa-trash text-secondary" aria-hidden="true"></i>
                        </a>-->
                      </td>
                    </tr>
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

<script src="https://cdn.datatables.net/2.0.6/js/dataTables.min.js"></script>
<link href="https://cdn.datatables.net/2.0.6/css/dataTables.dataTables.min.css" rel="stylesheet" />

<script>
    $(document).ready(function () {
        $("#products-list").DataTable();

        $('.').addClass('dataTable-top');
    });
</script>

@endsection
