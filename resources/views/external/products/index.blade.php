@extends('layouts.app-external')

@section('content')
<div class="mx-auto">
    <div class="bg-white rounded-lg shadow p-6 ">
        <h1 class="text-md md:text-xl font-bold text-gray-800 mb-3">Product Search</h1>

        <!-- Search Form -->
        <form method="GET" action="{{ route('customer.products.index') }}">
            {{-- <div class="text-sm text-red-600 mb-3 bg-red-50 py-3 px-2 rounded-md">
                สต๊อกที่แสดงเป็นสต๊อก ณ เวลา <strong>{{ $last_update->format('Y-m-d H:i') }}</strong> และเพื่อป้องกันความผิดพลาด<br>
                หากต้องการยืนยันคำสั่งซื้อ ขอให้ตรวจสอบยืนยันกับพนักงานขายของท่านทุกครั้ง
            </div> --}}
            <div class="flex gap-4">
                <div class="flex-1">
                    <label for="item_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Item Code
                    </label>
                    <input type="text"
                        id="item_code"
                        name="item_code"
                        value="{{ old('item_code', $item_code ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-transparent"
                        placeholder="Enter item code to search..." autofocus>
                    @error('item_code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="px-6 py-2 button-primary rounded-md">
                        Search
                    </button>
                </div>
            </div>
        </form>

        <!-- Search Results -->
        @if(isset($searched) && $searched)
        @if($product)
        <div class="bg-gray-50 rounded-lg p-3 md:p-6 mt-6">
            <div class="flex items-center gap-4 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h2 class="text-xl font-bold text-gray-800">Product Details</h2>
            </div>

            <div class="space-y-6">
                <!-- Product Information -->
                <div class="bg-white p-3 md:p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-2/5 2xl:w-1/5">
                            <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden border border-gray-200 mb-4">
                                <img src="{{ asset('/storage/img/products/' . $item_code . '.jpg') }}" alt="product image" class="w-full h-full object-contain p-2">
                            </div>
                            <a href="/customer/products/product-info/{{ $item_code }}" target="_blank" class="block w-full text-center bg-blue-900 hover:bg-gray-700 text-white font-medium py-1 px-4 rounded-lg transition duration-200">
                                Product Information
                            </a>
                        </div>

                        <div class="w-full md:w-3/5 2xl:w-4/5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2 border-b pb-2">
                                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Item Code</label>
                                <p class="text-lg font-bold text-gray-800">{{ $item_code }}</p>

                                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mt-3">Item Description</label>
                                <p class="text-gray-600">{{ $product['productInformations'][0]['ArticleName'] ?? '-' }}</p>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-md">
                                <label class="block text-xs font-medium text-gray-500">Base Price</label>
                                <p class="text-xl font-bold text-green-600">{{ number_format($product['productInformations'][0]['TotalPrice'], 0) }} <span class="text-md font-normal">/ {{ $product['productInformations'][0]['QuantityUnit'] }}</span></p>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-md">
                                @php
                                    $storloc = collect($product['productInformations'][0]['AvailablePackagesStorloc'] ?? [])->firstWhere('Storagelocation', 'TH02');
                                    $stock = $storloc['Atpquantity'] ?? 0;
                                @endphp
                                <label class="block text-xs font-medium text-gray-500">Stock Quantity</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 mt-1 rounded-full text-sm font-semibold {{ $stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ number_format($stock, 0) }} {{ $product['productInformations'][0]['QuantityUnit'] }}
                                </span>
                            </div>

                            <div class="border-l-4 border-blue-200 pl-3">
                                <label class="block text-xs font-medium text-gray-500">Inventory Status</label>
                                <p @class([
                                    'inline-flex items-center px-2.5 py-0.5 rounded-md text-white font-semibold mt-1 bg-green-500' => $product_external['mrp'] ?? null,
                                    'text-md text-gray-500' => empty($product_external['mrp'] ?? null)])>
                                    {{ $product_external['mrp'] ?? '-' }}
                                </p>
                            </div>

                            <div class="border-l-4 border-blue-200 pl-3">
                                <label class="block text-xs font-medium text-gray-500">Item Status</label>
                                <span @class([
                                    'inline-flex items-center px-2.5 py-0.5 rounded-md text-white font-semibold mt-1',
                                    'bg-green-500' => (($product_external['item_status'] ?? null) === 'Active'),
                                    'bg-red-500' => !empty($product_external['item_status'] ?? null) && ($product_external['item_status'] ?? null) !== 'Active',
                                    'bg-gray-500' => empty($product_external['item_status'] ?? null),
                                ])>
                                    {{ $product_external['item_status'] ?? 'N/A' }}
                                </span>
                            </div>

                            <div class="border-l-4 border-orange-200 pl-3">
                                <label class="block text-xs font-medium text-gray-500">MOQ</label>
                                <p class="font-semibold text-gray-800">{{ number_format($product_internal->NSU_PURC_MOQ ?? 0, 0) }}</p>
                            </div>

                            <div class="border-l-4 border-orange-200 pl-3">
                                <label class="block text-xs font-medium text-gray-500">Repl Time</label>
                                <p class="font-semibold text-gray-800">{{ $product_internal->NSU_SUPP_REPL_TIME ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-6">
            <div class="flex">
                <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-yellow-800">Product Not Found</h3>
                    <p class="text-sm text-yellow-700 mt-1">
                        No product found with item code: <strong>{{ $item_code }}</strong>
                    </p>
                </div>
            </div>
        </div>
        @endif
        @endif

    </div>
</div>
@endsection

@section('scripts')
<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    document.getElementById('item_code').addEventListener('input', function(e) {
        let input = e.target.value.replace(/\D/g, '');
        let formattedInput = '';

        if (input.length > 0) {
            formattedInput = input.substring(0, 3);
            if (input.length > 3) {
                formattedInput += '.' + input.substring(3, 5);
            }
            if (input.length > 5) {
                formattedInput += '.' + input.substring(5, 8);
            }
        }

        e.target.value = formattedInput;
    });
</script>
@endsection
