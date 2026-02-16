{{-- <div class="text-center">
    <h2>ชำระเงินผ่าน QR Code (1)</h2>
    <p>จำนวนเงิน: {{ number_format($amount, 2) }} บาท</p>
    <p>เลขที่รายการ (Ref 1): {{ $ref1 }}</p>
    <p>เลขที่รายการ (Ref 2): {{ $ref2 }}</p>

    <img src="{{ $base64Image }}" alt="Payment QR Code">

    <p>สแกนผ่านแอปธนาคารเพื่อชำระเงิน</p>
</div>
<div class="text-center mt-10">
    <h2>ชำระเงินผ่าน QR Code (2)</h2>
    <p>จำนวนเงิน: {{ number_format($amount, 2) }} บาท</p>
    <p>เลขที่รายการ (Ref 1): {{ $ref1 }}</p>
    <p>เลขที่รายการ (Ref 2): {{ $ref2 }}</p>

    <img src="{{ $base64Image2 }}" alt="Payment QR Code">

    <p>สแกนผ่านแอปธนาคารเพื่อชำระเงิน</p>
</div> --}}

{{-- resources/views/pages/payment/show.blade.php --}}
<div class="grid grid-cols-2 gap-8 p-6">

    {{-- QR ชุดที่ 1 --}}
    <div class="border rounded-xl p-4 text-center shadow">
        <h2 class="font-bold text-lg mb-3">Lib 1 — phumin/PromptParse</h2>
        <img src="{{ $qrImage1 }}" alt="QR 1" class="mx-auto w-64 h-64">
        <pre class="mt-3 text-xs bg-gray-100 rounded p-2 break-all text-left">{{ $payload1 }}</pre>
    </div>

    {{-- QR ชุดที่ 2 --}}
    <div class="border rounded-xl p-4 text-center shadow">
        <h2 class="font-bold text-lg mb-3">Lib 2 — PromptPayQR/Builder</h2>
        <img src="{{ $qrImage2 }}" alt="QR 2" class="mx-auto w-64 h-64">
        <pre class="mt-3 text-xs bg-gray-100 rounded p-2 break-all text-left">{{ $payload2 }}</pre>
    </div>

</div>

{{-- ข้อมูล order ──────────────────────────────────── --}}
<div class="mt-6 p-4 bg-gray-50 rounded-xl text-sm">
    <p><span class="font-semibold">Ref1:</span> {{ $ref1 }}</p>
    <p><span class="font-semibold">Ref2:</span> {{ $ref2 }}</p>
    <p><span class="font-semibold">Amount:</span> {{ number_format($amount, 2) }} บาท</p>
</div>

{{-- ตรวจสอบ payload ตรงกันหรือไม่ ──────────────── --}}
@if ($payload1 === $payload2)
    <div class="mt-4 p-3 bg-green-100 text-green-700 rounded-lg text-center font-semibold">
        ✅ Payload ตรงกันทั้งสอง Library
    </div>
@else
    <div class="mt-4 p-3 bg-red-100 text-red-700 rounded-lg text-center font-semibold">
        ❌ Payload ไม่ตรงกัน — กรุณาตรวจสอบ
    </div>
@endif