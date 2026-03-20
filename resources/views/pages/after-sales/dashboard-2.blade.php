<div class="h-full flex flex-col gap-2 overflow-hidden text-gray-800">

    {{-- TOP: Legend + KPIs --}}
    <div class="flex-shrink-0 flex items-center gap-2 flex-wrap">
        {{-- Aging Legend --}}
        <div
            class="self-stretch flex items-center bg-white px-3 rounded-lg border border-gray-200 shadow-sm gap-3 text-sm font-medium">
            <span class="text-gray-400 uppercase tracking-wide text-md">Aging</span>
            <div class="flex items-center gap-1">
                <div class="w-2.5 h-2.5 rounded-full bg-0-3"></div><span class="text-gray-600">0-3 Days</span>
            </div>
            <div class="flex items-center gap-1">
                <div class="w-2.5 h-2.5 rounded-full bg-4-7"></div><span class="text-gray-600">4-7 Days</span>
            </div>
            <div class="flex items-center gap-1">
                <div class="w-2.5 h-2.5 rounded-full bg-8-15"></div><span class="text-gray-600">8-15 Days</span>
            </div>
            <div class="flex items-center gap-1">
                <div class="w-2.5 h-2.5 rounded-full bg-16-30"></div><span class="text-gray-600">16-30 Days</span>
            </div>
            <div class="flex items-center gap-1">
                <div class="w-2.5 h-2.5 rounded-full bg-over-30"></div><span class="text-gray-600">Over 30 Days</span>
            </div>
        </div>

        {{-- KPI Cards --}}
        <div class="flex gap-2 flex-1">
            <div
                class="bg-white px-3 py-1.5 rounded-lg border border-gray-100 shadow-sm flex items-center gap-2 flex-1">
                <div class="p-1.5 rounded-md bg-blue-500 bg-opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="text-blue-600" viewBox="0 0 16 16">
                        <path d="M4 4.85v.9h1v-.9zm7 0v.9h1v-.9zm-7 1.8v.9h1v-.9zm7 0v.9h1v-.9zm-7 1.8v.9h1v-.9zm7 0v.9h1v-.9zm-7 1.8v.9h1v-.9zm7 0v.9h1v-.9z" />
                        <path d="M1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13h13a1.5 1.5 0 0 0 1.5-1.5V10a.5.5 0 0 0-.5-.5 1.5 1.5 0 0 1 0-3A.5.5 0 0 0 16 6V4.5A1.5 1.5 0 0 0 14.5 3zM1 4.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v1.05a2.5 2.5 0 0 0 0 4.9v1.05a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-1.05a2.5 2.5 0 0 0 0-4.9z" />
                    </svg>
                </div>
                <div>
                    <p class="text-md text-gray-500 font-medium leading-none mb-0.5">Total Created</p>
                    <h3 class="text-lg font-bold text-gray-800 leading-none">{{ $total_stat_data['total'] }}</h3>
                </div>
            </div>
            <div
                class="bg-white px-3 py-1.5 rounded-lg border border-gray-100 shadow-sm flex items-center gap-2 flex-1">
                <div class="p-1.5 rounded-md bg-yellow-500 bg-opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="text-yellow-600" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                    </svg>
                </div>
                <div>
                    <p class="text-md text-gray-500 font-medium leading-none mb-0.5">Total Closed</p>
                    <h3 class="text-lg font-bold text-gray-800 leading-none">{{ $total_stat_data['total_closed'] }}</h3>
                </div>
            </div>
            <div
                class="bg-white px-3 py-1.5 rounded-lg border border-gray-100 shadow-sm flex items-center gap-2 flex-1">
                <div class="p-1.5 rounded-md bg-red-500 bg-opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="text-red-600" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                    </svg>
                </div>
                <div>
                    <p class="text-md text-gray-500 font-medium leading-none mb-0.5">Total Pending</p>
                    <h3 class="text-lg font-bold text-gray-800 leading-none">{{ $total_stat_data['total_pending'] }}</h3>
                </div>
            </div>
            {{-- Pending Breakdown --}}
            <div class="bg-white px-3 py-1.5 rounded-lg border border-gray-100 shadow-sm flex gap-3 items-center">
                <div class="text-center">
                    <span class="text-base font-bold text-yellow-600 leading-none">{{ $total_stat_data['total_open'] }}</span>
                    <span class="block text-md text-gray-500 uppercase tracking-wider">Open</span>
                </div>
                <div class="w-px h-6 bg-gray-200"></div>
                <div class="text-center">
                    <span class="text-base font-bold text-yellow-400 leading-none">{{ $total_stat_data['total_in_prog'] }}</span>
                    <span class="block text-md text-gray-500 uppercase tracking-wider">In Prog</span>
                </div>
                <div class="w-px h-6 bg-gray-200"></div>
                <div class="text-center">
                    <span class="text-base font-bold text-red-500 leading-none">{{ $total_stat_data['total_reason'] }}</span>
                    <span class="block text-md text-gray-500 uppercase tracking-wider">Reason</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Aging Bar --}}
    <div class="flex-shrink-0 bg-white rounded-lg border border-gray-100 shadow-sm flex items-center gap-3 px-3 h-8">
        <span class="text-md font-semibold text-gray-700 whitespace-nowrap">Overall Aging</span>
        <div class="flex-1 flex h-5 rounded-md overflow-hidden">
            <div class="aging-0-3 flex items-center justify-center text-white text-md font-bold">{{ $aging_data['0-3'] }}</div>
            <div class="aging-4-7 flex items-center justify-center text-white text-md font-bold">{{ $aging_data['4-7'] }}</div>
            <div class="aging-8-15 flex items-center justify-center text-white text-md font-bold">{{ $aging_data['8-15'] }}</div>
            <div class="aging-16-30 flex items-center justify-center text-white text-md font-bold">{{ $aging_data['16-30'] }}</div>
            <div class="aging-over-30 flex items-center justify-center text-white text-md font-bold">{{ $aging_data['over_30'] }}</div>
        </div>
    </div>

    {{-- Charts Grid --}}
    <div class="flex-1 min-h-0 grid grid-cols-3 gap-2">

        {{-- Col 1: Type / Product Group / Status --}}
        <div class="flex flex-col gap-2 min-h-0">
            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col flex-1 min-h-0">
                <h3 class="text-md font-semibold text-gray-700 mb-1 flex-shrink-0">Pending Type</h3>
                <div class="flex-1 min-h-0">
                    <canvas id="pending-type-chart"></canvas>
                </div>
            </div>
            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col flex-1 min-h-0">
                <h3 class="text-md font-semibold text-gray-700 mb-1 flex-shrink-0">Pending Product Group</h3>
                <div class="flex-1 min-h-0">
                    <canvas id="pending-product-chart"></canvas>
                </div>
            </div>
            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col flex-1 min-h-0">
                <h3 class="text-md font-semibold text-gray-700 mb-1 flex-shrink-0">Status Overview</h3>
                <div class="flex-1 min-h-0">
                    <canvas id="status-chart"></canvas>
                </div>
            </div>
        </div>

        {{-- Col 2: ASC Pending / In House --}}
        <div class="flex flex-col gap-2 min-h-0">
            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col flex-1 min-h-0">
                <h3 class="text-md font-semibold text-gray-700 mb-1 flex-shrink-0">ASC Pending by Region (Detail)</h3>
                <div class="flex-1 min-h-0">
                    <canvas id="asc-pending-chart"></canvas>
                </div>
            </div>
            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col flex-1 min-h-0">
                <h3 class="text-md font-semibold text-gray-700 mb-1 flex-shrink-0">In House Pending by Technician</h3>
                <div class="flex-1 min-h-0 flex items-center justify-center">
                    <span class="text-md text-gray-400">— No data —</span>
                </div>
            </div>
        </div>

        {{-- Col 3: Reason / Region / Product --}}
        <div class="flex flex-col gap-2 min-h-0">
            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col flex-1 min-h-0">
                <h3 class="text-md font-semibold text-gray-700 mb-1 flex-shrink-0">Pending Reason</h3>
                <div class="flex-1 min-h-0">
                    <canvas id="pending-reason-chart"></canvas>
                </div>
            </div>
            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col flex-1 min-h-0">
                <h3 class="text-md font-semibold text-gray-700 mb-1 flex-shrink-0">Pending by Region (Summary)</h3>
                <div class="flex-1 min-h-0">
                    <canvas id="region-chart"></canvas>
                </div>
            </div>
            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col flex-1 min-h-0">
                <h3 class="text-md font-semibold text-gray-700 mb-1 flex-shrink-0">Pending by Product</h3>
                <div class="flex-1 min-h-0">
                    <canvas id="pending-product-aging-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $agingTotal = array_sum([
        $aging_data['0-3'],
        $aging_data['4-7'],
        $aging_data['8-15'],
        $aging_data['16-30'],
        $aging_data['over_30'],
    ]);
    $agingPct = fn($val) => $agingTotal > 0 ? round((100 * $val) / $agingTotal, 2) : 0;
