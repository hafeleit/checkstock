<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <style media="screen">

    body {
      margin-top: -35px;margin-left: -40px;
    	font-family: 'AngsanaUPC'; height: 100%;
      font-size: 14px;
    }

    @font-face {
      font-family: 'AngsanaUPC';
      font-style: normal;
      font-weight: normal;
      src: local('AngsanaUPC'),
      src: url("{{ asset('fonts/AngsanaUPC.ttf')}}") format('truetype');
    }

    tr {
      line-height: 12px;
    }

    table, th, td {
      border: 0px solid black;
      border-collapse: collapse;
    }

    .topic {
      font-size: 16px;
    }
  </style>
  <body>
    <div>
      <table width="100%">
        <tr>
          <td class="topic">ชื่อผลิตภัณฑ์: </td>
          <td colspan="4">ก๊อกน้ำสำหรับเครื่องสุขภัณฑ์เฉพาะด้านสิ่งแวดล้อม : การประหยัดน้ำ</td>
          <td><img src="img/logos/Logo-HAFELE-02.jpg" width="55" ></td>
        </tr>
        <tr>
          <td class="topic">ชื่อรุ่น: </td>
          <td colspan="5">xyz series</td>
        </tr>
        <tr>
          <td class="topic">รหัส: </td>
          <td colspan="5">495.60.255</td>
        </tr>
        <tr>
          <td class="topic">ชนิด: </td>
          <td>ดหกดหกดหกดหกดหกดหกดหกด</td>
          <td class="topic" width="40px">ประเภท: </td>
          <td colspan="3">กดเกดเกดเกดเกดเกดเกดเ</td>
        </tr>
        <tr>
          <td class="topic">แบบ: </td>
          <td>กดเดกดเ</td>
          <td class="topic">สี: </td>
          <td>ขาว</td>
          <td class="topic">แบบรุ่น: </td>
          <td>เกดเกดเกดเกดเ</td>
        </tr>
        <tr>
          <td class="topic">ขนาด: </td>
          <td colspan="5">360x360x700มม</td>
        </tr>
        <tr>
          <td class="topic">วิธีใช้: </td>
          <td colspan="5">หกดหกดหกดหกดหกดหกดหกดหกดหกดหกดหกดหกดหกด</td>
        </tr>
        <tr>
          <td class="topic">ข้อแนะนำ/คำเตือน: </td>
          <td colspan="4">หกดหกดหกดหกดหกดหกดหกดหกดหกดหกดหกดหกดหกด</td>
          <td>
          </td>
        </tr>
        <div class="" style="position:absolute; right:70px;bottom:160px">
          <img src="img/logos/LEAD.png" width="55">
        </div>
        <div class="" style="position:absolute; right:15px;bottom:160px">
          <?php echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($productItems["bar_code"], "QRCODE") . '" width="40" height="40"/>'; ?>
        </div>
        <tr>
          <td class="topic">วันที่ผลิต/นำเข้า: </td>
          <td colspan="5">27/08/2567</td>
        </tr>
        <tr>
          <td class="topic">ผลิตโดย: </td>
          <td colspan="3">หกดหกดกหดฟหกดฟหกดฟหกดฟหกดฟหกดฟหกดฟหกดหกฟด</td>
          <td colspan="2" style="padding-left: 25px"> มอก. 792-2554</td>
        </tr>
        <tr>
          <td class="topic">ประเทศผู้ผลิต: </td>
          <td colspan="5">หกดหกดหกดหกดหกด</td>
        </tr>
        <tr>
          <td colspan="6" class="topic">นำเข้าและจัดจำหน่ายโดย: บริษัทเฮเฟเล่(ประเทสไทย) จำกัด</td>
        </tr>
        <tr>
          <td colspan="2" width="50px">57 ซอยสุขุมวิท 64 ถนนสุขุมวิท แขวงพระโขนงใต้ เขตพระโขนง กรุงเทพมหานคร 10260</td>
          <td colspan="4" align="right">

          </td>
        </tr>
        <div class="" style="position:absolute; right:50px; bottom:20px">
          <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($productItems["bar_code"], "EAN13") . '" width="150" height="26.25" style="margin:0px 0px 0px 0px;" />'; ?>
            <p style="margin:0px 0px 0px 0px;">
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
        <tr>
          <td class="topic">ปริมาณบรรจุ: </td>
          <td colspan="5">1 ชิ้น</td>
        </tr>
        <tr>
          <td class="topic">ราคา: </td>
          <td colspan="5">ระบุ ณ จุดขาย</td>
        </tr>
      </table>
    </div>
  </body>
</html>
