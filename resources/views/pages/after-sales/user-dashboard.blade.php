@extends('layouts.after-sales-user')

@section('title', 'After-Sales Dashboard')
@section('subtitle', now()->format('F Y'))

@php
    $csiSurvey = $csi_response_data['survey_data'];
    $csiResponses = (int) ($csiSurvey->total ?? 0);
    $csiTotal = (int) ($csi_response_data['total_ticket'] ?? 0);
    $csiRate = $csiTotal > 0 ? round(($csiResponses / $csiTotal) * 100, 1) : 0;
    $csiSatPct = $csiResponses > 0 ? round(($csiSurvey->service_very_good / $csiResponses) * 100, 1) : 0;

    $agingTotal = array_sum([
        $aging_data['0-3'],
        $aging_data['4-7'],
        $aging_data['8-15'],
        $aging_data['16-30'],
        $aging_data['over_30'],
    ]);
    $agPct = fn($v) => $agingTotal > 0 ? round((100 * $v) / $agingTotal, 1) : 0;

    $kpis = [
        [
            'id' => 'ud-csi-chart',
            'label' => 'CSI',
            'value' => "{$csiSatPct}%",
            'target' => '95.0%',
            'grade' => 'B',
            'grade_color' => 'yellow',
        ],
        [
            'id' => 'ud-rtat-chart',
            'label' => 'R_TAT',
            'value' => $rtat['overall'],
            'target' => '8.9 days',
            'grade' => 'B',
            'grade_color' => 'yellow',
            'sub' => "BKK: {$rtat['bkk']} (TG 3.0)",
        ],
        [
            'id' => 'ud-ltp-chart',
            'label' => 'LTP',
            'value' => "{$ltp}%",
            'target' => '70.0%',
            'grade' => 'C',
            'grade_color' => 'red',
        ],
        [
            'id' => 'ud-ftf-chart',
            'label' => 'FTF',
            'value' => "{$ftf}%",
            'target' => '80.0%',
            'grade' => 'A',
            'grade_color' => 'green',
        ],
    ];
    $gradeBadge = [
        'yellow' => 'bg-yellow-100 text-yellow-700',
        'red' => 'bg-red-100 text-red-700',
        'green' => 'bg-green-100 text-green-700',
    ];
@endphp

@push('styles')
    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .ud-aging-seg {
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
        }

        /* Aging bar */
        .ud-aging-bar {
            display: flex;
            height: 24px;
            border-radius: 8px;
            overflow: hidden;
        }

        .ud-ag-0,
        .bg-0-3 {
            background-color: #10b981;
        }

        .ud-ag-1,
        .bg-4-7 {
            background-color: #84cc16;
        }

        .ud-ag-2,
        .bg-8-15 {
            background-color: #facc15;
        }

        .ud-ag-3,
        .bg-16-30 {
            background-color: #fb923c;
        }

        .ud-ag-4,
        .bg-over-30 {
            background-color: #ef4444;
        }

        /* Chart wrappers */
        .ud-chart-wrap {
            position: relative;
        }

        .ud-h-280 {
            height: 280px;
        }

        .ud-h-300 {
            height: 300px;
        }

        .ud-h-200 {
            height: 200px;
        }

        .ud-h-120 {
            height: 120px;
        }

        .ud-rowc-wrap {
            position: relative;
            min-height: 120px;
        }

        /* Pending overview */
        .ud-pending-flex {
            display: flex;
            gap: 12px;
            height: 300px;
        }

        .ud-pie-wrap {
            width: 35%;
            position: relative;
        }

        .ud-bar-flex {
            flex: 1;
            position: relative;
        }

        /* CSI sat bar */
        .ud-sat-bar-wrap {
            width: 50%;
            position: relative;
            height: 120px;
        }
    </style>
@endpush

