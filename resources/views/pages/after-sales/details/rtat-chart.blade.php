@extends('layouts.after-sales-user')

@section('title', 'After-Sales Dashboard')
@section('content')

    <div class="space-y-2">
        <div
            class="bg-white rounded-lg px-3 py-4 shadow-sm border border-gray-100 flex items-center justify-center gap-4 w-full">
            <div class="relative w-32 h-32 flex-shrink-0">
                <canvas id="detail-rtat-chart"></canvas>
            </div>
            <div>
                <p class="text-md text-gray-400 uppercase tracking-widest font-semibold">R_TAT</p>
                <div class="flex items-baseline gap-1 mt-0.5">
                    <span class="text-lg font-bold text-gray-800">{{ number_format($rtatData['overall'], 1) }}</span>
                    <span class="text-sm font-bold px-1 py-0.5 rounded bg-yellow-100 text-yellow-700">Grade B</span>
                </div>
                <p class="text-sm text-gray-400 mt-0.5">Target: <span class="font-semibold text-gray-600">8.9 days</span></p>
                <div class="flex items-center gap-1.5 mt-0.5 pt-0.5 border-t border-gray-100">
                    <span class="text-sm font-bold text-gray-400 uppercase tracking-wider">BKK</span>
                    <span class="text-sm text-gray-400">TG: <span class="font-semibold text-gray-600">3.0</span></span>
                    <span class="text-gray-300">|</span>
                    <span class="text-sm text-gray-400">Act: <span class="font-semibold text-rose-500">{{ number_format($rtatData['bkk'], 1) }}</span></span>
                </div>
            </div>
        </div>

        {{-- RTAT Tickets Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full overflow-hidden">
            <div class="px-3 py-3 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">RTAT Tickets</p>
                        <p class="text-lg font-bold text-gray-800 mt-0.5">{{ number_format($tickets->total()) }} <span class="text-sm font-normal text-gray-400">tickets</span> | {{ number_format($activeRegion === 'Bangkok Metropolitan' ? $rtatData['total_bkk_days'] : $rtatData['total_all_days'], 1) }} <span class="text-sm font-normal text-gray-400">days</span></p>
                    </div>
                </div>

                {{-- Region Filter --}}
                @php
                    $regions = ['Bangkok Metropolitan'];
                @endphp
                <div class="flex flex-wrap gap-1.5 mt-2">
                    <a href="?" class="px-2 py-1 rounded text-xs font-semibold {{ !$activeRegion ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
                    @foreach ($regions as $region)
                        <a href="?region={{ urlencode($region) }}" class="px-2 py-1 rounded text-xs font-semibold {{ $activeRegion === $region ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
                            {{ $region }}
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
                            <th class="px-3 py-2 text-left font-semibold">Release Date</th>
                            <th class="px-3 py-2 text-left font-semibold">Closed Date</th>
                            <th class="px-3 py-2 text-left font-semibold">Region</th>
                            <th class="px-3 py-2 text-right font-semibold">Days</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-gray-400">{{ $tickets->firstItem() + $loop->index }}</td>
                                <td class="px-3 py-2 font-medium text-gray-700">{{ $ticket->ticket_number ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->name ?? '-' }}</td>
                                <td class="px-3 py-2">
                                    <span class="px-1.5 py-0.5 rounded font-semibold bg-green-100 text-green-700">{{ $ticket->status ?? '-' }}</span>
                                </td>
                                <td class="px-3 py-2 text-gray-600">{{ \Carbon\Carbon::parse($ticket->release_date)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ \Carbon\Carbon::parse($ticket->date_modified)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->master_part_eng ?? '-' }}</td>
                                <td class="px-3 py-2 text-right">
                                    @php $days = (int) $ticket->days_diff; @endphp
                                    <span class="px-1.5 py-0.5 rounded font-semibold {{ $days > 8 ? 'text-red-700' : 'text-green-700' }}">
                                        {{ $days }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-3 py-6 text-center text-gray-400">No tickets this month.</td>
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
            const centerTextPlugin = {
                id: 'centerText',
                beforeDraw: function(chart) {
                    if (chart.config.type !== 'doughnut') {
                        return;
                    }

                    if (chart.config.options.elements && chart.config.options.elements.center) {
                        const ctx = chart.ctx;
                        const centerConfig = chart.config.options.elements.center;
                        const fontStyle = centerConfig.fontStyle || 'Arial';
                        const txt = centerConfig.text;
                        const color = centerConfig.color || '#000';
                        const sidePadding = centerConfig.sidePadding || 20;
                        const sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 20);

                        ctx.font = "bold 20px " + fontStyle;

                        const stringWidth = ctx.measureText(txt).width;
                        const elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                        const widthRatio = elementWidth / stringWidth;
                        const newFontSize = Math.floor(30 * widthRatio);
                        const fontSizeToUse = Math.min(newFontSize, centerConfig.maxFontSize || 70);

                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        const centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                        const centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);

                        ctx.font = "bold " + fontSizeToUse + "px " + fontStyle;
                        ctx.fillStyle = color;

                        ctx.fillText(txt, centerX, centerY);
                    }
                }
            };
            Chart.register(centerTextPlugin);

            const doughnutDefaults = {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    datalabels: {
                        display: false
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: false
                    },
                },
            };

            const createKPIDoughnut = (id, value) => new Chart(document.getElementById(id), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [Math.min(value, 100), Math.max(0, 100 - value)],
                        backgroundColor: [value >= 100 ? '#10b981' : '#c70e0e', '#fecdd3'],
                        borderWidth: 0,
                    }],
                },
                options: {
                    ...doughnutDefaults,
                    elements: {
                        center: {
                            text: value + '%',
                            color: '#1e40af'
                        }
                    },
                },
            });

            const rtatData = {!! json_encode($rtatData) !!};
            const rtatScore = Math.round(Math.min(100, Math.max(0, 100 * rtatData['overall'] / 8.9)));
            createKPIDoughnut('detail-rtat-chart', rtatScore);
        </script>
    @endpush
@endsection
