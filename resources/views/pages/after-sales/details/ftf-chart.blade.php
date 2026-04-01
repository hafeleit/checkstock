@extends('layouts.after-sales-user')

@section('title', 'After-Sales Dashboard')
@section('content')
    <div class="space-y-2">
        <div
            class="bg-white rounded-lg px-3 py-4 shadow-sm border border-gray-100 flex items-center justify-center gap-4 w-full">
            <div class="relative w-32 h-32 flex-shrink-0">
                <canvas id="detail-ftf-chart"></canvas>
            </div>
            <div>
                <p class="text-md text-gray-400 uppercase tracking-widest font-semibold">FTF</p>
                <div class="flex items-baseline gap-1 mt-0.5">
                    <span class="text-lg font-bold text-gray-800">{{ $ftfData }}%</span>
                </div>
                <p class="text-sm text-gray-400 mt-0.5">Target: <span class="font-semibold text-gray-600">70.0%</span></p>
            </div>
        </div>

        {{-- FTF Survey Responses Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full">
            <div class="px-3 py-3 border-b border-gray-100">
                <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">FTF Tickets</p>
                <p class="text-lg font-bold text-gray-800 mt-0.5">{{ number_format($tickets->total()) }} <span class="text-sm font-normal text-gray-400">tickets</span></p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-xs">
                    <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold">#</th>
                            <th class="px-3 py-2 text-left font-semibold">Ticket No.</th>
                            <th class="px-3 py-2 text-left font-semibold">Name</th>
                            <th class="px-3 py-2 text-left font-semibold">Status</th>
                            <th class="px-3 py-2 text-left font-semibold">Release Date</th>
                            <th class="px-3 py-2 text-right font-semibold">Round</th>
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
                                <td class="px-3 py-2 text-right">{{ $ticket->round ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-6 text-center text-gray-400">No tickets this month.</td>
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

            const ftfScore = Math.round(Math.min(100, Math.max(0, 100 * {{ $ftfData ?? 0 }} / 80)));
            createKPIDoughnut('detail-ftf-chart', ftfScore);
        </script>
    @endpush
@endsection
