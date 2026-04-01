@extends('layouts.after-sales-user')

@section('title', 'After-Sales Dashboard')
@section('content')

    @push('styles')
        <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
            .ud-chart-wrap {
                position: relative;
            }

            .ud-h-400 {
                height: 400px;
            }

            .bg-orange-100 { background-color: #ffedd5; }
            .text-orange-700 { color: #c2410c; }
            .bg-emerald-100 { background-color: #d1fae5; }
            .text-emerald-700 { color: #047857; }
            .bg-lime-100 { background-color: #ecfccb; }
            .text-lime-700 { color: #4d7c0f; }
        </style>
    @endpush

    <div class="space-y-2">
        <div class="bg-white rounded-lg px-3 py-4 shadow-sm border border-gray-100 w-full">
            <p class="text-md font-semibold text-gray-600 mb-2">Pending by Type</p>
            <div class="ud-chart-wrap ud-h-200">
                <canvas id="ud-type-chart"></canvas>
            </div>
        </div>

        {{-- Tickets Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full overflow-hidden">
            <div class="px-3 py-3 border-b border-gray-100">
                <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">Pending by Type</p>
                <p class="text-lg font-bold text-gray-800 mt-0.5">{{ number_format($tickets->total()) }} <span
                        class="text-sm font-normal text-gray-400">tickets</span></p>

                @php
                    $typeLabels = [
                        'I'                 => 'Installation',
                        'R'                 => 'Repair',
                        'spare_part'        => 'Spare Part',
                        'C'                 => 'Onsite Consult',
                        'consult_or_advise' => 'Phone Consult',
                    ];
                @endphp

                {{-- Type Filter --}}
                <div class="flex flex-wrap gap-1.5 mt-2">
                    <a href="?" class="px-2 py-1 rounded text-xs font-semibold {{ !$activeType ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All Types</a>
                    @foreach ($typeLabels as $value => $label)
                        <a href="?type={{ $value }}" class="px-2 py-1 rounded text-xs font-semibold {{ $activeType === $value ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
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
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Type</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Release Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Date Modified</th>
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
                                <td class="px-3 py-2 text-gray-600 whitespace-nowrap">{{ $typeLabels[$ticket->type ?? ''] ?? ($ticket->type ?? '-') }}</td>
                                <td class="px-3 py-2 text-gray-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($ticket->release_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-3 py-2 text-gray-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($ticket->date_modified)->format('d/m/Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 py-6 text-center text-gray-400">No tickets found.</td>
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

            const rawPendingType = {!! json_encode($pendingData) !!};
            const udTypeData = {
                labels: ['Installation', 'Repair', 'Spare Part', 'Onsite Consult', 'Phone Consult'],
                values: [
                    rawPendingType.total_installation ?? 0,
                    rawPendingType.total_repair ?? 0,
                    rawPendingType.total_sparepart ?? 0,
                    rawPendingType.total_onsite ?? 0,
                    rawPendingType.total_phone ?? 0,
                ],
            };

            new Chart(document.getElementById('ud-type-chart'), {
                type: 'bar',
                data: {
                    labels: udTypeData.labels,
                    datasets: [{
                        data: udTypeData.values,
                        backgroundColor: '#c4ddff',
                        borderWidth: 0,
                        barPercentage: 0.7,
                    }]
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
                            offset: 4,
                            color: '#374151',
                            font: {
                                size: 12,
                                weight: 'bold'
                            },
                            formatter: v => v > 0 ? v.toLocaleString() : '',
                        },
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
                            },
                        },
                    },
                    layout: {
                        padding: {
                            right: 48
                        }
                    }
                },
            });
        </script>
    @endpush
@endsection
