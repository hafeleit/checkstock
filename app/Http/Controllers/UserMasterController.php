<?php

namespace App\Http\Controllers;

use App\Models\UserMaster;
use Illuminate\Http\Request;

use App\Imports\UserMasterImport;
use Maatwebsite\Excel\Facades\Excel;

class UserMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function import(Request $request)
    {

        UserMaster::truncate();
        Excel::import(new UserMasterImport,request()->file('file'));

        return back()->with('succes','Import successfully');;
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
    public function show(UserMaster $userMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserMaster $userMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserMaster $userMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserMaster $userMaster)
    {
        //
    }
}
