@extends('layouts.after-sales-user')

@section('title', 'After-Sales Dashboard')
@section('content')

    @push('styles')
        <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
            .bg-orange-100 { background-color: #ffedd5; }
            .text-orange-700 { color: #c2410c; }
            .bg-emerald-100 { background-color: #d1fae5; }
            .text-emerald-700 { color: #047857; }
            .bg-lime-100 { background-color: #ecfccb; }
            .text-lime-700 { color: #4d7c0f; }

            .text-3-day { color: #10b981; }
            .text-7-day { color: #84cc16; }
            .text-15-day { color: #ffcc00; }
            .text-30-day { color: #fb923c; }
            .text-over-30-day { color: #ef4444; }
        </style>
    @endpush

    <div class="space-y-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-md font-semibold text-gray-600">Status Overview (by Aging)</p>
            <div class="ud-chart-wrap ud-h-200">
                <canvas id="ud-status-chart"></canvas>
            </div>
        </div>

        {{-- Tickets Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full">
            <div class="px-3 py-3 border-b border-gray-100">
                <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">Status Overview Tickets</p>
                <p class="text-lg font-bold text-gray-800 mt-0.5">
                    {{ number_format($tickets->total()) }} <span class="text-sm font-normal text-gray-400">tickets</span>
                </p>

                {{-- Status filter --}}
                <div class="flex flex-wrap gap-1.5 mt-2">
                    @php
                        $statusFilters = [
                            '' => 'All',
                            'Open' => 'Open',
                            'In_progress' => 'In Progress',
                            'Pending_Reason' => 'Pending',
                        ];
                    @endphp
                    @foreach ($statusFilters as $val => $label)
                        @php
                            $isActive = ($activeStatus ?? '') === $val;
                            $href = $val
                                ? http_build_query(array_merge(request()->query(), ['status' => $val]))
                                : http_build_query(array_diff_key(request()->query(), ['status' => '']));
                        @endphp
                        <a href="?{{ $href }}"
                            class="px-2 py-1 rounded text-xs font-semibold {{ $isActive ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                {{-- Aging filter --}}
                <div class="flex flex-wrap gap-1.5 mt-1.5">
                    @php
                        $agingFilters = [
                            '' => 'All Days',
                            '0-3' => '0-3 Days',
                            '4-7' => '4-7 Days',
                            '8-15' => '8-15 Days',
                            '16-30' => '16-30 Days',
                            'over_30' => '>30 Days',
                        ];
                    @endphp
                    @foreach ($agingFilters as $val => $label)
                        @php
                            $isActive = ($activeAging ?? '') === $val;
                            $href = $val
                                ? http_build_query(array_merge(request()->query(), ['aging' => $val]))
                                : http_build_query(array_diff_key(request()->query(), ['aging' => '']));
                        @endphp
                        <a href="?{{ $href }}"
                            class="px-2 py-1 rounded text-xs font-semibold {{ $isActive ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-xs">
                    <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">#</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Ticket No.</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Name</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Pending Reason</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Status</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Assigned To</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Created Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Release Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Booking Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Closed Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap w-3/12">Note</th>
                            <th class="px-3 py-2 text-right font-semibold whitespace-nowrap">Aging (Days)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $statusClass = fn($s) => match ($s ?? '') {
                                'In_progress' => 'bg-blue-100 text-blue-700',
                                'Open' => 'bg-yellow-100 text-yellow-700',
                                'Pending_Reason' => 'bg-orange-100 text-orange-700',
                                default => 'bg-gray-100 text-gray-500',
                            };
                            $statusLabel = fn($s) => match ($s ?? '') {
                                'In_progress' => 'In Progress',
                                'Pending_Reason' => 'Pending',
                                default => $s ?? '-',
                            };
                            $agingClass = fn($d) => match (true) {
                                $d <= 3 => 'text-3-day',
                                $d <= 7 => 'text-7-day',
                                $d <= 15 => 'text-15-day',
                                $d <= 30 => 'text-30-day',
                                default => 'text-over-30-day',
                            };
                            $pendingReasons = [
                                'Spare_part_on_progress' => 'Spare Part',
                                'Site_not_ready_or_waiting_confirm' => 'Site Not Ready',
                                'Postpone_or_new_appointment' => 'Postpone',
                                'Process_return_or_change_set' => 'Return/Change',
                                'Waiting_service_schedule_Technician' => 'Waiting Tech',
                            ];
                        @endphp
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-gray-400 whitespace-nowrap">{{ $tickets->firstItem() + $loop->index }}</td>
                                <td class="px-3 py-2 font-medium text-gray-700 whitespace-nowrap">{{ $ticket->ticket_number ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->name ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $pendingReasons[$ticket->pending ?? 'blank'] ?? ($ticket->pending ?? '-') }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <span class="px-1.5 py-0.5 rounded font-semibold {{ $statusClass($ticket->status) }}">
                                        {{ $statusLabel($ticket->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->first_name . ' ' . $ticket->last_name ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->date_entered ? \Carbon\Carbon::parse($ticket->date_entered)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->release_date ? \Carbon\Carbon::parse($ticket->release_date)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->booking ? \Carbon\Carbon::parse($ticket->booking)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->closed_datetime_c ? \Carbon\Carbon::parse($ticket->closed_datetime_c)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->note ?? '-' }}</td>
                                <td class="px-3 py-2 text-right">
                                    <span class="px-1.5 py-0.5 rounded font-bold {{ $agingClass((int) $ticket->days_diff) }}">
                                        {{ $ticket->days_diff ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="px-3 py-6 text-center text-gray-400">No tickets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($tickets->hasPages())
                <div class="px-3 py-3 border-t border-gray-100">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"
            nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>
        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
            const activeStatus = '{{ $activeStatus ?? '' }}';
            const activeAging  = '{{ $activeAging ?? '' }}';

            const AG    = ['#10b981', '#84cc16', '#facc15', '#fb923c', '#ef4444'];
            const AGdim = ['rgba(16,185,129,0.2)', 'rgba(132,204,22,0.2)', 'rgba(250,204,21,0.2)', 'rgba(251,146,60,0.2)', 'rgba(239,68,68,0.2)'];

            const agingKeys   = ['0_3', '4_7', '8_15', '16_30', 'over_30'];
            const agingLabels = ['0-3 Days', '4-7 Days', '8-15 Days', '16-30 Days', '>30 Days'];

            const agingIndexMap  = { '0-3': 0, '4-7': 1, '8-15': 2, '16-30': 3, 'over_30': 4 };
            const statusRowMap   = { 'Pending_Reason': 0, 'In_progress': 1, 'Open': 2 };
            const activeAgingIdx  = activeAging  ? (agingIndexMap[activeAging]  ?? -1) : -1;
            const activeStatusIdx = activeStatus ? (statusRowMap[activeStatus]  ?? -1) : -1;

            const isActive = (dsIdx, barIdx) => {
                const agingOk  = activeAgingIdx  < 0 || dsIdx  === activeAgingIdx;
                const statusOk = activeStatusIdx < 0 || barIdx === activeStatusIdx;
                return agingOk && statusOk;
            };

            const rawStatusData = {!! json_encode($statusData) !!};

            const udStatusRows = [
                {
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

            new Chart(document.getElementById('ud-status-chart'), {
                type: 'bar',
                data: {
                    labels: udStatusRows.map(r => r.label),
                    datasets: agingKeys.map((key, i) => ({
                        label: agingLabels[i],
                        data: udStatusRows.map(r => r[key] ?? 0),
                        backgroundColor: udStatusRows.map((_, j) => isActive(i, j) ? AG[i] : AGdim[i]),
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
                                font: { size: 12 },
                                padding: 4,
                                color: ctx => activeAgingIdx < 0 ? '#666'
                                    : ctx.index === activeAgingIdx ? '#333' : '#bbb'
                            }
                        },
                        datalabels: {
                            display: ctx => (ctx.dataset.data[ctx.dataIndex] ?? 0) > 0,
                            anchor: 'center',
                            align: 'center',
                            color: ctx => isActive(ctx.datasetIndex, ctx.dataIndex) ? '#fff' : 'rgba(255,255,255,0.15)',
                            font: { size: 10, weight: 'bold' },
                            formatter: v => v > 0 ? v : ''
                        },
                        tooltip: {
                            mode: 'y',
                            intersect: false,
                            callbacks: {
                                footer: items => 'Total: ' + items.reduce((s, i) => s + i.parsed.x, 0)
                            }
                        },
                    },
                    scales: {
                        x: { stacked: true, display: false, beginAtZero: true },
                        y: { stacked: true, grid: { display: false }, ticks: { font: { size: 12 } } },
                    },
                    layout: { padding: { right: 8 } },
                },
            });
        </script>
    @endpush

@endsection
