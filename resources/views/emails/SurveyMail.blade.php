<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style media="screen">
      td {
        padding: 8px;
        font-size: 16px;
      }

      .warning {
        color: rgb(236, 11, 22);
        font-weight: 400 ! important;
      }
    </style>
</head>
<body>
    <h1>{{ $mailData['title'] ?? '' }}</h1>
    <p>{{ $mailData['body'] ?? '' }}</p>

    <table width="1200px" border="1" style="border-collapse: collapse; border: 0px dotted #c0bdbd; ">
      <tr style="background-color: #F1F1F1;">
        <td colspan="2" align="center"><h3>ข้อมูลลูกค้าและข้อมูลพนักงานขาย</h3></td>
      </tr>
      <tr>
        <td width="50%">
          <table width="100%">
            <tr>
              <td width="40%">ชื่อลูกค้า</td>
              <td>{{ $mailData['customerName'] ?? '' }}</td>
            </tr>
            <tr>
              <td>เบอร์มือถือลูกค้า</td>
              <td>{{ $mailData['customerMobile'] ?? '' }}</td>
            </tr>
            <tr>
              <td>ที่อยู่ลูกค้า</td>
              <td>{{ $mailData['customerAddress'] ?? '' }}</td>
            </tr>
            <tr>
              <td>รายละเอียดเพิ่มเติม</td>
              <td>{{ $mailData['customerInformation'] ?? '' }}</td>
            </tr>
          </table>
        </td>
        <td >
          <table width="100%">
            <tr>
              <td width="50%">รหัสพนักงานขาย</td>
              <td>{{ $mailData['salesPersonID'] ?? '' }}</td>
            </tr>
            <tr>
              <td>ชื่อพนักงานขาย</td>
              <td>{{ $mailData['salesPersonName'] ?? '' }}</td>
            </tr>
            <tr>
              <td>สถานที่,ห้างร้าน - สาขาที่ขายล็อค</td>
              <td>{{ $mailData['salesPersonLocation'] ?? '' }}</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr style="background-color: #F1F1F1;">
        <td colspan="2" align="center"><h3>ข้อมูลประตูและล็อคที่จะติดตั้ง</h3></td>
      </tr>
      <tr>
        <td colspan="2">
          <table width="100%">
            @if( $mailData['lockModel'] != '' )
            <tr>
              <td width="45%">รุ่นโมเดลล็อค</td>
              <td>{{ $mailData['lockModel'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['installationLocation'] != '' )
            <tr>
              <td width="45%">สภาพแวดล้อมที่จะติดตั้ง</td>
              <td>{{ $mailData['installationLocation'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['installationLocationMessage'] != '' )
            <tr>
              <td width="45%"></td>
              <td class="warning">{{ $mailData['installationLocationMessage'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['doorCondition'] != '' )
            <tr>
              <td width="45%">ประตูที่จะติดตั้ง</td>
              <td class="">{{ $mailData['doorCondition'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['doorConditionMessage'] != '' )
            <tr>
              <td width="45%"></td>
              <td class="warning">{{ $mailData['doorConditionMessage'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['existingDoorRetrofit'] != '' )
            <tr>
              <td width="45%"></td>
              <td class="">{{ $mailData['existingDoorRetrofit'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['existingDoorRetrofitMessage'] != '' )
            <tr>
              <td width="45%"></td>
              <td class="">{{ $mailData['existingDoorRetrofitMessage'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['existingDoorRetrofitCaution'] != '' )
            <tr>
              <td width="45%"></td>
              <td class="">{{ $mailData['existingDoorRetrofitCaution'] ?? '' }}</td>
            </tr>
            @endif


            @if( $mailData['doorType'] != '' )
            <tr>
              <td width="45%">ประเภทประตูตามวิธีการเปิด</td>
              <td class="">{{ $mailData['doorType'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['doorTypeMessage'] != '' )
            <tr>
              <td width="45%"></td>
              <td class="warning">{{ $mailData['doorTypeMessage'] ?? '' }}</td>
            </tr>
            @endif

            @if( $mailData['swingDoorType'] != '' )
            <tr>
              <td width="45%">บานเปิดเข้า - ออก ทางเดียว</td>
              <td class="">{{ $mailData['swingDoorType'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['swingDoorTypeMessage'] != '' )
            <tr>
              <td width="45%"></td>
              <td class="warning">{{ $mailData['swingDoorTypeMessage'] ?? '' }}</td>
            </tr>
            @endif

            @if( $mailData['swingDoorJamb'] != '' )
            <tr>
              <td width="45%">ชนิดของวงกบ</td>
              <td class="">{{ $mailData['swingDoorJamb'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['swingDoorJambMessage'] != '' )
            <tr>
              <td width="45%"></td>
              <td class="warning">{{ $mailData['swingDoorJambMessage'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['swingDoorJambCaution'] != '' )
            <tr>
              <td width="45%"></td>
              <td class="">{{ $mailData['swingDoorJambCaution'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['doorThickness'] != '' )
            <tr>
              <td width="45%">ความหนาบานประตู</td>
              <td class="">{{ $mailData['doorThickness'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['doorThicknessMessage'] != '' )
            <tr>
              <td width="45%"></td>
              <td class="">{{ $mailData['doorThicknessMessage'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['doorThicknessInput'] != '' )
            <tr>
              <td width="45%"></td>
              <td class="">{{ $mailData['doorThicknessInput'] ?? '' }}</td>
            </tr>
            @endif

            @if( $mailData['doorThicknessInputMessage'] != '' )
            <tr>
              <td width="45%"></td>
              <td class="">{{ $mailData['doorThicknessInputMessage'] ?? '' }}</td>
            </tr>
            @endif

            @if( $mailData['doorMaterial'] != '' )
            <tr>
              <td width="45%">วัสดุของประตู</td>
              <td>{{ $mailData['doorMaterial'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['doorMaterialMessage'] != '' )
            <tr>
              <td width="45%"></td>
              <td class="warning">{{ $mailData['doorMaterialMessage'] ?? '' }}</td>
            </tr>
            @endif

            @if( $mailData['doorLeaf'] != '' )
            <tr>
              <td width="45%">ชนิดบานประตูและความกว้างกรอบบาน</td>
              <td>{{ $mailData['doorLeaf'] ?? '' }}</td>
            </tr>
            @endif
            @if( $mailData['doorLeafMessage'] != '' )
            <tr>
              <td></td>
              <td>{{ $mailData['doorLeafMessage'] ?? '' }}</td>
            </tr>
            @endif
          </table>
        </td>
      </tr>
    </table>

    <p>Thank you</p>
</body>
</html>
