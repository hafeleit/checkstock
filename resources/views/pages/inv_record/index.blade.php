@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav', ['title' => 'Invoice Record List'])
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
              <h5 class="mb-0">Invoice Record List</h5>
            </div>
            <div class="ms-auto my-auto mt-lg-0 mt-4">
              <div class="ms-auto my-auto">

                <a href="{{ route('inv-record.create') }}" class="btn bg-gradient-primary btn-sm mb-0" >+&nbsp; New Sheet</a>
                <a class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" href="{{ route('itasset-export') }}">Export All</a>

              </div>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-0">
          <div class="table-responsive">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
              <div class="dataTable-container">
                <table class="table table-flush dataTable-table" id="invoice-list">
                  <thead class="thead-light">
                    <tr>
                      <th>#</th>
                      <th>Create Date</th>
                      <th>Sheet ID</th>
                      <th>Creator</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($invRecords as $record)
                        <tr id="record-{{ $record->id }}">
                            <td></td>
                            <td>{{ $record->created_at }}</td>
                            <td>{{ $record->sheet_id }}</td>
                            <td>{{ $record->creator }}</td>
                            <td>{{ $record->sheet_status }}</td>

                            <td>
                                <!-- เพิ่ม Action ที่ต้องการ เช่น Edit หรือ Delete -->
                                <a href="{{ route('inv-record.edit', $record->id) }}" class="btn btn-primary">Edit</a>
                                <!--<form action="{{ route('inv-record.destroy', $record->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>-->
                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $record->id }})">Delete</button>
                                <a href="{{ route('inv-record.export', $record->id) }}" class="btn btn-success">Export</a>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $("#invoice-list").DataTable({
          pageLength: 50, // 🔥 ตั้งค่า default entries/page เป็น 50
          columnDefs: [
            {
              targets: 0,
              searchable: false,
              orderable: false,
              className: 'dt-type-numeric',
              render: function(data, type, row, meta) {
                return meta.row + 1; // ให้ลำดับแถวอัตโนมัติ
              }
            }
          ]
        });

    });

    function confirmDelete(recordId) {
        // ใช้ SweetAlert2 เพื่อยืนยันการลบ
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "ข้อมูลนี้จะถูกลบ!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // เริ่มการส่งคำขอ AJAX
                $.ajax({
                    url: '{{ route('inv-record.destroy', ':id') }}'.replace(':id', recordId),  // แทนที่ :id ด้วย id ของ record
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',  // ส่ง CSRF token
                        _method: 'DELETE'  // Method spoofing สำหรับการลบ
                    },
                    success: function(response) {
                        // ปิด SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'ลบข้อมูลสำเร็จ',
                            text: 'ข้อมูลนี้ถูกลบเรียบร้อยแล้ว',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        // อัปเดต UI หรือทำการลบแถวจากตาราง (ถ้ามี)
                        $('#record-' + recordId).remove();  // ลบแถวที่แสดงข้อมูลในตาราง
                    },
                    error: function(xhr, status, error) {
                        // แสดงข้อความเมื่อเกิดข้อผิดพลาด
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถลบข้อมูลได้',
                        });
                    }
                });
            }
        });
    }
</script>

@endsection
