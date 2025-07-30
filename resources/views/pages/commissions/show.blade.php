@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'รายละเอียด Commission'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Commission: {{ $commission->sub_id }}</h5>
                        <small class="text-muted">แสดงข้อมูล AR ที่เกี่ยวข้อง</small>
                    </div>

                    <a href="{{ route('commissions.index') }}" class="btn bg-gradient-secondary btn-sm">
                        ← ย้อนกลับ
                    </a>
                </div>

                <div class="card-body pt-3">
                    <form method="GET" class="row g-2 mb-4">
                        <div class="col-md-9 col-sm-12">
                            <input type="text" name="search" class="form-control" placeholder="ค้นหา Account, Name หรือ Sales Rep" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 col-sm-12 text-end">
                            <button type="submit" class="btn bg-gradient-success w-100">
                                <i class="fas fa-search me-1"></i> ค้นหา
                            </button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover align-items-center">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Account</th>
                                    <th>Name</th>
                                    <th>Document Type</th>
                                    <th>Reference</th>
                                    <th>Reference Key</th>
                                    <th>Document Date</th>
                                    <th>Clearing Date</th>
                                    <th>Amount</th>
                                    <th>Local Currency</th>
                                    <th>Clearing Document</th>
                                    <th>Text</th>
                                    <th>Posting Key</th>
                                    <th>Sales Rep</th>

                                    <th>Billing Ref</th>
                                    <th>Sales Doc</th>
                                    <th>SalesOrder Date</th>
                                    <th>CN. (No.)</th>
                                    <th>CN. date (Date)</th>
                                    <th>Ext. Sales rep.</th>
                                    <th>Tax-Invoice</th>
                                    <th>SalesDoc Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($commissionArs as $ar)
                                    <tr>
                                        <td>{{ $ar->type }}</td>
                                        <td>{{ $ar->account }}</td>
                                        <td>{{ $ar->name }}</td>
                                        <td>{{ $ar->document_type }}</td>
                                        <td>{{ $ar->reference }}</td>
                                        <td>{{ $ar->reference_key }}</td>
                                        <td>{{ $ar->document_date }}</td>
                                        <td>{{ $ar->clearing_date }}</td>
                                        <td>
                                            {{ is_numeric($ar->amount_in_local_currency)
                                                ? number_format($ar->amount_in_local_currency, 2)
                                                : '-' }}
                                        </td>
                                        <td>{{ $ar->local_currency }}</td>
                                        <td>{{ $ar->clearing_document }}</td>
                                        <td>{{ $ar->text }}</td>
                                        <td>{{ $ar->posting_key }}</td>
                                        <td>{{ $ar->sales_rep }}</td>

                                        <td>{{ $ar->cn_billing_ref }}</td>
                                        <td>{{ $ar->cn_sales_doc }}</td>
                                        <td>{{ $ar->cn_order_date }}</td>
                                        <td>{{ $ar->cn_no }}</td>
                                        <td>{{ $ar->cn_date }}</td>
                                        <td>{{ $ar->cn_sales_name }}</td>
                                        <td>{{ $ar->cn_tax_invoice }}</td>
                                        <td>{{ $ar->cn_sales_doc_name }}</td>
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
@endsection
