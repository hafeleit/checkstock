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
      //$request->session()->flush();
      $soh_txn_code = $request->soh_txn_code ?? '';
      $soh_no = $request->soh_no ?? '';
      $soh_cust_code = $request->soh_cust_code ?? '';
      $soh_cust_name = $request->soh_cust_name ?? '';
      $soh_sm_code = $request->soh_sm_code ?? '';
      $sm_name = $request->sm_name ?? '';

      $last_upd =so_status::first();
      $last_upd = $last_upd->created_at;

      if($soh_txn_code == '' && $soh_no == '' && $soh_cust_code == '' && $soh_cust_name == '' && $soh_sm_code == '' && $sm_name ==''){
        return view('pages.so_status.index',['data' => [], 'last_upd' => $last_upd]);
      }

      $q = so_status::query();
      if($soh_cust_name != ''){ $q->Where('SOH_NO',$soh_cust_name); }
      if($soh_no != ''){
        $q->Where('SOH_NO',$soh_no);
      }
      if($soh_cust_code != ''){ $q->Where('SOH_CUST_CODE',$soh_cust_code); }
      if($soh_cust_name != ''){ $q->Where('SOH_CUST_NAME',$soh_cust_name); }
      if($soh_sm_code != ''){ $q->Where('SOH_SM_CODE',$soh_sm_code); }
      if($sm_name != ''){ $q->Where('SM_NAME',$sm_name); }
      $q->groupBy('SOH_NO','POD_STATUS')->orderBy('SOH_NO','DESC');
      $sostatus = $q->get();
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
    public function show(Request $request)
    {
      $soh_no = $request->SOH_NO ?? '';
      $pos_status = $request->POD_STATUS ?? '';

      $kl = [];
      if($soh_no != ''){
        $q = so_status::where('SOH_NO', $soh_no)->where('POD_STATUS',$pos_status)->get();

        foreach ($q as $key => $value) {
          $kl[$value->SOI_ITEM_CODE][] = $value->INV_QTY;

        }
        return view('pages.so_status.detail',['data'=>$q, 'kl' => $kl]);
      }

      return abort(404);

        /*return response()->json([
          'status' => true,
          'data' => $so_status,
        ]);*/
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
