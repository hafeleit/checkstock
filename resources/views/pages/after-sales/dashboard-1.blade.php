@php
    $csiSurvey    = $csi_response_data['survey_data'];
    $csiResponses = (int) ($csiSurvey->total ?? 0);
    $csiTotal     = (int) ($csi_response_data['total_ticket'] ?? 0);
    $csiRate      = $csiTotal > 0 ? round($csiResponses / $csiTotal * 100, 1) : 0;
    $csiSatPct    = $csiResponses > 0 ? round($csiSurvey->service_very_good / $csiResponses * 100, 1) : 0;
@endphp

<style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
    .response-rate-bar { 
        width: {{ $csiRate }}%; 
    }
</style>

<div class="h-full flex flex-col gap-1 overflow-hidden text-gray-800">

    {{-- ── ROW 1: KPI Cards ── --}}
    <div class="flex-shrink-0 grid grid-cols-4 gap-1">

        {{-- CSI --}}
        <div class="bg-white rounded-lg px-2 py-1 shadow-sm border border-gray-100 flex items-center gap-2">
            <div class="relative w-16 h-16 flex-shrink-0">
                <canvas id="csi-chart"></canvas>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">CSI</p>
                <div class="flex items-baseline gap-1 mt-0.5">
                    <span class="text-lg font-bold text-gray-800">{{ $csiSatPct }}%</span>
                </div>
                <p class="text-xs text-gray-400 mt-0.5">Target: <span class="font-semibold text-gray-600">95.0%</span></p>
            </div>
        </div>

        {{-- R_TAT --}}
        <div class="bg-white rounded-lg px-2 py-1 shadow-sm border border-gray-100 flex items-center gap-2">
            <div class="relative w-16 h-16 flex-shrink-0">
                <canvas id="rtat-chart"></canvas>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">R_TAT</p>
                <div class="flex items-baseline gap-1 mt-0.5">
                    <span class="text-lg font-bold text-gray-800">{{ $rtat['overall'] }}</span>
                </div>
                <p class="text-xs text-gray-400 mt-0.5">Target: <span class="font-semibold text-gray-600">< 7 days</span></p>
                <div class="flex items-center gap-1.5 mt-0.5 pt-0.5 border-t border-gray-100">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">BKK</span>
                    <span class="text-xs text-gray-400">TG: <span class="font-semibold text-gray-600">3.0</span></span>
                    <span class="text-gray-300">|</span>
                    <span class="text-xs text-gray-400">Act: <span class="font-semibold text-rose-500">{{ $rtat['bkk'] }}</span></span>
                </div>
            </div>
        </div>

        {{-- LTP --}}
        <div class="bg-white rounded-lg px-2 py-1 shadow-sm border border-gray-100 flex items-center gap-2">
            <div class="relative w-16 h-16 flex-shrink-0">
                <canvas id="ltp-chart"></canvas>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">LTP</p>
                <div class="flex items-baseline gap-1 mt-0.5">
                    <span class="text-lg font-bold text-gray-800">{{ $ltp }}%</span>
                </div>
                <p class="text-xs text-gray-400 mt-0.5">Target: <span class="font-semibold text-gray-600">14.0%</span></p>
            </div>
        </div>

        {{-- FTF --}}
        <div class="bg-white rounded-lg px-2 py-1 shadow-sm border border-gray-100 flex items-center gap-2">
            <div class="relative w-16 h-16 flex-shrink-0">
                <canvas id="ftf-chart"></canvas>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">FTF</p>
                <div class="flex items-baseline gap-1 mt-0.5">
                    <span class="text-lg font-bold text-gray-800">{{ $ftf }}%</span>
                </div>
                <p class="text-xs text-gray-400 mt-0.5">Target: <span class="font-semibold text-gray-600">80.0%</span></p>
            </div>
        </div>

    </div>

    {{-- ── ROW 2: CSI Details + Pending Overview ── --}}
    <div class="min-h-0 grid grid-cols-5 gap-1 [flex:3]">

        {{-- CSI Details — 3 cols --}}
        <div class="col-span-3 bg-white rounded-lg p-2 shadow-sm border border-gray-100 flex flex-col gap-2 overflow-hidden">
            <h3 class="text-sm font-semibold text-gray-700 flex-shrink-0">Customer Satisfaction (CSI)</h3>

            {{-- Responses (left) + Are you satisfied (right) --}}
            <div class="flex-shrink-0 flex gap-2 items-stretch">
                {{-- Responses box --}}
                <div class="flex-shrink-0 bg-gray-100 rounded-lg p-1.5 flex flex-col justify-center gap-0.5">
                    <span class="text-sm text-gray-400 uppercase tracking-wide font-semibold leading-tight">Responses</span>
                    <div class="flex items-baseline gap-1">
                        <span class="text-base font-bold text-red-600">{{ number_format($csiResponses) }}</span>
                        <span class="text-sm text-gray-400">/ {{ number_format($csiTotal) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                        <div class="response-rate-bar h-1.5 rounded-full bg-yellow-400"></div>
                    </div>
                    <span class="text-sm font-semibold text-yellow-600 leading-tight">{{ $csiRate }}% Rate</span>
                </div>
                {{-- Satisfaction section --}}
                <div class="flex-1 min-w-0 flex flex-col gap-1">
                    <span class="text-sm font-medium text-gray-500 text-center leading-tight flex-shrink-0">Are you satisfied with the service team?</span>
                    <div class="flex items-center justify-center gap-2">
                        <div class="relative w-16 h-16 flex-shrink-0">
                            <canvas id="satisfaction-doughnut-chart"></canvas>
                        </div>
                        <div class="relative w-48 flex-shrink-0 h-16">
                            <canvas id="satisfaction-bar-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4 Mini Q — single horizontal row --}}
            <div class="flex-1 min-h-0 flex items-center justify-around pt-2 border-t border-gray-200">
                <div class="flex flex-col items-center gap-0.5">
                    <div class="relative w-16 h-16 flex-shrink-0">
                        <canvas id="response-1-chart"></canvas>
                    </div>
                    <p class="text-sm text-gray-500 text-center leading-tight">Problem resolved?</p>
                </div>
                <div class="flex flex-col items-center gap-0.5">
                    <div class="relative w-16 h-16 flex-shrink-0">
                        <canvas id="response-2-chart"></canvas>
                    </div>
                    <p class="text-sm text-gray-500 text-center leading-tight">Arrived as scheduled?</p>
                </div>
                <div class="flex flex-col items-center gap-0.5">
                    <div class="relative w-16 h-16 flex-shrink-0">
                        <canvas id="response-3-chart"></canvas>
                    </div>
                    <p class="text-sm text-gray-500 text-center leading-tight">Polite & well mannered?</p>
                </div>
                <div class="flex flex-col items-center gap-0.5">
                    <div class="relative w-16 h-16 flex-shrink-0">
                        <canvas id="response-4-chart"></canvas>
                    </div>
                    <p class="text-sm text-gray-500 text-center leading-tight">Charged expenses?</p>
                </div>
            </div>
        </div>

        {{-- Pending Overview — 2 cols --}}
        <div class="col-span-2 bg-white rounded-lg p-2 shadow-sm border border-gray-100 flex flex-col min-h-0">
            <h3 class="text-sm font-semibold text-gray-700 mb-1 flex-shrink-0">Pending Overview</h3>
            <div class="flex-1 min-h-0 flex gap-2 overflow-hidden">
                <div class="w-2/5 flex-shrink-0 relative min-h-0">
                    <canvas id="pending-1-chart"></canvas>
                </div>
                <div class="flex-1 min-w-0 relative min-h-0">
                    <canvas id="pending-bar-1-chart"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- ── ROW 3: Ticket + Contract + Daily ── --}}
    <div class="min-h-0 grid grid-cols-3 gap-1 [flex:2]">

        <div class="bg-white rounded-lg p-2 shadow-sm border border-gray-100 flex flex-col min-h-0">
            <h3 class="text-sm font-semibold text-gray-700 mb-0.5 flex-shrink-0">Ticket Open vs Close</h3>
            <div class="flex-1 min-h-0 relative">
                <canvas id="ticket-chart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg p-2 shadow-sm border border-gray-100 flex flex-col min-h-0">
            <h3 class="text-sm font-semibold text-gray-700 mb-0.5 flex-shrink-0">Contract Center Trend</h3>
            <div class="flex-1 min-h-0 relative">
                <canvas id="contract-center-chart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg p-2 shadow-sm border border-gray-100 flex flex-col min-h-0">
            <h3 class="text-sm font-semibold text-gray-700 mb-0.5 flex-shrink-0">Daily Performance
                ({{ now()->format('F') }})</h3>
            <div class="flex-1 min-h-0 relative">
                <canvas id="daily-total-chart"></canvas>
            </div>
        </div>

    </div>
