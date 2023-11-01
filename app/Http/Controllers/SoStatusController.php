<?php

namespace App\Http\Controllers;

use App\Models\so_status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class SoStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $request->session()->flush();
      $soh_txn_code = $request->soh_txn_code ?? '';
      $soh_no = $request->soh_no ?? '';
      $soh_cust_code = $request->soh_cust_code ?? '';
      $soh_cust_name = $request->soh_cust_name ?? '';
      $soh_sm_code = $request->soh_sm_code ?? '';
      $sm_name = $request->sm_name ?? '';
      $po_number = $request->po_number ?? '';

      $last_upd =so_status::first();
      $last_upd = $last_upd->created_at;

      if($soh_txn_code == '' && $soh_no == '' && $soh_cust_code == '' && $soh_cust_name == '' && $soh_sm_code == '' && $sm_name =='' && $po_number ==''){
        return view('pages.so_status.index',['data' => [], 'last_upd' => $last_upd]);
      }

      $q = so_status::query();
      if($soh_txn_code != ''){ $q->Where('SOH_TXN_CODE',$soh_txn_code);}
      if($soh_no != ''){ $q->Where('SOH_NO',$soh_no);}
      if($po_number != ''){ $q->Where('SOH_LPO_NO',$po_number);}
      if($soh_cust_code != ''){ $q->Where('SOH_CUST_CODE',$soh_cust_code); }
      if($soh_cust_name != ''){ $q->Where('SOH_CUST_NAME','like','%'.$soh_cust_name.'%'); }
      if($soh_sm_code != ''){ $q->Where('SOH_SM_CODE',$soh_sm_code);}
      if($sm_name != ''){ $q->Where('SM_NAME','like','%'.$sm_name.'%',); }

      $q->groupBy('SOH_NO','SOH_TXN_CODE')->orderBy('SOH_NO','DESC');
      //$sostatus = $q->limit(5)->get();
      $sostatus = $q->paginate(10);

      $kl = [];
      $kp = [];
      foreach ($sostatus as $key => $value) {
        $kl[$value->SOH_NO][] = $value->POD_STATUS;
      }

      foreach ($sostatus as $key => $value) {
        $kp[$value->SOH_NO][] = $value->WAVE_STS;
      }
      return view('pages.so_status.index',['data' => $sostatus, 'last_upd' => $last_upd, 'kl' => $kl, 'kp' => $kp]);
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
      $SOH_NO = $request->SOH_NO ?? '';
      $SOH_TXN_CODE = $request->SOH_TXN_CODE ?? '';

      $kl = [];
      if($SOH_NO != ''){
        $q = so_status::where('SOH_NO', $SOH_NO)->where('SOH_TXN_CODE',$SOH_TXN_CODE)->get();

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
