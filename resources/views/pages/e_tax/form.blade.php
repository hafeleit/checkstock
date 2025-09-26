@extends('layouts.guestform')
@section('title', 'E-Tax Invoice Form')
<style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
    .required::after {
        content: " *";
        color: red;
    }

    .indent-18 {
        text-indent: 18px;
    }
</style>
@section('content')
    <div class="container-fluid py-4">
        <header class="text-center mb-8">
            <h1 class="text-lg sm:text-3xl font-bold">ใบกำกับภาษี E-Tax / จัดส่งหลังงาน</h1>
        </header>

        <form action="{{ route('e-tax-form.store') }}" method="post" class="space-y-6">
            @csrf
            <div>
                <label class="block text-md font-medium mb-2 required">1. ช่องทางการสั่งซื้อสินค้าเฮเฟเล่</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" id="purchase_channel_group">
                    @foreach (['Big Clearance Sales', 'Hafele Showroom', 'HomePro', 'Boonthavorn', 'Hafele Home', 'Shopee', 'Lazada'] as $channel)
                        <label class="flex items-center space-x-2 cursor-pointer p-3 rounded-md border transition">
                            <input type="radio" name="purchase_channel" value="{{ $channel }}" required
                                class="form-radio ">
                            <span class="text-md">{{ $channel }}</span>
                        </label>
                    @endforeach
                    <label class="flex items-center space-x-2 cursor-pointer p-3 rounded-md border transition">
                        <input type="radio" name="purchase_channel" value="Other" required id="purchase_channel_other"
                            class="form-radio">
                        <span class="text-md">Other</span>
                    </label>
                </div>
                <div id="other_channel_input" class="mt-4 hidden">
                    <label for="other_channel"
                        class="block text-md font-medium required">กรุณาระบุช่องทางการสั่งซื้ออื่นๆ</label>
                    <input type="text" id="other_channel" name="other_channel"
                        class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 transition">
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label for="order_ref_container" class="block text-md font-medium required">
                        2. กรุณาระบุหมายเลขคำสั่งซื้อ
                        <span class="font-light text-gray-600">(Order Ref No.)</span>
                    </label>
                    <div id="order_ref_container" class="space-y-2 mt-1">
                        <div class="flex items-center space-x-2 order-ref-item">
                            <input type="text" name="order_refs[]" required
                                class="block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 focus:ring-[#002eb8]">
                        </div>
                    </div>
                    <button type="button" id="add_order_ref"
                        class="mt-2 text-sm text-blue-400 hover:text-blue-300 focus:outline-none">
                        + เพิ่มหมายเลขคำสั่งซื้อ
                    </button>
                </div>

                <div class="col-span-2">
                    <label for="customer_name" class="block text-md font-medium required">
                        3. ชื่อลูกค้า / บริษัท / ห้างร้าน
                    </label>
                    <input type="text" id="customer_name" name="customer_name" required
                        class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 transition">
                </div>
                <div class="col-span-2">
                    <label for="phone" class="block text-md font-medium required">
                        4. เบอร์โทรศัพท์
                    </label>
                    <input type="text" id="phone" name="phone" inputmode="numeric" maxlength="10" required
                        class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 transition">
                </div>
                <div class="col-span-2">
                    <label for="tax_id" class="block text-md font-medium required">
                        5. หมายเลขประจำตัวผู้เสียภาษี
                    </label>
                    <input type="text" id="tax_id" name="tax_id" inputmode="numeric" maxlength="13" required
                        class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 transition">
                </div>
                <div class="col-span-2">
                    <label for="branch_id" class="block text-md font-medium">
                        6. สาขา Branch ID
                        <span class="font-light text-gray-600">(ระบุเลข 5 หลัก เช่น 00002 ไม่ระบุถือว่าเป็นสำนักงานใหญ่
                            00000)</span>
                    </label>
                    <input type="text" id="branch_id" name="branch_id" maxlength="5"
                        class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 transition">
                </div>
                <div class="col-span-2">
                    <label for="email" class="block text-md font-medium required">
                        7. อีเมลสำหรับจัดส่งใบกำกับภาษี
                    </label>
                    <input type="email" id="email" name="email" required
                        class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 transition">
                </div>

                <div class="col-span-2">
                    <label for="address_line1" class="block text-md font-medium required">
                        8. บ้านเลขที่ / อาคาร, ถนน, ซอย
                    </label>
                    <textarea id="address_line1" name="address_line1" required rows="2"
                        class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 transition"></textarea>
                </div>
                <div class="col-span-2">
                    <label for="address_line2" class="block text-md font-medium required">
                        9. ตำบล/เขต, ,อำเภอ/แขวง
                    </label>
                    <textarea id="address_line2" name="address_line2" required rows="2"
                        class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 transition"></textarea>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="province" class="block text-md font-medium required">
                        10. จังหวัด
                    </label>
                    <input type="text" id="province" name="province" required
                        class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 transition">
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="zip_code" class="block text-md font-medium required">
                        11. รหัสไปรษณีย์
                    </label>
                    <input type="text" id="zip_code" name="zip_code" required
                        class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 transition">
                </div>
            </div>

            <div>
                <label class="block text-md font-medium required">
                    12. ที่อยู่จัดส่งเหมือนกับที่อยู่ E-Tax หรือไม่?
                </label>
                <div class="mt-2">
                    <label class="flex items-center">
                        <input type="radio" name="shipping_address_same" value="yes" id="shipping_yes" required
                            class="form-radio">
                        <span class="ml-2">ใช่</span>
                    </label>
                    <label class="flex items-center mt-2">
                        <input type="radio" name="shipping_address_same" value="no" id="shipping_no"
                            class="form-radio">
                        <span class="ml-2">ไม่ใช่</span>
                    </label>
                </div>
            </div>

            <div id="shipping_address_form" class="space-y-4 hidden pt-4">
                <h3 class="text-xl font-semibold border-b pb-2 required">ที่อยู่สำหรับจัดส่งสินค้า</h3>
                <div>
                    <label for="shipping_address_line1" class="block text-md font-medium required">
                        บ้านเลขที่ / อาคาร, ถนน, ซอย
                    </label>
                    <textarea id="shipping_address_line1" name="shipping_address_line1" rows="2"
                        class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 focus:ring-[#002eb8] transition"></textarea>
                </div>
                <div>
                    <label for="shipping_address_line2" class="block text-md font-medium required">
                        ตำบล/เขต, อำเภอ/แขวง
                    </label>
                    <textarea id="shipping_address_line2" name="shipping_address_line2" rows="2"
                        class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 focus:ring-[#002eb8] transition"></textarea>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="col-span-2 sm:col-span-1">
                        <label for="shipping_province" class="block text-md font-medium required">
                            จังหวัด
                        </label>
                        <input type="text" id="shipping_province" name="shipping_province"
                            class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 focus:ring-[#002eb8] transition">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="shipping_zip_code" class="block text-md font-medium required">
                            รหัสไปรษณีย์
                        </label>
                        <input type="text" id="shipping_zip_code" name="shipping_zip_code"
                            class="mt-1 block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 focus:ring-[#002eb8] transition">
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <p id="short_text" class="text-md indent-18">
                    เพื่อวัตถุประสงค์ในการออกใบกำกับภาษีอย่างถูกต้องตามกฎหมาย
                    บริษัทจำเป็นต้องขอใช้ข้อมูลเลขบัตรประจำตัวประชาชน 13 หลักของท่าน ข้อมูลดังกล่าวจะถูกเก็บ...
                    <button id="read_more_btn" type="button" class="text-blue-400 hover:text-blue-300 ml-1">
                        อ่านเพิ่มเติม
                    </button>
                </p>
                <div id="full_text" class="hidden">
                    <p class="text-md indent-18">
                        เพื่อวัตถุประสงค์ในการออกใบกำกับภาษีอย่างถูกต้องตามกฎหมาย
                        บริษัทจำเป็นต้องขอใช้ข้อมูลเลขบัตรประจำตัวประชาชน 13 หลักของท่าน ข้อมูลดังกล่าวจะถูกเก็บ ใช้
                        และประมวลผลเฉพาะในส่วนที่เกี่ยวข้องกับการออกเอกสารภาษี
                        และจะเก็บรักษาอย่างปลอดภัยตามมาตรการที่บริษัทกำหนด ทั้งนี้
                        ท่านสามารถติดต่อเพื่อแก้ไขหรือลบข้อมูลได้ตามสิทธิของเจ้าของข้อมูลส่วนบุคคลภายใต้พระราชบัญญัติคุ้มครองข้อมูลส่วนบุคคล
                        พ.ศ. 2562
                        <br>
                    <p class="font-light indent-18">
                        To issue a tax invoice in compliance with applicable laws, the Company requires your 13-digit
                        national identification number. This information will be collected, used, and processed solely
                        for the purpose of tax documentation and will be securely stored in accordance with the
                        Company's
                        data protection measures. You may request to update or delete this information accordance with
                        your
                        rights under the Personal Data Protection Act B.E. 2562 (PDPA).
                    </p>
                    </p>
                </div>
                <div class="mt-0 flex items-start">
                    <input type="checkbox" id="pdpa_consent" name="pdpa_consent" required
                        class="form-checkbox text-[#002eb8] rounded-sm focus:ring-[#002eb8] mt-2">
                    <label for="pdpa_consent" class="ml-2 text-md required">
                        ข้าพเจ้ายินยอมให้บริษัทใช้เลขประจำตัวประชาชนของข้าพเจ้าเพื่อการออกใบกำกับภาษีตามที่ระบุข้างต้น /
                        <span class="font-light">
                            I consent to the use of may national identification number for the issuance of a tax invoice as
                            described above.
                        </span>
                    </label>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-purple-700 hover:bg-purple-800 text-white font-bold py-3 px-4 rounded-md transition-colors duration-200 focus:ring-2">
                    Submit
                </button>
            </div>

        </form>
    </div>

    <div class="fixed bottom-4 right-4 z-50">
        @if(session('success'))
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2 animate-fade-in-up">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-lg font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2 animate-fade-in-up">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-lg font-semibold">{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        document.addEventListener('DOMContentLoaded', function() {
            // Other Channel
            const otherChannelRadio = document.getElementById('purchase_channel_other');
            const otherChannelInputDiv = document.getElementById('other_channel_input');
            const otherChannelInput = document.getElementById('other_channel');
            const purchaseChannelGroup = document.getElementById('purchase_channel_group');
            if (purchaseChannelGroup) {
                purchaseChannelGroup.addEventListener('change', function(event) {
                    if (event.target.id === 'purchase_channel_other') {
                        otherChannelInputDiv.classList.remove('hidden');
                        otherChannelInput.setAttribute('required', 'required');
                    } else {
                        otherChannelInputDiv.classList.add('hidden');
                        otherChannelInput.removeAttribute('required');
                    }
                });
            }

            // Shipping Address
            const shippingYesRadio = document.getElementById('shipping_yes');
            const shippingNoRadio = document.getElementById('shipping_no');
            const shippingAddressForm = document.getElementById('shipping_address_form');
            const shippingInputs = shippingAddressForm.querySelectorAll('input, textarea');
            function toggleShippingAddress() {
                if (shippingNoRadio.checked) {
                    shippingAddressForm.classList.remove('hidden');
                    shippingInputs.forEach(input => input.setAttribute('required', 'required'));
                } else {
                    shippingAddressForm.classList.add('hidden');
                    shippingInputs.forEach(input => {
                        input.removeAttribute('required');
                        input.value = '';
                    });
                }
            }
            toggleShippingAddress();
            shippingYesRadio.addEventListener('change', toggleShippingAddress);
            shippingNoRadio.addEventListener('change', toggleShippingAddress);

            // PDPA
            const shortText = document.getElementById('short_text');
            const fullText = document.getElementById('full_text');
            const readMoreBtn = document.getElementById('read_more_btn');
            if (readMoreBtn) {
                readMoreBtn.addEventListener('click', function() {
                    shortText.classList.add('hidden');
                    fullText.classList.remove('hidden');
                });
            }

            // Add Order No.
            const orderRefContainer = document.getElementById('order_ref_container');
            const addOrderRefBtn = document.getElementById('add_order_ref')
            function addOrderItem() {
                const newOrderItem = document.createElement('div');
                newOrderItem.className = 'flex items-center space-x-2 order-ref-item';
                newOrderItem.innerHTML = `
                    <input type="text" name="order_refs[]" required class="block w-full px-4 py-2 rounded-md border focus:outline-none focus:ring-2 focus:ring-[#002eb8]">
                    <button type="button" class="remove-order-ref text-red-400 hover:text-red-300 text-lg">&times;</button>
                `;
                orderRefContainer.appendChild(newOrderItem);
            }
            orderRefContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-order-ref')) {
                    event.target.closest('.order-ref-item').remove();
                }
            });
            if (addOrderRefBtn) {
                addOrderRefBtn.addEventListener('click', addOrderItem);
            }

            // Numeric Validation
            const numericInputs = document.querySelectorAll('#tax_id, #phone, #branch_id');
            numericInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            });

            // Toast Alerts
            const successToast = document.querySelector('.bg-green-500');
            const errorToast = document.querySelector('.bg-red-500');
            if (successToast) {
                setTimeout(() => {
                    successToast.style.transition = 'opacity 0.5s ease-out';
                    successToast.style.opacity = '0';
                    setTimeout(() => successToast.remove(), 500);
                }, 10000);
            }
            if (errorToast) {
                setTimeout(() => {
                    errorToast.style.transition = 'opacity 0.5s ease-out';
                    errorToast.style.opacity = '0';
                    setTimeout(() => errorToast.remove(), 500);
                }, 10000);
            }
        });
    </script>
@endsection
