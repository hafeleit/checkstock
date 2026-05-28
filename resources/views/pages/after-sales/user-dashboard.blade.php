@extends('layouts.after-sales-user')

@section('title', 'After-Sales Dashboard')
@section('subtitle', now()->format('F Y'))

@php
    $csiSurvey = $csi_response_data['survey_data'];
    $csiResponses = (int) ($csiSurvey->total ?? 0);
    $csiTotal = (int) ($csi_response_data['total_ticket'] ?? 0);
    $csiRate = $csiTotal > 0 ? round(($csiResponses / $csiTotal) * 100, 1) : 0;
    $csiPoint = ($csiSurvey->service_very_good*5) + ($csiSurvey->service_good*4) + ($csiSurvey->service_normal*3) + ($csiSurvey->service_bad*2) + ($csiSurvey->service_very_bad*1);
    $csiSatPct = $csiResponses > 0 ? round($csiPoint / ($csiResponses * 5) * 100, 1) : 0;

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
        ],
        [
            'id' => 'ud-rtat-chart',
            'label' => 'R_TAT',
            'value' => $rtat['overall'],
            'target' => '< 7 days',
            'sub' => "BKK: {$rtat['bkk']} (TG 3.0)",
        ],
        [
            'id' => 'ud-ltp-chart',
            'label' => 'LTP',
            'value' => "{$ltp}%",
            'target' => '< 7.0%',
        ],
        [
            'id' => 'ud-ftf-chart',
            'label' => 'FTF',
            'value' => "{$ftf}%",
            'target' => '80.0%',
        ],
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

        .ud-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .ud-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .ud-card-header p {
            margin: 0;
        }

        .ud-card .ud-chart-wrap,
        .ud-card .ud-pending-flex,
        .ud-card .ud-rowc-wrap {
            flex: 1;
            min-height: 0;
        }

        .ud-user-dashboard a.text-sm.font-semibold.text-blue-500.hover\:text-blue-700 {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 12px;
            padding: 1px 10px;
            border-radius: 5px;
            background-color: rgba(59, 130, 246, 0.08);
            color: #1d4ed8;
            transition: color 150ms ease, background-color 150ms ease, transform 150ms ease;
            text-decoration: none;
        }

        .ud-user-dashboard a.text-sm.font-semibold.text-blue-500.hover\:text-blue-700:hover {
            color: #1e40af;
            background-color: rgba(59, 130, 246, 0.16);
            transform: translateX(1px);
        }
    </style>
@endpush

