@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    @include('layouts.navbars.auth.topnav', ['title' => 'Invoice Record'])

    <div class="container-fluid py-4">
      <form id="myForm" action="{{ route('inv-record.update',$invRecord->id) }}" method="post" action="your_submit_url">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col-lg-6" style="z-index: 1;">
          <h4 class="text-white">Edit page</h4>

        </div>
        <div class="col-lg-6 text-end" style="z-index: 1;">
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
              <h5 class="font-weight-bolder">Sheet ID: {{$invRecord->sheet_id}}</h5>
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
                        <th>Approve <input type="checkbox" id="select-all" onclick="toggleCheckboxes()"></th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach($invRecordDetail as $detail)
                          <tr>
                              <td></td>
                              <td>{{ $detail->inv_number}}</td>
                              <td>
                                  <input type="checkbox" name="approve[]" value="{{ $detail->id }}"
                                         {{ $detail->approve == 1 ? 'checked' : '' }} class="approve-checkbox">
                              </td>
                              <td><a href="#" class="delete-row">delete</a></td>
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
      </div>
      </form>
    </div>
    <script src="https://cdn.datatables.net/2.0.6/js/dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/2.0.6/css/dataTables.dataTables.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

    function toggleCheckboxes() {
        var checkboxes = document.querySelectorAll('.approve-checkbox');
        var selectAll = document.getElementById('select-all');

        checkboxes.forEach(function(checkbox) {
            checkbox.checked = selectAll.checked; // กำหนดสถานะของ checkbox ตามสถานะของ "Select All"
        });
    }
    window.onload = checkSelectAllStatus;
    $(document).ready(function() {


      // สร้าง DataTable instance
      const table = $('#invoice-list').DataTable({
        pageLength: 10,
        columnDefs: [
          {
            targets: 0,
            searchable: false,
            orderable: false,
            className: 'dt-type-numeric',
            render: function(data, type, row, meta) {
              return meta.row + 1; // ให้ลำดับแถวอัตโนมัติ
            }
          },
          {
              targets: 2, // คอลัมน์ที่ 3 (Approve)
              orderable: false, // ปิดการทำงานของการเรียงลำดับ
              searchable: false // ปิดการทำงานของการค้นหาในคอลัมน์นี้
          }
        ]
      });

      function getCheckedApproveData() {
          var checkedData = [];

          // ใช้ .rows().every() เพื่อดึงข้อมูลจากทุกแถวใน DataTable
          table.rows().every(function() {
              var rowData = this.data(); // ข้อมูลในแต่ละแถว

              // หาค่า checkbox ที่ถูกติ๊กในคอลัมน์ที่ 3 (index 2)
              var checkbox = $(this.node()).find('input.approve-checkbox:checked');

              // ถ้ามี checkbox ที่ถูกติ๊ก (checked)
              checkbox.each(function() {
                  checkedData.push($(this).val()); // เก็บค่าของ checkbox ที่ถูกติ๊ก
              });
          });

          return checkedData;
      }

      $('#myForm').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'กำลังดำเนินการ...',
            text: 'กรุณารอซักครู่',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();  // แสดง spinner
            }
        });
        var checkedApprove = getCheckedApproveData();
                  // คุณสามารถส่งข้อมูลทั้งหมดไปในฟอร์มนี้หรือใช้ Ajax เพื่อส่งข้อมูล
        console.log(checkedApprove);  // ทดสอบแสดงค่าของ checkbox ที่ถูกติ๊ก

        $.ajax({
            url: '{{ route('inv-record.update', $invRecord->id) }}',  // URL สำหรับการส่งข้อมูล
            method: 'POST',  // ใช้ POST สำหรับการส่งข้อมูล
            data: {
                _token: '{{ csrf_token() }}',  // CSRF token
                _method: 'PUT',  // Method spoofing ใช้ PUT สำหรับการอัปเดต
                approve: checkedApprove  // ส่งค่าของ approveIds (ค่าของ checkbox ที่ถูกติ๊ก)
            },
            success: function(response) {
              // ปิด loading หลังจากส่งคำขอสำเร็จ
              Swal.close();

              // แสดงผลลัพธ์เมื่อการอัปเดตสำเร็จ
              Swal.fire({
                  icon: 'success',
                  title: 'อัปเดตสถานะ approve สำเร็จ!',
                  text: response.message || 'ข้อมูลได้รับการอัปเดตแล้ว',
                  confirmButtonText: 'ตกลง'
              });
            },
            error: function(xhr, status, error) {
                // จัดการกรณีเกิดข้อผิดพลาด
                console.log('Error:', error);
                // ปิด loading เมื่อเกิดข้อผิดพลาด
        Swal.close();

        // แสดงข้อความเมื่อเกิดข้อผิดพลาด
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: error || 'ไม่สามารถอัปเดตข้อมูลได้',
            confirmButtonText: 'ตกลง'
        });
            }
        });

      });

      // ฟังก์ชัน Select All ทั่วทั้ง DataTable (ทุกหน้า)
    $('#select-all').on('click', function() {
        var isChecked = $(this).prop('checked');
        // เลือกหรือยกเลิกการเลือก checkbox ทั้งหมดใน DataTable
        table.$('input[type="checkbox"]').prop('checked', isChecked);
    });

    // ฟังก์ชันตรวจสอบสถานะ Select All เมื่อมีการเปลี่ยนแปลง checkbox ในแถว
    $('#invoice-list').on('change', 'input[type="checkbox"]', function() {
        // ตรวจสอบว่า checkbox ทั้งหมดใน DataTable ถูกเลือกหรือไม่
        var allChecked = table.$('input[type="checkbox"]:checked').length === table.$('input[type="checkbox"]').length;
        $('#select-all').prop('checked', allChecked);
    });


      // เพิ่มแถวเมื่อกด Enter
      $('#scan_inv').on('keypress', function(e) {
      if (e.which === 13) {
        e.preventDefault();

        const invoiceNumber = $(this).val().trim();
        if (invoiceNumber === '') return;

        table.row.add([
        '',
        `
          ${invoiceNumber}
          <input type="hidden" name="invoice_number[]" value="${invoiceNumber}">
        `,
        `
          <input type="checkbox" name="approve[]" value="1" class="approve-checkbox">
        `,
        '<a href="#" class="delete-row">delete</a>'
      ]).draw(false);

        $(this).val('');
      }
      });

      // ลบแถว
      $('#invoice-list tbody').on('click', '.delete-row', function(e) {
        e.preventDefault();
        table.row($(this).parents('tr')).remove().draw();
      });
    });

    function checkSelectAllStatus() {
        const checkboxes = document.querySelectorAll('.approve-checkbox');  // เลือกทั้งหมดที่มี class="approve-checkbox"
        const selectAllCheckbox = document.getElementById('select-all');  // เลือก checkbox select-all

        // เช็คว่า checkbox ทั้งหมดถูกเลือกหรือไม่
        const allChecked = Array.from(checkboxes).every(function(checkbox) {
            return checkbox.checked;
        });

        // ถ้า checkbox ทั้งหมดถูกเลือก select-all จะถูกเลือก
        selectAllCheckbox.checked = allChecked;
    }

</script>


@endsection
