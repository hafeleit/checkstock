<div class="min-h-screen text-gray-800">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- * KPIs * --}}
        <div class="bg-white rounded-2xl p-5 flex flex-col items-center shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 font-medium text-md mb-4">CSI</h3>
            <div class="relative w-40 h-40 flex items-center justify-center mb-4">
                <canvas id="csi-chart"></canvas>
            </div>
            <div class="w-full flex justify-between items-end text-md">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-sm">Target</span>
                    <span class="font-semibold text-gray-700">95.0%</span>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-gray-400 text-sm">Actual</span>
                    <span class="font-semibold text-gray-700">94.0%</span>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-gray-400 text-sm">Grade</span>
                    <div class="flex items-center gap-1">
                        <span class="font-bold text-gray-800">B</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-frown text-yellow-500" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.5 3.5 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.5 4.5 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 flex flex-col items-center shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 font-medium text-md mb-4">R_TAT</h3>
            <div class="relative w-40 h-40 flex items-center justify-center mb-4">
                <canvas id="rtat-chart"></canvas>
            </div>
            <div class="w-full flex justify-between items-end text-md">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-sm">Target</span>
                    <span class="font-semibold text-gray-700">8.9</span>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-gray-400 text-sm">Actual</span>
                    <span class="font-semibold text-gray-700">{{ $rtat }}</span>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-gray-400 text-sm">Grade</span>
                    <div class="flex items-center gap-1">
                        <span class="font-bold text-gray-800">B</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-frown text-yellow-500" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.5 3.5 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.5 4.5 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="absolute top-4 right-2 bg-gray-50 text-sm p-2 rounded-lg border border-gray-100 text-right">
                <div class="font-semibold text-gray-700">BKK</div>
                <div class="text-gray-500 text-sm">
                    TG: 3.0 | Act: 
                    <span class="text-rose-500">3.8</span>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 flex flex-col items-center shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 font-medium text-md mb-4">LTP</h3>
            <div class="relative w-40 h-40 flex items-center justify-center mb-4">
                <canvas id="ltp-chart"></canvas>
            </div>
            <div class="w-full flex justify-between items-end text-md">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-sm">Target</span>
                    <span class="font-semibold text-gray-700">70.0%</span>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-gray-400 text-sm">Actual</span>
                    <span class="font-semibold text-gray-700">{{ $ltp }}%</span>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-gray-400 text-sm">Grade</span>
                    <div class="flex items-center gap-1">
                        <span class="font-bold text-gray-800">C</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-frown text-yellow-500" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.5 3.5 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.5 4.5 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 flex flex-col items-center shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 font-medium text-md mb-4">FTF</h3>
            <div class="relative w-40 h-40 flex items-center justify-center mb-4">
                <canvas id="ftf-chart"></canvas>
            </div>
            <div class="w-full flex justify-between items-end text-md">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-sm">Target</span>
                    <span class="font-semibold text-gray-700">80.0%</span>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-gray-400 text-sm">Actual</span>
                    <span class="font-semibold text-gray-700">{{ $ftf }}%</span>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-gray-400 text-sm">Grade</span>
                    <div class="flex items-center gap-1">
                        <span class="font-bold text-gray-800">A</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile text-yellow-500" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.5 3.5 0 0 0 8 11.5a3.5 3.5 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- * CSI Details & Pending * --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 lg:col-span-2 flex flex-col">
            <h3 class="text-gray-800 font-semibold mb-6 flex items-center gap-2">Customer Satisfaction (CSI) Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Responses --}}
                <div class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl">
                    <span class="text-sm text-gray-500 font-medium uppercase tracking-wider mb-2">Responses</span>
                    <div class="text-3xl font-bold text-red-600 mb-1">512</div>
                    <div class="text-sm text-gray-400">out of <span class="font-semibold text-gray-600">1,107</span></div>
                    <div class="relative w-3/4 mx-auto">
                        <canvas id="responses-chart"></canvas>
                    </div>
                    <span class="text-sm text-gray-500 mt-1">46% Response Rate</span>
                </div>
                {{-- Satisfaction Bar --}}
                <div class="md:col-span-2 flex flex-col justify-center">
                    <span class="text-md font-medium text-gray-700 mb-4 text-center">Are you satisfied with the service team?</span>
                    <div class="flex items-center gap-3 w-full">
                        <div class="relative w-28 h-28 mx-auto">
                            <canvas id="satisfaction-doughnut-chart"></canvas>
                        </div>
                        <div class="relative w-2/3 h-36 mx-auto">
                            <canvas id="satisfaction-bar-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4 Mini Questions --}}
            <div class="flex justify-between items-start border-gray-100 mt-auto">
                <div class="flex flex-col items-center text-center gap-2">
                    <div class="relative w-28 h-28 flex items-center justify-center">
                        <canvas id="response-1-chart"></canvas>
                    </div>
                    <p class="text-sm text-gray-500 leading-tight w-20">Problem resolved?</p>
                </div>
                <div class="flex flex-col items-center text-center gap-2">
                    <div class="relative w-28 h-28 flex items-center justify-center">
                        <canvas id="response-2-chart"></canvas>
                    </div>
                    <p class="text-sm text-gray-500 leading-tight w-20">Arrived as scheduled?</p>
                </div>
                <div class="flex flex-col items-center text-center gap-2">
                    <div class="relative w-28 h-28 flex items-center justify-center">
                        <canvas id="response-3-chart"></canvas>
                    </div>
                    <p class="text-sm text-gray-500 leading-tight w-20">Polite and well mannered?</p>
                </div>
                <div class="flex flex-col items-center text-center gap-2">
                    <div class="relative w-28 h-28 flex items-center justify-center">
                        <canvas id="response-4-chart"></canvas>
                    </div>
                    <p class="text-sm text-gray-500 leading-tight w-20">Charged any expenses?</p>
                </div>
            </div>
        </div>

        {{-- * Pending Card * --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 lg:col-span-2">
            <h3 class="text-gray-800 font-semibold mb-2">Pending Overview</h3>
            <p class="text-sm text-gray-500 mb-6">Distribution and breakdown of pending tasks.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 h-56">
                <div class="h-full">
                    <canvas id="pending-1-chart"></canvas>
                </div>
                <div>
                    <div class="h-full w-full">
                        <canvas id="pending-bar-1-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- * Tickets & Contract * --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 lg:col-span-2">
            <h3 class="text-gray-800 font-semibold mb-6">Ticket Open vs Close</h3>
            <div class="relative h-72 mx-auto">
                <canvas id="ticket-chart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 lg:col-span-2">
            <h3 class="text-gray-800 font-semibold mb-6">Contract Center Trend</h3>
            <div class="relative h-72 mx-auto">
                <canvas id="contract-center-chart"></canvas>
            </div>
        </div>

        {{-- * Total Daily Performance * --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 lg:col-span-4">
            <h3 class="text-gray-800 font-semibold mb-6">Total Daily Performance (March)</h3>
            <div class="relative h-72 mx-auto">
                <canvas id="daily-total-chart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        // Dashboard Data from Controller
        const dashboardData = {
            rtat: {{ $rtat ?? 0 }},
            ltp: {{ $ltp ?? 0 }},
            ftf: {{ $ftf ?? 0 }},
            pending_data: {!! json_encode($pending_data) !!},
        };

        console.log(dashboardData)

        // Color Constants
        const COLORS = {
            success: '#10b981',
            danger: '#9f1239',
            critical: '#c70e0e',
            darkRed: '#e11d48',
            darkPurple: '#300613',
            lightRed: '#fecdd3',
            lightPink: '#ffd6fa',
            primary: '#1e40af',
            black: '#000000',
            neutral: '#E0E0E0',
            gray: '#BDBDBD'
        };

        // Chart Configuration Defaults
        const doughnutDefaults = {
            cutout: '70%',
            plugins: {
                datalabels: { display: false },
                legend: { display: false },
                tooltip: { enabled: false }
            }
        };

        // Factory function for KPI doughnut charts
        const createKPIDoughnut = (chartId, value, displayText = null) => {
            const dataValue = value >= 100 ? 100 : value;
            const remainingValue = 100 - dataValue;
            return new Chart(document.getElementById(chartId), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [dataValue, remainingValue],
                        backgroundColor: [
                            dataValue >= 100 ? COLORS.success : COLORS.danger,
                            COLORS.lightRed
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    ...doughnutDefaults,
                    elements: {
                        center: {
                            text: displayText || value + '%',
                            color: COLORS.primary
                        }
                    }
                }
            });
        };

        // Factory function for satisfaction doughnut charts
        const createSatisfactionDoughnut = (chartId, value, displayText = null) => {
            const remainingValue = 100 - value;
            return new Chart(document.getElementById(chartId), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [value, remainingValue],
                        backgroundColor: [COLORS.darkRed, COLORS.lightPink],
                        borderWidth: 0
                    }]
                },
                options: {
                    ...doughnutDefaults,
                    elements: {
                        center: {
                            text: displayText || value + '%',
                            color: COLORS.critical
                        }
                    }
                }
            });
        };

        // Initialize KPI Charts
        const rtatScore = Math.round(Math.min(100, Math.max(0, 100 * (dashboardData.rtat / 8.9))));
        const ltpScore = Math.round(Math.min(100, Math.max(0, 100 * (dashboardData.ltp / 70))));
        const ftfScore = Math.round(Math.min(100, Math.max(0, 100 * (dashboardData.ftf / 80))));

        createKPIDoughnut('csi-chart', 99);
        createKPIDoughnut('rtat-chart', rtatScore);
        createKPIDoughnut('ltp-chart', ltpScore);
        createKPIDoughnut('ftf-chart', ftfScore);


        // Pending Pie Chart
        const ascScore = Math.round(Math.min(100, Math.max(0, 100 * (dashboardData.pending_data.grandAscTotal / dashboardData.pending_data.grandTotal))));
        const hafeleScore = Math.round(Math.min(100, Math.max(0, 100 * (dashboardData.pending_data.grandAscTotal / dashboardData.pending_data.grandTotal))));
        
        new Chart(document.getElementById('pending-1-chart'), {
            type: 'pie',
            data: {
                labels: ['ASC', 'Hafele'],
                datasets: [{
                    data: [dashboardData.pending_data.grandAscTotal, dashboardData.pending_data.grandAscTotal],
                    backgroundColor: [COLORS.darkPurple, COLORS.critical],
                    hoverOffset: 4
                }]
            },
            options: {
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        color: '#fff',
                        anchor: 'center',
                        align: 'center',
                        font: { size: 14 },
                        formatter: (value, ctx) => {
                            let label = ctx.chart.data.labels[ctx.dataIndex];
                            return label + '\n' + value + '%';
                        }
                    }
                }
            }
        });

        // Pending Bar Chart
        new Chart(document.getElementById('pending-bar-1-chart'), {
            type: 'bar',
            data: {
                labels: [
                    'Installation (ASC)',
                    'Repair (ASC)',
                    'Repair (hafele)',
                    'Spare Part (hafele)',
                    'Consult by Onsite (hafele)',
                    'Consult by Phone (hafele)'
                ],
                datasets: [{
                    data: [356, 170, 202, 64, 40, 15],
                    backgroundColor: [COLORS.darkPurple, COLORS.darkPurple, COLORS.critical, COLORS.critical, COLORS.critical, COLORS.critical],
                    barPercentage: 0.8,
                }],
                borderWidth: 0,
            },
            plugins: [ChartDataLabels],
            options: {
                indexAxis: 'y',
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'right',
                        offset: 4,
                        color: '#000',
                        font: { size: 10 }
                    },
                },
                scales: {
                    y: {
                        grid: { display: false },
                        ticks: { font: { size: 10 } }
                    },
                    x: { display: true, beginAtZero: true }
                },
                layout: {
                    padding: { top: 10, bottom: 10, left: 20, right: 20 }
                }
            }
        });

        // CSI Responses Gauge Chart
        new Chart(document.getElementById('responses-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [46, 54],
                    backgroundColor: ['#FBBF24', '#fff3cd'],
                    borderWidth: 0
                }]
            },
            options: {
                rotation: -90,
                circumference: 180,
                cutout: '55%',
                plugins: {
                    datalabels: { display: false },
                    legend: { display: false },
                    tooltip: { enabled: false },
                    centerTextHalf: {
                        text: '46%',
                        color: '#ffc107',
                        fontStyle: 'Arial'
                    }
                }
            }
        });

        // Satisfaction Doughnut Chart
        createSatisfactionDoughnut('satisfaction-doughnut-chart', 94);

        // Satisfaction Bar Chart
        new Chart(document.getElementById('satisfaction-bar-chart'), {
            type: 'bar',
            data: {
                labels: ['Very Good', 'Good', 'Normal', 'Bad', 'Very Bad'],
                datasets: [{
                    data: [283.71, 104.26, 2.1, 1.0, 0.0],
                    backgroundColor: [
                        COLORS.darkRed, '#f43f5e', '#fb7185', '#fda4af', COLORS.lightRed
                    ],
                    barPercentage: 0.6,
                }],
                borderWidth: 0,
            },
            plugins: [ChartDataLabels],
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#000',
                        font: { size: 10 }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            autoSkip: false,
                            font: { size: 10 }
                        }
                    },
                    y: { display: false, beginAtZero: true }
                },
                layout: { padding: { top: 20, bottom: 10 } }
            }
        });

        // Response Q1-Q4 Satisfaction Charts
        createSatisfactionDoughnut('response-1-chart', 99, '99%');
        createSatisfactionDoughnut('response-2-chart', 100, '100%');
        createSatisfactionDoughnut('response-3-chart', 97, '97%');
        createSatisfactionDoughnut('response-4-chart', 23, '23%');

        // Ticket Open vs Close Bar Chart
        new Chart(document.getElementById('ticket-chart'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Open',
                        data: [3584, 1426, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: COLORS.neutral,
                        borderWidth: 0,
                        barPercentage: 1,
                        categoryPercentage: 0.9
                    },
                    {
                        label: 'Closed',
                        data: [3505, 1424, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: COLORS.gray,
                        borderWidth: 0,
                        barPercentage: 1,
                        categoryPercentage: 0.9
                    }
                ]
            },
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: { boxWidth: 10, usePointStyle: true, pointStyle: 'rect' }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        rotation: 90,
                        color: '#000',
                        offset: 2,
                        font: { size: 8 },
                        formatter: (value) => value > 0 ? value.toLocaleString() : ''
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: true },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            autoSkip: false,
                            font: { size: 10 }
                        }
                    },
                    y: {
                        grid: { display: false },
                        display: true,
                        beginAtZero: true,
                        suggestedMax: 4500
                    }
                },
                layout: { padding: { top: 30, bottom: 10 } }
            }
        });

        // Contract Center Trend Line Chart
        new Chart(document.getElementById('contract-center-chart'), {
            type: 'line',
            data: {
                labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                datasets: [
                    {
                        label: '2025',
                        data: [5220, 4260, 4225, 3578, 4190, 3721, 4136, 4015, 4048, 4175, 4014, 4333],
                        borderColor: COLORS.black,
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: COLORS.black,
                        pointBorderWidth: 2,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#ffffff',
                        pointHoverBorderColor: COLORS.black,
                    },
                    {
                        label: '2026',
                        data: [4563, 2062, 5690, null, null, null, null, null, null, null, null, null],
                        borderColor: COLORS.critical,
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: COLORS.critical,
                        pointBorderWidth: 2,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#ffffff',
                        pointHoverBorderColor: COLORS.critical,
                    }
                ]
            },
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'bottom' },
                    datalabels: {
                        align: 'top',
                        anchor: 'end',
                        offset: 5,
                        color: '#333',
                        font: { size: 10 },
                        formatter: (value) => value > 0 ? value.toLocaleString() : ''
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 12 },
                        callbacks: {
                            label: (context) => context.dataset.label + ': ' + context.parsed.y
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            autoSkip: false,
                            font: { size: 10 }
                        }
                    },
                    y: { display: true, beginAtZero: true }
                },
                layout: { padding: { top: 20, left: 10, right: 10 } }
            }
        });

        // Daily Total Performance Line Chart
        new Chart(document.getElementById('daily-total-chart'), {
            type: 'line',
            data: {
                labels: ['1-Mar', '2-Mar', '3-Mar', '4-Mar', '5-Mar', '6-Mar', '7-Mar', '8-Mar', '9-Mar', '10-Mar', '11-Mar', '12-Mar', '13-Mar', '14-Mar', '15-Mar', '16-Mar', '17-Mar', '18-Mar', '19-Mar', '20-Mar', '21-Mar', '22-Mar', '23-Mar', '24-Mar', '25-Mar', '26-Mar', '27-Mar', '28-Mar', '29-Mar', '30-Mar', '31-Mar'],
                datasets: [
                    {
                        label: 'Day Shift',
                        data: [45, 52, 48, 55, 62, 58, 51, 49, 54, 60, 57, 53, 59, 64, 61, 58, 52, 50, 55, 61, 63, 60, 58, 54, 52, 49, 51, 56, 59, 62, null],
                        borderColor: COLORS.black,
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: COLORS.black,
                        pointBorderWidth: 2,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#ffffff',
                        pointHoverBorderColor: COLORS.black,
                    },
                    {
                        label: 'Night Shift',
                        data: [38, 42, 45, 48, 52, 50, 44, 41, 46, 51, 49, 45, 50, 55, 53, 50, 44, 42, 47, 52, 54, 51, 49, 45, 43, 40, 42, 47, 50, 53, null],
                        borderColor: COLORS.critical,
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: COLORS.critical,
                        pointBorderWidth: 2,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#ffffff',
                        pointHoverBorderColor: COLORS.critical,
                    }
                ]
            },
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'bottom' },
                    datalabels: {
                        align: 'top',
                        anchor: 'end',
                        offset: 0,
                        color: '#333',
                        font: { size: 10 },
                        formatter: (value) => value > 0 ? value : ''
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 12 },
                        callbacks: {
                            label: (context) => context.dataset.label + ': ' + context.parsed.y
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            autoSkip: false,
                            font: { size: 10 }
                        }
                    },
                    y: { grid: { display: false }, display: true, beginAtZero: true }
                },
                layout: { padding: { top: 20, left: 40, right: 10, bottom: 20 } }
            }
        });
    </script>
@endpush
