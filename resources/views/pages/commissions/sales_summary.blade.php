@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'ยอดรวม Commission ราย Sales Rep'])
<style>
  .table-scroll-wrapper {
      position: relative;
  }

  .table-scroll-top {
      overflow-x: auto;
      overflow-y: hidden;
      height: 20px;           /* ความสูงให้เห็น scrollbar */
      background: #f8f9fa;    /* สีพื้นหลังให้แยกจาก table */
      border-bottom: 1px solid #dee2e6;
  }

  .table-scroll-bottom {
      overflow-x: auto;       /* table เลื่อนได้จริง */
  }

  .table-scroll-top div {
      height: 1px;            /* spacer */
  }
  .go-top-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #0d6efd;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 50%;
      font-size: 24px;
      cursor: pointer;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s, visibility 0.3s, transform 0.3s;
      z-index: 9999;
  }

  .go-top-btn:hover {
      background: #0b5ed7;
      transform: translateY(-4px);
  }
  .go-top-btn.show {
      opacity: 1;
      visibility: visible;
  }

  /* ปรับใช้กับ scrollbar ทั้งบนและล่าง */
  .table-scroll-top::-webkit-scrollbar,
  .table-scroll-bottom::-webkit-scrollbar {
      height: 10px; /* ความสูงของ scrollbar */
  }

  .table-scroll-top::-webkit-scrollbar-track,
  .table-scroll-bottom::-webkit-scrollbar-track {
      background: #f1f1f1; /* สีพื้นหลัง track */
      border-radius: 10px;
  }

  .table-scroll-top::-webkit-scrollbar-thumb,
  .table-scroll-bottom::-webkit-scrollbar-thumb {
      background: linear-gradient(45deg, #4facfe, #00f2fe); /* gradient thumb */
      border-radius: 10px;
      border: 2px solid #f1f1f1; /* ทำให้ดูเป็นแท่งนูนขึ้น */
  }

  .table-scroll-top::-webkit-scrollbar-thumb:hover,
  .table-scroll-bottom::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(45deg, #43e97b, #38f9d7); /* เปลี่ยนสีเวลา hover */
  }

  /* สำหรับ Firefox */
  .table-scroll-top,
  .table-scroll-bottom {
      scrollbar-color: #dcdcdc #f1f1f1; /* thumb, track */
      scrollbar-width: thin;
  }

</style>
<div id="alert">
    @include('components.alert')
</div>
<!-- ปุ่ม Go to Top -->
<button id="goTopBtn" class="go-top-btn">
  <i class="fas fa-arrow-up"></i>
</button>
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
                    <form method="GET" class="row g-2 mb-2">
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

                      <a href="{{ route('commissions.show', $commission->id) }}"
                         class="btn btn-sm bg-gradient-info px-3 me-2">
                          <i class="fas fa-file-export me-1"></i> ดูรายละเอียด
                      </a>
                      @if ($commission->status === 'Final Approved')
                        @can('Commissions Summary-Export')
                        <button type="button"
                                class="btn btn-sm bg-gradient-success px-3 me-2"
                                id="export-btn"
                                data-url="{{ route('commissions.summary-export', $commission->id) }}">
                            <i class="fas fa-file-export me-1"></i> Export
                        </button>
                        @endcan
                      @endif

                      @if ($commission->status === 'Summary Approved')
                        @can('Commissions Approve')
                        <div class="ms-auto">
                            <form id="approve-form-{{ $commission->id }}"
                                  action="{{ route('commissions.updateStatus', $commission->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Final Approved">
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

                      @if ($commission->status === 'Summary Confirmed' || $commission->status === 'Final Rejected')
                        @can('Commissions Summary-Approve')
                        <div class="ms-auto">
                            <form id="approve-form-{{ $commission->id }}"
                                  action="{{ route('commissions.updateStatus', $commission->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Summary Approved">
                                <button type="button"
                                        class="btn btn-sm bg-gradient-info px-3 me-2"
                                        onclick="approveSwal_Summary('{{ $commission->id }}')">
                                    <i class="fas fa-check me-1"></i>Summary Approve
                                </button>
                            </form>
                        </div>
                        <button type="button"
                                class="btn btn-sm bg-gradient-danger px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#summary-rejectModal-{{ $commission->id }}">
                            <i class="fas fa-times me-1"></i> Reject
                        </button>
                        @endcan
                      @endif

                      @if ($commission->status === 'AR Approved' || $commission->status === 'Summary Rejected(Manager)')
                        @can('Commissions Summary-Confirm')
                        <div class="ms-auto">
                            <form id="approve-form-{{ $commission->id }}"
                                  action="{{ route('commissions.updateStatus', $commission->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Summary Confirmed">
                                <input type="hidden" id="selected_sales_{{ $commission->id }}" name="selected_sales">
                                <button type="button"
                                        class="btn btn-sm bg-gradient-info px-3 me-2"
                                        onclick="approveSwal('{{ $commission->id }}')">
                                    <i class="fas fa-check me-1"></i>Summary Confirm
                                </button>
                            </form>
                        </div>

                        <!-- ปุ่ม Reject -->
                        <button type="button"
                                class="btn btn-sm bg-gradient-danger px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#rejectModal-{{ $commission->id }}">
                            <i class="fas fa-times me-1"></i>Reject
                        </button>
                        @endcan

                      @endif

                    </div>
                <div class="table-scroll-wrapper">
                <!-- Scrollbar ด้านบน -->
                  <div class="table-scroll-top">
                      <div style="height:1px;"></div> <!-- จะกำหนดความกว้างด้วย JS -->
                  </div>
                    <div class="table-responsive table-scroll-bottom">
                        <table class="table table-hover align-items-center" id="sortableTable">
                            <thead>
                                <tr>
                                    @can('Commissions Summary-Confirm')
                                    <th >
                                      All <input type="checkbox" id="checkAll" {{ !in_array($commission->status, ['AR Approved','Summary Rejected(Manager)']) ? 'disabled' : '' }}>
                                    </th>
                                    @endcan

                                    @canany(['Commissions Summary-Approve','Commissions Approve'])
                                    <th onclick="sortTable(0)">Clear<i class="fas fa-sort"></i></th>
                                    @endcan

                                    <th onclick="sortTable(1)">Employee Status <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(2)">Effecttive Date <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(3)">Sales Rep <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(4)">Sales Name <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(5)">Position <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(6)">Team <i class="fas fa-sort"></i></th>
                                    <th class="text-end" onclick="sortTable(7)">Total Initial <i class="fas fa-sort"></i></th>
                                    <th class="text-end" onclick="sortTable(8)">Total Adjustment <i class="fas fa-sort"></i></th>
                                    <th class="text-end" onclick="sortTable(9)">Total Commissions <i class="fas fa-sort"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($summary as $item)
                                    <tr>
                                          @can('Commissions Summary-Confirm')
                                          <td>
                                            <input type="checkbox" class="row-check" value="{{ $item->sales_rep }}" {{ $item->status == 'Approve' ? 'checked' : '' }} {{ !in_array($commission->status, ['AR Approved','Summary Rejected(Manager)']) ? 'disabled' : '' }}>
                                          </td>
                                          @endcan
                                          @canany(['Commissions Summary-Approve','Commissions Approve'])
                                          <td>
                                              @if($item->status === 'Approve')
                                                  <span class="text-success">✔️</span>
                                              @else
                                                  <span class="text-danger">❌</span>
                                              @endif
                                          </td>
                                          @endcan

                                        <td>
                                            <span class="badge {{ $item->emp_status === 'Resign' ? 'bg-danger' : 'bg-success' }}">
                                                {{ $item->emp_status }}
                                            </span>
                                        </td>
                                        <td>{{ $item->effecttive_date }}</td>
                                        <td>{{ $item->sales_rep }}</td>
                                        <td>{{ $item->name_en }}</td>
                                        <td>{{ $item->division }}</td>
                                        <td>{{ $item->emp_position }}</td>
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
                  <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const topScroll = document.querySelector(".table-scroll-top");
                        const spacer = topScroll.querySelector("div");
                        const bottomScroll = document.querySelector(".table-scroll-bottom");
                        const table = bottomScroll.querySelector("table");

                        // กำหนดความกว้าง scrollbar ด้านบนให้เท่ากับ table
                        spacer.style.width = table.scrollWidth + "px";
                        spacer.style.height = "1px"; // สำคัญ ไม่งั้นมันจะ collapse

                        // sync scroll
                        topScroll.addEventListener("scroll", () => {
                            bottomScroll.scrollLeft = topScroll.scrollLeft;
                        });
                        bottomScroll.addEventListener("scroll", () => {
                            topScroll.scrollLeft = bottomScroll.scrollLeft;
                        });
                    });

                  </script>
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
            <input type="hidden" name="status" value="Summary Rejected">
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
            <input type="hidden" name="status" value="Final Rejected">
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
<div class="modal fade" id="summary-rejectModal-{{ $commission->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('commissions.updateStatus', $commission->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="Summary Rejected(Manager)">
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
        title: 'ยืนยันการ Confirm?',
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
        title: 'ยืนยันการ Final Approve?',
        text: "เมื่ออนุมัติแล้วสถานะจะถูกเปลี่ยนเป็น Final Approved",
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

function approveSwal_Summary(id) {
    Swal.fire({
        title: 'ยืนยันการ Summary Approve?',
        text: "เมื่ออนุมัติแล้วสถานะจะถูกเปลี่ยนเป็น Summary Approved",
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    const goTopBtn = document.getElementById("goTopBtn");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            goTopBtn.classList.add("show");
        } else {
            goTopBtn.classList.remove("show");
        }
    });

    goTopBtn.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
});

</script>
@endsection
