@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'ยอดรวม Commission ราย Sales Rep'])
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
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Initial</p>
                                <h5 class="font-weight-bolder">
                                    {{ number_format( $totalInitial, 2 ) }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                          <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                              <i class="ni ni-chart-bar-32 text-lg opacity-10" aria-hidden="true"></i>
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
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Adjustment</p>
                                <h5 class="font-weight-bolder">
                                    {{ number_format( $totalAdjustment, 2 ) }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                          <div class="icon icon-shape bg-gradient-primary shadow-success text-center rounded-circle">
                              <i class="ni ni-curved-next text-lg opacity-10" aria-hidden="true"></i>
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
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Commission</p>
                                <h5 class="font-weight-bolder">
                                    {{ number_format( $totalCommissions, 2 ) }}
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
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Commission ID: {{ $commission->sub_id }}</h5>
                        status: <small class="badge
                            {{ stripos($commission->status, 'Reject') !== false ? 'bg-danger' :'bg-success' }}">
                            {{ $commission->status }}
                        </small>
                    </div>

                    <a href="{{ route('commissions.index') }}" class="btn bg-gradient-secondary btn-sm">
                        ← ย้อนกลับ
                    </a>
                </div>

                <div class="card-body pt-3">
                    <form method="GET" class="row g-2 mb-4">
                        <div class="col-md-10 col-sm-12">
                            <input type="text" name="search" class="form-control" placeholder="ค้นหา Sales Rep หรือ Sales Name" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 col-sm-12 text-end">
                            <button type="submit" class="btn bg-gradient-success w-100">
                                <i class="fas fa-search me-1"></i> ค้นหา
                            </button>
                        </div>
                    </form>
                    <div class="col-lg-12 col-md-3 col-sm-6 d-flex ">
                      @if ($commission->status === 'Final Approve')
                        @can('Commissions Summary-Export')
                        <button type="button"
                                class="btn btn-sm bg-gradient-success px-3 me-2"
                                id="export-btn"
                                data-url="{{ route('commissions.summary-export', $commission->id) }}">
                            <i class="fas fa-file-export me-1"></i> Export
                        </button>
                        @endcan
                      @endif

                      @if ($commission->status === 'Summary Approve')
                        @can('Commissions Approve')
                        <div class="ms-auto">
                            <form id="approve-form-{{ $commission->id }}"
                                  action="{{ route('commissions.updateStatus', $commission->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Final Approve">
                                <button type="button"
                                        class="btn btn-sm bg-gradient-info px-3 me-2"
                                        onclick="approveSwal_final('{{ $commission->id }}')">
                                    <i class="fas fa-check me-1"></i>Final Approve
                                </button>
                            </form>
                        </div>
                        <button type="button"
                                class="btn btn-sm bg-gradient-danger px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#final-rejectModal-{{ $commission->id }}">
                            <i class="fas fa-times me-1"></i> Reject
                        </button>
                        @endcan
                      @endif

                      @if ($commission->status === 'Summary Confirm')
                        @can('Commissions Summary-Approve')
                        <div class="ms-auto">
                            <form id="approve-form-{{ $commission->id }}"
                                  action="{{ route('commissions.updateStatus', $commission->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Summary Approve">
                                <input type="hidden" id="selected_sales_{{ $commission->id }}" name="selected_sales">
                                <button type="button"
                                        class="btn btn-sm bg-gradient-info px-3 me-2"
                                        onclick="approveSwal('{{ $commission->id }}')">
                                    <i class="fas fa-check me-1"></i>Summary Approve
                                </button>
                            </form>
                        </div>

                        <!-- ปุ่ม Reject -->
                        <button type="button"
                                class="btn btn-sm bg-gradient-danger px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#rejectModal-{{ $commission->id }}">
                            <i class="fas fa-times me-1"></i> Reject
                        </button>
                        @endcan
                      @endif

                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-items-center" id="sortableTable">
                            <thead>
                                <tr>
                                    <th >
                                        All <input type="checkbox" id="checkAll" {{ !in_array($commission->status, ['Summary Confirm']) ? 'disabled' : '' }}>
                                    </th>
                                    <th onclick="sortTable(1)">Status <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(2)">Effecttive Date <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(3)">Sales Rep <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(4)">Sales Name <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(5)">Division <i class="fas fa-sort"></i></th>
                                    <th class="text-end" onclick="sortTable(6)">Total Initial <i class="fas fa-sort"></i></th>
                                    <th class="text-end" onclick="sortTable(7)">Total Adjustment <i class="fas fa-sort"></i></th>
                                    <th class="text-end" onclick="sortTable(8)">Total Commissions <i class="fas fa-sort"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($summary as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="row-check" value="{{ $item->sales_rep }}" {{ $item->status == 'Approve' ? 'checked' : '' }} {{ !in_array($commission->status, ['Summary Confirm']) ? 'disabled' : '' }}>
                                        </td>
                                        <td>
                                            <span class="badge {{ $item->emp_status === 'Resign' ? 'bg-danger' : 'bg-success' }}">
                                                {{ $item->emp_status }}
                                            </span>
                                        </td>
                                        <td>{{ $item->effecttive_date }}</td>
                                        <td>{{ $item->sales_rep }}</td>
                                        <td>{{ $item->name_en }}</td>
                                        <td>{{ $item->division }}</td>
                                        <td class="text-end">{{ number_format($item->total_initial,2) }}</td>
                                        <td class="text-end">{{ number_format($item->total_adjust,2) }}</td>
                                        <td class="text-end">{{ number_format($item->total_commissions,2) }}</td>

                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center text-muted">ไม่มีข้อมูล</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Reject -->
<div class="modal fade" id="rejectModal-{{ $commission->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('commissions.updateStatus', $commission->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="Summary Reject">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Commission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="reason">Reason<span class="text-danger">*</span></label>
                    <textarea name="hr_comment" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="final-rejectModal-{{ $commission->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('commissions.updateStatus', $commission->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="Final Reject">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Commission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="reason">Reason<span class="text-danger">*</span></label>
                    <textarea name="fin_comment" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </div>
        </form>
    </div>
</div>
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
<script>

document.getElementById('checkAll').addEventListener('change', function () {
    document.querySelectorAll('.row-check').forEach(chk => chk.checked = this.checked);
});

function approveSwal(id) {
    let selected = [];
    document.querySelectorAll('.row-check:checked').forEach(cb => {
        selected.push(cb.value);
    });

    if (selected.length === 0) {
        Swal.fire('กรุณาเลือกอย่างน้อย 1 รายการ', '', 'warning');
        return;
    }

    // set ค่าใน hidden input
    document.getElementById('selected_sales_' + id).value = selected.join(',');

    Swal.fire({
        title: 'ยืนยันการ Summary Approve?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('approve-form-' + id).submit();
        }
    });
}



function approveSwal_final(id) {
    Swal.fire({
        title: 'ยืนยันการ Approve?',
        text: "เมื่ออนุมัติแล้วสถานะจะถูกเปลี่ยนเป็น Final Approve",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ใช่, Approve เลย!',
        cancelButtonText: 'ยกเลิก',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('approve-form-' + id).submit();
        }
    });
}
</script>
@endsection
