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
            <p class="text-md font-semibold text-gray-600 mb-2">Contract Center Trend</p>
            <div class="ud-chart-wrap ud-h-280">
                <canvas id="ud-contract-chart"></canvas>
            </div>
        </div>

        {{-- Tickets Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full">
            <div class="px-3 py-3 border-b border-gray-100">
                <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">Contract Center Trend</p>
                <p class="text-lg font-bold text-gray-800 mt-0.5">
                    {{ number_format($tickets->total()) }} <span class="text-sm font-normal text-gray-400">tickets</span>
                </p>

                @php
                    $monthLabels  = ['1'=>'JAN','2'=>'FEB','3'=>'MAR','4'=>'APR','5'=>'MAY','6'=>'JUN','7'=>'JUL','8'=>'AUG','9'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC'];
                    $yearLabels   = range(now()->year - 1, now()->year);
                @endphp

                @php
                    $yearParams = array_filter(['month' => $activeMonths ?? [], 'status' => request()->input('status')]);
                    $baseParams = array_filter(['year' => $activeYears ?? [], 'month' => $activeMonths ?? []]);
                    $yearLinkParams = request()->except('year');
                    $monthLinkParams = request()->except('month');
                @endphp

                {{-- Year Filter --}}
                <div class="mt-2">
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-gray-400 mb-1">Year</p>
                    <div class="flex flex-wrap gap-1.5">
                        @php
                            $selectedYears = $activeYears ?? [];
                        @endphp
                        <a href="?{{ http_build_query($monthLinkParams) }}" class="px-2 py-1 rounded text-xs font-semibold {{ empty($selectedYears) ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All Years</a>
                        @foreach ($yearLabels as $year)
                            @php
                                $isActive = in_array((string)$year, $selectedYears, false);
                                $newYears = $isActive ? array_values(array_diff($selectedYears, [(string)$year])) : array_values(array_unique(array_merge($selectedYears, [(string)$year])));
                                $params = empty($newYears) ? $monthLinkParams : [...array_diff_key($monthLinkParams, ['year' => []]), 'year' => $newYears];
                            @endphp
                            <a href="?{{ http_build_query($params) }}"
                                class="px-2 py-1 rounded text-xs font-semibold {{ $isActive ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
                                {{ $year }}
                            </a>
                        @endforeach
                    </div>
                </div>
                

                {{-- Month Filter --}}
                <div class="mt-2">
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-gray-400 mb-1">Month</p>
                    <div class="flex flex-wrap gap-1.5">
                        @php $selectedMonths = $activeMonths ?? []; @endphp
                        <a href="?{{ http_build_query($monthLinkParams) }}" class="px-2 py-1 rounded text-xs font-semibold {{ empty($selectedMonths) ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All Months</a>
                        @foreach ($monthLabels as $value => $label)
                            @php
                                $isActive = in_array((string)$value, $selectedMonths, false);
                                $newMonths = $isActive ? array_values(array_diff($selectedMonths, [(string)$value])) : array_values(array_unique(array_merge($selectedMonths, [(string)$value])));
                                $params = empty($newMonths) ? $monthLinkParams : [...array_diff_key($monthLinkParams, ['month' => []]), 'month' => $newMonths];
                            @endphp
                            <a href="?{{ http_build_query($params) }}"
                                class="px-2 py-1 rounded text-xs font-semibold {{ $isActive ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
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
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Code</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Name</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Type</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Date Entered</th>
                            <th class="px-3 py-2 text-left font-semibold">Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-gray-400 whitespace-nowrap">{{ $tickets->firstItem() + $loop->index }}</td>
                                <td class="px-3 py-2 font-medium text-gray-700 whitespace-nowrap">{{ $ticket->code ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600 max-w-[10rem] truncate">{{ $ticket->name ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600 whitespace-nowrap">{{ $ticket->type ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600 whitespace-nowrap">{{ $ticket->date_entered ? (\Carbon\Carbon::parse($ticket->date_entered)->format('d/m/Y H:i:s')) : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->description ?? '-' }}</td>
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

            const activeYears  = {!! json_encode($activeYears ?? []) !!};
            const activeMonths = {!! json_encode($activeMonths ?? []) !!};

            const udContractData = {!! json_encode($contractData) !!};

            const activeMonthIdxs = activeMonths.map(m => parseInt(m, 10) - 1).filter(idx => idx >= 0);
            const activeMonthSet = new Set(activeMonthIdxs);
            const prevYearActive    = activeYears.length === 0 || String(udContractData.prev_year)    === String(activeYears.find(y => String(y) === String(udContractData.prev_year)) ?? '');
            const currentYearActive = activeYears.length === 0 || String(udContractData.current_year) === String(activeYears.find(y => String(y) === String(udContractData.current_year)) ?? '');

            const prevColor    = prevYearActive    ? '#000'    : 'rgba(0,0,0,0.15)';
            const currentColor = currentYearActive ? '#c70e0e' : 'rgba(199,14,14,0.15)';

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

            new Chart(document.getElementById('ud-contract-chart'), {
                type: 'line',
                data: {
                    labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                    datasets: [
                        makeLineDataset(String(udContractData.prev_year),    Array.from({ length: 12 }, (_, i) => udContractData.prev[i + 1]    ?? null), prevColor),
                        makeLineDataset(String(udContractData.current_year), Array.from({ length: 12 }, (_, i) => udContractData.current[i + 1] ?? null), currentColor),
                    ]
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
                                font: { size: 12 },
                                color: ctx => {
                                    if (activeYears.length === 0) return '#666';
                                    return (ctx.index === 0 ? prevYearActive : currentYearActive) ? '#333' : '#bbb';
                                }
                            }
                        },
                        datalabels: {
                            align: 'top',
                            anchor: 'end',
                            offset: 3,
                            color: ctx => {
                                    const isYearActive  = ctx.datasetIndex === 0 ? prevYearActive : currentYearActive;
                                    const isMonthActive = activeMonthIdxs.length === 0 || activeMonthSet.has(ctx.dataIndex);
                                    return isYearActive && isMonthActive ? '#555' : '#ccc';
                            },
                            font: { size: 12 },
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
                        },
                    },
                    layout: { padding: { top: 25 } },
                },
            });
        </script>
    @endpush
@endsection
