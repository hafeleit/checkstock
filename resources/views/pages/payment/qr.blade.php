<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชำระเงินผ่าน QR Code (Bill Payment)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500&display=swap');

        body {
            font-family: 'Kanit', sans-serif;
        }

        .qr-container svg {
            margin: 0 auto;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-lg max-w-sm w-full text-center border-t-8 border-blue-600">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Thai QR Payment</h2>
        <p class="text-gray-500 mb-6 text-sm">สแกนเพื่อชำระค่าบริการ</p>

        <div class="qr-container bg-white p-4 border-2 border-gray-100 rounded-xl mb-6 shadow-inner">
            {!! $qrCode !!}
        </div>

        <div class="space-y-3 text-left bg-gray-50 p-4 rounded-lg">
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500 text-sm">Ref 1:</span>
                <span class="font-medium text-gray-800 tracking-wider">CUS00001</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500 text-sm">Ref 2:</span>
                <span class="font-medium text-gray-800">-</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500 text-sm">ยอดชำระ:</span>
                <span class="text-xl font-bold text-blue-600">฿ 1.00</span>
            </div>
        </div>

        <p class="mt-6 text-[10px] text-gray-400 break-all leading-tight">
            Payload: {{ $payload }}
        </p>

        <button onclick="window.print()"
            class="mt-6 w-full bg-blue-600 text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition">
            บันทึกรูปภาพ / พิมพ์
        </button>
    </div>

</body>

</html>
