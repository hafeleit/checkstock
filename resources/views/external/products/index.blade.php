@extends('layouts.app-external')

@section('content')
<div class="mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-md md:text-xl font-bold text-gray-800 mb-3">Product Search</h1>

        <!-- Search Form -->
        <form method="GET" action="{{ route('customer.products.index') }}">
            <div class="text-sm text-red-600 mb-3 bg-red-50 py-3 px-2 rounded-md">
                สต๊อกที่แสดงเป็นสต๊อก ณ เวลา <strong>{{ $last_update->format('Y-m-d H:i') }}</strong> และเพื่อป้องกันความผิดพลาด<br>
                หากต้องการยืนยันคำสั่งซื้อ ขอให้ตรวจสอบยืนยันกับพนักงานขายของท่านทุกครั้ง
            </div>
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
        <div class="bg-gray-50 rounded-lg p-6 mt-6">
            <div class="flex items-center gap-4 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h2 class="text-xl font-bold text-gray-800">Product Details</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Product Information -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Item Code</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $product->Material }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Item Description</label>
                        <p class="text-gray-700">{{ $product->kurztext }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Base Price</label>
                        <p class="text-xl font-bold text-green-600">฿{{ number_format($product->Amount, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Stock Quantity</label>
                        <p class="text-gray-800">
                            <span class="inline-flex items-center px-2.5 py-0.5 mt-2 rounded-full text-sm font-medium {{ $product->unrestricted > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ number_format($product->unrestricted, 0) }} units
                            </span>
                        </p>
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
<script>
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
