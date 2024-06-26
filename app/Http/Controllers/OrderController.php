<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use File;
use DB;
use App\Exports\ExportOrders;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $orders = Order::groupBy('filename')->orderBy('id','desc')->select(DB::raw("orders.*, COUNT(orders.filename) AS cnt"))->limit(20)->get();

      return view('pages.onlineorder.index',compact('orders'));
    }

    public function download($file){

      $res = $this->file_fetch($file);
    	if($res){
    		return response()->download(storage_path('app/export/orders/'.$file));
    	}else{
    		return "NO such File Exists";
    	}

   }


   public function file_fetch($file) {

        $destinationPath = storage_path('app/export/orders/'.$file);

        if(!File::exists($destinationPath) && !is_dir($destinationPath)){
          return false;
        }else{
          return true;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function onlineorder_manual_get(){

      $storename = "hthecommerce@hafele.co.th";
      $apikey = "by3oFDNKYKNb8PHSRTM/k5IxHuuHT2RKTaPqyqWwuE=";
      $apisecret = "NOnFem169tqnU1VzMbFcd0YqrStaIb65ofmyHN3IQDs=";

      $order_status = 0;
      $start_date = '2023-07-01';
      $today = date('Y-m-d');
      $endpoint = '/Order/GetOrders?updatedafter='.$start_date.'&updatedbefore='.$today.'&limit=2000&status='.$order_status;
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

      $orders_count = $response->count;
      $orders = $response->list;
      $new_order = [];
      $insert_order = [];
      $data_excel = [];

      foreach ($orders as $key => $order) {
        $check_dup = Order::where('order_number', $order->number)->where('del', 0)->count();
        if($check_dup == 0){
          $new_order[] = $orders[$key];
        }
      }
      $new_order_count = count($new_order);
      $l = 0;
      $file_name = date('dmy')."_".date('His').".xlsx";

      foreach ($new_order as $key2 => $order) {
        $insert_order[] = [
          'order_number' => $order->number,
          'filename' => $file_name,
          'created_at' => date('Y-m-d H:i:s'),
        ];
        $list_cnt = count($order->list) + 1;

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


      if(count($insert_order) > 0){
        Order::insert($insert_order);
      }
      $excel = false;
      if(count($data_excel) > 0){
        $excel = $this->exportExcel($data_excel);
      }

      if($excel){
        $this->sendLine($new_order_count);
      }else{
        $this->sendLine("Orders: 0");
      }

      return redirect()->back()->with('success', $new_order_count);
      //return "Total orders: " . $new_order_count;

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

    public function exportExcel($data_excel){

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
      $file_name = date('dmy')."_".date('His').".xlsx";
      return Excel::store($export, $file_name, 'path_export');

    }
}
