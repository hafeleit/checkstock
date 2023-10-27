<?php

namespace App\Http\Controllers;

use App\Models\so_status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $soh_cust_name = $request->soh_cust_name ?? '';
      $soh_no = $request->soh_no ?? '';
      $soh_cust_code = $request->soh_cust_code ?? '';
      $soh_cust_name = $request->soh_cust_name ?? '';
      $soh_code = $request->soh_code ?? '';
      $sm_name = $request->sm_name ?? '';

      $q = so_status::query();
      if($soh_cust_name != ''){ $q->orWhere('SOH_NO',$soh_cust_name); }
      if($soh_no != ''){ $q->orWhere('SOH_NO',$soh_no); }
      if($soh_cust_code != ''){ $q->orWhere('SOH_NO',$soh_cust_code); }
      if($soh_cust_name != ''){ $q->orWhere('SOH_NO',$soh_cust_name); }
      if($soh_code != ''){ $q->orWhere('SOH_NO',$soh_code); }
      if($sm_name != ''){ $q->orWhere('SOH_NO',$sm_name); }
      $sostatus = $q->paginate(5);
      $last_upd = date('d-m-Y H:i:s', strtotime($sostatus[0]->created_at));
      return view('pages.so_status.index',['data' => $sostatus, 'last_upd' => $last_upd]);
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
    public function show(so_status $so_status)
    {

        return response()->json([
          'status' => true,
          'data' => $so_status,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(so_status $so_status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, so_status $so_status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(so_status $so_status)
    {
        //
    }
}
