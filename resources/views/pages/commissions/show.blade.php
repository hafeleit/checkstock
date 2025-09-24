@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'รายละเอียด Commission'])
    <script src="{{ asset('js/tom-select.complete.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/tom-select.bootstrap5.css') }}">


    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .table-scroll-wrapper {
            position: relative;
        }

        .table-scroll-top {
            overflow-x: auto;
            overflow-y: hidden;
            height: 20px;
            /* ความสูงให้เห็น scrollbar */
            background: #f8f9fa;
            /* สีพื้นหลังให้แยกจาก table */
            border-bottom: 1px solid #dee2e6;
        }

        .table-scroll-bottom {
            overflow-x: auto;
            /* table เลื่อนได้จริง */
        }

        .table-scroll-top div {
            height: 1px;
            /* spacer */
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
            height: 10px;
            /* ความสูงของ scrollbar */
        }

        .table-scroll-top::-webkit-scrollbar-track,
        .table-scroll-bottom::-webkit-scrollbar-track {
            background: #f1f1f1;
            /* สีพื้นหลัง track */
            border-radius: 10px;
        }

        .table-scroll-top::-webkit-scrollbar-thumb,
        .table-scroll-bottom::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            /* gradient thumb */
            border-radius: 10px;
            border: 2px solid #f1f1f1;
            /* ทำให้ดูเป็นแท่งนูนขึ้น */
        }

        .table-scroll-top::-webkit-scrollbar-thumb:hover,
        .table-scroll-bottom::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #43e97b, #38f9d7);
            /* เปลี่ยนสีเวลา hover */
        }

        /* สำหรับ Firefox */
        .table-scroll-top,
        .table-scroll-bottom {
            scrollbar-color: #dcdcdc #f1f1f1;
            /* thumb, track */
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
                                        {{ number_format($totalInitial, 2) }}
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
                                        {{ number_format($totalAdjustment, 2) }}
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
                                        {{ number_format($totalCommissions, 2) }}
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
                            status: <small
                                class="badge
                            {{ stripos($commission->status, 'Reject') !== false ? 'bg-danger' : 'bg-success' }}">
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
                                <input type="text" name="search" class="form-control"
                                    placeholder="ค้นหา Account, Name, Reference Document หรือ Sales Code, Name"
                                    value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2 col-sm-12 text-end">
                                <button type="submit" class="btn bg-gradient-success w-100">
                                    <i class="fas fa-search me-1"></i> ค้นหา
                                </button>
                            </div>
                        </form>
                        <div class="col-lg-12 col-md-3 col-sm-6 d-flex ">
                            <button type="button" class="btn btn-sm bg-gradient-secondary px-3 me-2" data-bs-toggle="modal"
                                data-bs-target="#schemaModal">
                                <i class="fas fa-table me-1"></i> ดู Schema
                            </button>
                            @if ($commission->status === 'calculated')
                                @can('Commissions AR-Approve')
                                    <div class="ms-auto">
                                        <form id="approve-form-{{ $commission->id }}"
                                            action="{{ route('commissions.updateStatus', $commission->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="AR Approved">
                                            <button type="button" class="btn btn-sm bg-gradient-info px-3"
                                                onclick="approveSwal('{{ $commission->id }}')">
                                                <i class="fas fa-check me-1"></i>AR Approve
                                            </button>
                                        </form>
                                    </div>
                                @endcan
                            @endif
                            @if ($commission->status === 'imported')
                                <!-- ปุ่ม calculated Commission -->
                                <form method="POST" action="{{ route('commissions.update', $commission->id) }}"
                                    id="calculated-form">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm bg-gradient-primary px-3">
                                        <i class="fas fa-calculator me-1"></i> calculated Commission
                                    </button>
                                </form>
                            @endif

                            @if (
                                $commission->status === 'AR Approved' ||
                                    $commission->status === 'Summary Confirmed' ||
                                    $commission->status === 'Summary Rejected(Manager)')
                                @can('Commissions AR-Adjust')
                                    <button type="button" class="btn btn-sm bg-gradient-warning px-3 me-2"
                                        data-bs-toggle="modal" data-bs-target="#adjustModal">
                                        <i class="fas fa-edit me-1"></i> Adjust
                                    </button>
                                @endcan
                                @can('Commissions Summary-Confirm')
                                    <!--
                                <div class="ms-auto">
                                    <form id="approve-form-{{ $commission->id }}"
                                          action="{{ route('commissions.updateStatus', $commission->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Summary Confirmed">
                                        <button type="button"
                                                class="btn btn-sm bg-gradient-info px-3"
                                                onclick="approveSwal_confirm('{{ $commission->id }}')">
                                            <i class="fas fa-check me-1"></i>Summary Confirmed
                                        </button>
                                    </form>
                                </div>
                                -->
                                @endcan
                            @endif
                            @can('Commissions AR-Adjust')
                                <button type="button" class="btn btn-sm bg-gradient-info px-3 me-2" id="export-btn"
                                    data-url="{{ route('commissions.export', $commission->id) }}">
                                    <i class="fas fa-file-export me-1"></i> Export
                                </button>
                            @endcan
                            @can('Commissions Summary-View')
                                <div class="ms-auto">
                                    <a href="{{ route('commissions.sales-summary', $commission->id) }}"
                                        class="btn btn-sm bg-gradient-info px-3">
                                        <i class="fas fa-file-export me-1"></i> ดูยอดรวม
                                    </a>
                                </div>
                            @endcan

                        </div>


                        <div class="table-scroll-wrapper">
                            <!-- Scrollbar ด้านบน -->
                            <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
                                .sc-top {
                                    height: 1px;
                                }
                            </style>
                            <div class="table-scroll-top">
                                <div class="sc-top"></div> <!-- จะกำหนดความกว้างด้วย JS -->
                            </div>
                            <div class="table-responsive table-scroll-bottom">
                                <table class="table table-hover align-items-center" id="sortableTable">
                                    <thead>
                                        <tr>
                                            <th onclick="sortTable(0)">Type <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(1)">Account<i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(2)">Reference <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(3)">Reference Document <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(4)">Document Date <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(5)">Clearing Date <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(6)">Amount <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(7)">Clearing Document <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(8)">Document Type <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(9)">Text <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(10)">Sales Rep <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(11)">Team <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(12)">Rate (days) <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(13)">Rate (%) <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(14)">Commission <i class="fas fa-sort"></i></th>
                                            <th onclick="sortTable(15)">Remark <i class="fas fa-sort"></i></th>
                                            <th></th> <!-- ปุ่มหรือ action อื่นๆ -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($commissionArs as $ar)
                                            <tr>
                                                <td>{{ $ar->type }}</td>
                                                <td>{{ $ar->account . ' - ' . $ar->name }}</td>
                                                <td>{{ $ar->reference }}</td>
                                                <td>{{ $ar->reference_key }}</td>
                                                <td>{{ $ar->document_date }}</td>
                                                <td>{{ $ar->clearing_date }}</td>
                                                <td>
                                                    {{ is_numeric($ar->amount_in_local_currency) ? number_format($ar->amount_in_local_currency, 2) : '-' }}
                                                </td>
                                                <td>{{ $ar->clearing_document }}</td>
                                                <td>{{ $ar->document_type }}</td>
                                                <td>{{ $ar->text }}</td>
                                                <td>{{ $ar->sales_rep . ' - ' . $ar->name_en }}</td>
                                                <td>{{ $ar->division }}</td>
                                                <td class="text-end">
                                                    @if ($ar->ar_rate_percent != '')
                                                        {{ number_format($ar->ar_rate) }}
                                                    @endif
                                                </td>
                                                <td class="text-end">{{ $ar->ar_rate_percent }}</td>
                                                <td class="text-end">{{ $ar->commissions }}</td>
                                                <td>{{ $ar->remark }}</td>
                                                <td>
                                                    @if ($ar->type === 'Adjust')
                                                        @can('Commissions AR-Adjust')
                                                            <button type="button" class="btn btn-sm btn-warning"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editAdjustModal{{ $ar->id }}">
                                                                <i class="fas fa-edit me-1"></i> แก้ไข
                                                            </button>
                                                            <!-- ปุ่มลบ -->
                                                            <form method="POST"
                                                                action="{{ route('commissions.adjust.delete', $ar->id) }}"
                                                                class="d-inline delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger btn-delete">
                                                                    <i class="fas fa-trash me-1"></i> ลบ
                                                                </button>
                                                            </form>
                                                        @endcan
                                                        <div class="modal fade" id="editAdjustModal{{ $ar->id }}"
                                                            tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form method="POST"
                                                                    action="{{ route('commissions.adjust.update', $ar->id) }}"
                                                                    class="needs-validation" novalidate>
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">แก้ไข Adjust</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"></button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <!-- Sales Rep -->
                                                                            <div class="mb-3">
                                                                                <label
                                                                                    for="sales_rep_edit_{{ $ar->id }}">Sales
                                                                                    Rep <span
                                                                                        class="text-danger">*</span></label>
                                                                                <select
                                                                                    id="sales_rep_edit_{{ $ar->id }}"
                                                                                    name="sales_rep" class="form-select"
                                                                                    required>
                                                                                    <option value="">-- Select Sales
                                                                                        Rep --</option>
                                                                                    @foreach ($salesReps as $rep)
                                                                                        <option
                                                                                            value="{{ $rep->sales_rep }}"
                                                                                            {{ $rep->sales_rep == $ar->sales_rep ? 'selected' : '' }}>
                                                                                            {{ $rep->sales_rep }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <div class="invalid-feedback">กรุณาเลือก
                                                                                    Sales Rep</div>
                                                                            </div>

                                                                            <!-- Reference Document -->
                                                                            <div class="mb-3">
                                                                                <label>Reference Document <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text" class="form-control"
                                                                                    name="reference_key"
                                                                                    value="{{ $ar->reference_key }}"
                                                                                    required>
                                                                                <div class="invalid-feedback">กรุณากรอก
                                                                                    Reference Document</div>
                                                                            </div>

                                                                            <!-- Commissions -->
                                                                            <div class="mb-3">
                                                                                <label>Commissions <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="number" step="0.01"
                                                                                    class="form-control"
                                                                                    name="commissions"
                                                                                    value="{{ $ar->commissions }}"
                                                                                    required>
                                                                                <div class="invalid-feedback">กรุณากรอก
                                                                                    Commissions</div>
                                                                            </div>

                                                                            <!-- Remark (with previous remarks + create new) -->
                                                                            <div class="mb-3">
                                                                                <label>Remark <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text"
                                                                                    id="remark_edit_{{ $ar->id }}"
                                                                                    name="remark" class="form-control"
                                                                                    value="{{ $ar->remark }}" required>
                                                                                <div class="invalid-feedback">กรุณากรอก
                                                                                    Remark</div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary btn-sm"
                                                                                data-bs-dismiss="modal">ปิด</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary btn-sm">บันทึก</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <!-- TomSelect scripts -->
                                                        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                // Sales Rep
                                                                new TomSelect("#sales_rep_edit_{{ $ar->id }}", {
                                                                    create: false,
                                                                    sortField: {
                                                                        field: "text",
                                                                        direction: "asc"
                                                                    },
                                                                    placeholder: "-- Select Sales Rep --"
                                                                });

                                                                // Remark
                                                                new TomSelect("#remark_edit_{{ $ar->id }}", {
                                                                    create: true, // พิมพ์เองได้
                                                                    maxItems: 1,
                                                                    options: [
                                                                        @foreach ($previousRemarks as $r)
                                                                            {
                                                                                value: "{{ $r }}",
                                                                                text: "{{ $r }}"
                                                                            },
                                                                        @endforeach
                                                                    ],
                                                                    placeholder: "Select or type Remark"
                                                                });
                                                            });
                                                        </script>

                                                        <!-- Bootstrap validation -->
                                                        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
                                                            (() => {
                                                                'use strict'
                                                                const forms = document.querySelectorAll('.needs-validation')
                                                                Array.from(forms).forEach(form => {
                                                                    form.addEventListener('submit', event => {
                                                                        if (!form.checkValidity()) {
                                                                            event.preventDefault()
                                                                            event.stopPropagation()
                                                                        }
                                                                        form.classList.add('was-validated')
                                                                    }, false)
                                                                })
                                                            })
                                                            ();
                                                        </script>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">ไม่มีข้อมูล</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
                            document.addEventListener("DOMContentLoaded", function() {
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

                        <div class="d-flex justify-content-center mt-4">
                            {{ $commissionArs->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Adjust Commission Modal -->
    <div class="modal fade" id="adjustModal" tabindex="-1" aria-labelledby="adjustModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('commissions.adjust', $commission->id) }}" class="needs-validation"
                novalidate>
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adjustModalLabel">Adjust Commission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Sales Rep -->
                        <div class="mb-3">
                            <label for="sales_rep" class="form-label">Sales Code <span
                                    class="text-danger">*</span></label>
                            <select id="sales_rep" name="sales_rep" class="form-select" required>
                                <option value="">-- Select Sales Rep --</option>
                                @foreach ($salesReps as $rep)
                                    <option value="{{ $rep->sales_rep }}">{{ $rep->sales_rep }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">กรุณาเลือก Sales Code</div>
                        </div>

                        <!-- Reference Document -->
                        <div class="mb-3">
                            <label for="reference_key" class="form-label">Reference Document / Credit Note Number <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="reference_key" id="reference_key" required>
                            <div class="invalid-feedback">กรุณากรอก Reference Document / Credit Note Number</div>
                        </div>

                        <!-- Commission Amount -->
                        <div class="mb-3">
                            <label for="commissions" class="form-label">Commission Amount(THB) <span
                                    class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="commissions"
                                id="commissions" required>
                            <div class="invalid-feedback">กรุณากรอก Commission Amount</div>
                        </div>

                        <!-- Reason (with previous remarks) -->
                        <div class="mb-3">
                            <label for="remark" class="form-label">Reason <span class="text-danger">*</span></label>
                            <input type="text" id="remark" name="remark" class="form-control" required>
                            <div class="invalid-feedback">กรุณากรอก Reason</div>
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

    <!-- TomSelect scripts -->
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        document.addEventListener("DOMContentLoaded", function() {
            // Sales Rep
            new TomSelect("#sales_rep", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "-- Select Sales Rep --"
            });

            // Reason (previous remarks + allow typing new)
            new TomSelect("#remark", {
                create: true, // อนุญาตพิมพ์เองได้
                maxItems: 1,
                options: [
                    @foreach ($previousRemarks as $r)
                        {
                            value: "{{ $r }}",
                            text: "{{ $r }}"
                        },
                    @endforeach
                ],
                placeholder: "Select or type Reason"
            });
        });
    </script>

    <!-- Bootstrap validation -->
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })();
    </script>

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
                                        @foreach ($columns as $range)
                                            <th>{{ $range }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($schemaTable as $division => $rates)
                                        <tr>
                                            <td class="text-start">{{ $division }}</td>
                                            @foreach ($columns as $range)
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

    @if (session('adjust_success'))
        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
            Swal.fire({
                icon: 'success',
                title: 'ปรับค่าคอมมิชชั่นสำเร็จ!',
                text: 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว',
                confirmButtonText: 'ตกลง'
            });
        </script>
    @endif

    @if (session('adjust_updated'))
        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
            Swal.fire({
                icon: 'success',
                title: 'บันทึกสำเร็จ',
                text: 'ปรับปรุงข้อมูล Adjust เรียบร้อยแล้ว',
            });
        </script>
    @endif

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        $(document).ready(function() {
            $('.btn-delete').click(function(e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: "รายการนี้จะถูกลบถาวร!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'ใช่, ลบเลย!',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // submit form DELETE
                    }
                });
            });
        });
    </script>
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        document.getElementById('export-btn')?.addEventListener('click', function() {
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

                    return response.blob().then(blob => ({
                        blob,
                        filename
                    }));
                })
                .then(({
                    blob,
                    filename
                }) => {
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
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        document.addEventListener("DOMContentLoaded", function() {
            const calculatedForm = document.getElementById('calculated-form');
            if (calculatedForm) {
                calculatedForm.addEventListener('submit', function(e) {
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
            }
        });
    </script>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
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

        function approveSwal(id) {
            Swal.fire({
                title: 'ยืนยันการ Approve?',
                text: "เมื่ออนุมัติแล้วสถานะจะถูกเปลี่ยนเป็น AR Approved",
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

        function approveSwal_confirm(id) {
            Swal.fire({
                title: 'ยืนยันการ Confirm?',
                text: "เมื่ออนุมัติแล้วสถานะจะถูกเปลี่ยนเป็น Summary Contirm",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, Confirm เลย!',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approve-form-' + id).submit();
                }
            });
        }
    </script>
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        document.addEventListener("DOMContentLoaded", function() {
            const goTopBtn = document.getElementById("goTopBtn");

            window.addEventListener("scroll", () => {
                if (window.scrollY > 300) {
                    goTopBtn.classList.add("show");
                } else {
                    goTopBtn.classList.remove("show");
                }
            });

            goTopBtn.addEventListener("click", () => {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            });
        });
    </script>
@endsection
