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
      //$request->session()->flush();
      $soh_txn_code = $request->soh_txn_code ?? '';
      $soh_no = $request->soh_no ?? '';
      $soh_cust_code = $request->soh_cust_code ?? '';
      $soh_cust_name = $request->soh_cust_name ?? '';
      $soh_sm_code = $request->soh_sm_code ?? '';
      $sm_name = $request->sm_name ?? '';
      $po_number = $request->po_number ?? '';
      $page = 5;
      $last_upd =so_status::first();
      $last_upd = $last_upd->created_at ?? '';

      if($soh_txn_code == '' && $soh_no == '' && $soh_cust_code == '' && $soh_cust_name == '' && $soh_sm_code == '' && $sm_name =='' && $po_number ==''){
        return view('pages.so_status.index',['data' => [], 'last_upd' => $last_upd]);
      }

      //$q = so_status::query();
      $q = DB::table('zhinsd_va05 as a')
        ->leftJoin('hww_sd_06 as b', function ($join) {
            $join->on('b.SalesDoc', '=', 'a.sd_document')
                 ->on('b.Material', '=', 'a.material');
        })
        ->leftJoin('hww_sd_custlis as c', 'c.IDMA_ZI', '=', 'b.ZE')
        ->select([
            'a.id',
            'a.sales_document_type AS SOH_TXN_CODE',
            'a.sd_document AS SOH_NO',
            'a.document_date AS SOH_DT',
            'a.purchase_order_no AS SOH_LPO_NO',
            'a.sold_to_party AS SOH_CUST_CODE',
            'a.name1 AS SOH_CUST_NAME',
            'b.ZE AS SOH_SM_CODE',
            'c.IDMA_ZI_NAME AS SM_NAME',
            'a.status AS OVERALL_STATUS'
        ]);
      if($soh_txn_code != ''){ $q->Where('sales_document_type',$soh_txn_code);}
      if($soh_no != ''){ $q->Where('sd_document',$soh_no);}
      if($po_number != ''){ $q->Where('purchase_order_no',$po_number);}
      if($soh_cust_code != ''){ $q->Where('sold_to_party',$soh_cust_code); }
      if($soh_cust_name != ''){ $q->Where('name1','like','%'.$soh_cust_name.'%'); }
      if($soh_sm_code != ''){ $q->Where('SOH_SM_CODE',$soh_sm_code);}
      if($sm_name != ''){ $q->Where('SM_NAME','like','%'.$sm_name.'%',); }

      $q->groupBy('a.sd_document','a.sales_document_type')->orderBy('a.sd_document','DESC');
      //$sostatus = $q->limit(5)->get();
      $sostatus = $q->paginate($page);

      $kl = [];
      $kp = [];
      foreach ($sostatus as $key => $value) {
        //$kl[$value->SOH_NO][] = $value->POD_STATUS;
        $kl[$value->SOH_NO][] = '';
      }

      foreach ($sostatus as $key => $value) {
        //$kp[$value->SOH_NO][] = $value->WAVE_STS;
        $kp[$value->SOH_NO][] = '';
      }
      return view('pages.so_status.index',['data' => $sostatus, 'last_upd' => $last_upd, 'kl' => $kl, 'kp' => $kp,'page' => $page]);
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
        //$q = so_status::where('SOH_NO', $SOH_NO)->where('SOH_TXN_CODE',$SOH_TXN_CODE)->get();
        $q = DB::table('zhinsd_va05 as a')
        ->select([
            'a.sales_document_type as SOH_TXN_CODE',
            'a.sd_document as SOH_NO',
            'a.document_date as SOH_DT',
            'a.purchase_order_no as SOH_LPO_NO',
            'a.sold_to_party as SOH_CUST_CODE',
            'a.name1 as SOH_CUST_NAME',
            'b.ZE as SOH_SM_CODE',
            'c.IDMA_ZI_NAME as SM_NAME',
            'a.status as OVERALL_STATUS',
            'd.invoiced_quantity as INV_QTY',
            'e.FollOndoc as DO_NO',
            'e.Createdon as DO_DT',
            'd.billing_type as INV_NO',
            'd.billing_date as INV_DT',
            'a.material as SOI_ITEM_CODE',
            'a.description as SOI_ITEM_DESC',
            'a.order_quantity as SOI_QTY',
            DB::raw("'N/A' as WAVE_STS"),
            DB::raw("'N/A' as WWH_DT"),
            DB::raw("'N/A' as POD_STATUS"),
        ])
        ->leftJoin('hww_sd_06 as b', function($join) {
            $join->on('b.SalesDoc', '=', 'a.sd_document')
                 ->on('b.Material', '=', 'a.material');
        })
        ->leftJoin('hww_sd_custlis as c', 'c.IDMA_ZI', '=', 'b.ZE')
        ->leftJoin('zhaasd_inv as d', function($join) {
            $join->on('d.sales_document', '=', 'a.sd_document')
                 ->on('d.material', '=', 'a.material');
        })
        ->leftJoin('zhwwsd_ob_wo_i as e', function($join) {
            $join->on('e.SalesDoc', '=', 'a.sd_document')
                 ->on('e.Material', '=', 'a.material');
        })
        ->where('a.sd_document', $SOH_NO)
        ->where('a.sales_document_type',$SOH_TXN_CODE)
        ->get();

        foreach ($q as $key => $value) {
          $kl[$value->SOI_ITEM_CODE][] = $value->INV_QTY;

        }
        //dd($q);
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
