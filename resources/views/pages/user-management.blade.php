@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Master'])
    <style media="screen">
      .dt-layout-row{
        padding: 1.5rem;
      }

      .dt-layout-row.dt-layout-table{
        padding: 0rem;
      }
    </style>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="row mt-4 mx-4">
        <div class="col-12">

            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-lg-flex">
                      <div>
                        <h5 class="mb-0">User Master</h5>
                      </div>
                      <div class="ms-auto my-auto mt-lg-0 mt-4">
                        <div class="ms-auto my-auto">
                          <button type="button" class="btn btn-outline-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#import"> Import </button>

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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">uuid</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">job code</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">name th</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">name en</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">dept</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">position</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">location</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">email</th>

                                </tr>
                            </thead>
                            <tbody>
                              @foreach($user_master as $row)
                                <tr>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $row->uuid }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $row->job_code }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $row->name_th }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $row->name_en }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $row->dept }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $row->position }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $row->location }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $row->email }}</p>
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

    <script src="https://cdn.datatables.net/2.0.6/js/dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/2.0.6/css/dataTables.dataTables.min.css" rel="stylesheet" />

    <script>
        $(document).ready(function () {

            $("#products-list").DataTable({
              order: [[1, 'asc']]
            });

            $('.').addClass('dataTable-top');
        });
    </script>
@endsection
