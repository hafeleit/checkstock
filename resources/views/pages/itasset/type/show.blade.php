@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Asset Type Details'])

    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .z-1 {
            z-index: 1;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #344767;
            border-bottom: 2px solid #f0f2f5;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }

        .detail-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            color: #8392ab;
            margin-bottom: 0.2rem;
        }

        .detail-value {
            font-size: 0.875rem;
            font-weight: 600;
            color: #344767;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            min-height: 38px;
            display: flex;
            align-items: center;
        }
    </style>

    <div class="container-fluid py-4">
        {{-- Header --}}
        <div class="row align-items-center mb-4">
            <div class="col-lg-6 z-1">
                <h4 class="text-white mb-0">Asset Type Details</h4>
                <p class="text-white text-sm opacity-8 mb-0">View information for this asset type</p>
            </div>
            <div class="col-lg-6 text-end z-1 mt-lg-0 mt-3">
                <a href="{{ route('asset_types.index') }}" class="btn btn-secondary mb-0 me-2">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                @can('itasset update')
                    <a href="{{ route('asset_types.edit', $assetType->id) }}" class="btn btn-primary mb-0">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                @endcan
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-tag me-2 text-primary"></i>Asset Type Information</h5>

                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="detail-label">Type Code</div>
                                <div class="detail-value">{{ $assetType->type_code ?? 'n/a' }}</div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="detail-label">Status</div>
                                <div class="detail-value bg-transparent px-0">
                                    @if (isset($assetType->type_status) && strtoupper($assetType->type_status) == 'ACTIVE')
                                        <span class="badge badge-sm bg-success px-3">{{ $assetType->type_status }}</span>
                                    @elseif(isset($assetType->type_status) && strtoupper($assetType->type_status) == 'INACTIVE')
                                        <span class="badge badge-sm bg-danger px-3">{{ $assetType->type_status }}</span>
                                    @else
                                        <span class="badge badge-sm bg-secondary px-3">{{ $assetType->type_status ?? 'n/a' }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mt-3">
                                <div class="detail-label">Asset Type Description</div>
                                <div class="detail-value">{{ $assetType->type_desc ?? 'n/a' }}</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
