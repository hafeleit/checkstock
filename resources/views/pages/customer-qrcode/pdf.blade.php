<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>QR Code - {{ $customer->customer_code }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'sans-serif';
            background-color: #f4f7f6;
            padding: 40px;
            color: #2d3436;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h3 {
            margin-top: 0;
            color: #2d3436;
            font-size: 22px;
            text-align: center;
        }

        .qr-section {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: #fafafa;
            border-radius: 15px;
        }

        .qr-img {
            width: 200px;
            height: 200px;
        }

        .info-section {
            margin-top: 25px;
            border-top: 1px dashed #dfe6e9;
            padding-top: 20px;
        }

        .info-row {
            margin-bottom: 12px;
            display: block;
        }

        .label {
            color: #636e72;
            font-size: 13px;
            margin-bottom: 2px;
        }

        .value {
            font-weight: bold;
            font-size: 16px;
            color: #2d3436;
        }

        .amount-value {
            color: #e67e22;
            font-size: 20px;
        }

        .customer-name {
            margin-top: 25px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #4a90e2;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>QR Payment</h3>

        <div class="qr-section">
            <img src="{{ $qrCode }}" class="qr-img">
        </div>

        <div class="info-section">
            <div class="info-row">
                <div class="label">Ref 1 (Customer Code):</div>
                <div class="value">{{ $customer->customer_code }}</div>
            </div>

            <div class="info-row">
                <div class="label">Amount:</div>
                <div class="value amount-value">0.00 THB</div>
            </div>
        </div>

        <div class="customer-name">
            {{ $customer->customer_name }}
        </div>
    </div>
</body>

</html>
