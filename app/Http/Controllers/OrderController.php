<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use File;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $orders = Order::groupBy('filename')->orderBy('id','desc')->limit(20)->get();

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
}
