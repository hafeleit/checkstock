@extends('layouts.after-sales-user')

@section('title', 'After-Sales Dashboard')
@section('content')

    @php
        // Overall — KPI card (response rate, total ticket count)
        $csiSurvey    = $csiData['survey_data'];
        $csiResponses = (int) ($csiSurvey->total ?? 0);
        $csiTotal     = (int) ($csiData['total_ticket'] ?? 0);
        $csiRate      = $csiTotal > 0 ? round(($csiResponses / $csiTotal) * 100, 1) : 0;

        // Filtered — drives all charts + response card
        $filtSurvey   = $filteredSurvey;
        $filtTotal    = (int) ($filtSurvey->total ?? 0);
        $filtRate     = $csiTotal > 0 ? round(($filtTotal / $csiTotal) * 100, 1) : 0;
        $filtPoint    = ($filtSurvey->service_very_good * 5)
                      + ($filtSurvey->service_good      * 4)
                      + ($filtSurvey->service_normal    * 3)
                      + ($filtSurvey->service_bad       * 2)
                      + ($filtSurvey->service_very_bad  * 1);
        $filtSatPct   = $filtTotal > 0 ? round(($filtPoint / ($filtTotal * 5)) * 100, 1) : 0;
    @endphp

    @push('styles')
        <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
            .ud-sat-bar-wrap {
                width: 50%;
                position: relative;
                height: 120px;
            }
        </style>
    @endpush

    <div class="space-y-2">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mb-6">

            {{-- Responses + Satisfaction --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex gap-4 h-full">
                    {{-- Response rate --}}
                    <div class="flex-shrink-0 bg-gray-100 rounded-lg p-3 flex flex-col justify-center gap-1 w-40">
                        <p class="text-md text-gray-400 uppercase font-semibold">Responses</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-bold text-red-600">{{ number_format($filtTotal) }}</span>
                            <span class="text-sm text-gray-400">/ {{ number_format($csiTotal) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                            <div class="h-1.5 rounded-full bg-yellow-400" id="ud-csi-rate-bar"></div>
                        </div>
                        <span class="text-sm font-bold text-yellow-600">{{ $filtRate }}% Rate</span>
                    </div>
                    {{-- Satisfaction --}}
                    <div class="flex-1 flex flex-col">
                        <p class="text-md text-center text-gray-500 mb-2">Are you satisfied with the service team?</p>
                        <div class="flex items-center justify-center gap-4 flex-1">
                            <div class="relative w-24 h-24 flex-shrink-0">
                                <canvas id="ud-sat-doughnut"></canvas>
                            </div>
                            <div class="ud-sat-bar-wrap">
                                <canvas id="ud-sat-bar"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4 Mini Q --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="grid grid-cols-2 gap-3 h-full">
                    @foreach ([['ud-q1-chart', 'Problem resolved?'], ['ud-q2-chart', 'Arrived as scheduled?'], ['ud-q3-chart', 'Polite & well mannered?']] as [$qid, $qlabel])
                        <div class="flex flex-col items-center justify-center gap-1 {{ $loop->last ? 'col-span-2' : '' }}">
                            <div class="relative w-20 h-20"><canvas id="{{ $qid }}"></canvas></div>
                            <p class="text-md text-gray-500 text-center leading-tight">{{ $qlabel }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- CSI Survey Responses Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full">
            <div class="px-3 py-3 border-b border-gray-100">
                <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">CSI Survey Responses</p>
                <p class="text-lg font-bold text-gray-800 mt-0.5">{{ number_format($surveys->total() ?? 0, 0) }}
                    <span class="text-sm font-normal text-gray-400">responses</span>
                </p>

                {{-- Status Filter --}}
                @php
                    $serviceStatuses = [
                        'ดีมาก (Very Good)' => 'Very Good',
                        'ดี (Good)'         => 'Good',
                        'ปกติ (Normal)'     => 'Normal',
                        'แย่ (Bad)'         => 'Bad',
                        'แย่มาก (Very Bad)' => 'Very Bad',
                    ];
                @endphp

                <div class="mt-2">
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-gray-400 mb-1">Service Status</p>
                    <div class="flex flex-wrap gap-1.5">
                        <a href="?" class="px-2 py-1 rounded text-xs font-semibold {{ empty($activeStatuses) ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
                        @foreach ($serviceStatuses as $value => $label)
                            @php
                                $isStatusActive  = in_array($value, $activeStatuses);
                                $newStatuses     = $isStatusActive
                                    ? array_values(array_filter($activeStatuses, fn($s) => $s !== $value))
                                    : [...$activeStatuses, $value];
                                $statusParams    = !empty($newStatuses) ? ['status' => $newStatuses] : [];
                            @endphp
                            <a href="?{{ http_build_query($statusParams) }}" class="px-2 py-1 rounded text-xs font-semibold {{ $isStatusActive ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
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
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Date</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Service Team</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Problem Resolved</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Arrive on Schedule</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Polite</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap">Charged Expenses</th>
                            <th class="px-3 py-2 text-left font-semibold whitespace-nowrap w-3/12">Suggestions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($surveys as $survey)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-gray-400">{{ $surveys->firstItem() + $loop->index }}</td>
                                <td class="px-3 py-2 text-gray-600">
                                    {{ \Carbon\Carbon::parse($survey->start_time)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    @php
                                        $serviceClass = match (true) {
                                            str_contains($survey->service_team ?? '', 'Very Good') => 'bg-green-100 text-green-700',
                                            str_contains($survey->service_team ?? '', 'Good') => 'bg-blue-100 text-blue-700',
                                            str_contains($survey->service_team ?? '', 'Normal') => 'bg-yellow-100 text-yellow-700',
                                            str_contains($survey->service_team ?? '', 'Bad') => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <span
                                        class="px-1.5 py-0.5 rounded font-semibold {{ $serviceClass }}">{{ $survey->service_team ?? '-' }}</span>
                                </td>
                                <td class="px-3 py-2 text-gray-600">{{ $survey->problem_resolved ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $survey->arrive_as_scheduled ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $survey->polite_and_well_mannered ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $survey->charged_expenses ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $survey->suggestions ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 py-6 text-center text-gray-400">No survey responses this
                                    month.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($surveys->hasPages())
                <div class="px-3 py-3 border-t border-gray-100">
                    {{ $surveys->links() }}
                </div>
            @endif
        </div>
    </div>


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2" nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>
        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
            Chart.register({
                id: 'centerText',
                beforeDraw(chart) {
                    if (chart.config.type !== 'doughnut') return;
                    const cfg = chart.config.options?.elements?.center;
                    if (!cfg) return;
                    const ctx = chart.ctx;
                    ctx.font = 'bold 12px Arial';
                    const ratio = ((chart.innerRadius * 2) - 20) / ctx.measureText(cfg.text).width;
                    ctx.font = `bold ${Math.min(Math.floor(30 * ratio), 70)}px Arial`;
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillStyle = cfg.color || '#000';
                    ctx.fillText(cfg.text, (chart.chartArea.left + chart.chartArea.right) / 2, (chart.chartArea.top + chart.chartArea.bottom) / 2);
                }
            });
            Chart.register(ChartDataLabels);

            // Filtered survey data — drives all charts
            const csiSurvey     = {!! json_encode($filteredSurvey) !!};
            const activeStatuses = {!! json_encode($activeStatuses) !!};
            const csiPct = v => csiSurvey.total > 0 ? Math.round(v / csiSurvey.total * 1000) / 10 : 0;

            const doughnutOpts = {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: { datalabels: { display: false }, legend: { display: false }, tooltip: { enabled: false } },
            };

            const makeSatDoughnut = (id, value, text = null) => new Chart(document.getElementById(id), {
                type: 'doughnut',
                data: {
                    datasets: [{ data: [value, 100 - value], backgroundColor: ['#c70e0e', '#ffd6fa'], borderWidth: 0 }]
                },
                options: {
                    ...doughnutOpts,
                    elements: { center: { text: text ?? value + '%', color: '#c70e0e' } }
                },
            });

            // Satisfaction doughnut — filtered %
            makeSatDoughnut('ud-sat-doughnut', {{ $filtSatPct }});

            // CSI rate bar — filtered
            document.getElementById('ud-csi-rate-bar').style.width = '{{ $filtRate }}%';

            // Bar dimming: active selections stay full, others dim
            const statusIndexMap = {
                'ดีมาก (Very Good)': 0, 'ดี (Good)': 1,
                'ปกติ (Normal)': 2, 'แย่ (Bad)': 3, 'แย่มาก (Very Bad)': 4
            };
            const activeIdxs  = activeStatuses.map(s => statusIndexMap[s] ?? -1).filter(i => i >= 0);
            const fullColors  = ['#c70e0e', '#f43f5e', '#fb7185', '#fda4af', '#fecdd3'];
            const dimColors   = ['rgba(199,14,14,0.2)', 'rgba(244,63,94,0.2)', 'rgba(251,113,133,0.2)', 'rgba(253,164,175,0.2)', 'rgba(254,205,211,0.2)'];
            const barBgColors = fullColors.map((c, i) => activeIdxs.length === 0 || activeIdxs.includes(i) ? c : dimColors[i]);
            const barLabelColors = fullColors.map((_, i) => activeIdxs.length === 0 || activeIdxs.includes(i) ? '#000' : '#ccc');

            // Satisfaction bar chart — filtered counts
            new Chart(document.getElementById('ud-sat-bar'), {
                type: 'bar',
                data: {
                    labels: ['Very Good', 'Good', 'Normal', 'Bad', 'Very Bad'],
                    datasets: [{
                        data: [csiSurvey.service_very_good, csiSurvey.service_good, csiSurvey.service_normal, csiSurvey.service_bad, csiSurvey.service_very_bad],
                        backgroundColor: barBgColors,
                        borderWidth: 0,
                        barPercentage: 0.6
                    }],
                },
                plugins: [ChartDataLabels],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        datalabels: {
                            anchor: 'end', align: 'top',
                            color: ctx => barLabelColors[ctx.dataIndex],
                            font: { size: 12 }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 12 } } },
                        y: { display: false, beginAtZero: true }
                    },
                    layout: { padding: { top: 20, bottom: 3 } }
                },
            });

            // Mini Q doughnuts — filtered counts
            makeSatDoughnut('ud-q1-chart', csiPct(csiSurvey.problem_resolved_yes), csiPct(csiSurvey.problem_resolved_yes) + '%');
            makeSatDoughnut('ud-q2-chart', csiPct(csiSurvey.arrive_as_scheduled_yes), csiPct(csiSurvey.arrive_as_scheduled_yes) + '%');
            makeSatDoughnut('ud-q3-chart', csiPct(csiSurvey.polite_and_well_mannered_yes), csiPct(csiSurvey.polite_and_well_mannered_yes) + '%');
        </script>
    @endpush
@endsection
