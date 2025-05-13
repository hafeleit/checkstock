<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use Illuminate\Http\Request;
use Image;

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
          $query = Warranty::where('serial_no', $request->search)
                    ->orWhere('tel', $request->search);
          $count = $query->count();
          $data = $query->get();
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
           'file' => 'required|image|mimes:jpeg,png,jpg|max:10048',
           'file2' => 'image|mimes:jpeg,png,jpg|max:10048',
           'file3' => 'image|mimes:jpeg,png,jpg|max:10048',
           'file4' => 'image|mimes:jpeg,png,jpg|max:10048',
           'file5' => 'image|mimes:jpeg,png,jpg|max:10048',
           'name' => 'required',
           'addr' => 'required',
           'tel' => 'required',
           'serial_no' => 'unique:warranties,serial_no',
           'order_channel' => 'required',
           'order_number' => 'required',
        ],[
          'unique' => 'หมายเลขซีเรียลได้ถูกนำไปใช้แล้ว'
        ]);

        if($request->file('file')) {
          $image  = $request->file('file');
          $fileName = $request->serial_no . '.'. $image->getClientOriginalExtension();
          $resize_image = Image::make($image->getRealPath());
          $resize_image->resize(1000, 1900);
          $resize_image->save( 'storage/img/warranty/'.$fileName ,60, 'jpg');
        }

        if($request->file('file2')) {
          $image  = $request->file('file2');
          $fileName2 = $request->serial_no . '_2.'. $image->getClientOriginalExtension();
          $resize_image = Image::make($image->getRealPath());
          $resize_image->resize(1000, 1900);
          $resize_image->save( 'storage/img/warranty/'.$fileName2 ,60, 'jpg');
        }

        if($request->file('file3')) {
          $image  = $request->file('file3');
          $fileName3 = $request->serial_no . '_3.'. $image->getClientOriginalExtension();
          $resize_image = Image::make($image->getRealPath());
          $resize_image->resize(1000, 1900);
          $resize_image->save( 'storage/img/warranty/'.$fileName3 ,60, 'jpg');
        }

        if($request->file('file4')) {
          $image  = $request->file('file4');
          $fileName4 = $request->serial_no . '_4.'. $image->getClientOriginalExtension();
          $resize_image = Image::make($image->getRealPath());
          $resize_image->resize(1000, 1900);
          $resize_image->save( 'storage/img/warranty/'.$fileName4 ,60, 'jpg');
        }

        if($request->file('file5')) {
          $image  = $request->file('file5');
          $fileName5 = $request->serial_no . '_5.'. $image->getClientOriginalExtension();
          $resize_image = Image::make($image->getRealPath());
          $resize_image->resize(1000, 1900);
          $resize_image->save( 'storage/img/warranty/'.$fileName5 ,60, 'jpg');
        }

        $wanranty = $request->all();
        $wanranty['file_name'] = $fileName;
        $wanranty['file_name2'] = $fileName2 ?? '';
        $wanranty['file_name3'] = $fileName3 ?? '';
        $wanranty['file_name4'] = $fileName4 ?? '';
        $wanranty['file_name5'] = $fileName5 ?? '';
        $wanranty['created_at'] = date('Y-m-d H:i:s');
        unset($wanranty['_token']);
        unset($wanranty['file']);
        unset($wanranty['file2']);
        unset($wanranty['file3']);
        unset($wanranty['file4']);
        unset($wanranty['file5']);

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
