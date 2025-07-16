@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav', ['title' => 'Online Order'])
<style media="screen">
  .dt-layout-row{
    padding: 1.5rem;
  }

  .dt-layout-row.dt-layout-table{
    padding: 0rem;
  }
</style>
<div class="card shadow-lg mx-4 card-profile-bottom">
    <div class="card-body p-3">
        <div class="row gx-4">
            <div class="col-auto">
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <p class="mb-0 font-weight-bold text-sm">

                        Run orders automatically every <i class="ni ni-time-alarm"> </i><span class="text-danger"> 7:00, 10:00, 13:30, 16:30</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="alert">
    @include('components.alert')
</div>
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-header pb-0">
          <div class="d-lg-flex">
            <div>
              <h5 class="mb-0">Online Orders</h5>
            </div>
            <div class="ms-auto my-auto mt-lg-0 mt-4">
              <div class="ms-auto my-auto">
                <a href="{{ route('onlineorder-manual-get') }}" id="get_order" class="btn bg-gradient-primary btn-sm mb-0" >Get Order</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-0">
          <div class="table-responsive">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
              <div class="dataTable-container">
                <table class="table table-flush dataTable-table" id="orders-list">
                  <thead class="thead-light">
                    <tr>
                      <th >
                        <a href="#" class="">Orders count</a>
                      </th>
                      <th >
                        <a href="#" class="">Date Time</a>
                      </th>
                      <th >
                        <a href="#" class="">File name</a>
                      </th>
                      <th >
                        <a href="#" class="">Annotation</a>
                      </th>
                      <th >
                        <a href="#" class="">SAP</a>
                      </th>
                      <th >
                        <a href="#" class="">SAP EX</a>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($orders as $index => $order)
                    <tr>
                      <td class="text-sm">{{$order->cnt}}</td>
                      <td class="text-sm">{{$order->created_at}}</td>
                      <td class="text-sm">{{$order->filename}} </td>

                      <td class="text-sm">
                        <a href={{route('onlineorder-download',$order->filename)}} data-bs-toggle="tooltip" data-bs-original-title="Download">
                          <i class="ni ni-archive-2 text-dark" aria-hidden="true"> Download</i>
                        </a>
                      </td>
                      <td class="text-sm">
                        @if(file_exists(storage_path('app/export/orders/'.'SAP_'.$order->filename)))
                        <a href={{route('onlineorder-download','SAP_'.$order->filename)}} data-bs-toggle="tooltip" data-bs-original-title="Download">
                          <i class="ni ni-archive-2 text-dark" aria-hidden="true"> Download</i>
                        </a>
                        @else
                         <a>-</a>
                        @endif
                      </td>
                      <td class="text-sm">
                        @if(file_exists(storage_path('app/export/orders/'.'SAP_EX_'.$order->filename)))
                        <a href={{route('onlineorder-download','SAP_EX_'.$order->filename)}} data-bs-toggle="tooltip" data-bs-original-title="Download">
                          <i class="ni ni-archive-2 text-dark" aria-hidden="true"> Download</i>
                        </a>
                        @else
                         <a>-</a>
                        @endif

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

        $("#orders-list").DataTable({
          order: [[1, 'desc']]
        });

        $('.').addClass('dataTable-top');

    });

    $(function(){
      $( "#get_order" ).on( "click", function() {
        $(this).addClass('disabled');
      } );
    });
</script>

@endsection
