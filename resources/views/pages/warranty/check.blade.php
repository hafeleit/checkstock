@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'ตรวจสอบการรับประกัน'])
<link href="{{ URL::to('/') }}/assets/css/warranty.css" rel="stylesheet">

<div class="container-fluid py-4">

    {{-- Search --}}
    <div class="row justify-content-center mb-4">
        <div class="col-xl-8 col-lg-10">
            <div class="card wc-search-card p-4">
                <h5 class="font-weight-bold mb-1">ตรวจสอบสถานะการรับประกัน</h5>
                <p class="text-sm text-muted mb-3">ค้นหาด้วยเบอร์โทร, Serial no., หมายเลขคำสั่งซื้อ หรือชื่อ</p>
                <form method="GET" action="{{ route('warranty.check') }}" autocomplete="off">
                    <div class="input-group">
                        <input type="text" name="search" class="wc-search-input" placeholder="เช่น 0812345678 / SN12345 / ชื่อ-นามสกุล..." value="{{ request('search') }}" autocomplete="off" spellcheck="false">
                        <button type="submit" class="btn bg-gradient-danger wc-search-btn">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            ค้นหา
                        </button>
                    </div>
                    <p class="wc-search-hint">ค้นหาได้จาก: เบอร์โทรศัพท์ / Serial no. / หมายเลขคำสั่งซื้อ / ชื่อ-นามสกุล</p>
                </form>
            </div>
        </div>
    </div>

    {{-- Results --}}
    @if ($searched)
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">

            @if ($results && $results->count() > 0)
                <p class="text-sm text-muted mb-3">
                    พบ <strong>{{ $results->count() }}</strong> รายการ สำหรับ "<strong>{{ request('search') }}</strong>"
                </p>

                @foreach ($results as $item)
                @php
                    $images = collect([
                        $item->file_name,
                        $item->file_name2,
                        $item->file_name3,
                        $item->file_name4,
                        $item->file_name5,
                    ])->filter()->map(function ($f) {
                        $path = "/storage/img/warranty/{$f}";
                        return file_exists(public_path($path)) ? $path : null;
                    })->filter()->values();
                @endphp

                <div class="wc-result-card">
                    <div class="wc-result-header">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <p class="wc-result-header-title">{{ $item->name }}</p>
                        <span class="wc-result-header-date">{{ $item->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="wc-result-body">
                        <div class="wc-info-grid">
                            <div class="wc-info-item">
                                <span class="wc-info-label">เบอร์โทร</span>
                                <span class="wc-info-value">{{ $item->tel }}</span>
                            </div>
                            <div class="wc-info-item">
                                <span class="wc-info-label">อีเมล</span>
                                <span class="wc-info-value">{{ $item->email ?: '-' }}</span>
                            </div>
                            <div class="wc-info-item">
                                <span class="wc-info-label">Article no.</span>
                                <span class="wc-info-value">{{ $item->article_no }}</span>
                            </div>
                            <div class="wc-info-item">
                                <span class="wc-info-label">Serial no.</span>
                                <span class="wc-info-value">{{ $item->serial_no ?: '-' }}</span>
                            </div>
                            <div class="wc-info-item">
                                <span class="wc-info-label">ช่องทางการสั่งซื้อ</span>
                                <span class="wc-info-value">{{ $item->order_channel }}</span>
                            </div>
                            <div class="wc-info-item">
                                <span class="wc-info-label">หมายเลขคำสั่งซื้อ</span>
                                <span class="wc-info-value">{{ $item->order_number }}</span>
                            </div>
                            <div class="wc-info-item">
                                <span class="wc-info-label">ที่อยู่จัดส่ง</span>
                                <span class="wc-info-value">{{ $item->addr }}</span>
                            </div>
                        </div>

                        @if ($images->count() > 0)
                        <hr class="wc-divider">
                        <p class="wc-images-title">เอกสารแนบ ({{ $images->count() }} ไฟล์)</p>
                        <div class="wc-thumb-grid">
                            @foreach ($images as $idx => $src)
                            <img src="{{ $src }}" class="wc-thumb" data-group="{{ $loop->parent->index }}" data-index="{{ $idx }}" alt="เอกสารแนบ {{ $idx + 1 }}">
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach

            @else
                <div class="card wc-search-card">
                    <div class="wc-empty">
                        <div class="wc-empty-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </div>
                        <p class="wc-empty-title">ไม่พบข้อมูล</p>
                        <p class="text-sm mb-0">ไม่พบรายการที่ตรงกับ "{{ request('search') }}"</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
    @endif
</div>

{{-- Lightbox --}}
<div id="lb" class="lb-overlay">
    <button class="lb-close" id="lbClose">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <div class="lb-img-wrap">
        <button class="lb-nav lb-prev" id="lbPrev">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <img id="lbImg" class="lb-img" src="" alt="">
        <button class="lb-nav lb-next" id="lbNext">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
    </div>
    <div class="lb-toolbar">
        <span class="lb-counter" id="lbCounter"></span>
        <button class="lb-btn" id="lbDownload">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            บันทึกภาพ
        </button>
    </div>
</div>

@endsection

@push('js')
<script src="{{ asset('assets/js/warranty-check.js') }}" nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>
@endpush
