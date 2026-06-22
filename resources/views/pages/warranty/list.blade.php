@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Warranty Registration'])
<link href="{{ URL::to('/') }}/assets/css/warranty.css" rel="stylesheet">

<div class="container-fluid py-4">

    {{-- Search card --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card wc-search-card p-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <h5 class="font-weight-bold mb-1">Warranty Registration List</h5>
                        <p class="text-sm text-muted mb-0">Search and filter warranty registration data</p>
                    </div>
                    @can('warranty export')
                    <a href="{{ route('warranty.export', request()->query()) }}" class="wl-export-btn ms-3 text-decoration-none" target="_blank" rel="noopener">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Export Excel
                    </a>
                    @endcan
                </div>
                <form method="GET" action="{{ route('warranty.list') }}" autocomplete="off">
                    <div class="row g-2">
                        <div class="col-md-3 col-sm-6">
                            <label class="wl-label">Name</label>
                            <input type="text" name="name" class="wl-input" placeholder="Search name..." value="{{ request('name') }}" autocomplete="off" spellcheck="false">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label class="wl-label">Phone Number</label>
                            <input type="text" name="tel" class="wl-input" placeholder="e.g., 0812345678" value="{{ request('tel') }}" autocomplete="off" spellcheck="false">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label class="wl-label">Serial No.</label>
                            <input type="text" name="serial_no" class="wl-input" placeholder="e.g., SN12345" value="{{ request('serial_no') }}" autocomplete="off" spellcheck="false">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label class="wl-label">Order Number</label>
                            <input type="text" name="order_number" class="wl-input" placeholder="e.g., ORD12345" value="{{ request('order_number') }}" autocomplete="off" spellcheck="false">
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-sm bg-primary text-white d-flex align-items-center gap-1">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            Search
                        </button>
                        <a href="{{ route('warranty.list') }}" class="wl-reset-btn text-decoration-none">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('updated'))
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert-modern alert-success-modern mb-0 d-flex align-items-center gap-2">
                <div class="alert-modern-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="alert-modern-body">
                    <p class="alert-modern-title mb-0">{{ session('updated') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-2">
                    <p class="mb-0 font-weight-bold text-sm">
                        Total <strong>{{ $warranties->total() }}</strong> records
                        @if(request()->anyFilled(['name', 'tel', 'serial_no', 'order_number']))
                        <span class="text-muted ms-1">(Filtered)</span>
                        @endif
                    </p>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 px-2 ps-3">#</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 px-2">Name</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 px-2">Phone Number</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 px-2">Email</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 px-2">Article No.</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 px-2">Serial No.</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 px-2">Purchase Channel</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 px-2">Order No.</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 px-2">Address</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 px-2">Date</th>
                                    @can('warranty edit')
                                    <th class="text-secondary opacity-7"></th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($warranties as $item)
                                <tr>
                                    <td class="ps-3">
                                        <p class="text-xs font-weight-bold mb-0 text-secondary">{{ $warranties->firstItem() + $loop->index }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->name }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0">{{ $item->tel }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0 text-secondary">{{ $item->email ?: '-' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0">{{ $item->article_no }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0">{{ $item->serial_no ?: '-' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0 wl-td-channel" title="{{ $item->order_channel }}">{{ $item->order_channel }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0">{{ $item->order_number }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0 wl-td-addr" title="{{ $item->addr }}">{{ $item->addr }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0 text-nowrap">{{ $item->created_at->format('d/m/Y') }}</p>
                                    </td>
                                    @can('warranty edit')
                                    <td class="pe-3">
                                        <a href="{{ route('warranty.edit', $item->id) }}" class="wl-edit-btn" title="Edit Warranty">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                    </td>
                                    @endcan
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center py-5">
                                        <div class="wc-empty">
                                            <div class="wc-empty-icon mx-auto">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                            </div>
                                            <p class="wc-empty-title">Data not found</p>
                                            <p class="text-sm mb-0 text-muted">Try adjusting your search criteria</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($warranties->hasPages())
                <div class="card-footer pt-3 pb-3">
                    {{ $warranties->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
