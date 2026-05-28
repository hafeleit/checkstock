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
            <p class="text-md font-semibold text-gray-600 mb-2">Pending Product Groups</p>
            <div class="ud-chart-wrap ud-h-200">
                <canvas id="ud-product-group-chart"></canvas>
            </div>
        </div>

        {{-- Tickets Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full">
            <div class="px-3 py-3 border-b border-gray-100">
                <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">Pending Product Group</p>
                <p class="text-lg font-bold text-gray-800 mt-0.5">
                    {{ number_format($tickets->total()) }} <span class="text-sm font-normal text-gray-400">tickets</span>
                </p>

                @php
                    $groupLabels = ['Smart Technology', 'Home appliances', 'Sanitary', 'Architectural hardware', 'FF - Furniture Fittings'];
                @endphp

                {{-- group Filter --}}
                <div class="mt-2">
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-gray-400 mb-1">Group</p>
                    <div class="flex flex-wrap gap-1.5">
                        <a href="?"
                            class="px-2 py-1 rounded text-xs font-semibold {{ empty($activeGroups) ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
                            All Groups
                        </a>
                        @foreach ($groupLabels as $label)
                            @php
                                $isActive = in_array($label, $activeGroups, true);
                                $newGroups = $isActive
                                    ? array_values(array_diff($activeGroups, [$label]))
                                    : [...$activeGroups, $label];
                            @endphp
                            <a href="?{{ http_build_query(['group' => $newGroups]) }}"
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
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Ticket No.</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Name</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Status</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Group</th>
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
                                $d <= 3 => 'bg-emerald-100 text-emerald-700',
                                $d <= 7 => 'bg-lime-100 text-lime-700',
                                $d <= 15 => 'bg-yellow-100 text-yellow-700',
                                $d <= 30 => 'bg-orange-100 text-orange-700',
                                default => 'bg-red-100 text-red-700',
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
                                <td class="px-3 py-2 text-gray-600 whitespace-nowrap">{{ $typeLabels[$ticket->product_group ?? ''] ?? ($ticket->product_group ?? '-') }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->first_name . ' ' . $ticket->last_name ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->date_entered ? \Carbon\Carbon::parse($ticket->date_entered)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->release_date ? \Carbon\Carbon::parse($ticket->release_date)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->booking ? \Carbon\Carbon::parse($ticket->booking)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->closed_datetime_c ? \Carbon\Carbon::parse($ticket->closed_datetime_c)->format('d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->note ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="px-3 py-6 text-center text-gray-400">No tickets found.</td>
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

            const activeGroups = {!! json_encode($activeGroups) !!};
            const groupLabels = ['Smart Technology', 'Home appliances', 'Sanitary', 'Architectural hardware', 'FF - Furniture Fittings'];
            const groupIndexMap = {
                'Smart Technology': 0,
                'Home appliances': 1,
                'Sanitary': 2,
                'Architectural hardware': 3,
                'FF - Furniture Fittings': 4,
            };
            const activeGroupIdxs = activeGroups.map(label => groupIndexMap[label]).filter(idx => idx >= 0);
            const groupFull = '#c4ddff';
            const groupDim  = 'rgba(196,221,255,0.25)';
            const groupBg = groupLabels.map((label, index) => activeGroupIdxs.length === 0 || activeGroupIdxs.includes(index) ? groupFull : groupDim);

            const rawPendingGroup = {!! json_encode($pendingData) !!};

            new Chart(document.getElementById('ud-product-group-chart'), {
                type: 'bar',
                data: {
                    labels: ['Smart Technology', 'Home Appliances', 'Sanitary', 'Arch. Hardware', 'Furniture Fitting'],
                    datasets: [{
                        data: [
                            rawPendingGroup.total_smart_tech ?? 0,
                            rawPendingGroup.total_home_appl ?? 0,
                            rawPendingGroup.total_sanitary ?? 0,
                            rawPendingGroup.total_arch_hardware ?? 0,
                            rawPendingGroup.total_furniture_fitting ?? 0,
                        ],
                        backgroundColor: groupBg,
                        borderWidth: 0,
                        barPercentage: 0.7,
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
                            offset: 4,
                            color: ctx => activeGroupIdxs.length === 0 || activeGroupIdxs.includes(ctx.dataIndex) ? '#374151' : '#bbb',
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
                            }
                        },
                    },
                    layout: {
                        padding: {
                            right: 48
                        }
                    },
                },
            });
        </script>
    @endpush
@endsection
