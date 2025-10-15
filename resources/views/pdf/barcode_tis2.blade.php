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
        height: 500px;
        width: 580px;
        z-index: -1;
        padding: 14px 0px 0px 15px;
    }

    tr {
        line-height: 10px;
    }

    .hafele-logo {
        position: absolute;
        top: -26px;
        right: 0px;
        z-index: -1;
    }

    .hafele-logo img {
        margin-top: 2px;
    }

    .lead-logo {
        position: absolute;
        right: 60px;
        top: 390px;
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

    .qr-code {
        position: absolute;
        right: -10px;
        top: 390px;
    }

    .barcode-container {
        position: absolute;
        left: 170px;
        top: 470px;
        line-height: 0px;
    }

    .barcode-text {
        font-size: 15px;
        margin: 20px 0px 0px 17px;
    }

    .text-20 {
        font-size: 20px;
    }
</style>
<!DOCTYPE html>

<div class="hafele-logo">
    <img src="img/logos/Logo-HAFELE-02.jpg" width="110">
</div>
<div class="lead-logo">
    <img src="img/logos/LEAD.png" width="60"></br>
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
@if ($productItems['qr_code'] != '')
    <div class="qr-code">
        <?php echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($productItems['qr_code'], 'QRCODE') . '" width="60" height="60"/>'; ?>
    </div>
@endif

@if ($productItems['bar_code'] != '')
    <div class="barcode-container">
        @if (strlen($productItems->bar_code) == 13)
            <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($productItems['bar_code'], 'EAN13') . '" width="150" />'; ?>
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
                <td>ชื่อผลิตภัณฑ์:</td>
                <td colspan="2">{{ $productItems['product_name'] }}</td>
            </tr>
            <tr>
                <td>รหัส:</td>
                <td>{{ $productItems['item_code'] }}</td>
            </tr>
            <tr>
                <td>แบบรุ่น:</td>
                <td>{{ $productItems['supplier_item'] }}</td>
            </tr>
            <tr>
                <td>แบบการขจัดฝ้าน้ำแข็ง:</td>
                <?php
                switch ($productItems->defrosting) {
                    case 'Automatic':
                        $defrosting = '() ด้วยมือ () กึ่งอัตโนมัติ (X) อัตโนมัติ';
                        break;
                    case 'Semiauto':
                        $defrosting = '() ด้วยมือ (X) กึ่งอัตโนมัติ () อัตโนมัติ';
                        break;
                    case 'Manual':
                        $defrosting = '(X) ด้วยมือ () กึ่งอัตโนมัติ () อัตโนมัติ';
                        break;
                
                    default:
                        $defrosting = '() ด้วยมือ () กึ่งอัตโนมัติ () อัตโนมัติ';
                        break;
                }
                ?>
                <td>{{ $defrosting }}</td>
            </tr>
            <tr>
                <td>ปริมาตราภายในที่กำหนด:</td>
                <td>
                    @if ($productItems->gross_int != '')
                        {{ number_format($productItems['gross_int'], 1) }} ลูกบาศก์เดซิเมตร
                    @endif
                </td>
            </tr>
            <tr>
                <td>แรงดันไฟฟ้าที่กำหนด:</td>
                <td>{{ $productItems['nominal_voltage'] }} โวลต์</td>
            </tr>
            <tr>
                <td>กำลังไฟฟ้าที่ละลายน้ำแข็ง:</td>
                <td>{{ $productItems['defrosting_power'] }} วัตต์</td>
            </tr>
            <tr>
                <td>กระแสไฟฟ้าที่กำหนด:</td>
                <td>{{ $productItems['nominal_electricity'] }} แอมแปร์</td>
            </tr>
            <tr>
                <td colspan="2">ค่ากำลังไฟฟ้าสูงสุดของหลอดไฟฟ้า: {{ '-' }} วัตต์</td>
            </tr>
            <tr>
                <td>จำนวนเฟส:</td>
                <td>{{ $productItems['electric_power_phase'] }} เฟส</td>
            </tr>
            <tr>
                <td>กำลังไฟฟ้าที่กำหนด:</td>
                <td>{{ $productItems['nominal_power'] }} วัตต์</td>
            </tr>
            <tr>
                <td>ประเภทดาวของช่องแช่แข็ง:</td>
                <td>{{ $productItems['star_rating_freezer'] }}</td>
            </tr>
            <tr>
                <td>ค่าพลังงานไฟฟ้าที่ใช้:</td>
                <td>{{ number_format((int) $productItems['energy_cons_per_year'], 2) }} กิโลวัตต์ชั่วโมงต่อปี</td>
            </tr>
            <tr>
                <td>ชั้นภูมิอากาศ:</td>
                <td>{{ $productItems['climate_class'] }}</td>
            </tr>
            <tr>
                <td>ชนิดของสารความเย็น:</td>
                <td>{{ $productItems['refrigerant'] }} กรัม</td>
            </tr>
            <tr>
                <td>วิธีใช้:</td>
                <td>{{ $productItems['how_to_text'] }}</td>
            </tr>
            <tr>
                <td class="text-20">ข้อแนะนำ/คำเตือน:</td>
                <td>{{ $productItems['warning_text'] }}</td>
            </tr>
            <tr>
                <td>วันที่ผลิต:</td>
                <td>{{ $productItems['man_date'] }}</td>
            </tr>
            <tr>
                <td>ผลิตโดย:</td>
                <td>{{ $productItems['made_by2'] }}</td>
            </tr>
            <?php
            $country_code = ['CN - CHINA' => 'สาธารณรัฐประชาชนจีน', 'DE - GERMANY' => 'เยอรมนี'];
            ?>
            <tr>
                <td>ประเทศ:</td>
                <td>{{ $productItems['country_code'] }} </td>
            </tr>
            <tr>
                <td colspan="2">นำเข้าและจัดจำหน่ายโดย: บริษัท เฮเฟเล่(ประเทศไทย)จำกัด</td>
            </tr>
            <tr>
                <td colspan="2"> 57 ซอยสุขุมวิท 64 ถนนสุขุมวิท </td>
            </tr>
            <tr>
                <td colspan="2"> แขวงพระโขนงใต้ เขตพระโขนง กรุงเทพมหานคร 10260</td>
            </tr>
            <tr>
                <td colspan="2"> โทร 02-768-7171</td>
            </tr>
            <tr>
                <td>ปริมาณบรรจุ:</td>
                <td>{{ $productItems['item_amout'] }}</td>
            </tr>
            <tr>
                <td>ราคา:</td>
                <td>{{ '' }}</td>
            </tr>
            <tr>
                <td>ขนาด:</td>
                <td>{{ '' }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
