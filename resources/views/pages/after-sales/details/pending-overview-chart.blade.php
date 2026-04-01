@extends('layouts.after-sales-user')

@section('title', 'After-Sales Dashboard')
@section('content')

    @php
        $typeLabels = [
            'R' => 'Repair',
            'C' => 'Consult',
            'I' => 'Installation',
            'spare_part' => 'Spare Part',
            'consult_or_advise' => 'Consult/Advise',
        ];
    @endphp

    @push('styles')
        <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
            .ud-chart-wrap {
                position: relative;
            }

            .ud-h-250 {
                height: 250px;
            }
        </style>
    @endpush

    <div class="space-y-2">
        <div class="bg-white rounded-lg px-3 py-4 shadow-sm border border-gray-100 w-full">
            <p class="text-md font-semibold text-gray-600 mb-3">Pending Overview (ASC vs Hafele)</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="ud-chart-wrap ud-h-250">
                    <canvas id="ud-pending-pie"></canvas>
                </div>
                <div class="ud-chart-wrap ud-h-250">
                    <canvas id="ud-pending-bar"></canvas>
                </div>
            </div>
        </div>

        {{-- Tickets Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full overflow-hidden">
            <div class="px-3 py-3 border-b border-gray-100">
                <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">Pending Tickets</p>
                <p class="text-lg font-bold text-gray-800 mt-0.5">
                    {{ number_format($tickets->total()) }} <span class="text-sm font-normal text-gray-400">tickets</span>
                </p>
                <div class="flex flex-wrap gap-1.5 mt-2">
                    <a href="?" class="px-2 py-1 rounded text-xs font-semibold {{ !$activeGroup ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
                    <a href="?group=asc" class="px-2 py-1 rounded text-xs font-semibold {{ $activeGroup === 'asc' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">ASC</a>
                    <a href="?group=hafele" class="px-2 py-1 rounded text-xs font-semibold {{ $activeGroup === 'hafele' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">Hafele</a>
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
                            <th class="px-3 py-2 text-left font-semibold">Type</th>
                            <th class="px-3 py-2 text-left font-semibold">Release Date</th>
                            <th class="px-3 py-2 text-left font-semibold">Date Modified</th>
                            <th class="px-3 py-2 text-left font-semibold">Assignee</th>
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
                                    {{ $typeLabels[$ticket->type ?? ''] ?? ($ticket->type ?? '-') }}</td>
                                <td class="px-3 py-2 text-gray-600">
                                    {{ \Carbon\Carbon::parse($ticket->release_date)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 text-gray-600">
                                    {{ \Carbon\Carbon::parse($ticket->date_modified)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 text-gray-600">
                                    {{ $ticket->assignee ? trim($ticket->assignee->first_name . ' ' . $ticket->assignee->last_name) : '-' }}
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

            const udPendingData = {!! json_encode($pendingData) !!};
            const pGrand = udPendingData.grandTotal || 1;
            const pPct = n => Math.round(Math.min(100, Math.max(0, 100 * n / pGrand)));
            new Chart(document.getElementById('ud-pending-pie'), {
                type: 'pie',
                data: {
                    labels: ['ASC', 'Hafele'],
                    datasets: [{
                        data: [pPct(udPendingData.grandAscTotal), pPct(udPendingData.grandHafeleTotal)],
                        backgroundColor: ['#300613', '#c70e0e'],
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
                        backgroundColor: ['#300613', '#300613', '#c70e0e', '#c70e0e', '#c70e0e', '#c70e0e'],
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
        </script>
    @endpush
@endsection
