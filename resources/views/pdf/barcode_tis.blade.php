<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <style media="screen">
    body {
    	margin-top: -42px;margin-left: -42px;
    	font-family: 'AngsanaUPC'; height: 100%;
      font-size: 16px;
    }
    .container{
      position:absolute;
      overflow: hidden;
      margin: 0px;
      padding: 0px;
      border: none;
      /*background-color: yellow;*/
      height: 400px;
      width: 580px;
      z-index: -1;
    }

    tr {
      line-height: 12px;
    }

    .item-code{
      font-size:36px;
      padding:10px 0px 10px 0px;
    }

    .subject{
      font-size:18px;
    }

    .mgl70{
      margin:0px 0px 0px 0px;
    }
  </style>

  <div class="" style="position:absolute;right:-30px;">
    <img src="img/logos/Logo-HAFELE-02.jpg" width="160" style="margin-top:10px">
  </div>
  <div class="" style="position:absolute; right:70px;top:130px; text-align:center">
    <img src="img/logos/LEAD.png" width="100" style="margin-bottom: -28px;"></br>
    <span style="text-align:center;font-weight:Bold">{{ $productItems["tis_1"] }}</span>
  </div>
  <div class="" style="position:absolute; right:10px;top:150px">
    <?php echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($productItems["qr_code"], "QRCODE") . '" width="60" height="60"/>'; ?>
  </div>
  <div class="" style="position:absolute; left:270px; top:260px; line-height: 0px;">
    <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($productItems["bar_code"], "EAN13") . '" width="250" />'; ?>
      <p style="font-size:30px; margin:20px 0px 0px 17px">
      <B>
        {{$productItems["bar_code"][0]}}&nbsp;&nbsp; {{$productItems["bar_code"][1]}}
        {{$productItems["bar_code"][2]}}
        {{$productItems["bar_code"][3]}}
        {{$productItems["bar_code"][4]}}
        {{$productItems["bar_code"][5]}}
        {{$productItems["bar_code"][6]}}&nbsp;&nbsp; {{$productItems["bar_code"][7]}}
        {{$productItems["bar_code"][8]}}
        {{$productItems["bar_code"][9]}}
        {{$productItems["bar_code"][10]}}
        {{$productItems["bar_code"][11]}}
        {{$productItems["bar_code"][12]}}
      </B>
  </div>

  <body>
    <div class="container">
      <table>
        <tr>
          <td class="subject">ชื่อผลิตภัณฑ์: </td>
          <td colspan="5"><p class="mgl70">{{$productItems["product_name"]}}</p></td>
        </tr>
        <tr>
          <td class="subject">ชื่อรุ่น: </td>
          <td colspan="5"><p class="mgl70">{{$productItems["series_name"]}}</p></td>
        </tr>
        <tr>
          <td class="subject">รหัส: </td>
          <td class="item-code" colspan="5"><p class="mgl70">{{$productItems["item_code"]}}</p></td>
        </tr>
        <tr>
          <td class="subject">ชนิด: </td>
          <td><p class="mgl70">{{$productItems["type"]}}</p></td>
          <td></td>
          <td width="70px"></td>
          <td class="subject">ประเภท: </td>
          <td >{{$productItems["format"]}}</td>
        </tr>
        <tr>
          <td class="subject">แบบ: </td>
          <td><p class="mgl70">{{$productItems["format"]}}</p></td>
          <td class="subject">สี: </td>
          <td>{{$productItems["material_color"]}}</td>
          <td class="subject">แบบรุ่น: </td>
          <td>{{$productItems["model"]}}</td>
        </tr>
        <tr>
          <td class="subject">ขนาด: </td>
          <td colspan="5"><p class="mgl70">{{$productItems["item_size"]}}</p></td>
        </tr>
        <tr>
          <td class="subject">วิธีใช้: </td>
          <td colspan="5"><p class="mgl70">{{$productItems["how_to_text"]}}</p></td>
        </tr>
        <tr>
          <td class="subject">ข้อแนะนำ/คำเตือน: </td>
          <td colspan="5">{{$productItems["warning_text"]}}</td>
        </tr>
        <tr>
          <td class="subject">วันที่ผลิต/นำเข้า: </td>
          <td colspan="5">{{$productItems["man_date"]}}</td>
        </tr>
        <tr>
          <td class="subject">ผลิตโดย: </td>
          <td colspan="5">{{$productItems["made_by"]}}</td>
        </tr>
        <tr>
          <td class="subject" >ประเทศผู้ผลิต: </td>
          <td colspan="5">{{ $productItems["country_code"] }}</td>
        </tr>
        <tr>
          <td class="subject">นำเข้าและจัดจำหน่ายโดย: </td>
          <td colspan="5" >บริษัทเฮเฟเล่(ประเทสไทย) จำกัด</td>
        </tr>
        <tr>
          <td colspan="6">57 ซอยสุขุมวิท 64 ถนนสุขุมวิท แขวงพระโขนงใต้ เขตพระโขนง กรุงเทพมหานคร 10260</td>
        </tr>
        <tr>
          <td class="subject">ปริมาณบรรจุ: </td>
          <td>{{ $productItems["item_amout"] }}</td>
        </tr>
        <tr>
          <td class="subject">ราคา: </td>
          <td>ระบุ ณ จุดขาย</td>
        </tr>

      </table>
    </div>
  </body>
</html>
