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
            max-width: 350px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 20px;
        }

        .header-title {
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #636e72;
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
        }

        .qr-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .qr-img {
            width: 200px;
            height: 200px;
            border-radius: 10px;
        }

        .info-table {
            width: 100%;
            border-top: 1px solid #f1f2f6;
            padding-top: 20px;
        }

        .label {
            color: #636e72;
            font-size: 14px;
            text-align: left;
            padding-bottom: 10px;
        }

        .value {
            text-align: right;
            font-weight: bold;
            font-size: 14px;
            padding-bottom: 10px;
        }

        .customer-name {
            margin-top: 20px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #0d1b2a;
        }

        .footer-date {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #b2bec3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-title">QR Code Payment</div>

        <div class="qr-section">
            <img src="data:image/png;base64, {{ $qrCode }}" width="200" alt="qr code" />
        </div>
        
        <table class="info-table">
            <tr>
                <td class="label">Ref1:</td>
                <td class="value">{{ $customer->customer_code }}</td>
            </tr>
            <tr>
                <td class="label">Amount:</td>
                <td class="value">{{ number_format($customer->amount, 2) }} THB</td>
            </tr>
        </table>

        <div class="customer-name">
            {{ $customer->customer_name }}
        </div>

        <div class="footer-date">
            Generated on {{ date('F d, Y') }}
        </div>
    </div>
</body>

</html>
