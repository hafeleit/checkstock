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
                            <input type="text" name="search" class="form-control" placeholder="ค้นหา Reference key" value="{{ request('search') }}">
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
                    <div class="table-responsive">

                        <table class="table table-hover align-items-center">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Account</th>
                                    <th>Reference Key</th>
                                    <th>Document Date</th>
                                    <th>Clearing Date</th>
                                    <th>Amount</th>
                                    <th>Clearing Document</th>
                                    <th>Billing Ref</th>
                                    <th>Sales Doc</th>
                                    <th>SalesOrder Date</th>
                                    <th>CN. (No.)</th>
                                    <th>CN. date (Date)</th>
                                    <th>Tax-Invoice</th>
                                    <th>Rate (days)</th>
                                    <th>Rate (%)</th>
                                    <th>Commission</th>
                                    <th>Remark</th>
                                    <th></th>
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
                                                            <label>Reference Key</label>
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
