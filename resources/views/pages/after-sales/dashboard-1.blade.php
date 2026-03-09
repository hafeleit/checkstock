@extends('layouts.app-dashboard')

@section('content')
    <div class="space-y-6">
        <div class="grid grid-cols-12 gap-4">
            {{-- CSI --}}
            <div class="col-span-2 p-2 border-2 border-red-500 rounded-3xl bg-white shadow-sm">
                <h3 class="font-bold text-center">CSI</h3>
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
            <div class="col-span-3 p-2 border-2 border-red-500 rounded-3xl bg-white shadow-sm">
                <h3 class="font-bold text-center">RTAT</h3>
                <div class="grid grid-cols-2 gap-4">
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
                    <div class="bg-red-300 border-2 border-red-500 flex p-2 rounded-3xl">
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
            <div class="col-span-2 p-2 border-2 border-red-500 rounded-3xl bg-white shadow-sm">
                <h3 class="font-bold text-center">LTP</h3>
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
                                <td class="px-2 text-center font-bold text-red-400">9.8%</td>
                                <td class="px-2 text-lg text-center font-bold">A</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- FTF --}}
            <div class="col-span-2 p-2 border-2 border-red-500 rounded-3xl bg-white shadow-sm">
                <h3 class="font-bold text-center">FTF</h3>
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
                                <td class="px-2 text-center font-bold text-red-400">93.6%</td>
                                <td class="px-2 text-lg text-center font-bold">A</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pending --}}
            <div class="col-span-3 p-2 border-2 border-red-500 rounded-3xl bg-white shadow-sm">
                <h3 class="font-bold text-center">Pending</h3>
                <div class="relative h-32 w-32 mx-auto">
                    <canvas id="pending-1-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        // Plugin สำหรับแสดงข้อความตรงกลางของ Doughnut Chart
        const centerTextPlugin = {
            id: 'centerText',
            beforeDraw: function(chart) {
                if (chart.config.options.elements.center) {
                    const ctx = chart.ctx;
                    const centerConfig = chart.config.options.elements.center;
                    const fontStyle = centerConfig.fontStyle || 'Arial';
                    const txt = centerConfig.text;
                    const color = centerConfig.color || '#000';
                    const sidePadding = centerConfig.sidePadding || 20;
                    const sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 20);

                    ctx.font = "bold 20px " + fontStyle;

                    const stringWidth = ctx.measureText(txt).width;
                    const elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                    const widthRatio = elementWidth / stringWidth;
                    const newFontSize = Math.floor(30 * widthRatio);
                    const fontSizeToUse = Math.min(newFontSize, centerConfig.maxFontSize || 70);

                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    const centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                    const centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);

                    ctx.font = "bold " + fontSizeToUse + "px " + fontStyle;
                    ctx.fillStyle = color;

                    ctx.fillText(txt, centerX, centerY);
                }
            }
        };

        // ลงทะเบียน Plugin
        Chart.register(centerTextPlugin);

        // 1. CSI Chart
        new Chart(document.getElementById('csi-chart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [99, 1],
                    backgroundColor: ['#881337', '#fecdd3'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '60%',
                plugins: {
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
                    backgroundColor: ['#881337', '#fecdd3'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '60%',
                plugins: {
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
                    backgroundColor: ['#881337', '#fecdd3'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '60%',
                plugins: {
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
                    backgroundColor: ['#881337', '#fecdd3'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '60%',
                plugins: {
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

        // 4. Pending Chart
        new Chart(document.getElementById('pending-1-chart'), {
            type: 'pie',
            data: {
                datasets: [{
                    data: [100, 0],
                    backgroundColor: ['#881337', '#fecdd3'],
                    hoverOffset: 4
                }]
            },
        });
    </script>
@endpush
