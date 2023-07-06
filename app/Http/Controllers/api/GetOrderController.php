<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Exports\ExportOrders;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use App\Models\Order;

class GetOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function sendLine($messages = 'Hi Apirak'){

      //web hook https://webhook.site/#!/4711aed3-29c3-4283-b2da-31280d3d295b/d440c9e9-7cc4-4ce6-955e-e19b451f3d85/1
      //$to = 'U69527e0c55f3d0c39ea5903b8e11094c'; //userid

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
      ];
      $data_export[] = $header;
      $data_export[] = $data_excel;
      $export = new ExportOrders($data_export);
      $file_name = date('dmy')."_".date('His').".xlsx";
      return Excel::store($export, $file_name, 'path_export');

    }

    public function index()
    {

      try {

        $storename = "hthecommerce@hafele.co.th";
        $apikey = "9mVH8tWzYxQ6CeAfY6jX3XxW4AJcnOJ6DtacDQpAmac=";
        $apisecret = "zPUa1VHcXo8hppy6M8zu7ANem61Yj82ckBReShjXycY=";

        $order_status = 0;
        $start_date = '2023-07-01';
        $today = date('Y-m-d');
        $endpoint = '/Order/GetOrders?updatedafter='.$start_date.'&updatedbefore='.$today.'&limit=100&status='.$order_status;
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
          ];
          $list_cnt = count($order->list) + 1;
          for ($i=0; $i < $list_cnt; $i++) {
            $data_excel[$l][] = 'HTH';
            $data_excel[$l][] = (string)date('d/m/y');
            $data_excel[$l][] = (string)'1';
            $data_excel[$l][] = (string)'2';
            $data_excel[$l][] = 'SO_WEB';
            $data_excel[$l][] = (string)$order->number;
            $data_excel[$l][] = (string)'2';
            $data_excel[$l][] = (string)'157019';
            $data_excel[$l][] = '157019-201';
            $data_excel[$l][] = $order->customername ?? '';
            $data_excel[$l][] = $order->shippingaddress ?? '';
            $data_excel[$l][] = '';
            $data_excel[$l][] = $order->customername ?? '';
            $data_excel[$l][] = '157019-10';
            $data_excel[$l][] = $order->shippingaddress ?? '';
            $data_excel[$l][] = '';
            $data_excel[$l][] = 'THB';
            $data_excel[$l][] = (string)date('d/m/y');
            $data_excel[$l][] = 'BY 3PL';
            $data_excel[$l][] = (string)'3040';
            $data_excel[$l][] = 'EX WORKS';
            $data_excel[$l][] = 'BANGKOK';
            $data_excel[$l][] = 'N';
            $data_excel[$l][] = $order->shippingchannel ?? '';
            $data_excel[$l][] = ($i+1 == $list_cnt) ? (string)'605' : (string)$order->list[$i]->sku; //sku
            $data_excel[$l][] = '';
            $data_excel[$l][] = '';
            $data_excel[$l][] = '';
            $data_excel[$l][] = ($i+1 == $list_cnt) ? (string)'1' : (string)$order->list[$i]->number; //number
            $data_excel[$l][] = '';
            if($i+1 == $list_cnt){

              $shipam = $order->shippingamount . '.00';
              //dd($order->shippingamount);
              $data_excel[$l][] = (string)$shipam; //rate shippingamount
            }else{
              $data_excel[$l][] = (string)$order->list[0]->totalprice; //rate price
            }
            $data_excel[$l][] = 'WEB_CONSUMER';
            $data_excel[$l][] = (string)'9999999999999';
            $data_excel[$l][] = (string)'00000';
            $data_excel[$l][] = '';
            $data_excel[$l][] = (string)'200';

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
                $data_excel[$l][] = 'W10000010';
                break;

              default:
                $data_excel[$l][] = $sale_channel;
                break;
            }

            $data_excel[$l][] = 'DIS_PROMO';
            $data_excel[$l][] = (string)$order->sellerdiscount;//sellerdiscount
            $data_excel[$l][] = $order->customerphone ?? '';
            $data_excel[$l][] = $order->customerphone ?? '';

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

            if(Str::contains($shipchan, 'KERRY')){
              $data_excel[$l][] = '0111_KER';
            }elseif(Str::contains($shipchan, 'NINJA')){
              $data_excel[$l][] = '0114_NINJA';
            }elseif(Str::contains($shipchan, 'J&T')){
              $data_excel[$l][] = '0116_J&t';
            }elseif(Str::contains($shipchan, 'LEX')){
              $data_excel[$l][] = '0117_LEX';
            }elseif(Str::contains($shipchan, 'SHOPEE')){
              $data_excel[$l][] = '0118_SHOPEE';
            }elseif(Str::contains($shipchan, 'DHL')){
              $data_excel[$l][] = '0119_DHL';
            }elseif(Str::contains($shipchan, 'BI')){
              $data_excel[$l][] = '0121_BI';
            }else{
              $data_excel[$l][] = $order->shippingchannel;
            }

            $data_excel[$l][] = (string)'1';
            $data_excel[$l][] = (string)$order->customerpostcode;
            $data_excel[$l][] = '';

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
          //$this->sendLine("Total number of orders: " . $new_order_count);
        }else{
          //$this->sendLine("Total number of orders: 0");
        }

        return "Total number of orders: " . $new_order_count;

      } catch (\Exception $e) {
        return response()->json([
          'status' => 0,
          'errors' => $e->getMessage()
        ]);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
