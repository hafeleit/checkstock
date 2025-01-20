<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Exports\ExportOrders;
use App\Exports\ExportOrdersSAP;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Services\SlackService;

class getorder extends Command
{

    protected $signature = 'cron:getorder';
    protected $description = 'get order from zort';

    protected $slackService;

     public function __construct(SlackService $slackService)
     {
        parent::__construct();
        $this->slackService = $slackService;
     }


    public function handle()
    {

      $this->onlineorder_manual_get();

    }

    public function get_order_api($page = 1){

      $storename = "hthecommerce@hafele.co.th";
      $apikey = "by3oFDNKYKNb8PHSRTM/k5IxHuuHT2RKTaPqyqWwuE=";
      $apisecret = "NOnFem169tqnU1VzMbFcd0YqrStaIb65ofmyHN3IQDs=";

      $order_status = 0;
      $start_date = '2023-07-01';
      $start_date = date('Y-m-d', strtotime(NOW(). ' - 1 days'));

      $today = date('Y-m-d');
      $endpoint = '/Order/GetOrders?updatedafter='.$start_date.'&updatedbefore='.$today.'&limit=2000&status='.$order_status.'&page='.$page;
      $url = "https://open-api.zortout.com/v4" . $endpoint;

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'storename: '.$storename,
          'apikey: '.$apikey,
          'apisecret: '.$apisecret,
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
      $response = json_decode($response);

      return $response;
    }

   // Convert a string to an array with multibyte string
    public function getMBStrSplit($string){

      //$string = 'บริษัท ริช 58 จำกัด บริษัท ริช 58 จำกัด บริษัท ริช 58 จำกัด บริษัท ริช 58 จำกัด บริษัท ริช 58 จำกัด บริษัท ริช 58 จำกัด บริษัท ริช 58 จำกัด บริษัท ริช 58 จำกัด บริษัท ริช 58 จำกัด บริษัท ริช 58 จำกัด บริษัท ริช 58 จำกัด บริษัท ริช 58 จำกัด ';

      $cnt_addr = 0;
      $run_addrs = 0;
      $addr[0] = [];
      $addr[1] = [];
      $addr[2] = [];
      $addr[3] = [];
      $addr_ar = [];

      $shipping_address = str_replace("\n", "", $string);
      $shipping_address = str_replace('+',' ',$shipping_address);
      $shipping_address = str_replace('*','',$shipping_address);
      $shipping_address = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $shipping_address);
      $shipping_address = preg_replace('/\d{5,}/', '', $shipping_address);
      //echo $shipping_address ."</br>";
      $sub_ship_addrs = explode(' ', $shipping_address);
      $limit = 60;

      foreach ($sub_ship_addrs as $key => $value) {

        //insert space secon string
        if($key != 0){
          $value = ' '.$value;
        }

        $cnt_addr += mb_strlen($value, 'UTF-8');
        //echo $cnt_addr . ' ' . $value ."</br>";
        if($cnt_addr <= $limit){
          $addr[$run_addrs][] = $value;
        }else{
          $cnt_addr = mb_strlen($value, 'UTF-8');
          // limit column to address 4
          if($run_addrs < 3){
            $run_addrs++; //run address
          }
          $limit = 40; // address 2, 3, 4 limit to 40 charecter
          $addr[$run_addrs][] = $value;
        }
      }
      //convert array to string
      $addr1_s = trim(implode('',$addr[0]));
      $addr2_s = trim(implode('',$addr[1]));
      $addr3_s = trim(implode('',$addr[2]));
      $addr4_s = trim(implode('',$addr[3]));

      //put address 4
      if($addr4_s == ''){
        if($addr3_s != ''){
          $addr4_s = $addr3_s;
          $addr3_s = '';
        }elseif ($addr2_s != '') {
          $addr4_s = $addr2_s;
          $addr2_s = '';
        }else{
          $addr4_s = '.';
        }
      }

      $addr_ar[] = $addr1_s;
      $addr_ar[] = $addr2_s;
      $addr_ar[] = $addr3_s;
      $addr_ar[] = $addr4_s;

