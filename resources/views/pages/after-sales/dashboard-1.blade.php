<div class="space-y-2">
    <div class="grid grid-cols-1 2xl:grid-cols-12 gap-2">
        <div class="col-span-1 2xl:col-span-9 grid grid-cols-1 md:grid-cols-1 lg:grid-cols-12 gap-2">
            {{-- CSI --}}
            <div class="lg:col-span-3 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                <h3 class="font-bold text-center mb-2">CSI</h3>
                <div class="relative h-32 w-32 mx-auto">
                    <canvas id="csi-chart"></canvas>
                </div>
                <div class="py-2">
                    <table class="w-full text-sm text-left">
                        <tbody>
                            <tr>
                                <td class="px-2 text-xs text-right font-semibold">TG.</td>
                                <td class="px-2 text-center font-bold">95.0%</td>
                                <td class="px-2 text-lg text-center">😞</td>
                            </tr>
                            <tr>
                                <td class="px-2 text-xs text-right font-semibold">Actual</td>
                                <td class="px-2 text-center font-bold">94.0%</td>
                                <td class="px-2 text-lg text-center font-bold">B</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- RTAT --}}
            <div class="lg:col-span-3 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                <h3 class="font-bold text-center mb-2">RTAT</h3>
                <div class="grid grid-cols-2 gap-2">
                    <div class="relative h-32 w-32 mx-auto">
                        <canvas id="rtat-chart"></canvas>
                        <div class="py-2">
                            <table class="w-full text-sm text-left">
                                <tbody>
                                    <tr>
                                        <td class="px-2 text-xs text-right font-semibold">TG.</td>
                                        <td class="px-2 text-center font-bold">7.0</td>
                                        <td class="px-2 text-lg text-center">😞</td>
                                    </tr>
                                    <tr>
                                        <td class="px-2 text-xs text-right font-semibold">Actual</td>
                                        <td class="px-2 text-center font-bold">7.2</td>
                                        <td class="px-2 text-lg text-center font-bold">B</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="bg-red-300 border-2 border-red-500 flex p-2 rounded-xl">
                        <table class="w-full text-sm text-left">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-center font-bold">BKK</td>
                                </tr>
                                <tr>
                                    <td class="px-2 text-xs font-semibold">TG.</td>
                                    <td class="px-2 text-center font-bold">3.0</td>
                                </tr>
                                <tr>
                                    <td class="px-2 text-xs font-semibold">Actual</td>
                                    <td class="px-2 text-center font-bold">4.2</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- LTP --}}
            <div class="lg:col-span-3 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                <h3 class="font-bold text-center mb-2">LTP</h3>
                <div class="relative h-32 w-32 mx-auto">
                    <canvas id="ltp-chart"></canvas>
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
                                <td class="px-2 text-center font-bold text-red-600">9.8%</td>
                                <td class="px-2 text-lg text-center font-bold">A</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- FTF --}}
            <div class="lg:col-span-3 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                <h3 class="font-bold text-center mb-2">FTF</h3>
                <div class="relative h-32 w-32 mx-auto">
                    <canvas id="ftf-chart"></canvas>
                </div>
                <div class="py-2">
                    <table class="w-full text-sm text-left">
                        <tbody>
                            <tr>
                                <td class="px-2 text-xs text-right font-semibold">TG.</td>
                                <td class="px-2 text-center font-bold">80.0%</td>
                                <td class="px-2 text-lg text-center">😊</td>
                            </tr>
                            <tr>
                                <td class="px-2 text-xs text-right font-semibold">Actual</td>
                                <td class="px-2 text-center font-bold text-red-600">93.6%</td>
                                <td class="px-2 text-lg text-center font-bold">A</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Monthly Summary --}}
            <div class="lg:col-span-12 grid grid-cols-1 lg:grid-cols-12 gap-2">
                <div class="lg:col-span-2 flex items-center p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                    <h3 class="text-4xl 2xl:text-5xl text-center font-bold">February</h3>
                </div>
                <div
                    class="lg:col-span-2 grid grid-cols-2 gap-3 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                    <div>
                        <p class="text-xs 2xl:text-sm text-center text-pink-600 font-bold">Create</p>
                        <div class="p-2 mt-2 bg-pink-500 rounded-lg text-center text-white">1426</div>
                    </div>
                    <div>
                        <p class="text-xs 2xl:text-sm text-center text-teal-status-400 font-bold">Closed</p>
                        <div class="p-2 mt-2 bg-teal-status-400 rounded-lg text-center text-white">1426</div>
                    </div>
                </div>
                <div class="p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                    <div>
                        <p class="text-xs 2xl:text-sm text-center text-red-600 font-bold">On hand</p>
                        <div class="p-2 mt-2 bg-brown-status-500 rounded-lg text-center text-white">924</div>
                    </div>
                </div>
                <div class="lg:col-span-3 grid grid-cols-3 gap-3 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                    <div>
                        <p class="text-xs 2xl:text-sm text-center text-orange-status-200 font-bold">Open</p>
                        <div class="p-2 mt-2 bg-orange-status-200 rounded-lg text-center text-white">137</div>
                    </div>
                    <div>
                        <p class="text-xs 2xl:text-sm text-center text-orange-status-400 font-bold">Booking</p>
                        <div class="p-2 mt-2 bg-orange-status-400 rounded-lg text-center text-white">298</div>
                    </div>
                    <div>
                        <p class="text-xs 2xl:text-sm text-center text-orange-status-600 font-bold">Pending</p>
                        <div class="p-2 mt-2 bg-orange-status-600 rounded-lg text-center text-white">489</div>
                    </div>
                </div>
                <div class="lg:col-span-4 grid grid-cols-5 gap-3 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                    <div>
                        <p class="text-xs 2xl:text-sm text-center text-aging-100 font-bold">0-3 D.</p>
                        <div class="p-2 mt-2 bg-aging-100 rounded-lg text-center text-white">264</div>
                    </div>
                    <div>
                        <p class="text-xs 2xl:text-sm text-center font-bold">4-7 D.</p>
                        <div class="p-2 mt-2 bg-aging-200 rounded-lg text-center text-white">197</div>
                    </div>
                    <div>
                        <p class="text-xs 2xl:text-sm text-center font-bold">8-15 D.</p>
                        <div class="p-2 mt-2 bg-aging-300 rounded-lg text-center">189</div>
                    </div>
                    <div>
                        <p class="text-xs 2xl:text-sm text-center font-bold">16-30 D.</p>
                        <div class="p-2 mt-2 bg-aging-400 rounded-lg text-center text-white">117</div>
                    </div>
                    <div>
                        <p class="text-xs 2xl:text-sm text-center text-aging-500 font-bold">Over 30 D.</p>
                        <div class="p-2 mt-2 bg-aging-500 rounded-lg text-center text-white">157</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="col-span-1 2xl:col-span-3 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
            <h3 class="font-bold text-center mb-2">Pending</h3>
            <div class="relative h-32 w-32 mx-auto">
                <canvas id="pending-1-chart"></canvas>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                <div class="relative w-full mx-auto">
                    <canvas id="pending-bar-1-chart" height="200"></canvas>
                </div>
                <div class="relative w-full mx-auto">
                    <canvas id="pending-bar-2-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 2xl:grid-cols-2 gap-2">
        {{-- Customer Satisfaction --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
            <div class="lg:col-span-2 font-bold">Customer Satisfaction (CSI)</div>
            <div class="grid grid-cols-6 gap-2 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                <div class="lg:col-span-2 space-y-2">
                    <p class="text-red-600 font-bold text-lg">Responses</p>
                    <div class="bg-red-600 py-4 rounded-lg text-3xl text-center text-white font-bold">400</div>
                    <div class="bg-red-600 py-2 rounded-lg text-lg text-center text-white">843</div>
                </div>
                <div class="lg:col-span-4">
                    <div class="relative w-48 mx-auto">
                        <canvas id="responses-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-2 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                <div class="lg:col-span-6 space-y-2">
                    <p class="font-bold text-center">Are you satisfied with the service team?</p>
                </div>
                <div class="lg:col-span-2">
                    <div class="relative w-32 h-32 mx-auto">
                        <canvas id="satisfaction-doughnut-chart"></canvas>
                    </div>
                </div>
                <div class="lg:col-span-4">
                    <div class="relative w-full mx-auto">
                        <canvas id="satisfaction-bar-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2 grid grid-cols-12 gap-2">
                <div class="lg:col-span-3 grid grid-rows-1 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                    <div class="font-bold text-sm mb-3">Was your problem resolved?</div>
                    <div class="relative w-32 h-32 mx-auto">
                        <canvas id="response-1-chart"></canvas>
                    </div>
                </div>
                <div class="lg:col-span-3 grid grid-rows-1 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                    <div class="font-bold text-sm mb-3">Did the service team arrive as scheduled?</div>
                    <div class="relative w-32 h-32 mx-auto">
                        <canvas id="response-2-chart"></canvas>
                    </div>
                </div>
                <div class="lg:col-span-3 grid grid-rows-1 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                    <div class="font-bold text-sm mb-3">Was the service polite and well mannered?</div>
                    <div class="relative w-32 h-32 mx-auto">
                        <canvas id="response-3-chart"></canvas>
                    </div>
                </div>
                <div class="lg:col-span-3 grid grid-rows-1 p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                    <div class="font-bold text-sm mb-3">Has the official charged any expenses or not?</div>
                    <div class="relative w-32 h-32 mx-auto">
                        <canvas id="response-4-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Spare parts --}}
        <div class="p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm space-y-2">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 h-full">
                <div class="lg:col-span-2 flex items-center font-bold text-3xl">Spare parts</div>
                <div class="p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                    <div class="font-bold text-center text-gray-500">Black Order</div>
                    <div class="relative w-full mx-auto">
                        <canvas id="black-order-chart"></canvas>
                    </div>
                </div>
                <div class="p-2 border-2 border-red-500 rounded-xl bg-white shadow-sm">
                    <div class="font-bold text-center text-gray-500">STAT</div>
                    <div class="relative w-full mx-auto">
                        <canvas id="stat-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
        <div class="p-2 border-2 border-gray-300 rounded-xl bg-white shadow-sm">
            <div class="font-bold text-sm text-center text-gray-600 mb-3">Ticket Open/Close</div>
            <div class="relative h-72 mx-auto">
                <canvas id="ticket-chart"></canvas>
            </div>
        </div>
        <div class="p-2 border-2 border-gray-300 rounded-xl bg-white shadow-sm">
            <div class="font-bold text-sm text-center text-gray-600 mb-3">Contract Center</div>
            <div class="relative h-72 mx-auto">
                <canvas id="contract-center-chart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        // 1. CSI Chart
        new Chart(document.getElementById('csi-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [99, 1],
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
                        text: '99%',
                        color: '#1e40af'
                    }
                }
            }
        });

        // 2. RTAT Chart
        new Chart(document.getElementById('rtat-chart'), {
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

        // 3. LTP Chart
        new Chart(document.getElementById('ltp-chart'), {
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

        // 4. FTF Chart
        new Chart(document.getElementById('ftf-chart'), {
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

        // 5. Pending Chart
        new Chart(document.getElementById('pending-1-chart'), {
            type: 'pie',
            data: {
                labels: ['ASC', 'Hafele'],
                datasets: [{
                    data: [58, 42],
                    backgroundColor: ['#800020', '#c70e0e'],
                    hoverOffset: 4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        color: '#fff',
                        anchor: 'center',
                        align: 'center',
                        font: {
                            size: 10
                        },
                        formatter: (value, ctx) => {
                            let label = ctx.chart.data.labels[ctx.dataIndex];
                            return label + '\n' + value + '%';
                        },
                        textAlign: 'center'
                    }
                }
            }
        });

        // 6. Pending Bar 1 Chart
        new Chart(document.getElementById('pending-bar-1-chart'), {
            type: 'bar',
            data: {
                labels: [
                    'Repair',
                    ['Spare Part'],
                    ['Consult by Onsite'],
                    ['Consult by Phone']
                ],
                datasets: [{
                    data: [202, 64, 40, 15],
                    backgroundColor: ['#c70e0e'],
                    barPercentage: 0.6,
                }],
                borderWidth: 0,
            },
            plugins: [ChartDataLabels],
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        offset: 2,
                        color: '#000',
                        font: {
                            weight: 'bold'
                        }
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 90,
                            minRotation: 0,
                            autoSkip: false,
                            font: {
                                size: 10
                            },
                            padding: 5
                        }
                    },
                    y: {
                        display: false,
                        beginAtZero: true,
                        grace: '15%'
                    }
                },
                layout: {
                    padding: {
                        top: 20,
                        bottom: 10
                    }
                }
            }
        });

        // 7. Pending Bar 2 Chart
        new Chart(document.getElementById('pending-bar-2-chart'), {
            type: 'bar',
            data: {
                labels: ['Installation', 'Repair'],
                datasets: [{
                    data: [356, 170],
                    backgroundColor: ['#800020'],
                    barPercentage: 0.6,
                }],
                borderWidth: 0,
            },
            plugins: [ChartDataLabels],
            options: {
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
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            autoSkip: false,
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        display: false,
                        beginAtZero: true,
                    }
                },
                layout: {
                    padding: {
                        top: 20,
                        bottom: 10
                    }
                }
            }
        });

        // 8. CSI Responses Chart
        new Chart(document.getElementById('responses-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [47, 53],
                    backgroundColor: ['#ffc107', '#fff3cd'],
                    borderWidth: 0
                }]
            },
            options: {
                rotation: -90,
                circumference: 180,
                cutout: '55%',
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
                    centerTextHalf: {
                        text: '47%',
                        color: '#ffc107',
                        fontStyle: 'Arial'
                    }
                }
            }
        });

        // 9. Satisfaction Doughnut Chart
        new Chart(document.getElementById('satisfaction-doughnut-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [94, 6],
                    backgroundColor: ['#c70e0e', '#fecdd3'],
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
                        color: '#c70e0e'
                    }
                }
            }
        });

        // 10. Satisfaction Bar Chart
        new Chart(document.getElementById('satisfaction-bar-chart'), {
            type: 'bar',
            data: {
                labels: ['Very Good', 'Good', 'Normal', 'Bad', 'Very Bad'],
                datasets: [{
                    data: [283.71, 104.26, 2.1, 1.0, 0.0],
                    backgroundColor: ['#c70e0e'],
                    barPercentage: 0.6,
                }],
                borderWidth: 0,
            },
            plugins: [ChartDataLabels],
            options: {
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
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            autoSkip: false,
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        display: false,
                        beginAtZero: true,
                    }
                },
                layout: {
                    padding: {
                        top: 20,
                        bottom: 10
                    }
                }
            }
        });

        // 11. Response 1 Chart
        new Chart(document.getElementById('response-1-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [99, 1],
                    backgroundColor: ['#c70e0e', '#fecdd3'],
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
                        text: '99%',
                        color: '#c70e0e'
                    }
                }
            }
        });

        // 12. Response 2 Chart
        new Chart(document.getElementById('response-2-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [100, 0],
                    backgroundColor: ['#c70e0e', '#fecdd3'],
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
                        color: '#c70e0e'
                    }
                }
            }
        });

        // 13. Response 3 Chart
        new Chart(document.getElementById('response-3-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [97, 3],
                    backgroundColor: ['#c70e0e', '#fecdd3'],
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
                        color: '#c70e0e'
                    }
                }
            }
        });

        // 14. Response 4 Chart
        new Chart(document.getElementById('response-4-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [23, 72],
                    backgroundColor: ['#c70e0e', '#fecdd3'],
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
                        text: '23%',
                        color: '#c70e0e'
                    }
                }
            }
        });

        // 15. Black Order Chart
        new Chart(document.getElementById('black-order-chart'), {
            type: 'line',
            data: {
                labels: [
                    ['JUL', '2025'],
                    ['AUG', '2025'],
                    ['SEP', '2025'],
                    ['OCT', '2025'],
                    ['NOV', '2025'],
                    ['DEC', '2025'],
                    ['JAN', '2026'],
                    ['FEB', '2026']
                ],
                datasets: [{
                    label: 'Black Orders',
                    data: [47.3, 49.4, 47.5, 53.2, 40.2, 45.6, 51.4, 54.5],
                    borderColor: '#000000',
                    fill: false,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#000000',
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#ffffff',
                    pointHoverBorderColor: '#000000',
                }]
            },
            plugins: [ChartDataLabels],
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        align: 'top',
                        anchor: 'end',
                        offset: 8,
                        color: '#333',
                        font: {
                            weight: 'bold',
                            size: 11
                        },
                        formatter: (value) => value.toFixed(1)
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 12
                        },
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            autoSkip: false,
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        display: false,
                        beginAtZero: true,
                        grace: '25%'
                    }
                },
                layout: {
                    padding: {
                        top: 30,
                        left: 10,
                        right: 10
                    }
                }
            }
        });

        // 16. STAT Chart
        new Chart(document.getElementById('stat-chart'), {
            type: 'line',
            data: {
                labels: [
                    ['JUL', '2025'],
                    ['AUG', '2025'],
                    ['SEP', '2025'],
                    ['OCT', '2025'],
                    ['NOV', '2025'],
                    ['DEC', '2025'],
                    ['JAN', '2026'],
                    ['FEB', '2026']
                ],
                datasets: [{
                    label: 'STAT',
                    data: [25.9, 28.7, 14.6, 10.8, 9.6, 7.4, 20.4, 11.8],
                    borderColor: '#000000',
                    fill: false,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#000000',
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#ffffff',
                    pointHoverBorderColor: '#000000',
                }]
            },
            plugins: [ChartDataLabels],
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        align: 'top',
                        anchor: 'end',
                        offset: 8,
                        color: '#333',
                        font: {
                            weight: 'bold',
                            size: 11
                        },
                        formatter: (value) => value.toFixed(1)
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 12
                        },
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            autoSkip: false,
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        display: false,
                        beginAtZero: true,
                        grace: '25%'
                    }
                },
                layout: {
                    padding: {
                        top: 30,
                        left: 10,
                        right: 10
                    }
                }
            }
        });

        // 17. Ticket Chart
        new Chart(document.getElementById('ticket-chart'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                        label: 'Open',
                        data: [3584, 1426, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: '#E0E0E0',
                        borderWidth: 0,
                        barPercentage: 1,
                        categoryPercentage: 0.9
                    },
                    {
                        label: 'Closed',
                        data: [3505, 1424, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: '#BDBDBD',
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
                        labels: {
                            boxWidth: 10,
                            usePointStyle: true,
                            pointStyle: 'rect'
                        }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#000',
                        offset: 2,
                        font: {
                            weight: 'bold',
                        },
                        formatter: function(value) {
                            return value > 0 ? value.toLocaleString() : '';
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: true
                        },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            autoSkip: false,
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        display: false,
                        beginAtZero: true,
                        suggestedMax: 4500
                    }
                },
                layout: {
                    padding: {
                        top: 30,
                        bottom: 10
                    }
                }
            }
        });

        // 18. Contract Center Chart
        new Chart(document.getElementById('contract-center-chart'), {
            type: 'line',
            data: {
                labels: [
                    ['JAN', '2025'],
                    ['FEB', '2025'],
                    ['MAR', '2025'],
                    ['APR', '2025'],
                    ['MAY', '2025'],
                    ['JUN', '2025'],
                    ['JUL', '2025'],
                    ['AUG', '2025'],
                    ['SEP', '2025'],
                    ['OCT', '2025'],
                    ['NOV', '2025'],
                    ['DEC', '2025'],
                    ['JAN', '2026'],
                    ['FEB', '2026']
                ],
                datasets: [{
                    label: 'Cotract center',
                    data: [5220, 4260, 4225, 3578, 4190, 3721, 4136, 4015, 4048, 4175, 4014, 4333, 4563,
                        2062
                    ],
                    borderColor: '#000000',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#000000',
                    pointBorderWidth: 2,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#ffffff',
                    pointHoverBorderColor: '#000000',
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
                        align: 'top',
                        anchor: 'end',
                        offset: 10,
                        color: '#333',
                        font: {
                            weight: 'bold',
                            size: 10
                        },
                        formatter: function(value) {
                            return value > 0 ? value.toLocaleString() : '';
                        }
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 12
                        },
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            ticks: {
                                font: {
                                    size: 9
                                },
                                padding: 10
                            }
                        },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            autoSkip: false,
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        display: true,
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: '#f0f0f0'
                        },
                        ticks: {
                            stepSize: 1000,
                            callback: (val) => val.toLocaleString()
                        },
                        grace: '25%'
                    }
                },
                layout: {
                    padding: {
                        top: 40,
                        left: 10,
                        right: 10
                    }
                }
            }
        });
    </script>
@endpush
