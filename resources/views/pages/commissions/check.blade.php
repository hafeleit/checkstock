@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'รายละเอียด Commission'])
<style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
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
                    <form method="GET" class="row g-2 mb-4">
                        <div class="col-md-10 col-sm-12">
                            <input type="text" name="search" class="form-control" placeholder="ค้นหา Reference Document" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 col-sm-12 text-end">
                            <button type="submit" class="btn bg-gradient-success w-100">
                                <i class="fas fa-search me-1"></i> ค้นหา
                            </button>
                        </div>
                    </form>
                    <div class="col-lg-12 col-md-3 col-sm-6 d-flex ">
                      <button type="button"
                              class="btn btn-sm bg-gradient-secondary px-3 me-2"
                              data-bs-toggle="modal"
                              data-bs-target="#schemaModal">
                          <i class="fas fa-table me-1"></i> ดู Schema
                      </button>
                      <a href="{{ route('commissions.summary-sales-export', $commission->id) }}"
                         class="btn btn-sm bg-gradient-success px-3">
                          <i class="fas fa-file-excel me-1"></i> Export
                      </a>
                    </div>

                  <div class="table-scroll-wrapper">
                <!-- Scrollbar ด้านบน -->
                <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
                  .sc-top{
                    height:1px;
                  }
                </style>
                    <div class="table-scroll-top">
                        <div class="sc-top"></div> <!-- จะกำหนดความกว้างด้วย JS -->
                    </div>
                    <div class="table-responsive  table-scroll-bottom">
                        <table class="table table-hover align-items-center" id="sortableTable">
                            <thead>
                                    <tr id="tableHeader">
                                        <th data-column-index="0">Type <i class="fas fa-sort"></i></th>
                                        <th data-column-index="1">Account <i class="fas fa-sort"></i></th>
                                        <th data-column-index="2">Reference Document <i class="fas fa-sort"></i></th>
                                        <th data-column-index="3">Document Date <i class="fas fa-sort"></i></th>
                                        <th data-column-index="4">Clearing Date <i class="fas fa-sort"></i></th>
                                        <th data-column-index="5">Amount <i class="fas fa-sort"></i></th>
                                        <th data-column-index="6">Clearing Document <i class="fas fa-sort"></i></th>
                                        <th data-column-index="7">Rate (days) <i class="fas fa-sort"></i></th>
                                        <th data-column-index="8">Rate (%) <i class="fas fa-sort"></i></th>
                                        <th data-column-index="9">Commission <i class="fas fa-sort"></i></th>
                                        <th data-column-index="10">Remark <i class="fas fa-sort"></i></th>
                                    </tr>
                            </thead>
                            <tbody>
                                @forelse ($commissionArs as $ar)
                                    <tr>
                                        <td>{{ $ar->type }}</td>
                                        <td>{{ $ar->account . ' ' .$ar->name }}</td>
                                        <td>{{ $ar->reference_key }}</td>
                                        <td>{{ $ar->document_date }}</td>
                                        <td>{{ $ar->clearing_date }}</td>
                                        <td>
                                            {{ is_numeric($ar->amount_in_local_currency)
                                                ? number_format($ar->amount_in_local_currency, 2)
                                                : '-' }}
                                        </td>
                                        <td>{{ $ar->clearing_document }}</td>

                                        <td class="text-end">
                                          @if($ar->ar_rate_percent != '')
                                          {{ number_format($ar->ar_rate) }}
                                          @endif
                                        </td>
                                        <td class="text-end">{{ $ar->ar_rate_percent }}</td>
                                        <td class="text-end">{{ $ar->commissions }}</td>
                                        <td>{{ $ar->remark }}</td>

                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center text-muted">ไม่มีข้อมูล</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                  </div>
                  <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
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
            <label for="sales_code" class="form-label">Sales Code</label>
            <input type="text" class="form-control" name="sales_rep" id="sales_rep" required>
          </div>

          <div class="mb-3">
            <label for="invoice_no" class="form-label">Invoice No</label>
            <input type="text" class="form-control" name="reference_key" id="reference_key" required>
          </div>

          <div class="mb-3">
            <label for="commission" class="form-label">Commission</label>
            <input type="number" step="0.01" class="form-control" name="commissions" id="commissions" required>
          </div>

          <div class="mb-3">
            <label for="remark" class="form-label">Remark</label>
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

<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
  document.addEventListener("DOMContentLoaded", function () {
      // Go to Top Button
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

      // SortTable
      const headerRow = document.getElementById('tableHeader'); 
      if (headerRow) {
          const headerCells = headerRow.querySelectorAll('th');
          headerCells.forEach(headerCell => {
              headerCell.addEventListener('click', function() {
                  const columnIndex = this.getAttribute('data-column-index');
                  if (columnIndex !== null) {
                      sortTable(parseInt(columnIndex));
                  }
              });
          });
      }

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
  });
</script>
@endsection
