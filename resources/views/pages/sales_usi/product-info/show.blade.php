@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'SALES USI'])

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-between">
                            <div>
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 h3">SALES USI</h6>
                                </div>
                                @php
                                    $yesterday = date('d/m/Y', strtotime('-1 day'));
                                @endphp
                                <p class="text-uppercase text-secondary text-xxs font-weight-bolder">LAST UPDATE: {{ $yesterday }} 20:00</p>
                            </div>
                            <div>
                                <a href="{{ url()->previous() }}" id="closeButton" type="button" class="btn btn-secondary d-flex items-center">
                                    <div>CLOSE</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-3">
                                <img id="item_preview" src="{{ $imgPath }}" class="img-thumbnail mb-3">
                            </div>
                            <div class="col-md-9">
                                {{-- Product Info --}}
                                <div class="card bg-gray-200 p-3 mb-3">
                                    <div>
                                        <label class="m-0">Item Code:</label>
                                        <span>{{ request()->item_code }}</span>
                                    </div>
                                    <div class="mt-1">
                                        <label class="m-0">Item Desc:</label>
                                        <span>{{ $productDetail ? $productDetail->item_desc : 'N/A' }}</span>
                                    </div>
                                    <div class="mt-1">
                                        <label class="m-0">Item Brand:</label>
                                        <span>{{ $productDetail && $productDetail->zmm_matzert ? $productDetail->zmm_matzert['certificate'] : 'N/A' }}</span>
                                    </div>
                                    <div class="mt-1">
                                        <label class="m-0">Item Status:</label>
                                        <span class="text-xs badge {{ $productDetail ? ($productDetail->item_status === 'Active' ? 'bg-success' : 'bg-danger') : ''}} m-0 py-1">{{ $productDetail ? $productDetail->item_status : '-' }}</span>
                                    </div>
                                    <div class="mt-1">
                                        <label class="m-0">MRP:</label>
                                        <span class="text-xs {{ $productDetail && $productDetail->mrp ? 'badge bg-success' : '' }} m-0 py-1">{{ $productDetail && $productDetail->mrp ? $productDetail->mrp : 'N/A' }}</span>
                                    </div>
                                    <div class="mt-1">
                                        <label class="m-0">Storage Indicator:</label>
                                        <span class="text-xs {{ $productDetail ? 'badge bg-success' : '' }} m-0 py-1">{{ $productDetail ? $productDetail->inventory_code : 'N/A' }}</span>
                                    </div>
                                </div>
                                {{-- Catalogues --}}
                                <div class="mb-3">
                                    <label class="fw-bold text-lg">Catalogues</label>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <tbody class="text-sm">
                                                @if (!($productInfo->catalogueFiles)->isEmpty())
                                                    @foreach ($productInfo->catalogueFiles as $catalogue)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ $catalogue->path }}" target="_blank" id="downloadCatalog" class="download-link">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                                                </svg>
                                                                <u>{{ $catalogue->file_name }}</u>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td class="text-muted">No catalogues found.</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Manuals --}}
                                <div class="mb-3">
                                    <label class="fw-bold text-lg">Manuals</label>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <tbody class="text-sm">
                                                @if (!($productInfo->manualFiles)->isEmpty())
                                                    @foreach ($productInfo->manualFiles as $manual)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ $manual->path }}" target="_blank" id="downloadCatalog" class="download-link">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                                                </svg>
                                                                <u>{{ $manual->file_name }}</u>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td class="text-muted">No manuals found.</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Spec Sheets --}}
                                <div class="mb-3">
                                    <label class="fw-bold text-lg">Spec Sheets</label>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <tbody class="text-sm">
                                                @if (!($productInfo->specsheetFiles)->isEmpty())
                                                    @foreach ($productInfo->specsheetFiles as $specsheet)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ $specsheet->path }}" target="_blank" id="downloadCatalog" class="download-link">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                                                </svg>
                                                                <u>{{ $specsheet->file_name }}</u>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td class="text-muted">No spec sheets found.</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Spare Parts --}}
                                <div>
                                    <label class="fw-bold text-lg">Spare Parts</label>
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0">
                                            <thead class="table-light text-xs">
                                                <tr>
                                                    <th class="w-20 px-2">Item Code</th>
                                                    <th class="px-2">Description</th>
                                                </tr>
                                            </thead>
                                            <tbody class="spare_parts">
                                                @if (!$spareParts->isEmpty())
                                                    @foreach ($spareParts as $sparePart)
                                                    <tr>
                                                        <td class="font-monospace">{{ $sparePart->component }}</td>
                                                        <td>{{ $sparePart->spareparts->kurztext ?? 'N/A' }}</td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="2" class="text-muted text-sm">No spare parts found.</td>
                                                </tr>
                                                @endif 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        document.getElementById('closeButton').addEventListener('click', function() {
            if (window.opener || window.history.length === 1) {
                window.close();
            } else {
                window.location.href = "{{ url()->previous() }}";
            }
        });
    </script>
@endsection