      return $addr_ar;

    }

    public function generate_excel_sap($new_order, $file_name){

      $l = 0;
      $data_excel = [];
      $data_excel_exp = [];
      $data_excel_over_string = [];
      $over_key = [];
      $pass_key = [];

      foreach ($new_order as $key2 => $order) {

        $list_cnt = count($order->list);

        for ($i=0; $i < $list_cnt; $i++) {

          $addr_ar = $this->getMBStrSplit($order->shippingaddress);

          if(mb_strlen($addr_ar[3], 'UTF-8') > 40){
            $over_key[$l] = '';
          }else{
            $pass_key[$l] = '';
          }

          $sale_channel = strtoupper($order->saleschannel); //Project Code

          switch ($sale_channel) { //bank code
            case 'SHOPEE':
              $soldTo = "TH0000901";
              $shipTo = "TH0400001";
              $billTo = "TH0400002";
              break;
            case 'LAZADA':
              $soldTo = "TH0000902";
              $shipTo = "TH0400003";
              $billTo = "TH0400004";
              break;
            case 'CENTRAL ONLINE':
              $soldTo = "TH0000906";
              $shipTo = "TH0400011";
              $billTo = "TH0400012";
              break;
            case 'NOCNOC':
              $soldTo = "TH0000905";
              $shipTo = "TH0400009";
              $billTo = "TH0400010";
              break;
            case 'SHOPIFY':
              $soldTo = "TH0000903";
              $shipTo = "TH0400005";
              $billTo = "TH0400006";
              break;
            case 'LINE':
              $soldTo = "TH0000904";
              $shipTo = "TH0400007";
              $billTo = "TH0400008";
              break;
            case '24 SHOPPING':
              $soldTo = "TH0000907";
              $shipTo = "TH0400013";
              $billTo = "TH0400014";
              break;
            case 'SOCIAL COMMERCE':
              $soldTo = "TH0000908";
              $shipTo = "TH0400015";
              $billTo = "TH0400016";
              break;
            case 'BUSINESS PARTNER':
              $soldTo = "TH0000909";
              $shipTo = "TH0400017";
              $billTo = "TH0400018";
              break;
            case 'INTERNAL SALE':
              $soldTo = "TH0000910";
              $shipTo = "TH0400019";
              $billTo = "TH0400020";
              break;
            case 'TIKTOK':
              $soldTo = "TH0000911";
              $shipTo = "TH0400021";
              $billTo = "TH0400022";
              break;
            case 'OCEAN GLASS':
              $soldTo = "TH0000912";
              $shipTo = "TH0400023";
              $billTo = "TH0400024";
              break;
            default:
              $soldTo = $sale_channel;
              $shipTo = $sale_channel;
              $billTo = $sale_channel;
              break;
          }

          $data_excel[$l][] = date('d/m/y');
          $data_excel[$l][] = "TH10";
          $data_excel[$l][] = 'TH02';
          $data_excel[$l][] = 'ZOS';
          $data_excel[$l][] = $order->number;
          $data_excel[$l][] = $soldTo;
          $data_excel[$l][] = $shipTo;
          $data_excel[$l][] = $order->shippingname;

          $data_excel[$l][] = $addr_ar[0];
          $data_excel[$l][] = $addr_ar[1];
          $data_excel[$l][] = $addr_ar[2];
          $data_excel[$l][] = $addr_ar[3];
          $data_excel[$l][] = $billTo;
          $data_excel[$l][] = $order->customername ?? $order->shippingname;
          $sub_billing_addr = $order->customeraddress ?? $order->shippingaddress;
          $ship_ar = $this->getMBStrSplit($sub_billing_addr);
          $data_excel[$l][] = $ship_ar[0];
          $data_excel[$l][] = $ship_ar[1];
          $data_excel[$l][] = $ship_ar[2];
          $data_excel[$l][] = $ship_ar[3];
          $data_excel[$l][] = $order->customerpostcode ?? $order->shippingpostcode;
          $data_excel[$l][] = 'THB';
          $data_excel[$l][] = date('d/m/y');
          $data_excel[$l][] = 'Z5';
          $data_excel[$l][] = 'EXW';
          $data_excel[$l][] = $order->list[$i]->sku; //item code
          $data_excel[$l][] = '';
          $data_excel[$l][] = $order->list[$i]->number; //qty
          //$data_excel[$l][] = $order->list[$i]->number; //number
          $rate = $order->list[$i]->totalprice / $order->list[$i]->number;
          $data_excel[$l][] = $rate.' '; //rate price
          $data_excel[$l][] = '';
          $data_excel[$l][] = (string)'9999999999999';  //$order->customeridnumber
          $data_excel[$l][] = '00000';
          $data_excel[$l][] = 'ZROL'; //Discount Code
          $discnt = '';

          if($order->discount != ''){
            $discnt = $order->sellerdiscount;
            if($sale_channel == 'NOC NOC'){
              $discnt = $order->discountamount;
            }
          }else{
            $discnt = '0';
          }
          $data_excel[$l][] = $discnt.' '; //Discount Amount
          $data_excel[$l][] = $order->shippingphone ?? '';
          $data_excel[$l][] = $order->shippingphone ?? '';
          //Carrier code
          $shipchan = strtoupper($order->saleschannel);
          if(strtoupper($order->saleschannel) == 'LAZADA'){
            $shipchan = 'LEX';
          }
          if(Str::contains($shipchan, 'KERRY')){
            $data_excel[$l][] = 'TH-KER-ECM';
          }elseif(Str::contains($shipchan, 'NINJA')){
            $data_excel[$l][] = 'TH-NIN-ECM';
          }elseif(Str::contains($shipchan, 'J&T')){
            $data_excel[$l][] = 'TH-JTE-ECM';
          }elseif(Str::contains($shipchan, 'LEX')){
            $data_excel[$l][] = 'TH-LEX-ECM';
          }elseif(Str::contains($shipchan, 'SHOPEE')){
            $data_excel[$l][] = 'TH-SPE-ECM';
          }elseif(Str::contains($shipchan, 'DHL')){
            $data_excel[$l][] = 'TH-DHL-ECM';
          }elseif(Str::contains($shipchan, 'BI')){
            $data_excel[$l][] = 'TH-BIL-ECM';
          }elseif(Str::contains($shipchan, 'FLEET')){
            $data_excel[$l][] = 'TH-OTHERS';
          }elseif(Str::contains($shipchan, 'FLASH')){
            $data_excel[$l][] = 'TH-SPE-ECM';
          }elseif(Str::contains($shipchan, 'IDEA')){
            $data_excel[$l][] = 'TH-BIL-ECM';
          }elseif(Str::contains($shipchan, 'SPX')){
            $data_excel[$l][] = 'TH-SPE-ECM';
          }elseif(Str::contains($shipchan, 'NOCNOC')){
            $data_excel[$l][] = 'TH-OTHERS';
          }elseif(strtoupper($order->saleschannel) == 'STANDARD DELIVERY'){
            $data_excel[$l][] = 'TH-OTHERS';
          }else{
            $data_excel[$l][] = $order->saleschannel;
          }

          $data_excel[$l][] = $order->customerpostcode ?? $order->shippingpostcode;
          $data_excel[$l][] = 'ZAF';
          $data_excel[$l][] = $order->shippingamount ?? '0';

          $l++;
        }

      }

      if(count($over_key) > 0){
        //remove over address in SO UPLOAD excel file
        $pass_excel = array_diff_key($data_excel, $over_key);

        //create SAP_EXCEPTION excel
        $over_excel = array_diff_key($data_excel, $pass_key);
        $file_name_over ='SAP_EX_'.$file_name;
        $excel_over = $this->exportExcelSAP($over_excel, $file_name_over);

      }else{ //don't have over address
        $pass_excel = $data_excel;
      }

      //create SO UPLOAD excel file
      $file_name_pass = 'SAP_'.$file_name;
      $excel = $this->exportExcelSAP($pass_excel, $file_name_pass);

      return $excel;
    }

    public function generate_excel_orion($new_order, $file_name){

      $l = 0;
      $data_excel = [];

      foreach ($new_order as $key2 => $order) {

          $list_cnt = count($order->list) + 1; //for orion

          for ($i=0; $i < $list_cnt; $i++) {

            $data_excel[$l][] = 'HTH';
            $data_excel[$l][] = date('d/m/y');
            $data_excel[$l][] = strval(1);
            $data_excel[$l][] = '1';
            $data_excel[$l][] = 'SO_WEB';
            $data_excel[$l][] = $order->number;
            $data_excel[$l][] = '1';
            $data_excel[$l][] = '157019';
            $data_excel[$l][] = '157019-201';
            $data_excel[$l][] = $order->shippingname;
            $data_excel[$l][] = $order->shippingaddress;
            $data_excel[$l][] = '';
            $data_excel[$l][] = $order->customername ?? $order->shippingname;
            $data_excel[$l][] = '157019-101';
            $data_excel[$l][] = $order->customeraddress ?? $order->shippingaddress;
            $data_excel[$l][] = '';
            $data_excel[$l][] = 'THB';
            $data_excel[$l][] = date('d/m/y');
            $data_excel[$l][] = 'BY 3PL';
            $data_excel[$l][] = '3040';
            $data_excel[$l][] = 'EX WORKS';
            $data_excel[$l][] = 'BANGKOK';
            $data_excel[$l][] = 'N';
            // Annotation
            if(strtoupper($order->saleschannel) == 'LAZADA'){
              $data_excel[$l][] = 'LEX';
            }elseif(strtoupper($order->shippingchannel) == 'STANDARD DELIVERY'){
              $data_excel[$l][] = 'NocNoc';
            }else{
              $data_excel[$l][] = $order->shippingchannel;
            }
            $data_excel[$l][] = ($i+1 == $list_cnt) ? '605' : $order->list[$i]->sku; //sku
            $data_excel[$l][] = '';
            $data_excel[$l][] = '';
            $data_excel[$l][] = '';
            $data_excel[$l][] = ($i+1 == $list_cnt) ? '1' : $order->list[$i]->number; //number
            $data_excel[$l][] = '';
            if($i+1 == $list_cnt){

              $shipam = $order->shippingamount;
              $data_excel[$l][] = (string)$shipam.' '; //rate shippingamount
            }else{
              $rate = $order->list[$i]->totalprice / $order->list[$i]->number;
              $data_excel[$l][] = $rate.' '; //rate price
            }
            $data_excel[$l][] = 'WEB_CONSUMER';
            $data_excel[$l][] = (string)'9999999999999';  //$order->customeridnumber
            $data_excel[$l][] = '00000';
            $data_excel[$l][] = '';
            $data_excel[$l][] = '200';

            $sale_channel = strtoupper($order->saleschannel); //Project Code
            switch ($sale_channel) {
              case 'SHOPEE':
                $data_excel[$l][] = 'W1000001';
                break;
              case 'LAZADA':
                $data_excel[$l][] = 'W1000002';
                break;
              case 'SHOPIFY':
                $data_excel[$l][] = 'W1000003';
                break;
              case 'LINE':
                $data_excel[$l][] = 'W1000004';
                break;
              case 'NOCNOC':
                $data_excel[$l][] = 'W1000005';
                break;
              case 'CENTRAL ONLINE':
                $data_excel[$l][] = 'W1000006';
                break;
              case '24 SHOPPING':
                $data_excel[$l][] = 'W1000007';
                break;
              case 'SOCIAL COMMERCE':
                $data_excel[$l][] = 'W1000008';
                break;
              case 'BUSINESS PARTNER':
                $data_excel[$l][] = 'W1000009';
                break;
              case 'INTERNAL SALE':
                $data_excel[$l][] = 'W1000010';
                break;
              case 'TIKTOK':
                $data_excel[$l][] = 'W1000011';
                break;

              default:
                $data_excel[$l][] = $sale_channel;
                break;
            }

            $data_excel[$l][] = 'DIS_PROMO';

            if($i+1 == $list_cnt){ //sellerdiscount
              $data_excel[$l][] = '0 ';
            }else{
              //$disc[] = $order->list[$i]->discount;
              $discnt = '';
              if($order->discount != ''){
                $discnt = $order->sellerdiscount;
                if($sale_channel == 'NOC NOC'){
                  $discnt = $order->discountamount;
                }
              }else{
                $discnt = '0';
              }
              $data_excel[$l][] = $discnt.' '; //Discount Amount
            }

            $data_excel[$l][] = $order->shippingphone ?? '';
            $data_excel[$l][] = $order->shippingphone ?? '';

            switch ($sale_channel) { //bank code
              case 'SHOPEE':
                $data_excel[$l][] = 'SHOPEE';
                break;
              case 'LAZADA':
                $data_excel[$l][] = 'LAZADA';
                break;
              case 'CENTRAL ONLINE':
                $data_excel[$l][] = 'CENTRAL';
                break;
              case 'NOC NOC':
                $data_excel[$l][] = 'NocNoc';
                break;
              case 'SHOPIFY':
                $data_excel[$l][] = '2C2P';
                break;

              default:
                $data_excel[$l][] = $order->saleschannel;
                break;
            }

            $shipchan = strtoupper($order->shippingchannel);
            if(strtoupper($order->saleschannel) == 'LAZADA'){
              $shipchan = 'LEX';
            }

            //Carrier code
            if(Str::contains($shipchan, 'KERRY')){
              $data_excel[$l][] = '0111_KER';
            }elseif(Str::contains($shipchan, 'NINJA')){
              $data_excel[$l][] = '0114_NINJA';
            }elseif(Str::contains($shipchan, 'J&T')){
              $data_excel[$l][] = '0116_J&T';
            }elseif(Str::contains($shipchan, 'LEX')){
              $data_excel[$l][] = '0117_LEX';
            }elseif(Str::contains($shipchan, 'SHOPEE')){
              $data_excel[$l][] = '0118_SHOPEE';
            }elseif(Str::contains($shipchan, 'DHL')){
              $data_excel[$l][] = '0119_DHL';
            }elseif(Str::contains($shipchan, 'BI')){
              $data_excel[$l][] = '0121_BI';
            }elseif(Str::contains($shipchan, 'FLEET')){
              $data_excel[$l][] = 'OTHER';
            }elseif(Str::contains($shipchan, 'FLASH')){
              $data_excel[$l][] = '0118_SHOPEE';
            }elseif(Str::contains($shipchan, 'IDEA')){
              $data_excel[$l][] = '0121_BI';
            }elseif(Str::contains($shipchan, 'SPX')){
              $data_excel[$l][] = '0118_SHOPEE';
            }elseif(strtoupper($order->shippingchannel) == 'STANDARD DELIVERY'){
              $data_excel[$l][] = 'OTHER';
            }else{
              $data_excel[$l][] = $order->shippingchannel;
            }

            $data_excel[$l][] = '1';
            $data_excel[$l][] = $order->customerpostcode ?? $order->shippingpostcode;
            $data_excel[$l][] = $order->customeremail ?? '';
            $data_excel[$l][] = $order->customeridnumber ?? '';
            $data_excel[$l][] = $order->tag[0] ?? '';
            $data_excel[$l][] = $order->customerbrancename ?? '';
            $data_excel[$l][] = $order->customerbranceno ?? '';

            $l++;
        }

      }

      $excel = false;
      if(count($data_excel) > 0){
        $excel = $this->exportExcel($data_excel, $file_name);
      }

      return $excel;

    }

    public function onlineorder_manual_get(){

      $new_order = [];
      $insert_order = [];
      $page = 1;
      $order_total = 0;
      $limit = 500;
      $file_name = date('dmy')."_".date('His').".xlsx";
      $response = $this->get_order_api($page); //get order by ZORT
      $order_total = $response->count;
      $orion_excel = false;

      $loop = ceil($order_total / $limit);
      if($loop == 0){
        $loop = 1;
      }

      for ($i=0; $i < $loop; $i++) {
        $response = $this->get_order_api($i+1);
        $orders = $response->list;
        foreach ($orders as $key => $order) {
          $check_dup = Order::where('order_number', $order->number)->where('del', 0)->count();
          if($check_dup == 0){
            $new_order[] = $orders[$key];
            $insert_order[] = [
              'order_number' => $orders[$key]->number,
              'filename' => $file_name,
              'created_at' => date('Y-m-d H:i:s'),
            ];
          }
        }
      }

      $new_order_count = count($new_order);
      $orion_excel = $this->generate_excel_orion($new_order, $file_name); //Orion Excel Exports
      $sap_excel = $this->generate_excel_sap($new_order, $file_name); //SAP Excel Exports

      if($orion_excel){
        if(count($insert_order) > 0){
          Order::insert($insert_order);
        }
      }

      if($orion_excel){
        $this->sendLine($new_order_count);
        $this->slackService->slackApi("The total number of orders is " . $new_order_count);
      }else{
        $this->sendLine("0");
      }

      echo "success";

    }

    public function sendLine($messages = 'Hi Apirak'){

      $to = 'C62baaa9fee015c1bd510b1933b0c0ba9'; //groupid from web hook
      $line_access_token = 'XukptniGPQZgjcusCfxa7FUMhwiBKnyiBjFsISFTe8+y3mgI/xdE9xcl/aNNrNzTcBn3fm4EsmdPHX0EM4EWwdTWGefp47HwH0mW7bWE41hKSnKw2h4imQDmcB1H87Sng8/5CYQafuFbknsRta4b/gdB04t89/1O/w1cDnyilFU=';
      $curl = curl_init();
      $postfields = '{
          "to": "'.$to.'",
          "messages":[
              {
                  "type":"text",
                  "text":"'.$messages.'"
              }
          ]
      }';

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.line.me/v2/bot/message/push',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postfields,
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
          'Authorization: Bearer ' . $line_access_token
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

    }

    //header orion excel
    public function exportExcel($data_excel, $file_name){

      $header[] = [
        'Company Code','SO Date','Doc Src Locn Code','Sales Location Code','Transaction Code','LPO Number',
        'Res Location','Customer Code','Ship To Address','Ship Contact Person','Ship Address1','Ship Address2',
        'Bill Contact Person','Bill To Address','Bill Address1','Bill Address2','Currency Code','Delivery  Date',
        'Shipment Mode','Sales Man','Delivery Terms','Inhouse Code','PartShip Y/N','Annotation','Item code',
        'Grade Code 1','Grade Code 2','Uom Code','Qty','Loose Qty','Rate','Price Code','Customer Tax Id',
        'Customer Branch Id','Form Code','Invoice Handling','Project Code','Discount Code','Discount Amount',
        'Ship Phone','Bill Phone','Bank Code','Carrier Code','Priority','POST_CODE','SHIP_EMAIL_ID',
        'Tax ID','Request INV.','Brance Name','Brance No.'
      ];
      $data_export[] = $header;
      $data_export[] = $data_excel;
      $export = new ExportOrders($data_export);
      return Excel::store($export, $file_name, 'path_export');

    }
    //header sap excel
    public function exportExcelSAP($data_excel, $file_name){

      $header[] = [
        'SO Date',
        'Doc Src Locn Code',
        'Sales Location Code',
        'Transaction Code',
        'LPO Number',
        'Customer Code',
        'Ship To Address',
        'Ship Contact Person',
        'Ship Address1',
        'Ship Address2',
        'Ship Address3',
        'Ship Address4',
        'Bill to code ',
        'Bill Contact Person',
        'Bill To Address1',
        'Bill Address2',
        'Bill Address3',
        'Bill Address4',
        'Bill-to Postal code',
        'Currency Code',
        'Delivery  Date',
        'Shipment Mode',
        'Delivery Terms',
        'Item code',
        'Uom Code',
        'Qty',
        'Rate',
        'Price Code',
        'Customer Tax Id',
        'Customer Branch Id',
        'Discount Code',
        'Discount Amount',
        'Ship Phone',
        'Bill Phone',
        'Carrier Code',
        'Post Code',
        'Freight Code',
        'Freight Amount',
      ];
      $data_export[] = $header;
      $data_export[] = $data_excel;
      $export = new ExportOrdersSAP($data_export);

      return Excel::store($export, $file_name, 'path_export');

    }
}
