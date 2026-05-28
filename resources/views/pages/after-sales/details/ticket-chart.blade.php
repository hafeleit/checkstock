@extends('layouts.after-sales-user')

@section('title', 'After-Sales Dashboard')
@section('content')

    @push('styles')
        <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
            .ud-chart-wrap {
                position: relative;
            }

            .ud-h-280 {
                height: 280px;
            }

            .bg-orange-100 { background-color: #ffedd5; }
            .text-orange-700 { color: #c2410c; }
        </style>
    @endpush

    <div class="space-y-2">
        <div class="bg-white rounded-lg px-3 py-4 shadow-sm border border-gray-100 w-full">
            <p class="text-md font-semibold text-gray-600 mb-2">Ticket Open vs Close</p>
            <div class="ud-chart-wrap ud-h-280">
                <canvas id="ud-ticket-chart"></canvas>
            </div>
        </div>

        {{-- Tickets Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full">
            <div class="px-3 py-3 border-b border-gray-100">
                <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">Ticket Open vs Close</p>
                <p class="text-lg font-bold text-gray-800 mt-0.5">
                    {{ number_format($tickets->total()) }} <span class="text-sm font-normal text-gray-400">tickets</span>
                </p>

                @php
                    $monthLabels = ['1'=>'JAN','2'=>'FEB','3'=>'MAR','4'=>'APR','5'=>'MAY','6'=>'JUN','7'=>'JUL','8'=>'AUG','9'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC'];
                    $baseParams  = array_filter(['month' => $activeMonths ?? [], 'status' => $activeStatuses ?? []]);
                @endphp

                {{-- Month Filter --}}
                <div class="mt-2">
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-gray-400 mb-1">Month</p>
                    <div class="flex flex-wrap gap-1.5">
                        <a href="?{{ http_build_query(array_diff_key($baseParams, ['month' => ''])) }}" class="px-2 py-1 rounded text-xs font-semibold {{ empty($activeMonths) ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All Months</a>
                        @foreach ($monthLabels as $value => $label)
                            @php
                                $selectedMonths = $activeMonths ?? [];
                                $isActive = in_array($value, $selectedMonths, false);
                                $newMonths = $isActive
                                    ? array_values(array_diff($selectedMonths, [$value]))
                                    : array_values(array_unique(array_merge($selectedMonths, [$value])));
                                $monthParams = empty($newMonths)
                                    ? array_diff_key($baseParams, ['month' => []])
                                    : [...array_diff_key($baseParams, ['month' => []]), 'month' => $newMonths];
                            @endphp
                            <a href="?{{ http_build_query($monthParams) }}" class="px-2 py-1 rounded text-xs font-semibold {{ $isActive ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
                

                {{-- Status Closed Filter --}}
                <div class="mt-2">
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-gray-400 mb-1">Status</p>
                    <div class="flex flex-wrap gap-1.5">
                        <a href="?{{ http_build_query(array_diff_key($baseParams, ['status' => ''])) }}" class="px-2 py-1 rounded text-xs font-semibold {{ empty($activeStatuses) ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
                        @foreach (['opened' => 'Opened', 'closed' => 'Closed'] as $value => $label)
                            @php
                                $selectedStatuses = $activeStatuses ?? [];
                                $isActive = in_array($value, $selectedStatuses, false);
                                $newStatuses = $isActive
                                    ? array_values(array_diff($selectedStatuses, [$value]))
                                    : array_values(array_unique(array_merge($selectedStatuses, [$value])));
                                $statusParams = empty($newStatuses)
                                    ? array_diff_key($baseParams, ['status' => []])
                                    : [...array_diff_key($baseParams, ['status' => []]), 'status' => $newStatuses];
                            @endphp
                            <a href="?{{ http_build_query($statusParams) }}" class="px-2 py-1 rounded text-xs font-semibold {{ $isActive ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
                
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-xs">
                    <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">#</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Ticket No.</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Name</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Status</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Assigned To</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Created Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Release Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Booking Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Closed Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Pending</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap w-3/12">Note</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $statusClass = fn($s) => match ($s ?? '') {
                                'In_progress'    => 'bg-blue-100 text-blue-700',
                                'Open'           => 'bg-yellow-100 text-yellow-700',
                                'Pending_Reason' => 'bg-orange-100 text-orange-700',
                                'Closed'         => 'bg-green-100 text-green-700',
                                default          => 'bg-gray-100 text-gray-500',
                            };
                            $statusLabel = fn($s) => match ($s ?? '') {
                                'In_progress'    => 'In Progress',
                                'Pending_Reason' => 'Pending',
                                'Closed'         => 'Closed',
                                default          => $s ?? '-',
                            };
                        @endphp
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-gray-400 whitespace-nowrap">{{ $tickets->firstItem() + $loop->index }}</td>
                                <td class="px-3 py-2 font-medium text-gray-700 whitespace-nowrap">{{ $ticket->ticket_number ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->name ?? '-' }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <span class="px-1.5 py-0.5 rounded font-semibold {{ $statusClass($ticket->status) }}">{{ $statusLabel($ticket->status) }}</span>
                                </td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->first_name . ' ' . $ticket->last_name ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->date_entered ? \Carbon\Carbon::parse($ticket->date_entered)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->release_date ? \Carbon\Carbon::parse($ticket->release_date)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->booking ? \Carbon\Carbon::parse($ticket->booking)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->closed_datetime_c ? \Carbon\Carbon::parse($ticket->closed_datetime_c)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->pending ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->note ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-3 py-6 text-center text-gray-400">No tickets found.</td>
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
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2" nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>
        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
            Chart.register(ChartDataLabels);

            const activeMonths = {!! json_encode($activeMonths ?? []) !!};
            const activeStatuses = {!! json_encode($activeStatuses ?? []) !!};

            const activeMonthIdxs = activeMonths.map(m => parseInt(m, 10) - 1).filter(idx => idx >= 0);
            const activeMonthSet = new Set(activeMonthIdxs);
            const openActive = activeStatuses.length === 0 || activeStatuses.includes('opened');
            const closedActive = activeStatuses.length === 0 || activeStatuses.includes('closed');
            const statusFilterActive = activeStatuses.length > 0 && !(openActive && closedActive);

            const openFull   = '#cbd5e1';
            const openDim    = 'rgba(203,213,225,0.2)';
            const closedFull = '#475569';
            const closedDim  = 'rgba(71,85,105,0.2)';

            // dsIdx 0=Open, 1=Closed
            const isBarActive = (dsIdx, barIdx) => {
                const monthOk = activeMonthIdxs.length === 0 || activeMonthSet.has(barIdx);
                const statusOk = !statusFilterActive
                    || (dsIdx === 0 && openActive)
                    || (dsIdx === 1 && closedActive);
                return monthOk && statusOk;
            };

            const udTicketData = {!! json_encode($ticketData) !!};
            const monthNames = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
            const allMonths = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

            new Chart(document.getElementById('ud-ticket-chart'), {
                type: 'bar',
                data: {
                    labels: monthNames,
                    datasets: [
                        {
                            label: 'Open',
                            data: allMonths.map(m => udTicketData[m]?.open ?? null),
                            backgroundColor: allMonths.map((_, j) => isBarActive(0, j) ? openFull : openDim),
                            borderWidth: 0,
                            barPercentage: 1,
                            categoryPercentage: 0.9
                        },
                        {
                            label: 'Closed',
                            data: allMonths.map(m => udTicketData[m]?.closed ?? null),
                            backgroundColor: allMonths.map((_, j) => isBarActive(1, j) ? closedFull : closedDim),
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
                                font: { size: 12 },
                                color: ctx => {
                                    if (activeStatuses.length === 0) return '#666';
                                    const active = (ctx.index === 0 && openActive) || (ctx.index === 1 && closedActive);
                                    return active ? '#333' : '#bbb';
                                }
                            }
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            color: ctx => isBarActive(ctx.datasetIndex, ctx.dataIndex) ? '#555' : '#ccc',
                            offset: 0,
                            font: { size: 12 },
                            formatter: v => v > 0 ? v.toLocaleString() : ''
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                maxRotation: 0,
                                autoSkip: false,
                                font: { size: 12 },
                                color: ctx => activeMonthIdxs.length === 0 || activeMonthSet.has(ctx.index) ? '#555' : '#bbb'
                            }
                        },
                        y: {
                            grid: { display: false },
                            beginAtZero: true,
                            ticks: { stepSize: 1000, font: { size: 9 } }
                        }
                    },
                    layout: { padding: { top: 28 } }
                },
            });
        </script>
    @endpush
@endsection
