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

        if($request->file('file')) {

          $file = $request->file('file');
          $fileName = $request->order_number . '.'. $file->getClientOriginalExtension();
          $destinationPath = 'uploads';
          $file->move($destinationPath,$fileName);
          
        }

        dd($request->all());
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
