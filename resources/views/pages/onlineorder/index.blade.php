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
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-header pb-0">
          <div class="d-lg-flex">
            <div>
              <h5 class="mb-0">Online Orders</h5>
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
                        <a href="#" class="">ACTION</a>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($orders as $order)
                    <tr>
                      <td class="text-sm">{{$order->cnt}}</td>
                      <td class="text-sm">{{$order->created_at}}</td>
                      <td class="text-sm">{{$order->filename}}</td>

                      <td class="text-sm">
                        <a href={{route('onlineorder-download',$order->filename)}} data-bs-toggle="tooltip" data-bs-original-title="Download">
                          <i class="ni ni-archive-2 text-dark" aria-hidden="true"> Download</i>
                        </a>
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

        $("#orders-list").DataTable({
          order: [[0, 'desc']]
        });

        $('.').addClass('dataTable-top');
    });
</script>

@endsection
