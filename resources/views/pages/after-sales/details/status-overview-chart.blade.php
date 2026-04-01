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
                            <th class="px-3 py-2 text-left font-semibold w-40">Name</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Status</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Pending Reason</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Release Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Date Modified</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Aging (Days)</th>
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
                                $d <= 3 => 'bg-emerald-100 text-emerald-700',
                                $d <= 7 => 'bg-lime-100 text-lime-700',
                                $d <= 15 => 'bg-yellow-100 text-yellow-700',
                                $d <= 30 => 'bg-orange-100 text-orange-700',
                                default => 'bg-red-100 text-red-700',
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
                                <td class="px-3 py-2 text-gray-400 whitespace-nowrap">
                                    {{ $tickets->firstItem() + $loop->index }}</td>
                                <td class="px-3 py-2 font-medium text-gray-700 whitespace-nowrap">
                                    {{ $ticket->ticket_number ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600 max-w-[10rem] truncate">{{ $ticket->name ?? '-' }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <span class="px-1.5 py-0.5 rounded font-semibold {{ $statusClass($ticket->status) }}">
                                        {{ $statusLabel($ticket->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-gray-600 whitespace-nowrap">
                                    {{ $pendingReasons[$ticket->pending ?? ''] ?? ($ticket->pending ?? '-') }}</td>
                                <td class="px-3 py-2 text-gray-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($ticket->release_date)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 text-gray-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($ticket->date_modified)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <span
                                        class="px-1.5 py-0.5 rounded font-semibold {{ $agingClass((int) $ticket->days_diff) }}">
                                        {{ $ticket->days_diff ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-3 py-6 text-center text-gray-400">No tickets found.</td>
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
            const AG = ['#10b981', '#facc15', '#fb923c', '#ef4444', '#881337'];
            const agingKeys = ['0_3', '4_7', '8_15', '16_30', 'over_30'];
            const agingLabels = ['0-3 Days', '4-7 Days', '8-15 Days', '16-30 Days', '>30 Days'];

            const rawStatusData = {!! json_encode($statusData) !!};

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
                            mode: 'y',
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

            makeStackedBar('ud-status-chart', udStatusRows);
        </script>
    @endpush

@endsection
