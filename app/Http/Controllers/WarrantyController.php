<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.warranty.index');
    }

    public function check_warranty()
    {
        return view('pages.warranty.check');
    }

    public function search_warranty(Request $request)
    {
        if($request->search != ''){
          $query = Warranty::where('serial_no', $request->search);
          $count = $query->count();
          $data = $query->first();
          return view('pages.warranty.search',['data' => $data, 'count'=>$count]);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
           'file' => 'required|mimes:jpg,jpeg,png',
           'name' => 'required',
           'addr' => 'required',
           'tel' => 'required',
           'serial_no' => 'required',
           'order_channel' => 'required',
           'order_number' => 'required',
        ]);

        if($request->file('file')) {

          $file = $request->file('file');
          $fileName = $request->serial_no . '.'. $file->getClientOriginalExtension();
          $destinationPath = 'public';
          $file->move(public_path('storage/img/warranty'),$fileName);

        }

        $wanranty = $request->all();
        $wanranty['file_name'] = $fileName;
        $wanranty['created_at'] = date('Y-m-d H:i:s');
        unset($wanranty['_token']);
        unset($wanranty['file']);

        Warranty::insert($wanranty);

        return back()->with('success','You have successfully applied for a warranty.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warranty $warranty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warranty $warranty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warranty $warranty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warranty $warranty)
    {
        //
    }
}