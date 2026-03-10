<div class="space-y-2">
    <div class="grid grid-cols-1 lg:grid-cols-10 gap-2">
        {{-- LTP --}}
        <div class="lg:col-span-2 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
            <h3 class="font-bold text-center mb-2">LTP</h3>
            <div class="relative h-32 w-32 mx-auto">
                <canvas id="ltp-2-chart"></canvas>
            </div>
            <div class="py-2">
                <table class="w-full text-sm text-left">
                    <tbody>
                        <tr>
                            <td class="px-2 text-xs text-right font-semibold">TG.</td>
                            <td class="px-2 text-center font-bold">10.0%</td>
                            <td class="px-2 text-lg text-center">😊</td>
                        </tr>
                        <tr>
                            <td class="px-2 text-xs text-right font-semibold">Actual</td>
                            <td class="px-2 text-center font-bold">9.8%</td>
                            <td class="px-2 text-lg text-center font-bold">A</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TAT --}}
        <div class="lg:col-span-2 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
            <h3 class="font-bold text-center mb-2">TAT</h3>
            <div class="relative h-32 w-32 mx-auto">
                <canvas id="tat-chart"></canvas>
            </div>
            <div class="py-2">
                <table class="w-full text-sm text-left">
                    <tbody>
                        <tr>
                            <td class="px-2 text-xs text-right font-semibold">TG.</td>
                            <td class="px-2 text-center font-bold">7.0%</td>
                            <td class="px-2 text-lg text-center">😞</td>
                        </tr>
                        <tr>
                            <td class="px-2 text-xs text-right font-semibold">Actual</td>
                            <td class="px-2 text-center font-bold">7.2%</td>
                            <td class="px-2 text-lg text-center font-bold">B</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- CSI Response --}}
        <div class="lg:col-span-2 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
            <h3 class="font-bold text-center mb-2">CSI Response</h3>
            <div class="relative h-32 w-32 mx-auto">
                <canvas id="csi-response-chart"></canvas>
            </div>
            <div class="py-2">
                <table class="w-full text-sm text-left">
                    <tbody>
                        <tr>
                            <td class="px-2 text-xs text-right font-semibold">TG.</td>
                            <td class="px-2 text-center font-bold">60.0%</td>
                            <td class="px-2 text-lg text-center">😞</td>
                        </tr>
                        <tr>
                            <td class="px-2 text-xs text-right font-semibold">Actual</td>
                            <td class="px-2 text-center font-bold">24.7%</td>
                            <td class="px-2 text-lg text-center font-bold">C</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Open 3D --}}
        <div class="lg:col-span-2 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
            <h3 class="font-bold text-center mb-2">Open 3D</h3>
            <div class="relative h-32 w-32 mx-auto">
                <canvas id="open-3d-chart"></canvas>
            </div>
            <div class="py-2">
                <table class="w-full text-sm text-left">
                    <tbody>
                        <tr>
                            <td class="px-2 text-xs text-right font-semibold">TG.</td>
                            <td class="px-2 text-center font-bold">0.0%</td>
                            <td class="px-2 text-lg text-center">😞</td>
                        </tr>
                        <tr>
                            <td class="px-2 text-xs text-right font-semibold">Actual</td>
                            <td class="px-2 text-center font-bold">2.2%</td>
                            <td class="px-2 text-lg text-center font-bold">B</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pending 7D --}}
        <div class="lg:col-span-2 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
            <h3 class="font-bold text-center mb-2">Pending 7D</h3>
            <div class="relative h-32 w-32 mx-auto">
                <canvas id="pending-7d-chart"></canvas>
            </div>
            <div class="py-2">
                <table class="w-full text-sm text-left">
                    <tbody>
                        <tr>
                            <td class="px-2 text-xs text-right font-semibold">TG.</td>
                            <td class="px-2 text-center font-bold">0.0%</td>
                            <td class="px-2 text-lg text-center">😞</td>
                        </tr>
                        <tr>
                            <td class="px-2 text-xs text-right font-semibold">Actual</td>
                            <td class="px-2 text-center font-bold">6.3%</td>
                            <td class="px-2 text-lg text-center font-bold">C</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-2">
        <div class="col-span-3 flex items-center justify-center p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
            <h3 class="text-6xl font-bold">C</h3>
        </div>
        <div class="p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
            <div>
                <p class="text-xs 2xl:text-sm text-center text-red-600 font-bold">Pending</p>
                <div class="p-2 mt-2 bg-brown-status-500 rounded-lg text-center text-white">924</div>
            </div>
        </div>
        <div class="col-span-3 grid grid-cols-3 gap-3 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
            <div>
                <p class="text-xs 2xl:text-sm text-center text-orange-status-200 font-bold">Open</p>
                <div class="p-2 mt-2 bg-orange-status-200 rounded-lg text-center text-white">137</div>
            </div>
            <div>
                <p class="text-xs 2xl:text-sm text-center text-orange-status-400 font-bold">In Progress</p>
                <div class="p-2 mt-2 bg-orange-status-400 rounded-lg text-center text-white">298</div>
            </div>
            <div>
                <p class="text-xs 2xl:text-sm text-center text-orange-status-600 font-bold">Reason</p>
                <div class="p-2 mt-2 bg-orange-status-600 rounded-lg text-center text-white">489</div>
            </div>
        </div>
        <div class="col-span-5 grid grid-cols-5 gap-3 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
            <div>
                <p class="text-xs 2xl:text-sm text-center text-aging-100 font-bold">0-3 Days</p>
                <div class="p-2 mt-2 bg-aging-100 rounded-lg text-center text-white">264</div>
            </div>
            <div>
                <p class="text-xs 2xl:text-sm text-center font-bold">4-7 Days</p>
                <div class="p-2 mt-2 bg-aging-200 rounded-lg text-center text-white">197</div>
            </div>
            <div>
                <p class="text-xs 2xl:text-sm text-center font-bold">8-15 Days</p>
                <div class="p-2 mt-2 bg-aging-300 rounded-lg text-center">189</div>
            </div>
            <div>
                <p class="text-xs 2xl:text-sm text-center font-bold">16-30 Days</p>
                <div class="p-2 mt-2 bg-aging-400 rounded-lg text-center text-white">117</div>
            </div>
            <div>
                <p class="text-xs 2xl:text-sm text-center text-aging-500 font-bold">Over 30 Days</p>
                <div class="p-2 mt-2 bg-aging-500 rounded-lg text-center text-white">157</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-2">
        <div class="col-span-3 space-y-2">
            {{-- Pending Type --}}
            <div class="p-2 border-2 border-gray-300 rounded-xl bg-white shadow-sm">
                <div class="font-bold text-sm text-center text-gray-800 mb-3">Pending Type</div>
                <div class="relative w-full mx-auto">
                    <canvas id="pending-type-chart"></canvas>
                </div>
            </div>

            {{-- Pending Product Group --}}
            <div class="p-2 border-2 border-gray-300 rounded-xl bg-white shadow-sm">
                <div class="font-bold text-sm text-center text-gray-800 mb-3">Pending Product Group</div>
                <div class="relative w-full mx-auto">
                    <canvas id="pending-product-chart"></canvas>
                </div>
            </div>
        </div>

        {{-- ASC PENDING --}}
        <div class="col-span-4 p-2 border-2 border-gray-300 rounded-xl bg-white shadow-sm">
            <div class="font-bold text-sm text-center text-gray-500 mb-3">ASC PENDING</div>
            <div class="relative w-full mx-auto">
                <canvas id="asc-pending-chart" height="350"></canvas>
            </div>
        </div>

        {{-- IN HOUSE PENDING --}}
        <div class="col-span-5 p-2 border-2 border-gray-300 rounded-xl bg-white shadow-sm">
            <div class="font-bold text-sm text-center text-gray-500 mb-3">IN HOUSE PENDING</div>
            <div class="relative w-full mx-auto">
                <canvas id="inhouse-pending-chart" height="350"></canvas>
            </div>
        </div>

        {{-- Product Type Chart --}}
        <div class="col-span-7 p-2 border-2 border-gray-300 rounded-xl bg-white shadow-sm">
            <div class="relative w-full h-2/3 mx-auto">
                <canvas id="product-type-chart"></canvas>
            </div>
        </div>

        {{-- Region Chart --}}
        <div class="col-span-5 p-2 border-2 border-gray-300 rounded-xl bg-white shadow-sm">
            <div class="relative w-full mx-auto">
                <canvas id="region-chart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        // 1. LTP Chart
        new Chart(document.getElementById('ltp-2-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [100, 0],
                    backgroundColor: ['#800020', '#fecdd3'],
                    borderWidth: 0
                }]
            },
            options: {
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
                    }
                },
                elements: {
                    center: {
                        text: '100%',
                        color: '#1e40af'
                    }
                }
            }
        });

        // 2. TAT Chart
        new Chart(document.getElementById('tat-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [97, 3],
                    backgroundColor: ['#800020', '#fecdd3'],
                    borderWidth: 0
                }]
            },
            options: {
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
                    }
                },
                elements: {
                    center: {
                        text: '97%',
                        color: '#1e40af'
                    }
                }
            }
        });

        // 3. CSI Response Chart
        new Chart(document.getElementById('csi-response-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [41, 59],
                    backgroundColor: ['#800020', '#fecdd3'],
                    borderWidth: 0
                }]
            },
            options: {
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
                    }
                },
                elements: {
                    center: {
                        text: '41%',
                        color: '#1e40af'
                    }
                }
            }
        });

        // 4. Open 3D Chart
        new Chart(document.getElementById('open-3d-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [98, 2],
                    backgroundColor: ['#800020', '#fecdd3'],
                    borderWidth: 0
                }]
            },
            options: {
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
                    }
                },
                elements: {
                    center: {
                        text: '98%',
                        color: '#1e40af'
                    }
                }
            }
        });

        // 4. Pending 7D Chart
        new Chart(document.getElementById('pending-7d-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [94, 6],
                    backgroundColor: ['#800020', '#fecdd3'],
                    borderWidth: 0
                }]
            },
            options: {
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
                    }
                },
                elements: {
                    center: {
                        text: '94%',
                        color: '#1e40af'
                    }
                }
            }
        });
        
        // 5. Pending Type Chart
        new Chart(document.getElementById('pending-type-chart'), {
            type: 'bar',
            data: {
                labels: ['Repair', 'Installation', 'Spare Part / Accessory', 'Consult by Onsite', 'Consult by Phone'],
                datasets: [{
                    data: [439, 357, 64, 46, 16],
                    backgroundColor: '#DBDBDB',
                    borderWidth: 0,
                    barThickness: 25
                }]
            },
            plugins: [ChartDataLabels],
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    datalabels: {
                        anchor: 'start',
                        align: 'right',
                        offset: 10,
                        color: '#333',
                        font: { weight: 'bold', size: 11 },
                        formatter: function(value, context) {
                            return context.chart.data.labels[context.dataIndex] + ',  ' + value.toLocaleString();
                        }
                    }
                },
                scales: {
                    x: {
                        display: false,
                        grid: { display: false },
                        beginAtZero: true
                    },
                    y: {
                        display: false,
                        grid: { display: false }
                    }
                },
                layout: {
                    padding: {
                        right: 50
                    }
                }
            }
        });
        
        // 6. Pending Product Group Chart
        new Chart(document.getElementById('pending-product-chart'), {
            type: 'bar',
            data: {
                labels: ['Smart Technology', 'Home Appliances', 'Sanitary', 'Architectural Hardware', 'Furniture Fitting'],
                datasets: [{
                    data: [428, 379, 55, 29, 8],
                    backgroundColor: ['#DBDBDB', '#C4C4C4', '#ADADAD', '#969696', '#696969'],
                    borderWidth: 0,
                    barThickness: 25
                }]
            },
            plugins: [ChartDataLabels],
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    datalabels: {
                        anchor: 'start',
                        align: 'right',
                        offset: 10,
                        color: '#333',
                        font: { weight: 'bold', size: 11 },
                        formatter: function(value, context) {
                            return context.chart.data.labels[context.dataIndex] + ',  ' + value.toLocaleString();
                        }
                    }
                },
                scales: {
                    x: {
                        display: false,
                        grid: { display: false },
                        beginAtZero: true
                    },
                    y: {
                        display: false,
                        grid: { display: false }
                    }
                },
                layout: {
                    padding: {
                        right: 50
                    }
                }
            }
        });
        
        // 7. ASC pending Chart
        new Chart(document.getElementById('asc-pending-chart'), {
            type: 'bar',
            data: {
                labels: [ 'Bangkok Metropolitan', 'Southern', 'Eastern', 'Northern', 'Northeastern', 'Western', 'Central', 'blank'],
                datasets: [
                    {
                        label: 'Green',
                        data: [57, 14, 24, 18, 4, 7, 2, 2],
                        backgroundColor: '#00B050',
                        barPercentage: 0.8,
                        categoryPercentage: 0.9,
                    },
                    {
                        label: 'Light Green',
                        data: [37, 17, 18, 14, 11, 4, 1, 1],
                        backgroundColor: '#92D050',
                        barPercentage: 0.8,
                        categoryPercentage: 0.9,
                    },
                    {
                        label: 'Yellow',
                        data: [56, 26, 35, 6, 12, 3, 9, 3],
                        backgroundColor: '#FFFF00',
                        barPercentage: 0.8,
                        categoryPercentage: 0.9,
                    },
                    {
                        label: 'Orange',
                        data: [27, 39, 11, 7, 5, 2, 3, 1],
                        backgroundColor: '#FFC000',
                        barPercentage: 0.8,
                        categoryPercentage: 0.9,
                    },
                    {
                        label: 'Red',
                        data: [18, 18, 11, 5, 5, 2, 0, 2],
                        backgroundColor: '#FF0000',
                        barPercentage: 0.8,
                        categoryPercentage: 0.9,
                    }
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
                        color: '#333',
                        font: { size: 10 },
                        formatter: (value) => value > 0 ? value : '',
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: { display: false },
                        max: 250,
                        ticks: { stepSize: 50 }
                    },
                    y: {
                        stacked: true,
                        grid: { display: false }
                    }
                }
            }
        });
        
        // 8. In house pending Chart
        new Chart(document.getElementById('inhouse-pending-chart'), {
            type: 'bar',
            data: {
                labels: [
                    'HA&SA Technician BKK1', 'HA&SA Technician BKK2', 'HA&SA Technician BKK3',
                    'HA&SA Technician BKK4', 'HA&SA Technician BKK5', 'HA&SA Technician BKK6',
                    'HA&SA Technician BKK7', 'HW&FF Technician BKK1', 'HW&FF Technician BKK2',
                    'HW&FF Technician BKK3', 'HW&FF Technician BKK4', 'Technician BKK',
                    'Technician CM', 'Technician PHK'
                ],
                datasets: [
                    {
                        label: '0-3 Days',
                        data: [11, 16, 3, 4, 8, 8, 8, 7, 7, 13, 8, 0, 7, 20],
                        backgroundColor: '#00B050',
                    },
                    {
                        label: '4-7 Days',
                        data: [4, 6, 9, 2, 3, 3, 3, 12, 2, 6, 4, 0, 2, 18],
                        backgroundColor: '#92D050',
                    },
                    {
                        label: '8-15 Days',
                        data: [1, 12, 2, 0, 1, 1, 3, 1, 0, 0, 0, 1, 4, 1],
                        backgroundColor: '#FFFF00',
                    },
                    {
                        label: '16-30 Days',
                        data: [1, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: '#FFC000',
                    },
                    {
                        label: 'Over 30 Days',
                        data: [0, 2, 1, 0, 0, 0, 1, 0, 0, 0, 0, 2, 0, 1],
                        backgroundColor: '#FF0000',
                    }
                ]
            },
            plugins: [ChartDataLabels],
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 10 } }
                    },
                    datalabels: {
                        color: '#333',
                        font: { size: 10, weight: 'bold' },
                        formatter: (value) => value > 0 ? value : '',
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        max: 45,
                        grid: { display: false }
                    },
                    y: {
                        stacked: true,
                        grid: { display: false },
                        ticks: { font: { size: 10 } }
                    }
                },
            }
        });
    
        // 9. Product Type Chart
        new Chart(document.getElementById('product-type-chart'), {
            type: 'bar',
            data: {
                labels: ['Smart Technology', 'Home Appliances', 'Sanitary'],
                datasets: [
                    {
                        label: 'G1', 
                        data: [151, 81, 8], 
                        backgroundColor: '#00B050'
                    },
                    {
                        label: 'G2', 
                        data: [100, 65, 14], 
                        backgroundColor: '#92D050'
                    },
                    {
                        label: 'G3', 
                        data: [95, 78, 6], 
                        backgroundColor: '#FFFF00', 
                    },
                    {
                        label: 'G4', 
                        data: [65, 43, 7], 
                        backgroundColor: '#FFC000', 
                    },
                    {
                        label: 'G5', 
                        data: [17, 112, 20], 
                        backgroundColor: '#FF0000', 
                    }
                ]
            },
            plugins: [ChartDataLabels],
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 10 } }
                    },
                    datalabels: {
                        color: '#333',
                        font: { size: 10, weight: 'bold' },
                        formatter: (value) => value > 0 ? value : '',
                    }
                },
                scales: {
                    y: {
                        stacked: true,
                        grid: { display: false },
                        ticks: { font: { size: 10 } },
                        afterFit: (scaleInstance) => {
                            scaleInstance.width = 120;
                        }
                    },
                    x: {
                        stacked: true,
                        grid: { display: false }
                    }
                },
                datasets: {
                    bar: {
                        barThickness: 40, // fix the bar height to 40px
                        maxBarThickness: 50
                    }
                },
            }
        });

        // 10. Region Chart
        new Chart(document.getElementById('region-chart'), {
            type: 'bar',
            data: {
                labels: [
                    'Bangkok Metropolitan', 'Southern', 'Eastern', 'Northern', 
                    'Blank', 'Northeastern', 'Western', 'Central', '0'
                ],
                datasets: [
                    {
                        label: 'G1', 
                        data: [144, 38, 27, 25, 9, 8, 14, 2, 0], 
                        backgroundColor: '#00B050' 
                    },
                    {
                        label: 'G2', 
                        data: [87, 47, 23, 17, 3, 13, 5, 2, 0], 
                        backgroundColor: '#92D050'
                    },
                    {
                        label: 'G3', 
                        data: [83, 29, 35, 11, 7, 12, 3, 9, 0], 
                        backgroundColor: '#FFFF00', 
                    },
                    {
                        label: 'G4', 
                        data: [37, 44, 12, 9, 5, 5, 2, 3, 0], 
                        backgroundColor: '#FFC000', 
                    },
                    {
                        label: 'G5', 
                        data: [62, 34, 16, 8, 22, 8, 8, 0, 2], 
                        backgroundColor: '#FF0000', 
                    }
                ]
            },
            plugins: [ChartDataLabels],
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 10 } }
                    },
                    datalabels: {
                        color: '#333',
                        font: { size: 10, weight: 'bold' },
                        formatter: (value) => value > 0 ? value : '',
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: { display: false }
                    },
                    y: {
                        stacked: true,
                        grid: { display: false },
                        ticks: { font: { size: 10 } }
                    }
                },
            }
        });
    </script>
@endpush
