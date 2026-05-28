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
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full">
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
                    <a href="?" class="px-2 py-1 rounded text-xs font-semibold {{ empty($activeTypes) ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All Types</a>
                    @foreach ($typeLabels as $value => $label)
                        @php
                            $isActive = in_array($value, $activeTypes ?? [], true);
                            $newTypes = $isActive
                                ? array_values(array_diff($activeTypes, [$value]))
                                : [...($activeTypes ?? []), $value];
                        @endphp
                        <a href="{{ empty($newTypes) ? '?' : '?'.http_build_query(['type' => $newTypes]) }}"
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
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Name</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Status</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Type</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Assigned To</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Created Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Release Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Booking Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Closed Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap w-3/12">Note</th>
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
                                $d <= 3 => 'text-3-day',
                                $d <= 7 => 'text-7-day',
                                $d <= 15 => 'text-15-day',
                                $d <= 30 => 'text-30-day',
                                default => 'text-over-30-day',
                            };
                        @endphp
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-gray-400 whitespace-nowrap">{{ $tickets->firstItem() + $loop->index }}</td>
                                <td class="px-3 py-2 font-medium text-gray-700 whitespace-nowrap">{{ $ticket->ticket_number ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->name ?? '-' }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <span class="px-1.5 py-0.5 rounded font-semibold {{ $statusClass($ticket->status) }}">
                                        {{ $statusLabel($ticket->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-gray-600 whitespace-nowrap">{{ $typeLabels[$ticket->type ?? ''] ?? ($ticket->type ?? '-') }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->first_name . ' ' . $ticket->last_name ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->date_entered ? \Carbon\Carbon::parse($ticket->date_entered)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->release_date ? \Carbon\Carbon::parse($ticket->release_date)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->booking ? \Carbon\Carbon::parse($ticket->booking)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->closed_datetime_c ? \Carbon\Carbon::parse($ticket->closed_datetime_c)->format('d/m/Y') : '-' }}</td>
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

            const activeTypes = {!! json_encode($activeTypes ?? []) !!};
            const typeLabels = ['I', 'R', 'spare_part', 'C', 'consult_or_advise'];
            const typeIndexMap = { 'I': 0, 'R': 1, 'spare_part': 2, 'C': 3, 'consult_or_advise': 4 };
            const activeTypeIdxs = activeTypes.map(type => typeIndexMap[type]).filter(idx => idx >= 0);
            const typeFull = '#c4ddff';
            const typeDim  = 'rgba(196,221,255,0.25)';
            const typeBg = typeLabels.map((_, index) => activeTypeIdxs.length === 0 || activeTypeIdxs.includes(index) ? typeFull : typeDim);

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
                        backgroundColor: typeBg,
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
                            color: ctx => activeTypeIdxs.length === 0 || activeTypeIdxs.includes(ctx.dataIndex) ? '#374151' : '#bbb',
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
