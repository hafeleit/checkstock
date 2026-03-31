@extends('layouts.after-sales-user')

@section('title', 'After-Sales Dashboard')
@section('content')

    @push('styles')
        <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
            .ud-chart-wrap {
                position: relative;
            }

            .ud-h-300 {
                height: 300px;
            }
        </style>
    @endpush

    <div class="space-y-2">
        <div class="bg-white rounded-lg px-3 py-4 shadow-sm border border-gray-100 w-full">
            <p class="text-md font-semibold text-gray-600 mb-2">Pending Reason (by Aging)</p>
            <div class="ud-chart-wrap ud-h-300">
                <canvas id="ud-reason-chart"></canvas>
            </div>
        </div>

        {{-- Tickets Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full overflow-hidden">
            <div class="px-3 py-3 border-b border-gray-100">
                <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">Pending Reason Tickets</p>
                <p class="text-lg font-bold text-gray-800 mt-0.5">{{ number_format($tickets->total()) }} <span
                        class="text-sm font-normal text-gray-400">tickets</span></p>

                {{-- Aging Filter --}}
                @php
                    $agingParams = $activePending ? ['pending' => $activePending] : [];
                    $pendingParams = $activeAging ? ['aging' => $activeAging] : [];
                    $pendingReasons = [
                        'Spare_part_on_progress' => 'Spare Part',
                        'Site_not_ready_or_waiting_confirm' => 'Site Not Ready',
                        'Postpone_or_new_appointment' => 'Postpone',
                        'Process_return_or_change_set' => 'Return/Change',
                        'Waiting_service_schedule_Technician' => 'Waiting Tech',
                        'blank' => 'No Reason',
                    ];
                @endphp

                <div class="flex flex-wrap gap-1.5 mt-2">
                    <a href="?{{ http_build_query($agingParams) }}"
                        class="px-2 py-1 rounded text-xs font-semibold {{ !$activeAging ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All
                        Aging</a>
                    @foreach (['0-3' => '0-3 Days', '4-7' => '4-7 Days', '8-15' => '8-15 Days', '16-30' => '16-30 Days', 'over_30' => 'Over 30'] as $value => $label)
                        <a href="?{{ http_build_query(array_merge($agingParams, ['aging' => $value])) }}"
                            class="px-2 py-1 rounded text-xs font-semibold {{ $activeAging === $value ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                {{-- Pending Reason Filter --}}
                <div class="flex flex-wrap gap-1.5 mt-1.5">
                    <a href="?{{ http_build_query($pendingParams) }}"
                        class="px-2 py-1 rounded text-xs font-semibold {{ !$activePending ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All
                        Reasons</a>
                    @foreach ($pendingReasons as $value => $label)
                        <a href="?{{ http_build_query(array_merge($pendingParams, ['pending' => $value])) }}"
                            class="px-2 py-1 rounded text-xs font-semibold {{ $activePending === $value ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold">#</th>
                            <th class="px-3 py-2 text-left font-semibold">Ticket No.</th>
                            <th class="px-3 py-2 text-left font-semibold">Name</th>
                            <th class="px-3 py-2 text-left font-semibold">Status</th>
                            <th class="px-3 py-2 text-left font-semibold">Pending Reason</th>
                            <th class="px-3 py-2 text-left font-semibold">Release Date</th>
                            <th class="px-3 py-2 text-left font-semibold">Date Modified</th>
                            <th class="px-3 py-2 text-left font-semibold">Days Diff</th>
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
                        @endphp
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-gray-400">{{ $tickets->firstItem() + $loop->index }}</td>
                                <td class="px-3 py-2 font-medium text-gray-700">{{ $ticket->ticket_number ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->name ?? '-' }}</td>
                                <td class="px-3 py-2">
                                    <span class="px-1.5 py-0.5 rounded font-semibold {{ $statusClass($ticket->status) }}">
                                        {{ $statusLabel($ticket->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-gray-600">
                                    {{ $pendingReasons[$ticket->pending ?? 'blank'] ?? ($ticket->pending ?? '-') }}</td>
                                <td class="px-3 py-2 text-gray-600">
                                    {{ \Carbon\Carbon::parse($ticket->release_date)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 text-gray-600">
                                    {{ \Carbon\Carbon::parse($ticket->date_modified)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2">
                                    <span class="px-1.5 py-0.5 rounded font-semibold {{ $agingClass((int) $ticket->days_diff) }}">
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
            Chart.register(ChartDataLabels);

            const rawReasonData = {!! json_encode($pendingData) !!};
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

            const AG = ['#10b981', '#84cc16', '#facc15', '#fb923c', '#ef4444'];
            const agingKeys = ['0_3', '4_7', '8_15', '16_30', 'over_30'];
            const agingLabels = ['0-3 Days', '4-7 Days', '8-15 Days', '16-30 Days', '>30 Days'];

            new Chart(document.getElementById('ud-reason-chart'), {
                type: 'bar',
                data: {
                    labels: udReasonRows.map(r => r.label),
                    datasets: agingKeys.map((key, i) => ({
                        label: agingLabels[i],
                        data: udReasonRows.map(r => r[key] ?? 0),
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
        </script>
    @endpush
@endsection
