@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

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
                        <small class="text-muted">Status: {{ $commission->status }}</small>
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
                              class="btn btn-sm bg-gradient-secondary px-3"
                              data-bs-toggle="modal"
                              data-bs-target="#schemaModal">
                          <i class="fas fa-table me-1"></i> ดู Schema
                      </button>
                      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center" id="sortableTable">
                            <thead>
                                    <tr>
                                        <th onclick="sortTable(0)">Type <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(1)">Account <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(2)">Reference Document <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(3)">Document Date <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(4)">Clearing Date <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(5)">Amount <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(6)">Clearing Document <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(7)">Sales Rep <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(8)">Billing Ref <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(9)">Sales Doc <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(10)">SalesOrder Date <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(11)">CN. (No.) <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(12)">CN. date (Date) <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(13)">Tax-Invoice <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(14)">Rate (days) <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(15)">Rate (%) <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(16)">Commission <i class="fas fa-sort"></i></th>
                                        <th onclick="sortTable(17)">Remark <i class="fas fa-sort"></i></th>
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
                                        <td>{{ $ar->sales_rep }}</td>
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


@endsection
