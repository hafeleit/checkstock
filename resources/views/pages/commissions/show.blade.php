@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'รายละเอียด Commission'])
<div id="alert">
    @include('components.alert')
</div>

<div class="container-fluid py-4">
  @if ($errors->any())
      <div class="alert alert-danger">
          <ul class="mb-0">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Commission ID: {{ $commission->sub_id }}</h5>
                        <small class="text-muted">Status: {{ $commission->status }}</small>
                    </div>

                    <a href="{{ route('commissions.index') }}" class="btn bg-gradient-secondary btn-sm">
                        ← ย้อนกลับ
                    </a>
                </div>

                <div class="card-body pt-3">
                    <form method="GET" class="row g-2 mb-4">
                        <div class="col-md-10 col-sm-12">
                            <input type="text" name="search" class="form-control" placeholder="ค้นหา Account, Name, Reference Document หรือ Sales Rep" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 col-sm-12 text-end">
                            <button type="submit" class="btn bg-gradient-success w-100">
                                <i class="fas fa-search me-1"></i> ค้นหา
                            </button>
                        </div>
                    </form>
                    <div class="col-lg-12 col-md-3 col-sm-6 d-flex ">
                      @if ($commission->status === 'Calculate')
                          <!-- ปุ่ม Export
                          <button type="button"
                                  class="btn btn-sm bg-gradient-info px-3 me-2"
                                  id="export-btn"
                                  data-url="{{ route('commissions.export', $commission->id) }}">
                              <i class="fas fa-file-export me-1"></i> Export
                          </button>-->

                          <button type="button"
                                  class="btn btn-sm bg-gradient-warning px-3 me-2"
                                  data-bs-toggle="modal"
                                  data-bs-target="#adjustModal">
                              <i class="fas fa-edit me-1"></i> Adjust
                          </button>

                          <button type="button"
                                  class="btn btn-sm bg-gradient-secondary px-3"
                                  data-bs-toggle="modal"
                                  data-bs-target="#schemaModal">
                              <i class="fas fa-table me-1"></i> ดู Schema
                          </button>
                      @else
                          <!-- ปุ่ม Calculate Commission -->
                          <form method="POST" action="{{ route('commissions.update', $commission->id) }}" id="calculate-form">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="btn btn-sm bg-gradient-primary px-3">
                                  <i class="fas fa-calculator me-1"></i> Calculate Commission
                              </button>
                          </form>
                      @endif

                      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                      <script>
                      document.getElementById('export-btn')?.addEventListener('click', function () {
                          const url = this.getAttribute('data-url');

                          Swal.fire({
                              title: 'กำลังส่งออกข้อมูล...',
                              text: 'ระบบกำลังสร้างไฟล์ Excel',
                              allowOutsideClick: false,
                              allowEscapeKey: false,
                              didOpen: () => {
                                  Swal.showLoading();
                              }
                          });

                          fetch(url, {
                              headers: {
                                  'X-Requested-With': 'XMLHttpRequest',
                                  'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                              }
                          })
                          .then(response => {
                              if (!response.ok) throw new Error('ไม่สามารถส่งออกไฟล์ได้');

                              // ✅ ดึงชื่อไฟล์จาก Content-Disposition
                              const disposition = response.headers.get('Content-Disposition');
                              let filename = 'commissions_export.xlsx';

                              if (disposition && disposition.indexOf('filename=') !== -1) {
                                  const filenameRegex = /filename[^;=\n]*=(['"]?)([^'"\n]*)\1?/;
                                  const matches = filenameRegex.exec(disposition);
                                  if (matches != null && matches[2]) {
                                      filename = decodeURIComponent(matches[2]);
                                  }
                              }

                              return response.blob().then(blob => ({ blob, filename }));
                          })
                          .then(({ blob, filename }) => {
                              const link = document.createElement('a');
                              const url = window.URL.createObjectURL(blob);
                              link.href = url;
                              link.download = filename;
                              document.body.appendChild(link);
                              link.click();

                              // ทำความสะอาด
                              link.remove();
                              window.URL.revokeObjectURL(url);

                              Swal.close();
                          })
                          .catch(error => {
                              Swal.fire('เกิดข้อผิดพลาด', error.message, 'error');
                          });

                      });
                      </script>


                      <script>
                          document.getElementById('calculate-form').addEventListener('submit', function (e) {
                              Swal.fire({
                                  title: 'กำลังคำนวณ...',
                                  text: 'กรุณารอสักครู่',
                                  allowOutsideClick: false,
                                  allowEscapeKey: false,
                                  didOpen: () => {
                                      Swal.showLoading();
                                  }
                              });
                          });
                      </script>

                    </div>

                    <script>
                        let sortDirection = {};

                        function sortTable(colIndex) {
                          const table = document.getElementById("sortableTable"); // เปลี่ยน id ให้ตรงกับตาราง
                          const rows = Array.from(table.rows).slice(1);
                          const isAsc = sortDirection[colIndex] = !sortDirection[colIndex];

                          rows.sort((a, b) => {
                            const aText = a.cells[colIndex]?.innerText.trim();
                            const bText = b.cells[colIndex]?.innerText.trim();

                            const parseValue = (text) => {
                              const cleanText = text.replace(/,/g, '').trim(); // ลบ comma
                              const number = parseFloat(cleanText);
                              return isNaN(number) ? cleanText.toLowerCase() : number;
                            };

                            const aVal = parseValue(aText);
                            const bVal = parseValue(bText);


                            return isAsc ? (aVal > bVal ? 1 : -1) : (aVal < bVal ? 1 : -1);
                          });

                          const tbody = table.tBodies[0];
                          rows.forEach(row => tbody.appendChild(row));

                          // เปลี่ยน icon
                          const headers = table.querySelectorAll("th");
                          headers.forEach((th, idx) => {
                            const icon = th.querySelector("i");
                            if (icon) {
                              icon.className = "fas fa-sort";
                              if (idx === colIndex) {
                                icon.className = isAsc ? "fas fa-sort-up" : "fas fa-sort-down";
                              }
                            }
                          });
                        }
                    </script>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


                    <div class="table-responsive">

                        <table class="table table-hover align-items-center" id="sortableTable">
                            <thead>
                                <tr>
                                  <th onclick="sortTable(0)">Type <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(1)">Account <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(2)">Name <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(3)">Reference <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(4)">Reference Document <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(5)">Document Date <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(6)">Clearing Date <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(7)">Amount <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(8)">Clearing Document <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(9)">Document Type <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(10)">Text <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(11)">Sales Rep <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(12)">Emp Status <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(13)">Division <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(14)">Billing Ref <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(15)">Sales Doc <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(16)">SalesOrder Date <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(17)">CN. (No.) <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(18)">CN. Date <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(19)">Tax-Invoice <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(20)">Rate (days) <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(21)">Rate (%) <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(22)">Commission <i class="fas fa-sort"></i></th>
                                  <th onclick="sortTable(23)">Remark <i class="fas fa-sort"></i></th>
                                  <th></th> <!-- ปุ่มหรือ action อื่นๆ -->
                                </tr>

                            </thead>
                            <tbody>
                                @forelse ($commissionArs as $ar)
                                    <tr>
                                        <td>{{ $ar->type }}</td>
                                        <td>{{ $ar->account }}</td>
                                        <td>{{ $ar->name }}</td>
                                        <td>{{ $ar->reference }}</td>
                                        <td>{{ $ar->reference_key }}</td>
                                        <td>{{ $ar->document_date }}</td>
                                        <td>{{ $ar->clearing_date }}</td>
                                        <td>
                                            {{ is_numeric($ar->amount_in_local_currency)
                                                ? number_format($ar->amount_in_local_currency, 2)
                                                : '-' }}
                                        </td>
                                        <td>{{ $ar->clearing_document }}</td>
                                        <td>{{ $ar->document_type }}</td>
                                        <td>{{ $ar->text }}</td>
                                        <td>{{ $ar->sales_rep }}</td>
                                        <td>{{ $ar->name_en }}</td>
                                        <td>{{ $ar->division }}</td>

                                        <td>{{ $ar->cn_billing_ref }}</td>
                                        <td>{{ $ar->cn_sales_doc }}</td>
                                        <td>{{ $ar->cn_order_date }}</td>
                                        <td>{{ $ar->cn_no }}</td>
                                        <td>{{ $ar->cn_date }}</td>
                                        <td>{{ $ar->cn_tax_invoice }}</td>
                                        <td class="text-end">
                                          @if($ar->ar_rate_percent != '')
                                          {{ number_format($ar->ar_rate) }}
                                          @endif
                                        </td>
                                        <td class="text-end">{{ $ar->ar_rate_percent }}</td>
                                        <td class="text-end">{{ $ar->commissions }}</td>
                                        <td>{{ $ar->remark }}</td>
                                        <td>
                                            @if ($ar->type === 'Adjust')
                                                <button type="button"
                                                        class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editAdjustModal{{ $ar->id }}">
                                                    <i class="fas fa-edit me-1"></i> แก้ไข
                                                </button>
                                                <div class="modal fade" id="editAdjustModal{{ $ar->id }}" tabindex="-1" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                    <form method="POST" action="{{ route('commissions.adjust.update', $ar->id) }}">
                                                      @csrf
                                                      @method('PUT')
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title">แก้ไข Adjust</h5>
                                                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                          <div class="mb-3">
                                                            <label>Sales Rep</label>
                                                            <input type="text" class="form-control" name="sales_rep" value="{{ $ar->sales_rep }}" required>
                                                          </div>
                                                          <div class="mb-3">
                                                            <label>Reference Document</label>
                                                            <input type="text" class="form-control" name="reference_key" value="{{ $ar->reference_key }}" required>
                                                          </div>
                                                          <div class="mb-3">
                                                            <label>Commissions</label>
                                                            <input type="number" step="0.01" class="form-control" name="commissions" value="{{ $ar->commissions }}" required>
                                                          </div>
                                                          <div class="mb-3">
                                                            <label>Remark</label>
                                                            <textarea class="form-control" name="remark">{{ $ar->remark }}</textarea>
                                                          </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิด</button>
                                                          <button type="submit" class="btn btn-primary btn-sm">บันทึก</button>
                                                        </div>
                                                      </div>
                                                    </form>
                                                  </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center text-muted">ไม่มีข้อมูล</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $commissionArs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="adjustModal" tabindex="-1" aria-labelledby="adjustModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('commissions.adjust', $commission->id) }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="adjustModalLabel">Adjust Commission {{ $commission->id }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="sales_code" class="form-label">
              Sales Code <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" name="sales_rep" id="sales_rep" placeholder="HTHxxxx" required>
          </div>

          <div class="mb-3">
            <label for="invoice_no" class="form-label">
              Reference Document / Credit Note Number <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" name="reference_key" id="reference_key" required>
          </div>

          <div class="mb-3">
            <label for="commission" class="form-label">
              Commission Amount(THB) <span class="text-danger">*</span>
            </label>
            <input type="number" step="0.01" class="form-control" name="commissions" id="commissions" required>
          </div>

          <div class="mb-3">
            <label for="remark" class="form-label">Reason<span class="text-danger">*</span></label>
            <textarea class="form-control" name="remark" id="remark" rows="2"></textarea>
          </div>
        </div>


        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="schemaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">2025 Commission</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      @if (!empty($schemaTable))
      <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
          <thead class="bg-dark text-white">
            <tr>
              <th class="text-start">Division / AR</th>
              @foreach($columns as $range)
                <th>{{ $range }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach($schemaTable as $division => $rates)
            <tr>
              <td class="text-start">{{ $division }}</td>
              @foreach($columns as $range)
                <td>{{ $rates[$range] ?? '-' }}</td>
              @endforeach
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
      @else
      <div class="text-center text-muted py-4">
        ไม่มีข้อมูล Commission Schema
      </div>
      @endif


      </div>
    </div>
  </div>
</div>


@if(session('adjust_success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'ปรับค่าคอมมิชชั่นสำเร็จ!',
        text: 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว',
        confirmButtonText: 'ตกลง'
    });
</script>
@endif

@if(session('adjust_updated'))
<script>
  Swal.fire({
      icon: 'success',
      title: 'บันทึกสำเร็จ',
      text: 'ปรับปรุงข้อมูล Adjust เรียบร้อยแล้ว',
  });
</script>
@endif

@endsection
