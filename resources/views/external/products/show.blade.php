@extends('layouts.app-external')

@section('content')
    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .bg-dark {
            background-color: #344767;
        }
    </style>

    <div class="mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-md md:text-xl font-bold text-gray-800">Products Information</h1>
                </div>
                <div>
                    <a href="#" id="close-button" class="px-4 py-3 bg-gray-500 hover:bg-gray-700 text-white rounded-md transition duration-200">
                        CLOSE
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <div class="md:col-span-4 2xl:col-span-3">
                    <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden border border-gray-200">
                        @if ($imgPath && !empty($imgPath))
                            <img src="{{ $imgPath }}" alt="product image" class="w-full h-full object-contain p-2">
                        @else
                            <div class="img-thumbnail mb-3">
                                <div class="text-center flex flex-col justify-center items-center h-full p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-image text-gray-500" viewBox="0 0 16 16">
                                        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                        <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
                                    </svg>
                                    <p class="text-gray-500 m-0">No Image</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="md:col-span-8 2xl:col-span-9">
                    {{-- Product Info --}}
                    <div class="space-y-2 bg-gray-100 p-4 rounded-xl">
                        <div class="flex items-center gap-2">
                            <label class="block text-sm font-semibold text-gray-700 tracking-wider">Item Code: </label>
                            <p class="text-md text-gray-500">{{ $productDetail->material }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="block text-sm font-semibold text-gray-700 tracking-wider">Item Description:
                            </label>
                            <p class="text-md text-gray-500">{{ $productDetail ? $productDetail->item_desc : 'N/A' }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="block text-sm font-semibold text-gray-700 tracking-wider">Item Brand: </label>
                            <p class="text-md text-gray-500">
                                {{ $productDetail && $productDetail->zmm_matzert ? $productDetail->zmm_matzert['certificate'] : 'N/A' }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="block text-sm font-semibold text-gray-700 tracking-wider">Item Status: </label>
                            <p @class([
                                'inline-flex items-center px-2.5 py-0.5 rounded-md text-white text-xs font-semibold mt-1',
                                'bg-green-600' => $productDetail->item_status === 'Active',
                                'bg-red-600' => $productDetail->item_status !== 'Active',
                                'bg-gray-600' => empty($productDetail->item_status),
                            ])>
                                {{ $productDetail ? $productDetail->item_status : 'N/A' }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="block text-sm font-semibold text-gray-700 tracking-wider">Material Requirements Planning: </label>
                            <p @class([
                                'inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold mt-1 bg-green-600 text-white' => $productDetail->mrp,
                                'text-md text-gray-500' => empty($productDetail->mrp),
                            ])>
                                @php
                                    $productDetail->mrp = 'ZD-None Stock Item';
                                @endphp
                                {{ $productDetail && $productDetail->mrp ? $productDetail->mrp : 'N/A' }}
                            </p>
                        </div>
                    </div>

                    {{-- Files --}}
                    <div>
                        {{-- Catalogues --}}
                        <div class="mt-4">
                            <h2 class="text-lg font-bold text-gray-700 mb-2">Catalogues</h2>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse bg-white">
                                    @if ($catalogueFiles && !$catalogueFiles->isEmpty())
                                        <thead class="bg-dark text-white text-sm text-left">
                                            <tr>
                                                <th class="p-2 w-3/4">File Name</th>
                                                <th class="p-2 w-1/4 whitespace-nowrap text-center">Creation Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            @foreach ($catalogueFiles as $catalogue)
                                                <tr class="hover:bg-gray-100 transition-colors">
                                                    <td class="px-2 py-1">
                                                        <a href="{{ $catalogue->path }}" target="_blank" id="downloadCatalog" class="download-link flex items-center gap-2 underline text-gray-600 hover:text-red-500 transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                                            </svg>
                                                            <u class="truncate text-sm">{{ $catalogue->file_name }}</u>
                                                        </a>
                                                    </td>
                                                    <td class="px-2 py-1 text-gray-600 whitespace-nowrap text-center">{{ $catalogue->created_at ? $catalogue->created_at->format('d-m-Y') : 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <tr>
                                            <td colspan="2" class="text-gray-500 text-sm">No catalogues found.</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                        {{-- Manuals --}}
                        <div class="mt-4">
                            <h2 class="text-lg font-bold text-gray-700 mb-2">Manuals</h2>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse bg-white">
                                    @if ($manualFiles && !$manualFiles->isEmpty())
                                        <thead class="bg-dark text-white text-sm text-left">
                                            <tr>
                                                <th class="p-2 w-3/4">File Name</th>
                                                <th class="p-2 w-1/4 whitespace-nowrap text-center">Creation Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            @foreach ($manualFiles as $manual)
                                                <tr class="hover:bg-gray-100 transition-colors">
                                                    <td class="px-2 py-1">
                                                        <a href="{{ $manual->path }}" target="_blank" id="downloadManual" class="download-link flex items-center gap-2 underline text-gray-600 hover:text-red-500 transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                                            </svg>
                                                            <u class="truncate text-sm">{{ $manual->file_name }}</u>
                                                        </a>
                                                    </td>
                                                    <td class="px-2 py-1 text-gray-600 whitespace-nowrap text-center">{{ $manual->created_at ? $manual->created_at->format('d-m-Y') : 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <tr>
                                            <td colspan="2" class="text-gray-500 text-sm">No manuals found.</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        {{-- Spare Parts --}}
                        <div class="mt-4">
                            <h2 class="text-lg font-bold text-gray-700 mb-2">Spare Parts</h2>
                            <table class="table-auto w-full border-collapse overflow-auto">
                                <thead class="bg-gray-200 text-sm text-left">
                                    <tr>
                                        <th class="p-2 w-1/3">Item Code</th>
                                        <th class="p-2">Description</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm text-gray-600">
                                    @if ($spareParts && !$spareParts->isEmpty())
                                        @foreach ($spareParts as $spare)
                                            <tr class="hover:bg-gray-100 transition-colors duration-200">
                                                <td class="px-2 py-1 font-mono">{{ $spare->component }}</td>
                                                <td>{{ $spare->spareparts->kurztext ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2" class="text-gray-500 text-sm">No spare parts found.</td>
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

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        document.getElementById('close-button').addEventListener('click', function() {
            window.close();
        });
    </script>
@endsection
