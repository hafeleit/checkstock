<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Exports\ExportOrders;
use Maatwebsite\Excel\Facades\Excel;

class GetOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $testdata[] = [
        'T','R','W','F'
      ];

      $testdata[] = [
        '1','2','3','4'
      ];
      $export = new ExportOrders($testdata);

      return Excel::store($export, 'invoices2.xlsx', 'path_export');

      try {

        $storename = "hthecommerce@hafele.co.th";
        $apikey = "9mVH8tWzYxQ6CeAfY6jX3XxW4AJcnOJ6DtacDQpAmac=";
        $apisecret = "zPUa1VHcXo8hppy6M8zu7ANem61Yj82ckBReShjXycY=";
        $order_status = 3;
        $endpoint = '/Order/GetOrders?status='.$order_status.'&limit=100';
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
        $count = $response->count;
        $orders = $response->list;

        return $orders;
        return response()->json([
          'status' => 1,
          'count' => $count,
          'orders' => $orders
        ]);

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
