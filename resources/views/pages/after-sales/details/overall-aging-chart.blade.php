@extends('layouts.after-sales-user')

@section('title', 'After-Sales Dashboard')
@section('content')

    @php
        $agingTotal = array_sum([
            $agingData['0-3'],
            $agingData['4-7'],
            $agingData['8-15'],
            $agingData['16-30'],
            $agingData['over_30'],
        ]);
    @endphp

    @push('styles')
        <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
            .ud-aging-seg {
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                color: #fff;
                font-size: 14px;
                font-weight: 700;
            }

            /* Aging bar */
            .ud-aging-bar {
                display: flex;
                height: 24px;
                border-radius: 8px;
                overflow: hidden;
            }

            .ud-ag-0,
            .bg-0-3 {
                background-color: #10b981;
            }

            .ud-ag-1,
            .bg-4-7 {
                background-color: #84cc16;
            }

            .ud-ag-2,
            .bg-8-15 {
                background-color: #facc15;
            }

            .ud-ag-3,
            .bg-16-30 {
                background-color: #fb923c;
            }

            .ud-ag-4,
            .bg-over-30 {
                background-color: #ef4444;
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

        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full px-3 py-3 overflow-hidden">
            <div class="flex items-center justify-between mb-2">
                <div class="space-x-4">
                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-widest">Overall Aging</span>
                </div>
                <div class="self-stretch flex items-center bg-white px-2 rounded-lg gap-2 text-xs font-medium">
                    <div class="flex items-center gap-1">
                        <div class="w-2 h-2 rounded-full bg-0-3"></div><span class="text-gray-600">0-3 Days</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="w-2 h-2 rounded-full bg-4-7"></div><span class="text-gray-600">4-7 Days</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="w-2 h-2 rounded-full bg-8-15"></div><span class="text-gray-600">8-15 Days</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="w-2 h-2 rounded-full bg-16-30"></div><span class="text-gray-600">16-30 Days</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="w-2 h-2 rounded-full bg-over-30"></div><span class="text-gray-600">Over 30 Days</span>
                    </div>
                </div>
            </div>
            <div class="ud-aging-bar">
                <div class="ud-aging-seg ud-ag-0" id="ud-ag-0"></div>
                <div class="ud-aging-seg ud-ag-1" id="ud-ag-1"></div>
                <div class="ud-aging-seg ud-ag-2" id="ud-ag-2"></div>
                <div class="ud-aging-seg ud-ag-3" id="ud-ag-3"></div>
                <div class="ud-aging-seg ud-ag-4" id="ud-ag-4"></div>
            </div>
        </div>
        

        {{-- Tickets Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 w-full overflow-hidden">
            <div class="px-3 py-3 border-b border-gray-100">
                <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">Tickets</p>
                <p class="text-lg font-bold text-gray-800 mt-0.5">{{ number_format($tickets->total()) }} <span
                        class="text-sm font-normal text-gray-400">tickets</span></p>

                {{-- Aging Filter --}}
                <div class="flex flex-wrap gap-1.5 mt-2">
                    <a href="?"
                        class="px-2 py-1 rounded text-xs font-semibold {{ !$activeAging ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
                    @foreach (['0-3' => '0-3 Days', '4-7' => '4-7 Days', '8-15' => '8-15 Days', '16-30' => '16-30 Days', 'over_30' => 'Over 30'] as $value => $label)
                        <a href="?aging={{ $value }}"
                            class="px-2 py-1 rounded text-xs font-semibold {{ $activeAging === $value ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold">#</th>
                            <th class="px-3 py-2 text-left font-semibold">Ticket No.</th>
                            <th class="px-3 py-2 text-left font-semibold">Name</th>
                            <th class="px-3 py-2 text-left font-semibold">Status</th>
                            <th class="px-3 py-2 text-left font-semibold">Release Date</th>
                            <th class="px-3 py-2 text-left font-semibold">Date Modified</th>
                            <th class="px-3 py-2 text-left font-semibold">Aging (Days)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $statusLabels = [
                                'Closed' => 'Closed',
                                'Open' => 'Open',
                                'In_progress' => 'In Progress',
                                'Pending_Reason' => 'Pending',
                            ];
                            $statusClass = fn($s) => match ($s ?? '') {
                                'Closed' => 'bg-green-100 text-green-700',
                                'In_progress' => 'bg-blue-100 text-blue-700',
                                'Open' => 'bg-yellow-100 text-yellow-700',
                                'Pending_Reason' => 'bg-orange-100 text-orange-700',
                                default => 'bg-gray-100 text-gray-500',
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
                                <td class="px-3 py-2 text-gray-400">{{ $tickets->firstItem() + $loop->index }}</td>
                                <td class="px-3 py-2 font-medium text-gray-700">{{ $ticket->ticket_number ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $ticket->name ?? '-' }}</td>
                                <td class="px-3 py-2">
                                    <span class="px-1.5 py-0.5 rounded font-semibold {{ $statusClass($ticket->status) }}">
                                        {{ $statusLabels[$ticket->status] ?? ($ticket->status ?? '-') }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-gray-600">
                                    {{ \Carbon\Carbon::parse($ticket->release_date)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 text-gray-600">
                                    {{ \Carbon\Carbon::parse($ticket->date_modified)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2">
                                    <span
                                        class="px-1.5 py-0.5 rounded font-semibold {{ $agingClass((int) $ticket->days_diff) }}">
                                        {{ $ticket->days_diff }} days
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 py-6 text-center text-gray-400">No tickets found.</td>
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
        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
            (function () {
                const agingRaw = {!! json_encode($agingData) !!};
                const keys = ['0-3', '4-7', '8-15', '16-30', 'over_30'];
                const total = keys.reduce((s, k) => s + (agingRaw[k] || 0), 0) || 1;
                keys.forEach((key, i) => {
                    const v = agingRaw[key] || 0;
                    const pct = Math.round(v / total * 1000) / 10;
                    const el = document.getElementById('ud-ag-' + i);
                    el.style.width = pct + '%';
                    if (pct > 5) {
                        el.textContent = v;
                    }
                });
            })();
        </script>
    @endpush

@endsection
