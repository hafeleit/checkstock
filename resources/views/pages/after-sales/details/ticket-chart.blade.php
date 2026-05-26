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
                    $baseParams  = array_filter(['month' => $activeMonth, 'status' => $activeStatus]);
                @endphp

                {{-- Month Filter --}}
                <div class="flex flex-wrap gap-1.5 mt-2">
                    <a href="?{{ http_build_query(array_diff_key($baseParams, ['month' => ''])) }}" class="px-2 py-1 rounded text-xs font-semibold {{ !$activeMonth ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All Months</a>
                    @foreach ($monthLabels as $value => $label)
                        <a href="?{{ http_build_query([...$baseParams, 'month' => $value]) }}" class="px-2 py-1 rounded text-xs font-semibold {{ $activeMonth == $value ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                {{-- Status Closed Filter --}}
                <div class="flex flex-wrap gap-1.5 mt-1.5">
                    <a href="?{{ http_build_query(array_diff_key($baseParams, ['status' => ''])) }}" class="px-2 py-1 rounded text-xs font-semibold {{ !$activeStatus ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
                    <a href="?{{ http_build_query([...$baseParams, 'status' => 'opened']) }}" class="px-2 py-1 rounded text-xs font-semibold {{ $activeStatus === 'opened' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">Opened</a>
                    <a href="?{{ http_build_query([...$baseParams, 'status' => 'closed']) }}" class="px-2 py-1 rounded text-xs font-semibold {{ $activeStatus === 'closed' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">Closed</a>
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
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Release Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Date Modified</th>
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
                                <td class="px-3 py-2 text-gray-400 whitespace-nowrap">
                                    {{ $tickets->firstItem() + $loop->index }}
                                </td>
                                <td class="px-3 py-2 font-medium text-gray-700 whitespace-nowrap">
                                    {{ $ticket->ticket_number ?? '-' }}
                                </td>
                                <td class="px-3 py-2 text-gray-600 max-w-[10rem] truncate">{{ $ticket->name ?? '-' }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <span class="px-1.5 py-0.5 rounded font-semibold {{ $statusClass($ticket->status) }}">{{ $statusLabel($ticket->status) }}</span>
                                </td>
                                <td class="px-3 py-2 text-gray-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($ticket->release_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-3 py-2 text-gray-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($ticket->date_modified)->format('d/m/Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-6 text-center text-gray-400">No tickets found.</td>
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

            const activeMonth       = {!! json_encode($activeMonth) !!};
            const activeStatus = {!! json_encode($activeStatus) !!};

            const activeMonthIdx = activeMonth ? (parseInt(activeMonth) - 1) : -1;
            const openFull   = '#cbd5e1';
            const openDim    = 'rgba(203,213,225,0.2)';
            const closedFull = '#475569';
            const closedDim  = 'rgba(71,85,105,0.2)';

            // dsIdx 0=Open, 1=Closed
            const isBarActive = (dsIdx, barIdx) => {
                const monthOk  = activeMonthIdx < 0 || barIdx === activeMonthIdx;
                const statusOk = !activeStatus
                    || (activeStatus === 'opened' && dsIdx === 0)
                    || (activeStatus === 'closed' && dsIdx === 1);
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
                                    if (!activeStatus) return '#666';
                                    const active = (activeStatus === 'opened' && ctx.index === 0)
                                                || (activeStatus === 'closed' && ctx.index === 1);
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
                                color: ctx => activeMonthIdx < 0 || ctx.index === activeMonthIdx ? '#555' : '#bbb'
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
