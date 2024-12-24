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
                <a href="{{ route('asset_types.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; New Asset Type</a>
                @endcan
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
                        <a href="#" class="">TYPE CODE</a>
                      </th>
                      <th >
                        <a href="#" class="">TYPE DESCRIPTION</a>
                      </th>
                      <th >
                        <a href="#" class="">STATUS</a>
                      </th>
                      <th >
                        <a href="#" class="">ACTION</a>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($assetTypes as $assetType)
                    <tr>

                      <td class="text-sm">{{$assetType->id}}</td>

                      <td class="text-sm">{{$assetType->type_code}}</td>

                      <td class="text-sm">{{$assetType->type_desc}}</td>

                      <td class="text-sm">{{$assetType->type_status}}</td>

                      <td class="text-sm">
                        <a  href="" data-bs-toggle="tooltip" data-bs-original-title="Preview asset">
                          <i class="fas fa-eye text-secondary" aria-hidden="true"></i>
                        </a>
                        <a href="" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit asset">
                          <i class="fas fa-user-edit text-secondary" aria-hidden="true"></i>
                        </a>
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