</div>

@push('scripts')
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        // ── Data from Controller ──────────────────────────────────────────────────
        const dashboardData = {
            rtat: {{ $rtat['overall'] ?? 0 }},
            rtatBkk: {{ $rtat['bkk'] ?? 0 }},
            ltp: {{ $ltp ?? 0 }},
            ftf: {{ $ftf ?? 0 }},
            pending_data: {!! json_encode($pending_data) !!},
        };

        // ── Color palette ─────────────────────────────────────────────────────────
        const C = {
            primary: '#1e40af',
            critical: '#c70e0e',
            darkRed: '#e11d48',
            darkPurple: '#300613',
            lightRed: '#fecdd3',
            lightPink: '#ffd6fa',
            black: '#000000',
        };

        // ── Shared defaults ───────────────────────────────────────────────────────
        const doughnutDefaults = {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
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

        // ── Helpers ───────────────────────────────────────────────────────────────
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
            pointHoverRadius: 4,
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: color,
        });

        const createLineChart = (id, labels, datasets, yStepSize = null) => new Chart(document.getElementById(id), {
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
                                size: 8
                            }
                        }
                    },
                    datalabels: {
                        align: 'top',
                        anchor: 'end',
                        offset: 3,
                        color: '#333',
                        font: {
                            size: 9
                        },
                        formatter: (v) => v > 0 ? v.toLocaleString() : '',
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: (ctx) => ctx.dataset.label + ': ' + ctx.parsed.y
                        },
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
                                size: 8
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        beginAtZero: true,
                        ...(yStepSize !== null ? { ticks: { stepSize: yStepSize, font: { size: 8 } } } : { ticks: { font: { size: 8 } } }),
                    },
                },
                layout: {
                    padding: {
                        top: 25
                    }
                },
            },
        });

        const createKPIDoughnut = (id, value) => new Chart(document.getElementById(id), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [Math.min(value, 100), Math.max(0, 100 - value)],
                    backgroundColor: [value >= 100 ? '#10b981' : C.critical, C.lightRed],
                    borderWidth: 0,
                }],
            },
            options: {
                ...doughnutDefaults,
                elements: {
                    center: {
                        text: value + '%',
                        color: C.primary
                    }
                },
            },
        });

        const createSatDoughnut = (id, value, text = null) => new Chart(document.getElementById(id), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [value, 100 - value],
                    backgroundColor: [C.darkRed, C.lightPink],
                    borderWidth: 0,
                }],
            },
            options: {
                ...doughnutDefaults,
                elements: {
                    center: {
                        text: text ?? value + '%',
                        color: C.critical
                    }
                },
            },
        });

        // ── KPI Charts ────────────────────────────────────────────────────────────
        const rtatScore = Math.round(Math.min(100, Math.max(0, (7 / dashboardData.rtat) * 100)));
        const ltpScore = Math.round(Math.min(100, Math.max(0, 100 * dashboardData.ltp / 14)));
        const ftfScore = Math.round(Math.min(100, Math.max(0, 100 * dashboardData.ftf / 80)));

        createKPIDoughnut('rtat-chart', rtatScore);
        createKPIDoughnut('ltp-chart', ltpScore);
        createKPIDoughnut('ftf-chart', ftfScore);

        // ── Satisfaction charts ───────────────────────────────────────────────────
        const csiSurvey = {!! json_encode($csiSurvey) !!};
        const csiPct = val => csiSurvey.total > 0 ? Math.round(val / csiSurvey.total * 1000) / 10 : 0;
        const csiSatPct = csiPct(csiSurvey.service_very_good);
        const csiScore = Math.round(Math.min(100, Math.max(0, 100 * csiSatPct / 95)));
        createKPIDoughnut('csi-chart', csiScore);

        const csiProblemResolved   = csiPct(csiSurvey.problem_resolved_yes);
        const csiArriveAsScheduled = csiPct(csiSurvey.arrive_as_scheduled_yes);
        const csiPoliteWellMannered= csiPct(csiSurvey.polite_and_well_mannered_yes);
        const csiChargedExpenses   = csiPct(csiSurvey.charged_expenses_yes);
        createSatDoughnut('satisfaction-doughnut-chart', csiSatPct);

        new Chart(document.getElementById('satisfaction-bar-chart'), {
            type: 'bar',
            data: {
                labels: ['Very Good', 'Good', 'Normal', 'Bad', 'Very Bad'],
                datasets: [{
                    data: [csiSurvey.service_very_good, csiSurvey.service_good, csiSurvey.service_normal, csiSurvey.service_bad, csiSurvey.service_very_bad],
                    backgroundColor: [C.darkRed, '#f43f5e', '#fb7185', '#fda4af', C.lightRed],
                    barPercentage: 0.6,
                    borderWidth: 0,
                }],
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
                        anchor: 'end',
                        align: 'top',
                        color: '#000',
                        font: {
                            size: 7
                        }
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
                                size: 7
                            }
                        }
                    },
                    y: {
                        display: false,
                        beginAtZero: true
                    },
                },
                layout: {
                    padding: {
                        top: 12,
                        bottom: 3
                    }
                },
            },
        });

        createSatDoughnut('response-1-chart', csiProblemResolved,    csiProblemResolved    + '%');
        createSatDoughnut('response-2-chart', csiArriveAsScheduled,  csiArriveAsScheduled  + '%');
        createSatDoughnut('response-3-chart', csiPoliteWellMannered, csiPoliteWellMannered + '%');
        createSatDoughnut('response-4-chart', csiChargedExpenses,    csiChargedExpenses    + '%');

        // ── Pending Pie ───────────────────────────────────────────────────────────
        const {
            grandTotal,
            grandAscTotal,
            grandHafeleTotal,
            ascData,
            hafeleData
        } = dashboardData.pending_data;
        const pct = (n) => Math.round(Math.min(100, Math.max(0, 100 * n / grandTotal)));

        new Chart(document.getElementById('pending-1-chart'), {
            type: 'pie',
            data: {
                labels: ['ASC', 'Hafele'],
                datasets: [{
                    data: [pct(grandAscTotal), pct(grandHafeleTotal)],
                    backgroundColor: [C.darkPurple, C.critical],
                    hoverOffset: 4,
                }],
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
                            size: 9
                        },
                        formatter: (v, ctx) => ctx.chart.data.labels[ctx.dataIndex] + '\n' + v + '%',
                    },
                },
            },
        });

        // ── Pending Bar ───────────────────────────────────────────────────────────
        const getTotal = (data, type) => data.find(d => d.type === type)?.total ?? 0;
        new Chart(document.getElementById('pending-bar-1-chart'), {
            type: 'bar',
            data: {
                labels: [
                    'Installation (ASC)', 'Repair (ASC)',
                    'Repair (Hafele)', 'Spare Part (Hafele)',
                    'Onsite Consult (Hafele)', 'Phone Consult (Hafele)',
                ],
                datasets: [{
                    data: [
                        getTotal(ascData, 'I'),
                        getTotal(ascData, 'R'),
                        getTotal(hafeleData, 'R'),
                        getTotal(hafeleData, 'spare_part'),
                        getTotal(hafeleData, 'C'),
                        getTotal(hafeleData, 'consult_or_advise'),
                    ],
                    backgroundColor: [
                        C.darkPurple, C.darkPurple,
                        C.critical, C.critical, C.critical, C.critical,
                    ],
                    barPercentage: 0.8,
                    borderWidth: 0,
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
                            size: 8
                        }
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
                                size: 8
                            }
                        }
                    },
                },
                layout: {
                    padding: {
                        right: 20,
                        top: 3,
                        bottom: 3
                    }
                },
            },
        });

        // ── Ticket Chart ──────────────────────────────────────────────────────────
        const ticketData = {!! json_encode($ticket_status_data) !!};
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const ticketMonths = Object.keys(ticketData).map(Number).sort((a, b) => a - b);

        new Chart(document.getElementById('ticket-chart'), {
            type: 'bar',
            data: {
                labels: ticketMonths.map(m => monthNames[m - 1]),
                datasets: [{
                        label: 'Open',
                        data: ticketMonths.map(m => ticketData[m].open),
                        backgroundColor: '#cbd5e1',
                        borderWidth: 0,
                        barPercentage: 1,
                        categoryPercentage: 0.9
                    },
                    {
                        label: 'Closed',
                        data: ticketMonths.map(m => ticketData[m].closed),
                        backgroundColor: '#475569',
                        borderWidth: 0,
                        barPercentage: 1,
                        categoryPercentage: 0.9
                    },
                ],
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
                            usePointStyle: true,
                            pointStyle: 'rect',
                            font: {
                                size: 8
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        rotation: -90,
                        color: '#555',
                        offset: 0,
                        font: {
                            size: 9
                        },
                        formatter: (v) => v > 0 ? v.toLocaleString() : ''
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
                                size: 8
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1000,
                            font: {
                                size: 8
                            }
                        }
                    },
                },
                layout: {
                    padding: {
                        top: 28
                    }
                },
            },
        });

        // ── Contract Center Chart ─────────────────────────────────────────────────
        const contractData = {!! json_encode($contract_center_data) !!};
        createLineChart(
            'contract-center-chart',
            ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
            [
                makeLineDataset(String(contractData.prev_year), Array.from({ length: 12 }, (_, i) => contractData.prev[i + 1] ?? null), C.black),
                makeLineDataset(String(contractData.current_year), Array.from({ length: 12 }, (_, i) => contractData.current[i + 1] ?? null), C.critical),
            ],
            1000
        );

        // ── Daily Performance Chart ───────────────────────────────────────────────
        const dailyData = {!! json_encode($contract_daily_data) !!};
        const dailyDays = Object.keys(dailyData).map(Number).sort((a, b) => a - b);
        const dailyMonth = new Date({{ now()->year }}, {{ now()->month - 1 }}).toLocaleString('en', { month: 'short' });

        createLineChart(
            'daily-total-chart',
            dailyDays.map(d => d),
            [
                makeLineDataset('Day Shift (08:00 - 17:00)', dailyDays.map(d => dailyData[d].day_shift), C.black),
                makeLineDataset('Night Shift (17:01 - 07:59)', dailyDays.map(d => dailyData[d].night_shift), C.critical),
            ],
            50
        );
    </script>
@endpush