@section('content')

    {{-- SECTION 1 — KPI (dashboard-1) --}}
    <p class="text-md font-bold uppercase tracking-widest text-gray-800 mb-2">Key Performance Indicators — {{ now()->format('F Y') }}</p>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">

        @foreach ($kpis as $kpi)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-3 flex items-center gap-3">
                <div class="relative w-24 h-24 flex-shrink-0">
                    <canvas id="{{ $kpi['id'] }}"></canvas>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-md text-gray-400 uppercase tracking-widest font-semibold">{{ $kpi['label'] }}</p>
                    <div class="flex items-baseline gap-2 mt-0.5">
                        <span class="text-xl font-bold text-gray-800">{{ $kpi['value'] }}</span>
                        <span class="text-md font-bold px-1.5 py-0.5 rounded {{ $gradeBadge[$kpi['grade_color']] }}">Grade {{ $kpi['grade'] }}</span>
                    </div>
                    <p class="text-md text-gray-400 mt-0.5">Target: <span class="font-semibold text-gray-600">{{ $kpi['target'] }}</span></p>
                    @isset($kpi['sub'])
                        <p class="text-md text-gray-400 mt-0.5">{{ $kpi['sub'] }}</p>
                    @endisset

                    <a href="{{ route('after-sales.detail', ['chart' => $kpi['id']]) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                        View Detail →
                    </a>
                </div>
                
            </div>
        @endforeach

    </div>

    {{-- SECTION 2 — Ticket Stats + Aging (dashboard-2) --}}
    <div class="flex gap-4 items-center mb-2">
        <p class="text-md font-bold uppercase tracking-widest text-gray-800">Ticket Statistics</p>
        <a href="{{ route('after-sales.detail', ['chart' => 'ud-ticket-by-status-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
            View Detail →
        </a>
    </div>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-3">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-3 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="text-blue-600" viewBox="0 0 16 16">
                    <path
                        d="M4 4.85v.9h1v-.9zm7 0v.9h1v-.9zm-7 1.8v.9h1v-.9zm7 0v.9h1v-.9zm-7 1.8v.9h1v-.9zm7 0v.9h1v-.9zm-7 1.8v.9h1v-.9zm7 0v.9h1v-.9z" />
                    <path
                        d="M1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13h13a1.5 1.5 0 0 0 1.5-1.5V10a.5.5 0 0 0-.5-.5 1.5 1.5 0 0 1 0-3A.5.5 0 0 0 16 6V4.5A1.5 1.5 0 0 0 14.5 3zM1 4.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v1.05a2.5 2.5 0 0 0 0 4.9v1.05a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-1.05a2.5 2.5 0 0 0 0-4.9z" />
                </svg>
            </div>
            <div>
                <p class="text-md text-gray-400 font-medium">Total Created</p>
                <p class="text-2xl font-bold text-gray-800 leading-none">{{ $total_stat_data['total'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-3 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="text-yellow-600" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                    <path
                        d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                </svg>
            </div>
            <div>
                <p class="text-md text-gray-400 font-medium">Total Closed</p>
                <p class="text-2xl font-bold text-gray-800 leading-none">{{ $total_stat_data['total_closed'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-3 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="text-red-600" viewBox="0 0 16 16">
                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                </svg>
            </div>
            <div>
                <p class="text-md text-gray-400 font-medium">Total Pending</p>
                <p class="text-2xl font-bold text-gray-800 leading-none">{{ $total_stat_data['total_pending'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-3">
            <div class="flex items-center justify-around">
                <div class="text-center">
                    <p class="text-xl font-bold text-yellow-600 leading-none">{{ $total_stat_data['total_open'] }}</p>
                    <p class="text-md text-gray-400 mt-0.5 uppercase tracking-wider">Open</p>
                </div>
                <div class="w-px h-8 bg-gray-200"></div>
                <div class="text-center">
                    <p class="text-xl font-bold text-yellow-400 leading-none">{{ $total_stat_data['total_in_prog'] }}</p>
                    <p class="text-md text-gray-400 mt-0.5 uppercase tracking-wider">In Prog</p>
                </div>
                <div class="w-px h-8 bg-gray-200"></div>
                <div class="text-center">
                    <p class="text-xl font-bold text-red-500 leading-none">{{ $total_stat_data['total_reason'] }}</p>
                    <p class="text-md text-gray-400 mt-0.5 uppercase tracking-wider">Reason</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Aging Bar --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-3 mb-6">
        <div class="flex items-center justify-between mb-2">
            <div class="space-x-4">
                <span class="text-sm font-semibold text-gray-600 uppercase tracking-widest">Overall Aging</span>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-aging-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail →
                </a>
            </div>
            <div class="self-stretch flex items-center bg-white px-2 rounded-lg gap-2 text-xs font-medium">
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 rounded-full bg-0-3"></div><span class="text-gray-600">0-3 Days</span>
                </div>
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 rounded-full bg-4-7"></div><span class="text-gray-600">4-7 Days</span>
                </div>
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 rounded-full bg-8-15"></div><span class="text-gray-600">8-15 Days</span>
                </div>
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 rounded-full bg-16-30"></div><span class="text-gray-600">16-30 Days</span>
                </div>
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 rounded-full bg-over-30"></div><span class="text-gray-600">Over 30 Days</span>
                </div>
            </div>
        </div>
        <div class="ud-aging-bar">
            <div class="ud-aging-seg ud-ag-0" id="ud-ag-0"></div>
            <div class="ud-aging-seg ud-ag-1" id="ud-ag-1"></div>
            <div class="ud-aging-seg ud-ag-2" id="ud-ag-2"></div>
            <div class="ud-aging-seg ud-ag-3" id="ud-ag-3"></div>
            <div class="ud-aging-seg ud-ag-4" id="ud-ag-4"></div>
        </div>
    </div>

    {{-- SECTION 3 — CSI Details (dashboard-1) --}}
    <div class="flex items-center gap-4 mb-2">
        <p class="text-md font-bold uppercase tracking-widest text-gray-800">Customer Satisfaction Index</p>
        <a href="{{ route('after-sales.detail', ['chart' => 'ud-csi-response-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
            View Detail →
        </a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mb-6">

        {{-- Responses + Satisfaction --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex gap-4 h-full">
                {{-- Response rate --}}
                <div class="flex-shrink-0 bg-gray-100 rounded-lg p-3 flex flex-col justify-center gap-1 w-40">
                    <p class="text-md text-gray-400 uppercase font-semibold">Responses</p>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-bold text-red-600">{{ number_format($csiResponses) }}</span>
                        <span class="text-sm text-gray-400">/ {{ number_format($csiTotal) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                        <div class="h-1.5 rounded-full bg-yellow-400" id="ud-csi-rate-bar"></div>
                    </div>
                    <span class="text-sm font-bold text-yellow-600">{{ $csiRate }}% Rate</span>
                </div>
                {{-- Satisfaction --}}
                <div class="flex-1 flex flex-col">
                    <p class="text-md text-center text-gray-500 mb-2">Are you satisfied with the service team?</p>
                    <div class="flex items-center justify-center gap-4 flex-1">
                        <div class="relative w-24 h-24 flex-shrink-0">
                            <canvas id="ud-sat-doughnut"></canvas>
                        </div>
                        <div class="ud-sat-bar-wrap">
                            <canvas id="ud-sat-bar"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4 Mini Q --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="grid grid-cols-2 gap-3 h-full">
                @foreach ([['ud-q1-chart', 'Problem resolved?'], ['ud-q2-chart', 'Arrived as scheduled?'], ['ud-q3-chart', 'Polite & well mannered?'], ['ud-q4-chart', 'Charged expenses?']] as [$qid, $qlabel])
                    <div class="flex flex-col items-center justify-center gap-1">
                        <div class="relative w-20 h-20"><canvas id="{{ $qid }}"></canvas></div>
                        <p class="text-md text-gray-500 text-center leading-tight">{{ $qlabel }}</p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- SECTION 4 — Pending Analysis (dashboard-2) --}}
    <p class="text-md font-bold uppercase tracking-widest text-gray-800 mb-2">Pending Analysis</p>

    {{-- Row A (2 cols equal): Reason | Pending Overview --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3">

        {{-- Reason — 6 rows stacked aging --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center gap-4 mb-2">
                <p class="text-md font-semibold text-gray-600">Pending Reason (by Aging)</p>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-pending-reason-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail →
                </a>
            </div>
            
            <div class="ud-chart-wrap ud-h-300">
                <canvas id="ud-reason-chart"></canvas>
            </div>
        </div>

        {{-- Pending Overview --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center gap-4 mb-2">
                <p class="text-md font-semibold text-gray-600">Pending Overview (ASC vs Hafele)</p>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-pending-overview-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail →
                </a>
            </div>
            <div class="ud-pending-flex">
                <div class="ud-pie-wrap"><canvas id="ud-pending-pie"></canvas></div>
                <div class="ud-bar-flex"><canvas id="ud-pending-bar"></canvas></div>
            </div>
        </div>

    </div>

    {{-- Row B (2 cols equal): Status | Region --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-md font-semibold text-gray-600 mb-2">Status Overview (by Aging)</p>
            <div class="ud-chart-wrap ud-h-200"><canvas id="ud-status-chart"></canvas></div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-md font-semibold text-gray-600 mb-2">Pending by Region</p>
            <div class="ud-chart-wrap ud-h-200" id="ud-region-wrap"><canvas id="ud-region-chart"></canvas></div>
        </div>

    </div>

    {{-- Row C (2 cols equal): In-House | ASC — dynamic height เท่ากันทั้งคู่ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-md font-semibold text-gray-600 mb-2">In-House Pending by Team</p>
            <div id="ud-inhouse-wrap" class="ud-rowc-wrap"><canvas id="ud-inhouse-chart"></canvas></div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-md font-semibold text-gray-600 mb-2">ASC Pending by Region</p>
            <div id="ud-asc-wrap" class="ud-rowc-wrap"><canvas id="ud-asc-chart"></canvas></div>
        </div>

    </div>

    {{-- Row D (3 cols equal): Type | Product Group | Pending by Product --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mb-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-md font-semibold text-gray-600 mb-2">Pending by Type</p>
            <div class="ud-chart-wrap ud-h-200"><canvas id="ud-type-chart"></canvas></div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-md font-semibold text-gray-600 mb-2">Pending Product Group</p>
            <div class="ud-chart-wrap ud-h-200"><canvas id="ud-product-group-chart"></canvas></div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-md font-semibold text-gray-600 mb-2">Pending by Product</p>
            <div class="ud-chart-wrap ud-h-200"><canvas id="ud-product-aging-chart"></canvas></div>
        </div>

    </div>

    {{-- SECTION 5 — Trends (dashboard-1) --}}
    <p class="text-md font-bold uppercase tracking-widest text-gray-800 mb-2">Trends</p>
    <div class="grid grid-cols-1 gap-3 mb-6">

        {{-- Ticket: datalabels หมุน -90° ต้องมี top padding → ต้องสูงพอ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-md font-semibold text-gray-600 mb-2">Ticket Open vs Close</p>
            <div class="ud-chart-wrap ud-h-280"><canvas id="ud-ticket-chart"></canvas></div>
        </div>

        {{-- Contract: line 12 เดือน 2 เส้น datalabels ด้านบน --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-md font-semibold text-gray-600 mb-2">Contract Center Trend</p>
            <div class="ud-chart-wrap ud-h-280"><canvas id="ud-contract-chart"></canvas></div>
        </div>

        {{-- Daily: datalabels หนาแน่น ต้องสูงพอให้ไม่ทับกัน --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-md font-semibold text-gray-600 mb-2">Daily Performance ({{ now()->format('F') }})</p>
            <div class="ud-chart-wrap ud-h-280"><canvas id="ud-daily-chart"></canvas></div>
        </div>

    </div>

@endsection

@push('scripts')
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        // ── Center-text plugin ──
        Chart.register({
            id: 'centerText',
            beforeDraw(chart) {
                if (chart.config.type !== 'doughnut') {
                    return;
                }
                const cfg = chart.config.options?.elements?.center;
                if (!cfg) {
                    return;
                }
                const ctx = chart.ctx;
                const txt = cfg.text;
                ctx.font = 'bold 12px Arial';
                const ratio = ((chart.innerRadius * 2) - 20) / ctx.measureText(txt).width;
                ctx.font = `bold ${Math.min(Math.floor(30 * ratio), 70)}px Arial`;
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillStyle = cfg.color || '#000';
                ctx.fillText(txt, (chart.chartArea.left + chart.chartArea.right) / 2, (chart.chartArea.top + chart
                    .chartArea.bottom) / 2);
            }
        });
        Chart.register(ChartDataLabels);

        // ── Raw data จาก controller (normalize ใน JS) ──
        const udAgingRaw = {!! json_encode($aging_data) !!};
        const udCsiSurvey = {!! json_encode($csiSurvey) !!};
        const udPendingData = {!! json_encode($pending_data) !!};
        const udTicketData = {!! json_encode($ticket_status_data) !!};
        const udContractData = {!! json_encode($contract_center_data) !!};
        const udDailyData = {!! json_encode($contract_daily_data) !!};
        const rawReasonData = {!! json_encode($pending_reason_data) !!};
        const rawStatusData = {!! json_encode($status_data) !!};
        const rawInhouseData = {!! json_encode($inhouse_pending_data) !!};
        const rawAscData = {!! json_encode($asc_pending_data) !!};
        const rawRegionData = {!! json_encode($pending_region_data) !!};
        const rawPendingType = {!! json_encode($pending_type_data) !!};

        // ── Overall Aging Bar (set width + label via JS) ──
        (function() {
            const keys = ['0-3', '4-7', '8-15', '16-30', 'over_30'];
            const total = keys.reduce((s, k) => s + (udAgingRaw[k] || 0), 0) || 1;
            keys.forEach((key, i) => {
                const v = udAgingRaw[key] || 0;
                const pct = Math.round(v / total * 1000) / 10;
                const el = document.getElementById('ud-ag-' + i);
                el.style.width = pct + '%';
                if (pct > 5) {
                    el.textContent = v;
                }
            });
        })();
        document.getElementById('ud-csi-rate-bar').style.width = '{{ $csiRate }}%';

        // ── Normalize rows ───
        const reasonLabelMap = {
            'Spare_part_on_progress': 'Spare Part',
            'Site_not_ready_or_waiting_confirm': 'Site Not Ready',
            'Postpone_or_new_appointment': 'Postpone',
            'Process_return_or_change_set': 'Return/Change',
            'Waiting_service_schedule_Technician': 'Waiting Tech',
            'blank': 'No Reason',
        };

        const udReasonRows = Object.entries(rawReasonData)
            .filter(([, d]) => Object.values(d).some(v => v > 0))
            .map(([key, d]) => ({
                label: reasonLabelMap[key] ?? key,
                '0_3': d['0-3'],
                '4_7': d['4-7'],
                '8_15': d['8-15'],
                '16_30': d['16-30'],
                'over_30': d['over_30'],
            }));

        const udStatusRows = [{
                label: 'Pending Reason',
                '0_3': rawStatusData.reason_0_3 ?? 0,
                '4_7': rawStatusData.reason_4_7 ?? 0,
                '8_15': rawStatusData.reason_8_15 ?? 0,
                '16_30': rawStatusData.reason_16_30 ?? 0,
                'over_30': rawStatusData.reason_over_30 ?? 0
            },
            {
                label: 'In Progress',
                '0_3': rawStatusData.in_prog_0_3 ?? 0,
                '4_7': rawStatusData.in_prog_4_7 ?? 0,
                '8_15': rawStatusData.in_prog_8_15 ?? 0,
                '16_30': rawStatusData.in_prog_16_30 ?? 0,
                'over_30': rawStatusData.in_prog_over_30 ?? 0
            },
            {
                label: 'Open',
                '0_3': rawStatusData.open_0_3 ?? 0,
                '4_7': rawStatusData.open_4_7 ?? 0,
                '8_15': rawStatusData.open_8_15 ?? 0,
                '16_30': rawStatusData.open_16_30 ?? 0,
                'over_30': rawStatusData.open_over_30 ?? 0
            },
        ];

        // collection keyed by name → array, filter empty
        const normalizeAgingRows = (data) => Object.entries(data)
            .filter(([k, d]) => k && (d.days_0_3 || 0) + (d.days_4_7 || 0) + (d.days_8_15 || 0) + (d.days_16_30 || 0) + (d
                .days_over_30 || 0) > 0)
            .map(([k, d]) => ({
                label: k,
                '0_3': d.days_0_3 ?? 0,
                '4_7': d.days_4_7 ?? 0,
                '8_15': d.days_8_15 ?? 0,
                '16_30': d.days_16_30 ?? 0,
                'over_30': d.days_over_30 ?? 0
            }));

        const udInhouseRows = normalizeAgingRows(rawInhouseData);
        const udAscRows = normalizeAgingRows(rawAscData);
        const udRegionRows = normalizeAgingRows(rawRegionData);

        // คำนวณ height ตามจำนวน rows: rowHeight × n + legend
        const dynamicHeight = (rows, rowH = 38, legendH = 40) => Math.max(120, rows.length * rowH + legendH);
        const rowCHeight = Math.max(dynamicHeight(udInhouseRows), dynamicHeight(udAscRows));
        document.getElementById('ud-inhouse-wrap').style.height = rowCHeight + 'px';
        document.getElementById('ud-asc-wrap').style.height = rowCHeight + 'px';

        const udTypeData = {
            labels: ['Installation', 'Repair', 'Spare Part', 'Onsite Consult', 'Phone Consult'],
            values: [
                rawPendingType.total_installation ?? 0,
                rawPendingType.total_repair ?? 0,
                rawPendingType.total_sparepart ?? 0,
                rawPendingType.total_onsite ?? 0,
                rawPendingType.total_phone ?? 0,
            ],
        };

        // ── Palette ──
        const C = {
            primary: '#1e40af',
            critical: '#c70e0e',
            darkRed: '#e11d48',
            darkPurple: '#300613',
            lightRed: '#fecdd3',
            lightPink: '#ffd6fa',
        };
        const AG = ['#10b981', '#facc15', '#fb923c', '#ef4444', '#881337'];
        const agingKeys = ['0_3', '4_7', '8_15', '16_30', 'over_30'];
        const agingLabels = ['0-3 Days', '4-7 Days', '8-15 Days', '16-30 Days', '>30 Days'];

        // ── Helpers ──
        const doughnutOpts = {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                datalabels: {
                    display: false
                },
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            },
        };

        const makeKpiDoughnut = (id, value) => new Chart(document.getElementById(id), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [Math.min(value, 100), Math.max(0, 100 - value)],
                    backgroundColor: [value >= 100 ? '#10b981' : C.critical, C.lightRed],
                    borderWidth: 0
                }]
            },
            options: {
                ...doughnutOpts,
                elements: {
                    center: {
                        text: value + '%',
                        color: C.primary
                    }
                }
            },
        });

        const makeSatDoughnut = (id, value, text = null) => new Chart(document.getElementById(id), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [value, 100 - value],
                    backgroundColor: [C.darkRed, C.lightPink],
                    borderWidth: 0
                }]
            },
            options: {
                ...doughnutOpts,
                elements: {
                    center: {
                        text: text ?? value + '%',
                        color: C.critical
                    }
                }
            },
        });

        const csiPct = v => udCsiSurvey.total > 0 ? Math.round(v / udCsiSurvey.total * 1000) / 10 : 0;

        const makeStackedBar = (id, rows) => new Chart(document.getElementById(id), {
            type: 'bar',
            data: {
                labels: rows.map(r => r.label),
                datasets: agingKeys.map((key, i) => ({
                    label: agingLabels[i],
                    data: rows.map(r => r[key] ?? 0),
                    backgroundColor: AG[i],
                    borderWidth: 0,
                    barPercentage: 0.75,
                })),
            },
            plugins: [ChartDataLabels],
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 8,
                            font: {
                                size: 12
                            },
                            padding: 4
                        }
                    },
                    datalabels: {
                        display: ctx => (ctx.dataset.data[ctx.dataIndex] ?? 0) > 0,
                        anchor: 'center',
                        align: 'center',
                        color: '#fff',
                        font: {
                            size: 10,
                            weight: 'bold'
                        },
                        formatter: v => v > 0 ? v : ''
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            footer: items => 'Total: ' + items.reduce((s, i) => s + i.parsed.x, 0)
                        }
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                        display: false,
                        beginAtZero: true
                    },
                    y: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                },
                layout: {
                    padding: {
                        right: 8
                    }
                },
            },
        });

        const makeLineDataset = (label, data, color) => ({
            label,
            data,
            borderColor: color,
            borderWidth: 2,
            fill: false,
            tension: 0.4,
            pointRadius: 3,
            pointBackgroundColor: '#fff',
            pointBorderColor: color,
            pointBorderWidth: 2,
        });

        const makeLineChart = (id, labels, datasets, stepSize = null) => new Chart(document.getElementById(id), {
            type: 'line',
            data: {
                labels,
                datasets
            },
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 8,
                            font: {
                                size: 12
                            }
                        }
                    },
                    datalabels: {
                        align: 'top',
                        anchor: 'end',
                        offset: 3,
                        color: '#555',
                        font: {
                            size: 12
                        },
                        formatter: v => v > 0 ? v.toLocaleString() : ''
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 0,
                            autoSkip: false,
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        beginAtZero: true,
                        ...(stepSize ? {
                            ticks: {
                                stepSize,
                                font: {
                                    size: 9
                                }
                            }
                        } : {
                            ticks: {
                                font: {
                                    size: 9
                                }
                            }
                        })
                    },
                },
                layout: {
                    padding: {
                        top: 16
                    }
                },
            },
        });

        // ── Section 1: KPI Doughnuts ──
        makeKpiDoughnut('ud-csi-chart', Math.round(Math.min(100, Math.max(0, 100 * {{ $csiSatPct }} / 95))));
        makeKpiDoughnut('ud-rtat-chart', Math.round(Math.min(100, Math.max(0, 100 * {{ $rtat['overall'] ?? 0 }} / 8.9))));
        makeKpiDoughnut('ud-ltp-chart', Math.round(Math.min(100, Math.max(0, 100 * {{ $ltp ?? 0 }} / 70))));
        makeKpiDoughnut('ud-ftf-chart', Math.round(Math.min(100, Math.max(0, 100 * {{ $ftf ?? 0 }} / 80))));

        // ── Section 3: CSI Charts ──
        makeSatDoughnut('ud-sat-doughnut', {{ $csiSatPct }});

        new Chart(document.getElementById('ud-sat-bar'), {
            type: 'bar',
            data: {
                labels: ['Very Good', 'Good', 'Normal', 'Bad', 'Very Bad'],
                datasets: [{
                    data: [udCsiSurvey.service_very_good, udCsiSurvey.service_good, udCsiSurvey
                        .service_normal, udCsiSurvey.service_bad, udCsiSurvey.service_very_bad
                    ],
                    backgroundColor: [C.darkRed, '#f43f5e', '#fb7185', '#fda4af', C.lightRed],
                    borderWidth: 0,
                    barPercentage: 0.6
                }],
            },
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#000',
                        font: {
                            size: 12
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        display: false,
                        beginAtZero: true
                    }
                },
                layout: {
                    padding: {
                        top: 14,
                        bottom: 3
                    }
                }
            },
        });

        makeSatDoughnut('ud-q1-chart', csiPct(udCsiSurvey.problem_resolved_yes), csiPct(udCsiSurvey.problem_resolved_yes) +
            '%');
        makeSatDoughnut('ud-q2-chart', csiPct(udCsiSurvey.arrive_as_scheduled_yes), csiPct(udCsiSurvey
            .arrive_as_scheduled_yes) + '%');
        makeSatDoughnut('ud-q3-chart', csiPct(udCsiSurvey.polite_and_well_mannered_yes), csiPct(udCsiSurvey
            .polite_and_well_mannered_yes) + '%');
        makeSatDoughnut('ud-q4-chart', csiPct(udCsiSurvey.charged_expenses_yes), csiPct(udCsiSurvey.charged_expenses_yes) +
            '%');

        // ── Section 4: Pending Charts ─────────────────────────────────────────────
        makeStackedBar('ud-reason-chart', udReasonRows);
        makeStackedBar('ud-status-chart', udStatusRows);
        makeStackedBar('ud-inhouse-chart', udInhouseRows);
        makeStackedBar('ud-asc-chart', udAscRows);
        makeStackedBar('ud-region-chart', udRegionRows);

        new Chart(document.getElementById('ud-type-chart'), {
            type: 'bar',
            data: {
                labels: udTypeData.labels,
                datasets: [{
                    data: udTypeData.values,
                    backgroundColor: '#c4ddff',
                    borderWidth: 0,
                    barPercentage: 0.7,
                }]
            },
            plugins: [ChartDataLabels],
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'right',
                        offset: 4,
                        color: '#374151',
                        font: {
                            size: 12,
                            weight: 'bold'
                        },
                        formatter: v => v > 0 ? v.toLocaleString() : '',
                    },
                },
                scales: {
                    x: {
                        display: false,
                        beginAtZero: true
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        },
                    },
                },
                layout: {
                    padding: {
                        right: 48
                    }
                }
            },
        });

        const pGrand = udPendingData.grandTotal || 1;
        const pPct = n => Math.round(Math.min(100, Math.max(0, 100 * n / pGrand)));
        new Chart(document.getElementById('ud-pending-pie'), {
            type: 'pie',
            data: {
                labels: ['ASC', 'Hafele'],
                datasets: [{
                    data: [pPct(udPendingData.grandAscTotal), pPct(udPendingData.grandHafeleTotal)],
                    backgroundColor: [C.darkPurple, C.critical],
                    hoverOffset: 4
                }]
            },
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        color: '#fff',
                        anchor: 'center',
                        align: 'center',
                        font: {
                            size: 14
                        },
                        formatter: (v, ctx) => ctx.chart.data.labels[ctx.dataIndex] + '\n' + v + '%'
                    }
                }
            },
        });

        const getTypeTotal = (data, type) => data.find(d => d.type === type)?.total ?? 0;
        new Chart(document.getElementById('ud-pending-bar'), {
            type: 'bar',
            data: {
                labels: ['Installation (ASC)', 'Repair (ASC)', 'Repair (Hafele)', 'Spare Part (Hafele)',
                    'Onsite (Hafele)', 'Phone (Hafele)'
                ],
                datasets: [{
                    data: [
                        getTypeTotal(udPendingData.ascData, 'I'),
                        getTypeTotal(udPendingData.ascData, 'R'),
                        getTypeTotal(udPendingData.hafeleData, 'R'),
                        getTypeTotal(udPendingData.hafeleData, 'spare_part'),
                        getTypeTotal(udPendingData.hafeleData, 'C'),
                        getTypeTotal(udPendingData.hafeleData, 'consult_or_advise')
                    ],
                    backgroundColor: [C.darkPurple, C.darkPurple, C.critical, C.critical, C.critical, C
                        .critical
                    ],
                    borderWidth: 0,
                    barPercentage: 0.8
                }],
            },
            plugins: [ChartDataLabels],
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'right',
                        offset: 3,
                        color: '#555',
                        font: {
                            size: 12
                        }
                    }
                },
                scales: {
                    x: {
                        display: false,
                        beginAtZero: true
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                layout: {
                    padding: {
                        right: 40
                    }
                }
            },
        });

        // ── Section 4 Row D: Product Group + Product Aging ──
        const rawPendingGroup = {!! json_encode($pending_group_data) !!};
        const rawProductData = {!! json_encode($product_data) !!};

        new Chart(document.getElementById('ud-product-group-chart'), {
            type: 'bar',
            data: {
                labels: ['Smart Technology', 'Home Appliances', 'Sanitary', 'Arch. Hardware', 'Furniture Fitting'],
                datasets: [{
                    data: [
                        rawPendingGroup.total_smart_tech ?? 0,
                        rawPendingGroup.total_home_appl ?? 0,
                        rawPendingGroup.total_sanitary ?? 0,
                        rawPendingGroup.total_arch_hardware ?? 0,
                        rawPendingGroup.total_furniture_fitting ?? 0,
                    ],
                    backgroundColor: '#c4ddff',
                    borderWidth: 0,
                    barPercentage: 0.7,
                }],
            },
            plugins: [ChartDataLabels],
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'right',
                        offset: 4,
                        color: '#374151',
                        font: {
                            size: 12,
                            weight: 'bold'
                        },
                        formatter: v => v > 0 ? v.toLocaleString() : '',
                    },
                },
                scales: {
                    x: {
                        display: false,
                        beginAtZero: true
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                },
                layout: {
                    padding: {
                        right: 48
                    }
                },
            },
        });

        const productKeys = ['Smart Technology', 'Home appliances', 'Sanitary'];
        const productLabels = ['Smart Tech', 'Home Appl.', 'Sanitary'];
        new Chart(document.getElementById('ud-product-aging-chart'), {
            type: 'bar',
            data: {
                labels: productLabels,
                datasets: [{
                        label: '0-3 Days',
                        data: productKeys.map(p => rawProductData[p]?.['0-3'] ?? 0),
                        backgroundColor: AG[0]
                    },
                    {
                        label: '4-7 Days',
                        data: productKeys.map(p => rawProductData[p]?.['4-7'] ?? 0),
                        backgroundColor: AG[1]
                    },
                    {
                        label: '8-15 Days',
                        data: productKeys.map(p => rawProductData[p]?.['8-15'] ?? 0),
                        backgroundColor: AG[2]
                    },
                    {
                        label: '16-30 Days',
                        data: productKeys.map(p => rawProductData[p]?.['16-30'] ?? 0),
                        backgroundColor: AG[3]
                    },
                    {
                        label: 'Over 30',
                        data: productKeys.map(p => rawProductData[p]?.['over_30'] ?? 0),
                        backgroundColor: AG[4]
                    },
                ],
            },
            plugins: [ChartDataLabels],
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 8,
                            font: {
                                size: 12
                            },
                            padding: 4
                        },
                    },
                    datalabels: {
                        display: ctx => (ctx.dataset.data[ctx.dataIndex] ?? 0) > 0,
                        anchor: 'center',
                        align: 'center',
                        color: '#fff',
                        font: {
                            size: 9,
                            weight: 'bold'
                        },
                        formatter: v => v > 0 ? v : '',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                        display: false,
                        beginAtZero: true
                    },
                    y: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                },
                layout: {
                    padding: {
                        right: 8
                    }
                },
            },
        });

        // ── Section 5: Trend Charts ──
        const monthNames = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        const allMonths = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        new Chart(document.getElementById('ud-ticket-chart'), {
            type: 'bar',
            data: {
                labels: monthNames,
                datasets: [{
                        label: 'Open',
                        data: allMonths.map(m => udTicketData[m]?.open ?? null),
                        backgroundColor: '#cbd5e1',
                        borderWidth: 0,
                        barPercentage: 1,
                        categoryPercentage: 0.9
                    },
                    {
                        label: 'Closed',
                        data: allMonths.map(m => udTicketData[m]?.closed ?? null),
                        backgroundColor: '#475569',
                        borderWidth: 0,
                        barPercentage: 1,
                        categoryPercentage: 0.9
                    },
                ],
            },
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 8,
                            usePointStyle: true,
                            pointStyle: 'rect',
                            font: {
                                size: 12
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        // rotation: -90,
                        color: '#555',
                        offset: 0,
                        font: {
                            size: 12
                        },
                        formatter: v => v > 0 ? v.toLocaleString() : ''
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 0,
                            autoSkip: false,
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1000,
                            font: {
                                size: 9
                            }
                        }
                    }
                },
                layout: {
                    padding: {
                        top: 28
                    }
                }
            },
        });

        makeLineChart('ud-contract-chart',
            ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
            [
                makeLineDataset(String(udContractData.prev_year), Array.from({ length: 12 }, (_, i) => udContractData.prev[i + 1] ?? null), '#000'),
                makeLineDataset(String(udContractData.current_year), Array.from({ length: 12 }, (_, i) => udContractData.current[i + 1] ?? null), C.critical),
            ],
            1000
        );

        const dailyDays = Object.keys(udDailyData).map(Number).sort((a, b) => a - b);
        makeLineChart('ud-daily-chart',
            dailyDays,
            [
                makeLineDataset('Day Shift (08:00-17:00)', dailyDays.map(d => udDailyData[d].day_shift), '#000'),
                makeLineDataset('Night Shift (17:01-07:59)', dailyDays.map(d => udDailyData[d].night_shift), C.critical),
            ],
            50
        );
    </script>
@endpush
