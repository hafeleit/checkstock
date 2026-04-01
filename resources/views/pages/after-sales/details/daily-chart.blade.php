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
            <p class="text-md font-semibold text-gray-600 mb-2">Daily Performance {{ now()->format('F') }}</p>
            <div class="ud-chart-wrap ud-h-280">
                <canvas id="ud-daily-chart"></canvas>
            </div>
        </div>

        {{-- Tickets Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full overflow-hidden">
            <div class="px-3 py-3 border-b border-gray-100">
                <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">Daily Performance {{ now()->format('F') }}</p>
                <p class="text-lg font-bold text-gray-800 mt-0.5">
                    {{ number_format($tickets->total()) }} <span class="text-sm font-normal text-gray-400">tickets</span>
                </p>

                {{-- Shift Filter --}}
                <div class="flex flex-wrap gap-1.5 mt-2">
                    <a href="?{{ http_build_query([...request()->except('shift')]) }}"
                        class="px-2 py-1 rounded text-xs font-semibold {{ !$activeShift ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All Shifts</a>
                    <a href="?{{ http_build_query([...request()->except('shift'), 'shift' => 'day']) }}"
                        class="px-2 py-1 rounded text-xs font-semibold {{ $activeShift === 'day' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">Day Shift</a>
                    <a href="?{{ http_build_query([...request()->except('shift'), 'shift' => 'night']) }}"
                        class="px-2 py-1 rounded text-xs font-semibold {{ $activeShift === 'night' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">Night Shift</a>
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
                                    {{ \Carbon\Carbon::parse($ticket->release_date)->format('d/m/Y H:i:s') }}
                                </td>
                                <td class="px-3 py-2 text-gray-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($ticket->date_modified)->format('d/m/Y H:i:s') }}
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

            const udDailyData = {!! json_encode($dailyData) !!};

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

            const makeLineChart = (id, labels, datasets, stepSize = null) => new Chart(document.getElementById(id), {
                type: 'line',
                data: {
                    labels,
                    datasets
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
                                font: {
                                    size: 12
                                }
                            }
                        },
                        datalabels: {
                            align: 'top',
                            anchor: 'end',
                            offset: 3,
                            color: '#555',
                            font: {
                                size: 12
                            },
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
                            grid: {
                                display: false
                            },
                            ticks: {
                                maxRotation: 0,
                                autoSkip: false,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            beginAtZero: true,
                            ...(stepSize ? {
                                ticks: {
                                    stepSize,
                                    font: {
                                        size: 9
                                    }
                                }
                            } : {
                                ticks: {
                                    font: {
                                        size: 9
                                    }
                                }
                            })
                        },
                    },
                    layout: {
                        padding: {
                            top: 25
                        }
                    },
                },
            });

            const dailyDays = Object.keys(udDailyData).map(Number).sort((a, b) => a - b);
            makeLineChart('ud-daily-chart',
                dailyDays,
                [
                    makeLineDataset('Day Shift (08:00-17:00)', dailyDays.map(d => udDailyData[d].day_shift), '#000'),
                    makeLineDataset('Night Shift (17:01-07:59)', dailyDays.map(d => udDailyData[d].night_shift), '#c70e0e'),
                ],
                50
            );
        </script>
    @endpush
@endsection
