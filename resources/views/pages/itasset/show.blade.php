@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Detail Asset'])

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

        .software-row {
            border-bottom: 1px dashed #e9ecef;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .software-row:last-child {
            border-bottom: none;
        }
    </style>

    <div class="container-fluid py-4">
        {{-- Header --}}
        <div class="row align-items-center mb-4">
            <div class="col-lg-6 z-1">
                <h4 class="text-white mb-0">Asset Details</h4>
                <p class="text-white text-sm opacity-8 mb-0">View information for {{ $itasset->computer_name ?? 'this asset' }}</p>
            </div>
            <div class="col-lg-6 text-end z-1 mt-lg-0 mt-3">
                <a href="{{ route('itasset.index') }}" type="button" class="btn btn-secondary mb-0 me-2">
                  <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                @can('itasset update')
                    <a href="{{ route('itasset.edit', $itasset->id) }}" class="btn btn-primary mb-0"><i class="fas fa-edit me-1"></i> Edit</a>
                @endcan
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success text-white">
                <p class="mb-0">{{ $message }}</p>
            </div>
        @endif

        <div class="row">
            {{-- Left Column (Main Info) --}}
            <div class="col-lg-8">

                {{-- Asset Information --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-desktop me-2"></i>Asset Information</h5>

                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="detail-label">Device Name</div>
                                <div class="detail-value">{{ $itasset->computer_name ?? 'n/a' }}</div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="detail-label">Serial Number</div>
                                <div class="detail-value">{{ $itasset->serial_number ?? 'n/a' }}</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="detail-label">Old Device Name</div>
                                <div class="detail-value">{{ $itasset->old_device_name ?? 'n/a' }}</div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="detail-label">Type</div>
                                <div class="detail-value">{{ $itasset->type_desc ?? 'n/a' }}</div>
                                <input type="hidden" id="type" value="{{ $itasset->type_code }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="detail-label">Color</div>
                                <div class="detail-value">{{ $itasset->color ?? 'n/a' }}</div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="detail-label">Model</div>
                                <div class="detail-value">{{ $itasset->model ?? 'n/a' }}</div>
                            </div>
                        </div>

                        <div class="row d-none" id="col-tel">
                            <div class="col-md-12 mt-3">
                                <div class="detail-label">Phone Number</div>
                                <div class="detail-value bg-white border">{{ $itasset->tel ?? 'n/a' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Purchase & Warranty --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-file-invoice-dollar me-2"></i>Purchase & Warranty</h5>
                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <div class="detail-label">Fixed Asset No.</div>
                                <div class="detail-value">{{ $itasset->fixed_asset_no ?? 'n/a' }}</div>
                            </div>
                            <div class="col-md-4 mt-3">
                                <div class="detail-label">Purchase Date</div>
                                <div class="detail-value">{{ $itasset->purchase_date ?? 'n/a' }}</div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 mt-3">
                                <div class="detail-label">Warranty</div>
                                <div class="detail-value">{{ $itasset->warranty ?? 'n/a' }}</div>
                            </div>
                            <div class="col-md-4 mt-3">
                                <div class="detail-label">Expire Date</div>
                                <div class="detail-value">
                                    @php
                                        if ($itasset->purchase_date && $itasset->warranty) {
                                            $wrt = '+' . substr($itasset->warranty, 0, 1) . ' year';
                                            echo date('Y-m-d', strtotime($wrt, strtotime($itasset->purchase_date)));
                                        } else {
                                            echo 'n/a';
                                        }
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ownership --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-users me-2"></i>Ownership Information</h5>

                        <h6 class="text-sm text-primary mb-0 mt-3">Current Owner</h6>
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <div class="detail-label">User ID</div>
                                <div class="detail-value">{{ $itassetown->user ?? 'n/a' }}</div>
                            </div>
                            <div class="col-md-5 mt-2">
                                <div class="detail-label">Name</div>
                                <div class="detail-value">{{ $itassetown?->owner?->name_en ?? 'n/a' }}</div>
                            </div>
                            <div class="col-md-4 mt-2">
                                <div class="detail-label">Department</div>
                                <div class="detail-value">{{ $itassetown?->owner?->dept ?? 'n/a' }}</div>
                            </div>
                        </div>

                        <hr class="horizontal dark mt-3 mb-3">

                        <h6 class="text-sm text-secondary mb-0">Old Owner</h6>
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <div class="detail-label">User ID</div>
                                <div class="detail-value">{{ $itasset->old_user ?? 'n/a' }}</div>
                            </div>
                            <div class="col-md-5 mt-2">
                                <div class="detail-label">Name</div>
                                <div class="detail-value">{{ $itasset->old_name ?? 'n/a' }}</div>
                            </div>
                            <div class="col-md-4 mt-2">
                                <div class="detail-label">Department</div>
                                <div class="detail-value">{{ $itasset->old_department ?? 'n/a' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Software --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-layer-group me-2"></i>Software</h5>

                        <div class="row d-none d-md-flex px-2">
                            <div class="col-md-4">
                                <div class="detail-label">Software Name</div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-label">License Type</div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-label">Expire Date</div>
                            </div>
                        </div>

                        @forelse($softwares as $key => $value)
                            <div class="row software-row px-2 mt-2">
                                <div class="col-md-4 mb-2">
                                    <div class="detail-value">{{ str_replace('_', ' ', $value->software_name) ?? 'n/a' }}
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="detail-value">{{ $value->license_type ?? 'n/a' }}</div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="detail-value">{{ $value->license_expire_date ?? 'n/a' }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-3">
                                <small>No software licenses recorded.</small>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- Right Column (Image, Status, Spec) --}}
            <div class="col-lg-4">

                {{-- Asset Image --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center">
                        <h5 class="section-title text-start"><i class="fas fa-image me-2"></i>Asset Image</h5>
                        @php
                            $images = [
                                'T01' => 'macbook-pro.jpg',
                                'T02' => 'pc.jpg',
                                'T03' => 'printer-fuji.jpg',
                                'T05' => 'headset.jpg',
                                'T06' => 'telephone_sim.jpg',
                                'T07' => 'tv.png',
                                'T08' => 'copy_machine.png',
                                'T09' => 'handheld.png',
                                'T10' => 'mobile_printer.jpg',
                                'T11' => 'pos.png',
                                'T12' => 'phone_number.png',
                                'T13' => 'microphone.png',
                                'T14' => 'usb_flash_drive.png',
                                'T15' => 'video_conference.png',
                                'T16' => 'speaker.png',
                                'T17' => 'mobile_phone.png',
                                'T18' => 'tablet.png',
                            ];
                            $image = $images[$itasset->type] ?? null;
                        @endphp
                        @if ($image)
                            <img class="w-75 border-radius-lg shadow-sm mt-3" src="{{ URL::to('/') . '/img/itasset/' . $image }}" alt="itasset">
                        @else
                            <div class="p-5 bg-light border-radius-lg text-muted mt-3">
                                <i class="fas fa-laptop fa-3x mb-2"></i><br>
                                <small>No image available</small>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Status & Location --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-info-circle me-2"></i>Status & Location</h5>

                        <div class="mt-3">
                            <div class="detail-label">Status</div>
                            <div class="mt-1">
                                @if ($itasset->status == 'ACTIVE')
                                    <span class="badge badge-success badge-md px-3">{{ $itasset->status }}</span>
                                @elseif($itasset->status == 'SPARE')
                                    <span class="badge badge-info badge-md px-3">{{ $itasset->status }}</span>
                                @else
                                    <span class="badge badge-danger badge-md px-3">{{ $itasset->status }}</span>
                                @endif
                            </div>
                        </div>

                        @if ($itasset->reason_broken != '')
                            <div class="mt-3">
                                <div class="detail-label text-danger">Reason Broken</div>
                                <div class="detail-value text-danger bg-danger-soft">{{ $itasset->reason_broken }}</div>
                            </div>
                        @endif

                        <div class="mt-3">
                            <div class="detail-label">Location</div>
                            <div class="detail-value">{{ $itasset->location ?? 'n/a' }}</div>
                        </div>

                        <hr class="horizontal dark mt-4">
                        <div class="row">
                            <div class="col-6 mt-3">
                                <div class="detail-label">Create By</div>
                                <div class="detail-value bg-transparent px-0">{{ $itasset->create_by ?? 'n/a' }}</div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="detail-label">Create Date</div>
                                <div class="detail-value bg-transparent px-0">{{ $itasset->created_at ?? 'n/a' }}</div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="detail-label">Update By</div>
                                <div class="detail-value bg-transparent px-0">{{ $itasset->update_by ?? 'n/a' }}</div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="detail-label">Update Date</div>
                                <div class="detail-value bg-transparent px-0">{{ $itasset->updated_at ?? 'n/a' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Spec --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-microchip me-2"></i>Spec</h5>
                        <div class="mt-3">
                            <div class="detail-label">CPU</div>
                            <div class="detail-value">{{ $itassetspec->cpu ?? 'n/a' }}</div>
                        </div>
                        <div class="mt-3">
                            <div class="detail-label">RAM</div>
                            <div class="detail-value">{{ $itassetspec->ram ?? 'n/a' }}</div>
                        </div>
                        <div class="mt-3">
                            <div class="detail-label">Storage</div>
                            <div class="detail-value">{{ $itassetspec->storage ?? 'n/a' }}</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript" nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        $(document).ready(function() {
            function toggleTelField() {
                let val = $('#type').val();
                if (val === 'T17' || val === 'T18') {
                    $('#col-tel').removeClass('d-none');
                } else {
                    $('#col-tel').addClass('d-none');
                }
            }
            toggleTelField();
        });
    </script>
@endsection