@section('content')
<div class="ud-user-dashboard">

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
                    </div>
                    <p class="text-md text-gray-400 mt-0.5">Target: <span class="font-semibold text-gray-600">{{ $kpi['target'] }}</span></p>
                    @isset($kpi['sub'])
                        <p class="text-md text-gray-400 mt-0.5">{{ $kpi['sub'] }}</p>
                    @endisset

                    <a href="{{ route('after-sales.detail', ['chart' => $kpi['id']]) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                        View Detail
                    </a>
                </div>
                
            </div>
        @endforeach

    </div>

    {{-- SECTION 2 — Ticket Stats + Aging (dashboard-2) --}}
    <div class="flex gap-4 items-center mb-2">
        <p class="text-md font-bold uppercase tracking-widest text-gray-800">Ticket Statistics</p>
        <a href="{{ route('after-sales.detail', ['chart' => 'ud-ticket-by-status-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
            View Detail
        </a>
    </div>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 mb-2">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-3 py-2 flex items-center gap-2">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Created</p>
                <p class="text-xl font-bold text-gray-800 leading-none">{{ $total_stat_data['total_created'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-3 py-2 flex items-center gap-2">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Closed</p>
                <p class="text-xl font-bold text-gray-800 leading-none">{{ $total_stat_data['total_closed'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-3 py-2 flex items-center gap-2">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Pending</p>
                <p class="text-xl font-bold text-gray-800 leading-none">{{ $total_stat_data['total_pending'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-3 py-2">
            <div class="flex items-center justify-around">
                <div class="text-center">
                    <p class="text-lg font-bold text-yellow-600 leading-none">{{ $total_stat_data['total_open'] }}</p>
                    <p class="text-sm text-gray-400 mt-0.5 uppercase tracking-wider">Open</p>
                </div>
                <div class="w-px h-8 bg-gray-200"></div>
                <div class="text-center">
                    <p class="text-lg font-bold text-yellow-400 leading-none">{{ $total_stat_data['total_in_prog'] }}</p>
                    <p class="text-sm text-gray-400 mt-0.5 uppercase tracking-wider">In Prog</p>
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
                    View Detail
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
    <div class="ud-card-header">
        <p class="text-md font-bold uppercase tracking-widest text-gray-800">Customer Satisfaction Index</p>
        <a href="{{ route('after-sales.detail', ['chart' => 'ud-csi-response-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
            View Detail
        </a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mb-6">

        {{-- Responses + Satisfaction --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-4 ud-card">
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 ud-card">
            <div class="grid grid-cols-2 gap-3 h-full">
                @foreach ([['ud-q1-chart', 'Problem resolved?'], ['ud-q2-chart', 'Arrived as scheduled?'], ['ud-q3-chart', 'Polite & well mannered?']] as [$qid, $qlabel])
                    <div class="flex flex-col items-center justify-center gap-1 {{ $loop->last ? 'col-span-2' : '' }}">
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

        {{-- Pending Overview --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 ud-card">
            <div class="ud-card-header">
                <p class="text-md font-semibold text-gray-600">Pending Overview (ASC vs Hafele)</p>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-pending-overview-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail
                </a>
            </div>
            <div class="ud-pending-flex">
                <div class="ud-pie-wrap">
                    <canvas id="ud-pending-pie"></canvas>
                </div>
                <div class="ud-bar-flex">
                    <canvas id="ud-pending-bar"></canvas>
                </div>
            </div>
        </div>

        {{-- Reason — 6 rows stacked aging --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 ud-card">
            <div class="ud-card-header">
                <p class="text-md font-semibold text-gray-600">Pending Reason (by Aging)</p>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-pending-reason-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail
                </a>
            </div>
            
            <div class="ud-chart-wrap ud-h-300">
                <canvas id="ud-reason-chart"></canvas>
            </div>
        </div>

    </div>

    {{-- Row B (2 cols equal): Status | Region --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 ud-card">
            <div class="ud-card-header">
                <p class="text-md font-semibold text-gray-600">Status Overview (by Aging)</p>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-status-overview-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail
                </a>
            </div>
            
            <div class="ud-chart-wrap ud-h-200">
                <canvas id="ud-status-chart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 ud-card">
            <div class="ud-card-header">
                <p class="text-md font-semibold text-gray-600">Pending by Region</p>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-pending-by-region-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail
                </a>
            </div>
            <div class="ud-chart-wrap ud-h-200" id="ud-region-wrap">
                <canvas id="ud-region-chart"></canvas>
            </div>
        </div>

    </div>

    {{-- Row C (2 cols equal): In-House | ASC — dynamic height เท่ากันทั้งคู่ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 ud-card">
            <div class="ud-card-header">
                <p class="text-md font-semibold text-gray-600">In-House Pending by Team</p>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-inhouse-pending-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail
                </a>
            </div>
            <div id="ud-inhouse-wrap" class="ud-rowc-wrap">
                <canvas id="ud-inhouse-chart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 ud-card">
            <div class="ud-card-header">
                <p class="text-md font-semibold text-gray-600">ASC Pending by Region</p>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-asc-pending-by-region-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail
                </a>
            </div>
            <div id="ud-asc-wrap" class="ud-rowc-wrap">
                <canvas id="ud-asc-chart"></canvas>
            </div>
        </div>

    </div>

    {{-- Row D (3 cols equal): Type | Product Group --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 ud-card">
            <div class="ud-card-header">
                <p class="text-md font-semibold text-gray-600">Pending by Type</p>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-pending-by-type-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail
                </a>
            </div>
            <div class="ud-chart-wrap ud-h-200">
                <canvas id="ud-type-chart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 ud-card">
            <div class="ud-card-header">
                <p class="text-md font-semibold text-gray-600">Pending Product Group</p>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-pending-product-group-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail
                </a>
            </div>
            <div class="ud-chart-wrap ud-h-200">
                <canvas id="ud-product-group-chart"></canvas>
            </div>
        </div>

    </div>

    {{-- SECTION 5 — Trends (dashboard-1) --}}
    <p class="text-md font-bold uppercase tracking-widest text-gray-800 mb-2">Trends</p>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mb-6">

        {{-- Ticket: datalabels หมุน -90° ต้องมี top padding → ต้องสูงพอ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 ud-card">
            <div class="ud-card-header">
                <p class="text-md font-semibold text-gray-600">Ticket Open vs Close</p>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-ticket-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail
                </a>
            </div>
            <div class="ud-chart-wrap ud-h-280">
                <canvas id="ud-ticket-chart"></canvas>
            </div>
        </div>

        {{-- Contract: line 12 เดือน 2 เส้น datalabels ด้านบน --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 ud-card">
            <div class="ud-card-header">
                <p class="text-md font-semibold text-gray-600">Contract Center Trend</p>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-contract-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail
                </a>
            </div>
            <div class="ud-chart-wrap ud-h-280">
                <canvas id="ud-contract-chart"></canvas>
            </div>
        </div>

        {{-- Daily: datalabels หนาแน่น ต้องสูงพอให้ไม่ทับกัน --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 ud-card">
            <div class="ud-card-header">
                <p class="text-md font-semibold text-gray-600">Daily Performance ({{ now()->format('F') }})</p>
                <a href="{{ route('after-sales.detail', ['chart' => 'ud-daily-chart']) }}" class="text-sm font-semibold text-blue-500 hover:text-blue-700" target="_blank">
                    View Detail
                </a>
            </div>
            <div class="ud-chart-wrap ud-h-280">
                <canvas id="ud-daily-chart"></canvas>
            </div>
        </div>

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
                ctx.fillText(txt, (chart.chartArea.left + chart.chartArea.right) / 2, (chart.chartArea.top + chart.chartArea.bottom) / 2);
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
                el.textContent = v;
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

        const udStatusRows = [
            {
                label: 'Open',
                '0_3': rawStatusData.open_0_3 ?? 0,
                '4_7': rawStatusData.open_4_7 ?? 0,
                '8_15': rawStatusData.open_8_15 ?? 0,
                '16_30': rawStatusData.open_16_30 ?? 0,
                'over_30': rawStatusData.open_over_30 ?? 0
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
                label: 'Pending Reason',
                '0_3': rawStatusData.reason_0_3 ?? 0,
                '4_7': rawStatusData.reason_4_7 ?? 0,
                '8_15': rawStatusData.reason_8_15 ?? 0,
                '16_30': rawStatusData.reason_16_30 ?? 0,
                'over_30': rawStatusData.reason_over_30 ?? 0
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

        const udInhouseRows = normalizeAgingRows(rawInhouseData).sort((a, b) => a.label.localeCompare(b.label));
        const udAscRows = normalizeAgingRows(rawAscData).sort((a, b) => a.label.localeCompare(b.label));
        const udRegionRows = normalizeAgingRows(rawRegionData).sort((a, b) => a.label.localeCompare(b.label));

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
        const AG = ['#10b981', '#84cc16', '#facc15', '#fb923c', '#ef4444'];
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
                        top: 25
                    }
                },
            },
        });

        // ── Section 1: KPI Doughnuts ──
        makeKpiDoughnut('ud-csi-chart', Math.round(Math.min(100, Math.max(0, ({{ $csiSatPct }} / 95) * 100))));
        makeKpiDoughnut('ud-rtat-chart', Math.round(Math.min(100, Math.max(0, (7 / {{ $rtat['overall'] ?? 0 }}) * 100))));
        makeKpiDoughnut('ud-ltp-chart', Math.round(Math.min(100, Math.max(0, (7 / {{ $ltp ?? 0 }}) * 100))));
        makeKpiDoughnut('ud-ftf-chart', Math.round(Math.min(100, Math.max(0, ({{ $ftf ?? 0 }} / 80) * 100))));

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

        makeSatDoughnut('ud-q1-chart', csiPct(udCsiSurvey.problem_resolved_yes), csiPct(udCsiSurvey.problem_resolved_yes) + '%');
        makeSatDoughnut('ud-q2-chart', csiPct(udCsiSurvey.arrive_as_scheduled_yes), csiPct(udCsiSurvey.arrive_as_scheduled_yes) + '%');
        makeSatDoughnut('ud-q3-chart', csiPct(udCsiSurvey.polite_and_well_mannered_yes), csiPct(udCsiSurvey.polite_and_well_mannered_yes) + '%');

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
