@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Warranty Activity Log'])
<link href="{{ URL::to('/') }}/assets/css/warranty.css" rel="stylesheet">

<div class="container-fluid py-4">

    {{-- Filter card --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card wc-search-card p-4">
                <div class="mb-3">
                    <h5 class="font-weight-bold mb-1">Warranty Activity Log</h5>
                    <p class="text-sm text-muted mb-0">Track all updates and exports on warranty records</p>
                </div>
                <form method="GET" action="{{ route('warranty.log') }}" autocomplete="off">
                    <div class="row g-2">
                        <div class="col-md-3 col-sm-6">
                            <label class="wl-label">Action Type</label>
                            <select name="action_type" class="wl-input">
                                <option value="">All</option>
                                <option value="updated"  {{ request('action_type') == 'updated'  ? 'selected' : '' }}>Updated</option>
                                <option value="exported" {{ request('action_type') == 'exported' ? 'selected' : '' }}>Exported</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label class="wl-label">Date From</label>
                            <input type="date" name="date_from" class="wl-input" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label class="wl-label">Date To</label>
                            <input type="date" name="date_to" class="wl-input" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn bg-primary btn-sm text-white d-flex align-items-center gap-1">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            Search
                        </button>
                        <a href="{{ route('warranty.log') }}" class="wl-reset-btn text-decoration-none">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2 ps-3">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2">Timestamp</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2">Action</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2">Warranty</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2">Performed By</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2">Details</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2">IP Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                <tr>
                                    <td class="ps-3">
                                        <p class="text-xs font-weight-bold mb-0 text-secondary">{{ $logs->firstItem() + $loop->index }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0 text-nowrap">{{ $log->created_at->format('d/m/Y H:i:s') }}</p>
                                    </td>
                                    <td>
                                        @if($log->action_type === 'updated')
                                        <span class="wl-badge wl-badge-update">Updated</span>
                                        @else
                                        <span class="wl-badge wl-badge-export">Exported</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->warranty)
                                        <p class="text-xs font-weight-bold mb-0">{{ $log->warranty->name }}</p>
                                        <p class="text-xs text-secondary mb-0">#{{ $log->warranty_id }}</p>
                                        @else
                                        <p class="text-xs text-secondary mb-0">—</p>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $log->performer->username ?? '-' }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $log->performer->email ?? '' }}</p>
                                    </td>
                                    <td>
                                        @if($log->action_type === 'updated')
                                            @php $changed = $log->changed_fields; @endphp
                                            @if(count($changed))
                                            <div class="wl-diff">
                                                @foreach($changed as $field => $val)
                                                <div class="wl-diff-row">
                                                    <span class="wl-diff-field">{{ $field }}</span>
                                                    <span class="wl-diff-old">{{ $val['old'] ?: '—' }}</span>
                                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                                    <span class="wl-diff-new">{{ $val['new'] ?: '—' }}</span>
                                                </div>
                                                @endforeach
                                            </div>
                                            @else
                                            <p class="text-xs text-secondary mb-0">No changes detected</p>
                                            @endif
                                        @else
                                            <div class="wl-export-detail">
                                                <span class="wl-diff-field">Records:</span>
                                                <span class="text-xs">{{ number_format($log->record_count) }}</span>
                                            </div>
                                            @if($log->file_name)
                                            <div class="wl-export-detail mt-1">
                                                <span class="wl-diff-field">File:</span>
                                                <span class="text-xs">{{ $log->file_name }}</span>
                                            </div>
                                            @endif
                                            @if($log->new_values)
                                            <div class="wl-export-detail mt-1">
                                                <span class="wl-diff-field">Filters:</span>
                                                <span class="text-xs">{{ implode(', ', array_map(fn($k,$v) => "$k=$v", array_keys($log->new_values), $log->new_values)) }}</span>
                                            </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0 text-secondary">{{ $log->ip_address ?? '—' }}</p>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="wc-empty">
                                            <div class="wc-empty-icon mx-auto">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                            </div>
                                            <p class="wc-empty-title">No activity yet</p>
                                            <p class="text-sm mb-0 text-muted">Logs will appear here when warranties are updated or exported</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($logs->hasPages())
                <div class="card-footer pt-3 pb-3">
                    {{ $logs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
