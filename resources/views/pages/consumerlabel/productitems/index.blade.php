@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav', ['title' => 'Customer Label'])
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style media="screen">
  a.disabled {
    pointer-events: none;
    cursor: default;
  }
</style>
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
              <h5 class="mb-0">Product Items</h5>
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
                      <form id="import-form" action="{{ route('productitems_import') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-body">
                        <p>You can browse your computer for a file.</p>
                        <input type="file" placeholder="Browse file..." class="form-control mb-3" name="file" id="file-input">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary btn-sm">Upload</button>
                      </div>
                      </form>
                      <script>
                        const importForm = document.getElementById('import-form');

                        importForm.addEventListener('submit', function (event) {
                            event.preventDefault(); // ป้องกันการ reload หน้า

                            const fileInput = document.getElementById('file-input');
                            const file = fileInput.files[0];

                            if (!file) {
                                Swal.fire('Error', 'กรุณาเลือกไฟล์ก่อน!', 'error');
                                return;
                            }

                            // แสดง Loading
                            Swal.fire({
                                title: 'Importing...',
                                text: 'Please wait while the data is being imported.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // สร้าง FormData เพื่อส่งไฟล์
                            const formData = new FormData(importForm);

                            // ส่งคำขอไปยังเซิร์ฟเวอร์
                            fetch('/import-product-items', {
                                method: 'POST',
                                body: formData,
                                headers: {

                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    Swal.fire('Success', 'Import ข้อมูลสำเร็จ!', 'success');
                                    $('#import').modal('hide');
                                } else {
                                    throw new Error('Import failed');
                                }
                            })
                            .catch(error => {
                                Swal.fire('Error', error.message, 'error'); // แสดงข้อผิดพลาด
                            });
                        });
                    </script>
                    </div>
                  </div>
                </div>

                <a class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" id="btn_export" href="{{ route('productitems_export') }}">Export</a>
                <script>
                  const exportLink = document.getElementById('btn_export');

                  exportLink.addEventListener('click', function (event) {
                      event.preventDefault(); // ป้องกันการทำงานปกติของลิงก์

                      // แสดง Loading
                      Swal.fire({
                          title: 'Exporting...',
                          text: 'Please wait while your file is being prepared.',
                          allowOutsideClick: false,
                          didOpen: () => {
                              Swal.showLoading();
                          }
                      });

                      // ส่งคำขอไปยังเซิร์ฟเวอร์
                      fetch('/export-product-items', {
                          method: 'GET',
                          headers: {
                              'X-Requested-With': 'XMLHttpRequest'
                          }
                      })
                      .then(response => {
                          if (response.ok) {
                              Swal.close(); // ปิด Loading
                              return response.blob();
                          }
                          throw new Error('Export failed');
                      })
                      .then(blob => {
                          // ดาวน์โหลดไฟล์
                          const url = window.URL.createObjectURL(blob);
                          const a = document.createElement('a');
                          a.href = url;
                          a.download = 'ProductItems.xlsx'; // ตั้งชื่อไฟล์
                          document.body.appendChild(a);
                          a.click();
                          a.remove();
                      })
                      .catch(error => {
                          Swal.fire('Error', error.message, 'error'); // แสดงข้อความข้อผิดพลาด
                      });
                  });
              </script>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-0 mt-3">
          <div class="table-responsive">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
              <div class="dataTable-top">
                <div class="dataTable-dropdown">
                  <label>
                    <form id="form_search" class="" action="{{ route('product-items.index' )}}" method="get">
                    <select class="dataTable-selector" id="perpage" name="perpage">
                      <option value="5" {{ (request()->perpage == '5' ? 'selected' : '') }}>5</option>
                      <option value="10" {{ (request()->perpage == '10' ? 'selected' : '') }}>10</option>
                      <option value="20" {{ (request()->perpage == '20' ? 'selected' : '') }}>20</option>
                      <option value="50" {{ (request()->perpage == '50' ? 'selected' : '') }}>50</option>
                      <option value="100" {{ (request()->perpage == '100' ? 'selected' : '') }}>100</option>
                    </select> entries per page {{ request()->perpage }}</label>
                </div>

                <div class="dataTable-search">
                    <input class="dataTable-input" placeholder="Search..." type="text" id="search" name="search" value="{{request()->search ?? ''}}">
                    <a href="#" class="btn bg-gradient-primary btn-sm mb-0" id="btn_search">Search</a>
                  </form>
                </div>

              </div>
              <div class="dataTable-container">
                <table class="table table-flush dataTable-table" id="productitems-list">
                  <thead class="thead-light">
                    <tr>
                      <th>item_code</th>
                      <th>Item Desc</th>
                      <th>Product Name</th>
                      <th>Made by</th>
                      <th>Barcode</th>
                      <th></th>
                    </tr>
                  </thead>

                  <tbody id="tbody">
                    @if(count($productitems) > 0)
                      @foreach($productitems as $product)
                        <tr>
                          <td class="text-sm">{{ $product->item_code ?? '' }}</td>
                          <td class="text-sm">{{ $product->item_desc_en ?? '' }}</td>
                          <td class="text-sm">{{ $product->product_name ?? '' }}</td>
                          <td class="text-sm">{{ $product->made_by ?? '' }}</td>
                          <td class="text-sm">
                            <a href="" data-bs-toggle="modal" data-bs-target="#modal-barcode" data-bs-original-title="Download Barcode" onclick="icon_barcode('{{$product->item_code}}')">
                              <i class="fas fa-barcode text-lg text-danger" aria-hidden="true"></i>
                            </a>
                          </td>
                          <td class="text-sm">
                            <a  href="" data-bs-toggle="tooltip" data-bs-original-title="Preview Product">
                              <i class="fas fa-eye text-secondary" aria-hidden="true"></i>
                            </a>
                            @can('consumerlabel update')
                            <a href="{{ route('product-items.edit',$product->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Product">
                              <i class="fas fa-pen text-secondary" aria-hidden="true"></i>
                            </a>
                            @endcan
                          </td>
                        </tr>
                      @endforeach
                    @else
                    <tr>
                      <td colspan="4">No data.</td>
                    </tr>
                    @endif
                  </tbody>
                </table>

              </div>
              <div class="dataTable-bottom">
                <div class="dataTable-info">{{ "Showing " .  $productitems->firstItem() . " to " . $productitems->lastItem() . " of " . $productitems->total() . " entries"}}</div>
                {!! $productitems->withQueryString()->links('pagination::bootstrap-4') !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-barcode" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <form class="" action="{{ route('pdfbarcode')}}" method="get" target="_blank" onSubmit="return chkSkip()">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Consumer Labelling</h6><span id="modal-item-code"></span>
                <input type="hidden" name="item_code" id="item_code" value="">
                <input type="hidden" name="barcode_type" id="barcode_type" value="">
            </div>
            <div class="modal-body">
              <p>
                <input class="form-control datepicker" id="pdate" name="man_date" placeholder="Please select manufacturing date if you need" type="text" >
              </p>

              <p class="text-danger text-xs">* Please select the production date, if no need please click "OK" for skip it</p>
            </div>
            <div class="modal-footer">
              <div class="" style="width: 100%; text-align: left;">
                <button type="submit" class="btn btn-primary" onclick="document.getElementById('barcode_type').value='1pc';"><i class="fa fa-upload"></i> 1 Pc</button>
                <button type="submit" class="btn btn-primary" onclick="document.getElementById('barcode_type').value='a4';"><i class="fa fa-upload"></i> A4</button>
                <button type="submit" class="btn btn-primary" onclick="document.getElementById('barcode_type').value='a4_nob';"><i class="fa fa-upload"></i> A4 No border</button>

              </div>
              <div class="" style="width: 100%;">
                <button type="submit" class="btn btn-primary" onclick="document.getElementById('barcode_type').value='tis';"><i class="fa fa-upload"></i> TIS</button>
                <button type="submit" class="btn btn-primary" onclick="document.getElementById('barcode_type').value='tis2';"><i class="fa fa-upload"></i> TIS2</button>
                <button type="button" class="btn btn-link ml-auto" data-bs-dismiss="modal" style="float: right;">Close</button>

              </div>
                </div>
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">

  function chkSkip(){
    if($('#pdate').val() == ''){
      return confirm('Please note that, the consumer label must have production date Are you sure skip the date?');
    }
  }

  function icon_barcode(item_code){
    let txt_item_code = 'Item code: '+ item_code;
    $('#item_code').val(item_code);
    $('#modal-item-code').html(txt_item_code);
  }

  $(function(){


    $( "#perpage" ).on( "change", function() {
      $( "#form_search" ).trigger( "submit" );
    });
    $( "#btn_search" ).on( "click", function() {
      $( "#form_search" ).trigger( "submit" );
    });
    $("#pdate").flatpickr({
      disableMobile: "true",
    });
  });

</script>
@endsection
