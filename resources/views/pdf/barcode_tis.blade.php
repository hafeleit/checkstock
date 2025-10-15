<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title></title>
</head>
<style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
    @font-face {
        font-family: 'AngsanaUPC';
        font-style: normal;
        font-weight: normal;
        src: local('AngsanaUPC'),
            src: url("{{ asset('fonts/AngsanaUPC.ttf') }}") format('truetype');
    }

    body {
        margin-top: -42px;
        margin-left: -42px;
        font-family: 'AngsanaUPC';
        height: 100%;
        font-size: 16px;
    }

    .container {
        position: absolute;
        overflow: hidden;
        margin: 0px;
        border: none;
        /*background-color: yellow;*/
        height: 400px;
        width: 580px;
        z-index: -1;
        padding: 10px 0px 0px 0px;
    }

    tr {
        line-height: 8px;
    }

    .hafele-logo {
        position: absolute;
        right: -30px;
        z-index: -1;
    }

    .hafele-logo img {
        margin-top: 2px;
    }

    .lead-logo {
        position: absolute;
        right: 30px;
        top: 45px;
        text-align: center;
    }

    .lead-logo img {
        width: 60px;
        margin-bottom: -20px;
    }

    .lead-logo span {
        text-align: center;
        font-weight: bold;
    }

    .qr-code {
        position: absolute;
        right: -30px;
        top: 55px;
    }

    .barcode-container {
        position: absolute;
        left: 205px;
        top: 158px;
        line-height: 0px;
    }

    .barcode-text {
        font-size: 12px;
        margin: 10px 0px 0px 8px;
    }

    .align-top {
        vertical-align: top;
    }

    .w-300px {
        width: 300px;
    }

    .text-20 {
        font-size: 20px;
    }
</style>

<div class="hafele-logo">
    <img src="img/logos/Logo-HAFELE-02.jpg" width="120">
</div>
<div class="lead-logo">
    <img src="img/logos/LEAD.png">
    <div>
        <?php
        $tis_1 = '';
        if (strpos($productItems['tis_1'], 'มอก.') === false) {
            $tis_1 = 'มอก.' . $productItems['tis_1'];
        } else {
            $tis_1 = $productItems['tis_1'];
        }
        ?>
        <span>{{ $tis_1 }}</span>
    </div>
</div>
@if ($productItems['qr_code'] != '')
    <div class="qr-code">
        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($productItems['qr_code'], 'QRCODE') }}" alt="Barcode" width="50" height="50" >
    </div>
@endif
@if ($productItems['bar_code'] != '')
    <div class="barcode-container">
        @if (strlen($productItems->bar_code) == 13)
            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($productItems['bar_code'], 'EAN13') }}" alt="Barcode" width="120" >
            <p class="barcode-text">
                <B>
                    {{ $productItems['bar_code'][0] }}&nbsp;&nbsp; {{ $productItems['bar_code'][1] }}
                    {{ $productItems['bar_code'][2] }}
                    {{ $productItems['bar_code'][3] }}
                    {{ $productItems['bar_code'][4] }}
                    {{ $productItems['bar_code'][5] }}
                    {{ $productItems['bar_code'][6] }}&nbsp;&nbsp; {{ $productItems['bar_code'][7] }}
                    {{ $productItems['bar_code'][8] }}
                    {{ $productItems['bar_code'][9] }}
                    {{ $productItems['bar_code'][10] }}
                    {{ $productItems['bar_code'][11] }}
                    {{ $productItems['bar_code'][12] }}
                </B>
        @endif
    </div>
@endif

<body>
    <div class="container">
        <table>

            <tr>
                <td>รหัสรุ่น:</td>
                <td>{{ $productItems['item_code'] }}</td>
            </tr>
            <tr>
                <td>ชื่อสินค้า:</td>
                <td colspan="2">{{ $productItems['product_name'] }}</td>
            </tr>
            <tr>
                <td>ชนิด:</td>
                <td>{{ $productItems['type'] }}</td>
            </tr>
            <tr>
                <td>แบบ:</td>
                <td>{{ $productItems['format'] }}</td>
            </tr>
            <tr>
                <td class="align-top">แบบรุ่น:</td>
                <td>
                    <div class="w-300px"> {{ $productItems['model'] }} </div>
                </td>
            </tr>
            <tr>
                <td>วิธีใช้:</td>
                <td>{{ $productItems['how_to_text'] }}</td>
            </tr>
            <tr>
                <td colspan="2">ข้อแนะนำ: {{ $productItems['suggest_text'] }}</td>
            </tr>
            <tr>
                <td colspan="2"><span class="text-20">คำเตือน</span>: {{ $productItems['warning_text'] }}
                </td>
            </tr>
            <tr>
                <td colspan="2">วันที่ผลิต/นำเข้า: {{ $productItems['man_date'] }}</td>
            </tr>
            <tr>
                <td>ผลิตโดย:</td>
                <td>{{ $productItems['made_by2'] }}</td>
            </tr>

            <tr>
                <td>ประเทศ:</td>
                <td>{{ $productItems['country_code'] }} </td>
            </tr>
            <tr>
                <td colspan="2">นำเข้าและจัดจำหน่ายโดย: บริษัท เฮเฟเล่(ประเทศไทย)จำกัด</td>
            </tr>
            <tr>
                <td colspan="2"> 57 ซอยสุขุมวิท 64 ถนนสุขุมวิท แขวงพระโขนงใต้</td>
            </tr>
            <tr>
                <td colspan="2"> เขตพระโขนง กรุงเทพมหานคร 10260 โทร 02-768-7171</td>
            </tr>
            <tr>
                <td colspan="2">ปริมาณบรรจุ: {{ $productItems['item_amout'] }}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ราคา: ระบุ ณ จุดขาย</td>
            </tr>
        </table>
    </div>
</body>

</html>
