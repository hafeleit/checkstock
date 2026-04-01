@extends('layouts.after-sales-user')

@section('title', 'After-Sales Dashboard')
@section('content')

    @push('styles')
        <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
            .bg-orange-100 { background-color: #ffedd5; }
            .text-orange-700 { color: #c2410c; }
        </style>
    @endpush

    <div class="space-y-2">
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

        {{-- Tickets Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full">
            <div class="px-3 py-3 border-b border-gray-100">
                <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">Tickets</p>
                <p class="text-lg font-bold text-gray-800 mt-0.5">{{ number_format($tickets->total()) }} <span class="text-sm font-normal text-gray-400">tickets</span></p>

                {{-- Status Filter --}}
                @php
                    $statuses = ['Closed' => 'Closed', 'Open' => 'Open', 'In_progress' => 'In Progress', 'Pending_Reason' => 'Pending'];
                @endphp
                <div class="flex flex-wrap gap-1.5 mt-2">
                    <a href="?" class="px-2 py-1 rounded text-xs font-semibold {{ !$activeStatus ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
                    @foreach ($statuses as $value => $label)
                        <a href="?status={{ $value }}"
                           class="px-2 py-1 rounded text-xs font-semibold {{ $activeStatus === $value ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
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
                            <th class="px-3 py-2 text-left font-semibold">Date Modified</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-gray-400">{{ $tickets->firstItem() + $loop->index }}</td>
                                <td class="px-3 py-2 font-medium text-gray-700">{{ $ticket->ticket_number ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->name ?? '-' }}</td>
                                <td class="px-3 py-2">
                                    @php
                                        $statusClass = match($ticket->status ?? '') {
                                            'Closed'         => 'bg-green-100 text-green-700',
                                            'In_progress'    => 'bg-blue-100 text-blue-700',
                                            'Open'           => 'bg-yellow-100 text-yellow-700',
                                            'Pending_Reason' => 'bg-orange-100 text-orange-700',
                                            default          => 'bg-gray-100 text-gray-500',
                                        };
                                        $statusLabel = $statuses[$ticket->status] ?? ($ticket->status ?? '-');
                                    @endphp
                                    <span class="px-1.5 py-0.5 rounded font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                                </td>
                                <td class="px-3 py-2 text-gray-600">{{ \Carbon\Carbon::parse($ticket->release_date)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ \Carbon\Carbon::parse($ticket->date_modified)->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-3 py-6 text-center text-gray-400">No tickets found.</td>
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
        </script>
    @endpush
@endsection