@endphp

<style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
    /* ── Full-screen TV layout ── */
    html,
    body {
        height: 100%;
        overflow: hidden;
    }

    .dashboard-container {
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .dashboard-container nav {
        padding-top: 0.375rem !important;
        padding-bottom: 0.375rem !important;
    }

    .dashboard-container nav small {
        display: none;
    }

    /* ── Aging bar colors ── */
    .aging-0-3 {
        width: {{ $agingPct($aging_data['0-3']) }}%;
        background-color: #10b981;
    }

    .aging-4-7 {
        width: {{ $agingPct($aging_data['4-7']) }}%;
        background-color: #84cc16;
    }

    .aging-8-15 {
        width: {{ $agingPct($aging_data['8-15']) }}%;
        background-color: #facc15;
    }

    .aging-16-30 {
        width: {{ $agingPct($aging_data['16-30']) }}%;
        background-color: #fb923c;
    }

    .aging-over-30 {
        width: {{ $agingPct($aging_data['over_30']) }}%;
        background-color: #ef4444;
    }

    /* ── Legend dot colors ── */
    .bg-0-3 {
        background-color: #10b981;
    }

    .bg-4-7 {
        background-color: #84cc16;
    }

    .bg-8-15 {
        background-color: #facc15;
    }

    .bg-16-30 {
        background-color: #fb923c;
    }

    .bg-over-30 {
        background-color: #ef4444;
    }
</style>

@push('scripts')
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        // Pending Type Chart
        const pendingType = {!! json_encode($pending_type_data) !!};
        new Chart(document.getElementById('pending-type-chart'), {
            type: 'bar',
            data: {
                labels: ['Repair', 'Installation', 'Spare Part / Accessory', 'Consult by Onsite', 'Consult by Phone'],
                datasets: [{
                    data: [
                        pendingType.total_repair,
                        pendingType.total_installation,
                        pendingType.total_sparepart,
                        pendingType.total_onsite,
                        pendingType.total_phone,
                    ],
                    backgroundColor: '#c2dcff',
                    borderWidth: 0,
                    barThickness: 20
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
                        anchor: 'start',
                        align: 'right',
                        offset: 10,
                        color: '#333',
                        font: {
                            weight: 'bold',
                            size: 12
                        },
                        formatter: function(value, context) {
                            return context.chart.data.labels[context.dataIndex] + ',  ' + value.toLocaleString();
                        }
                    }
                },
                scales: {
                    x: {
                        display: false,
                        grid: {
                            display: false
                        },
                        beginAtZero: true
                    },
                    y: {
                        display: false,
                        grid: {
                            display: false
                        }
                    }
                },
                layout: {
                    padding: {
                        right: 50
                    }
                }
            }
        });

        // Pending Product Group Chart
        const pendingGroup = {!! json_encode($pending_group_data) !!};
        new Chart(document.getElementById('pending-product-chart'), {
            type: 'bar',
            data: {
                labels: ['Smart Technology', 'Home Appliances', 'Sanitary', 'Architectural Hardware',
                    'Furniture Fitting'
                ],
                datasets: [{
                    data: [
                        pendingGroup.total_smart_tech,
                        pendingGroup.total_home_appl,
                        pendingGroup.total_sanitary,
                        pendingGroup.total_arch_hardware,
                        pendingGroup.total_furniture_fitting,
                    ],
                    backgroundColor: '#c4ddff',
                    borderWidth: 0,
                    barThickness: 20
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
                        anchor: 'start',
                        align: 'right',
                        offset: 10,
                        color: '#333',
                        font: {
                            weight: 'bold',
                            size: 12
                        },
                        formatter: function(value, context) {
                            return context.chart.data.labels[context.dataIndex] + ',  ' + value.toLocaleString();
                        }
                    }
                },
                scales: {
                    x: {
                        display: false,
                        grid: {
                            display: false
                        },
                        beginAtZero: true
                    },
                    y: {
                        display: false,
                        grid: {
                            display: false
                        }
                    }
                },
                layout: {
                    padding: {
                        right: 50
                    }
                }
            }
        });

        // Status Overview
        const statusData = {!! json_encode($status_data) !!};
        new Chart(document.getElementById('status-chart'), {
            type: 'bar',
            data: {
                labels: ['Pending Reason', 'In Progress', 'Open'],
                datasets: [{
                        label: '0-3 Days',
                        data: [statusData.reason_0_3, statusData.in_prog_0_3, statusData.open_0_3],
                        backgroundColor: '#10b981'
                    },
                    {
                        label: '4-7 Days',
                        data: [statusData.reason_4_7, statusData.in_prog_4_7, statusData.open_4_7],
                        backgroundColor: '#84cc16'
                    },
                    {
                        label: '8-15 Days',
                        data: [statusData.reason_8_15, statusData.in_prog_8_15, statusData.open_8_15],
                        backgroundColor: '#facc15'
                    },
                    {
                        label: '16-30 Days',
                        data: [statusData.reason_16_30, statusData.in_prog_16_30, statusData.open_16_30],
                        backgroundColor: '#fb923c'
                    },
                    {
                        label: 'Over 30 Days',
                        data: [statusData.reason_over_30, statusData.in_prog_over_30, statusData.open_over_30],
                        backgroundColor: '#ef4444'
                    },
                ]
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
                        anchor: 'center',
                        align: 'center',
                        color: '#fff',
                        font: {
                            size: 10,
                            weight: 'bold'
                        },
                        formatter: (value) => value > 0 ? value : '',
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    },
                    y: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                datasets: {
                    bar: {
                        barThickness: 20
                    }
                },
                layout: {
                    padding: {
                        right: 10
                    }
                },
            }
        });

        // ASC Pending Chart
        const ascPending = {!! json_encode($asc_pending_data) !!};
        const ascRegions = ['bkk', 'southern', 'eastern', 'northern', 'northeastern', 'western', 'central', 'blank'];
        new Chart(document.getElementById('asc-pending-chart'), {
            type: 'bar',
            data: {
                labels: ['Bangkok', 'Southern', 'Eastern', 'Northern', 'Northeastern', 'Western', 'Central',
                    'Blank'],
                datasets: [{
                        label: '0-3 Days',
                        data: ascRegions.map(r => ascPending[r]['0-3']),
                        backgroundColor: '#10b981'
                    },
                    {
                        label: '4-7 Days',
                        data: ascRegions.map(r => ascPending[r]['4-7']),
                        backgroundColor: '#84cc16'
                    },
                    {
                        label: '8-15 Days',
                        data: ascRegions.map(r => ascPending[r]['8-15']),
                        backgroundColor: '#facc15'
                    },
                    {
                        label: '16-30 Days',
                        data: ascRegions.map(r => ascPending[r]['16-30']),
                        backgroundColor: '#fb923c'
                    },
                    {
                        label: 'Over 30 Days',
                        data: ascRegions.map(r => ascPending[r]['over_30']),
                        backgroundColor: '#ef4444'
                    },
                ]
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
                        anchor: 'center',
                        align: 'center',
                        color: '#fff',
                        font: {
                            size: 10,
                            weight: 'bold'
                        },
                        formatter: (value) => value > 0 ? value : '',
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    }
                },
                datasets: {
                    bar: {
                        barThickness: 20
                    }
                },
                layout: {
                    padding: {
                        top: 5
                    }
                },
            }
        });

        // Pending Reason Chart
        const pendingReason = {!! json_encode($pending_reason_data) !!};
        const reasonKeys = [
            'Spare_part_on_progress',
            'Site_not_ready_or_waiting_confirm',
            'Postpone_or_new_appointment',
            'Process_return_or_change_set',
            'Waiting_service_schedule_Technician',
            'blank',
        ];
        const reasonLabels = ['Spare Part', 'Site Not Ready', 'Postpone', 'Return/Change', 'Waiting Sched.', 'Blank'];
        new Chart(document.getElementById('pending-reason-chart'), {
            type: 'bar',
            data: {
                labels: reasonLabels,
                datasets: [{
                        label: '0-3 Days',
                        data: reasonKeys.map(r => pendingReason[r]?.['0-3'] ?? 0),
                        backgroundColor: '#10b981'
                    },
                    {
                        label: '4-7 Days',
                        data: reasonKeys.map(r => pendingReason[r]?.['4-7'] ?? 0),
                        backgroundColor: '#84cc16'
                    },
                    {
                        label: '8-15 Days',
                        data: reasonKeys.map(r => pendingReason[r]?.['8-15'] ?? 0),
                        backgroundColor: '#facc15'
                    },
                    {
                        label: '16-30 Days',
                        data: reasonKeys.map(r => pendingReason[r]?.['16-30'] ?? 0),
                        backgroundColor: '#fb923c'
                    },
                    {
                        label: 'Over 30',
                        data: reasonKeys.map(r => pendingReason[r]?.['over_30'] ?? 0),
                        backgroundColor: '#ef4444'
                    },
                ]
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
                        anchor: 'center',
                        align: 'center',
                        color: '#fff',
                        font: {
                            size: 10,
                            weight: 'bold'
                        },
                        formatter: (value) => value > 0 ? value : '',
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    }
                },
                datasets: {
                    bar: {
                        barThickness: 20
                    }
                },
                layout: {
                    padding: {
                        top: 5
                    }
                },
            }
        });

        // Region Chart
        const pendingRegion = {!! json_encode($pending_region_data) !!};
        const regionKeys = ['bkk', 'southern', 'eastern', 'northern', 'northeastern', 'western', 'central', 'blank'];
        const regionLabels = ['Bangkok', 'Southern', 'Eastern', 'Northern', 'Northeastern', 'Western', 'Central', 'Blank'];
        new Chart(document.getElementById('region-chart'), {
            type: 'bar',
            data: {
                labels: regionLabels,
                datasets: [{
                        label: '0-3 Days',
                        data: regionKeys.map(r => pendingRegion[r]['0-3']),
                        backgroundColor: '#10b981'
                    },
                    {
                        label: '4-7 Days',
                        data: regionKeys.map(r => pendingRegion[r]['4-7']),
                        backgroundColor: '#84cc16'
                    },
                    {
                        label: '8-15 Days',
                        data: regionKeys.map(r => pendingRegion[r]['8-15']),
                        backgroundColor: '#facc15'
                    },
                    {
                        label: '16-30 Days',
                        data: regionKeys.map(r => pendingRegion[r]['16-30']),
                        backgroundColor: '#fb923c'
                    },
                    {
                        label: 'Over 30',
                        data: regionKeys.map(r => pendingRegion[r]['over_30']),
                        backgroundColor: '#ef4444'
                    },
                ]
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
                        anchor: 'center',
                        align: 'center',
                        color: '#fff',
                        font: {
                            size: 10,
                            weight: 'bold'
                        },
                        formatter: (value) => value > 0 ? value : '',
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    },
                    y: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                datasets: {
                    bar: {
                        barThickness: 16
                    }
                },
                layout: {
                    padding: {
                        right: 10
                    }
                },
            }
        });

        // Product Chart
        const productData = {!! json_encode($product_data) !!};
        const productKeys = ['Smart Technology', 'Home appliances', 'Sanitary'];
        const productLabels = ['Smart Tech', 'Home Appl.', 'Sanitary'];
        new Chart(document.getElementById('pending-product-aging-chart'), {
            type: 'bar',
            data: {
                labels: productLabels,
                datasets: [{
                        label: '0-3 Days',
                        data: productKeys.map(p => productData[p]?.['0-3'] ?? 0),
                        backgroundColor: '#10b981'
                    },
                    {
                        label: '4-7 Days',
                        data: productKeys.map(p => productData[p]?.['4-7'] ?? 0),
                        backgroundColor: '#84cc16'
                    },
                    {
                        label: '8-15 Days',
                        data: productKeys.map(p => productData[p]?.['8-15'] ?? 0),
                        backgroundColor: '#facc15'
                    },
                    {
                        label: '16-30 Days',
                        data: productKeys.map(p => productData[p]?.['16-30'] ?? 0),
                        backgroundColor: '#fb923c'
                    },
                    {
                        label: 'Over 30',
                        data: productKeys.map(p => productData[p]?.['over_30'] ?? 0),
                        backgroundColor: '#ef4444'
                    },
                ]
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
                        anchor: 'center',
                        align: 'center',
                        color: '#fff',
                        font: {
                            size: 10,
                            weight: 'bold'
                        },
                        formatter: (value) => value > 0 ? value : '',
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    },
                    y: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                datasets: {
                    bar: {
                        barThickness: 22
                    }
                },
                layout: {
                    padding: {
                        right: 10
                    }
                },
            }
        });
    </script>
@endpush
