@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
  .z-index-1 {
    z-index: 1;
  }
</style>

@include('layouts.navbars.auth.topnav', ['title' => 'Invoice Record'])

<div class="container-fluid py-4">
  <form action="{{ route('inv-record.store') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-lg-6 z-index-1">
        <h4 class="text-white">Create Invoice Record</h4>

      </div>
      <div class="col-lg-6 text-end z-index-1">
        <a href="{{ route('inv-record.index') }}" type="button" class="btn btn-secondary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Cancel</a>
        <button type="submit" class="btn btn-primary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Save</button>
      </div>
    </div>
    <div class="row mt-4">

      <div class="col-lg-12 mt-lg-0 mt-4">
        <div class="card">
          <div class="card-body">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
              <p>{{ $message }}</p>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
              <strong>Whoops!</strong> There were some problems with your input.<br><br>
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            <h5 class="font-weight-bolder">New Sheet</h5>
            <div class="row">
              <div class="col-12 col-sm-3">
                <label>Scan Invoice Number</label>
                <input class="form-control" type="text" name="scan_inv" id="scan_inv" placeholder="Scan Invoice" autofocus>
              </div>
              <div class="col-12 col-sm-9">
                <label>Invoice Record List</label>

                <div class="table-responsive">
                  <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                    <div class="dataTable-container">
                      <table class="table table-flush dataTable-table" id="invoice-list">
                        <thead class="thead-light">
                          <tr>
                            <th>#</th>
                            <th>Invoice Number</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
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
    </div>
  </form>
</div>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
  $(document).ready(function() {
    // สร้าง DataTable instance
    const table = $('#invoice-list').DataTable({
      pageLength: 50, // 🔥 ตั้งค่า default entries/page เป็น 50
      columnDefs: [{
        targets: 0,
        searchable: false,
        orderable: false,
        className: 'dt-type-numeric',
        render: function(data, type, row, meta) {
          return meta.row + 1; // ให้ลำดับแถวอัตโนมัติ
        }
      }]
    });

    // เพิ่มแถวเมื่อกด Enter
    $('#scan_inv').on('keypress', function(e) {
      if (e.which === 13) {
        e.preventDefault();
        const invoiceNumber = $(this).val().trim();
        if (invoiceNumber === '') return;

        // ตรวจสอบว่า invoiceNumber ซ้ำหรือไม่
        let isDuplicate = false;
        table.rows().every(function() {
          const data = this.data();
          const html = $('<div>').html(data[1]).text().trim();
          if (html === invoiceNumber) {
            isDuplicate = true;
            return false; // break loop
          }
        });

        if (isDuplicate) {
          Swal.fire({
            icon: 'warning',
            title: 'ซ้ำ!',
            text: `Invoice Number "${invoiceNumber}" มีอยู่แล้ว`,
            confirmButtonText: 'ตกลง'
          });
        } else {
          table.row.add([
            '',
            `
                ${invoiceNumber}
                <input type="hidden" name="invoice_number[]" value="${invoiceNumber}">
              `,
            '<a href="#" class="delete-row">delete</a>'
          ]).draw(false);
        }

        $(this).val('');
      }
    });

    // ลบแถว
    $('#invoice-list tbody').on('click', '.delete-row', function(e) {
      e.preventDefault();
      table.row($(this).parents('tr')).remove().draw();
    });
  });
</script>
@endsection