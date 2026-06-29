@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Warranty Information'])
<link href="{{ URL::to('/') }}/assets/css/warranty.css" rel="stylesheet">

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div>
                        <h6 class="mb-0 font-weight-bold">Edit Warranty Information</h6>
                        <p class="text-xs text-muted mb-0">Registered on {{ $warranty->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <a href="{{ route('warranty.list') }}" class="btn btn-sm btn-outline-secondary">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                        Back
                    </a>
                </div>
                <div class="card-body pt-3">

                    @if($errors->any())
                    <div class="alert-modern alert-warning-modern mb-4">
                        <div class="alert-modern-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                        </div>
                        <div class="alert-modern-body">
                            <p class="alert-modern-title">Please correct the following errors</p>
                            <ul class="alert-modern-list mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('warranty.update', $warranty->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="wl-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="wl-input" value="{{ old('name', $warranty->name) }}" required autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="wl-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="tel" class="wl-input" value="{{ old('tel', $warranty->tel) }}" required autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="wl-label">Email</label>
                                <input type="email" name="email" class="wl-input" value="{{ old('email', $warranty->email) }}" autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="wl-label">Article No. <span class="text-danger">*</span></label>
                                <input type="text" name="article_no" class="wl-input" value="{{ old('article_no', $warranty->article_no) }}" required autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="wl-label">Serial No.</label>
                                <input type="text" name="serial_no" class="wl-input" value="{{ old('serial_no', $warranty->serial_no) }}" autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="wl-label">Order Number <span class="text-danger">*</span></label>
                                <input type="text" name="order_number" class="wl-input" value="{{ old('order_number', $warranty->order_number) }}" required autocomplete="off">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="wl-label">Order Channel <span class="text-danger">*</span></label>
                                <select name="order_channel" id="edit_order_channel" class="wl-input" required>
                                    <option value="" disabled {{ old('order_channel', $warranty->order_channel) === '' ? 'selected' : '' }}>กรุณาเลือกช่องทางการสั่งซื้อ (Please select)</option>
                                    @foreach([
                                        'showroom'            => 'โชว์รูม (Showroom)',
                                        'shopee'              => 'ช้อปปี้ (Shopee Mall)',
                                        'lazada'              => 'ลาซาด้า (Lazada Mall)',
                                        'website-hafele-home' => 'เว็บไซต์บริษัท (Website: Hafele Home)',
                                        'line-hafele-home'    => 'LINE Official (LINE: Hafele Home)',
                                        'modern-trade'        => 'ห้างโมเดิร์นเทรด (Modern Trade)',
                                        'dealer'              => 'ร้านค้าวัสดุ / ร้านตัวแทนจำหน่าย (Dealer)',
                                        'project-contractor'  => 'เซลล์โครงการ / งานโครงการ (Project) / ผู้รับเหมา (Contractor)',
                                        'other'               => 'อื่นๆ (Other)',
                                    ] as $val => $label)
                                    <option value="{{ $label }}" {{ old('order_channel', $warranty->order_channel) === $label ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3 {{ old('order_channel', $warranty->order_channel) === 'อื่นๆ (Other)' ? '' : 'wl-hidden' }}" id="edit_other_channel_wrap">
                                <label class="wl-label">Other Channel</label>
                                <input type="text" name="other_channel" id="edit_other_channel" class="wl-input" value="{{ old('other_channel', $warranty->other_channel) }}" placeholder="Please specify..." autocomplete="off">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="wl-label">Address <span class="text-danger">*</span></label>
                                <textarea name="addr" class="wl-input" rows="3" required>{{ old('addr', $warranty->addr) }}</textarea>
                            </div>
                        </div>

                        @php
                            $images = collect([
                                $warranty->file_name,
                                $warranty->file_name2,
                                $warranty->file_name3,
                                $warranty->file_name4,
                                $warranty->file_name5,
                            ])->filter()->map(function ($f) {
                                $path = "/storage/img/warranty/{$f}";
                                return file_exists(public_path($path)) ? $path : null;
                            })->filter()->values();
                        @endphp

                        @if($images->count() > 0)
                        {{-- <hr class="wc-divider mt-4"> --}}
                        <p class="wc-images-title">Attached Documents ({{ $images->count() }} file{{ $images->count() > 1 ? 's' : '' }})</p>
                        <div class="wc-thumb-grid">
                            @foreach($images as $idx => $src)
                            <img src="{{ $src }}" class="wc-thumb" data-group="0" data-index="{{ $idx }}" alt="Attachment {{ $idx + 1 }}">
                            @endforeach
                        </div>
                        @endif
                        
                        <div class="d-flex gap-2 justify-content-end mt-1">
                            <a href="{{ route('warranty.list') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
                            <button type="submit" class="btn btn-eu-primary btn-sm text-white">
                                <i class="fas fa-check fa-xs"></i> Update Warranty
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
            Download
        </button>
    </div>
</div>

@endsection

@push('js')
<script src="{{ asset('assets/js/warranty-check.js') }}" nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>
<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
(function () {
    const sel = document.getElementById('edit_order_channel');
    const wrap = document.getElementById('edit_other_channel_wrap');
    const input = document.getElementById('edit_other_channel');
    sel.addEventListener('change', function () {
        const isOther = this.value === 'อื่นๆ (Other)';
        wrap.classList.toggle('wl-hidden', !isOther);
        input.disabled = !isOther;
        if (!isOther) input.value = '';
    });
})();
</script>
@endpush
