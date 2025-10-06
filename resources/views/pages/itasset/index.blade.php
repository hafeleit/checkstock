@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav', ['title' => 'Asset List'])
<style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
  .dt-layout-row {
    padding: 1.5rem 0;
  }

  .dt-layout-row.dt-layout-table {
    padding: 0rem;
    overflow: auto;
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
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Notebooks / Spare</p>
                <h5 class="font-weight-bolder">
                  {{ NUMBER_FORMAT($total_notebook) ?? '' }} / {{ NUMBER_FORMAT($total_notebook_spare) ?? '' }}
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
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total PC / Spare</p>
                <h5 class="font-weight-bolder">
                  {{ NUMBER_FORMAT($total_pc) ?? '' }} / {{ NUMBER_FORMAT($total_pc_spare) ?? '' }}
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
        <div class="card-body px-4 pb-0 ">
          <div class="table-responsive overflow-hidden">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
              <div class="dataTable-container">
                <table class="table table-flush dataTable-table w-100 overflow-auto" id="products-list">
                  <thead class="thead-light">
                    <tr>
                      <th>
                        <a href="#" class="">COMPUTER NAME</a>
                      </th>
                      <th>
                        <a href="#" class="">CURRENT USER</a>
                      </th>
                      <th>
                        <a href="#" class="">SOFTWARE NAME</a>
                      </th>
                      <th>
                        <a href="#" class="">SERIAL NUMBER</a>
                      </th>
                      <th>
                        <a href="#" class="">TYPE</a>
                      </th>
                      <th>
                        <a href="#" class="">STATUS</a>
                      </th>
                      <th>
                        <a href="#" class="">ACTION</a>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($itassets as $itasset)
                    <tr>
                      <td>
                        <a href="{{ route('itasset.show',$itasset->id) }}">
                          <div class="d-flex">
                            @php
                                $images = [
                                    'T01' => 'macbook-pro.jpg',
                                    'T02' => 'pc.jpg',
                                    'T03' => 'printer-fuji.jpg',
                                    'T05' => 'headset.jpg',
                                    'T06' => 'telephone_sim.jpg',
                                    'T07' => 'tv.png',
                                    'T08' => 'copy_machine.png',
                                    'T09' => 'handheld.png',
                                    'T10' => 'mobile_printer.jpg',
                                    'T11' => 'pos.png',
                                    'T12' => 'phone_number.png',
                                    'T13' => 'microphone.png',
                                    'T14' => 'usb_flash_drive.png',
                                    'T15' => 'video_conference.png',
                                    'T16' => 'speaker.png',
                                    'T17' => 'mobile_phone.png',
                                    'T18' => 'tablet.png',
                                ];

                                $image = $images[$itasset->type] ?? null;
                            @endphp

                            <img class="w-30" src="{{ $image ? URL::to('/').'/img/itasset/'.$image : '' }}">

                            <h6 class="ms-3 my-auto">{{$itasset->computer_name}}</h6>
                          </div>
                        </a>
                      </td>
                      <td class="text-sm">{{$itasset->user . ' ' .$itasset->name_en}}</td>
                      <td class="text-sm">{{$itasset->software_name}}</td>
                      <td class="text-sm">{{$itasset->serial_number}}</td>
                      <td class="text-sm">{{$itasset->type_desc}}</td>
                      <td>
                        @if($itasset->status == 'ACTIVE')
                        <span class="badge badge-success badge-md">{{$itasset->status}}</span>
                        @elseif($itasset->status == 'SPARE')
                        <span class="badge badge-info badge-md">{{$itasset->status}}</span>
                        @else
                        <span class="badge badge-danger badge-md">{{$itasset->status}}</span>
                        @endif
                      </td>
                      <td class="text-sm">
                        <a href="{{ route('itasset.show',$itasset->id) }}" data-bs-toggle="tooltip" data-bs-original-title="Preview asset">
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

<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">

<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
  $(document).ready(function() {
    $("#products-list").DataTable();
  });
</script>

@endsection
