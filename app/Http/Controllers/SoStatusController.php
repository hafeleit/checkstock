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
      $last_upd = DB::table('ZHINSD_VA05')->first();
      $last_upd = $last_upd->created_at ?? '';

      if($soh_txn_code == '' && $soh_no == '' && $soh_cust_code == '' && $soh_cust_name == '' && $soh_sm_code == '' && $sm_name =='' && $po_number ==''){
        return view('pages.so_status.index',['data' => [], 'last_upd' => $last_upd]);
      }

      //$q = so_status::query();
      $q = DB::table('ZHINSD_VA05 as a')
        ->leftJoin('HWW_SD_06 as b', function ($join) {
            $join->on('b.SalesDoc', '=', 'a.sd_document')
                 ->on('b.Material', '=', 'a.material');
        })
        ->leftJoin('HWW_SD_CUSTLIS as c', 'c.IDMA_ZI', '=', 'b.ZE')
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
      if($soh_txn_code != ''){ $q->Where('a.sales_document_type',$soh_txn_code);}
      if($soh_no != ''){ $q->Where('a.sd_document',$soh_no);}
      if($po_number != ''){ $q->Where('a.purchase_order_no',$po_number);}
      if($soh_cust_code != ''){ $q->Where('a.sold_to_party',$soh_cust_code); }
      if($soh_cust_name != ''){ $q->Where('a.name1','like','%'.$soh_cust_name.'%'); }
      if($soh_sm_code != ''){ $q->Where('b.ZE',$soh_sm_code);}
      if($sm_name != ''){ $q->Where('c.IDMA_ZI_NAME','like','%'.$sm_name.'%',); }

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

        $q = DB::table('ZHINSD_VA05 as a')
        ->selectRaw("
            a.sales_document_type AS SOH_TXN_CODE,
            a.sd_document AS SOH_NO,
            a.document_date AS SOH_DT,
            a.purchase_order_no AS SOH_LPO_NO,
            a.sold_to_party AS SOH_CUST_CODE,
            a.name1 AS SOH_CUST_NAME,
            a.status AS OVERALL_STATUS,
            a.material AS SOI_ITEM_CODE,
            a.description AS SOI_ITEM_DESC,
            FORMAT(SUM(a.order_quantity), 2) AS SOI_QTY,
            GROUP_CONCAT(DISTINCT a.status ORDER BY a.status SEPARATOR ', ') AS ALL_STATUSES,
            b.ZE AS SOH_SM_CODE,
            c.IDMA_ZI_NAME AS SM_NAME,
            FORMAT(SUM(d.invoiced_quantity), 2) AS INV_QTY,
            CONCAT(d.billing_type, '-', d.billing_document) AS INV_NO,
            d.billing_date AS INV_DT,
            e.FollOndoc AS DO_NO,
            e.Createdon AS DO_DT,
            'N/A' AS WAVE_STS,
            'N/A' AS WWH_DT,
            'N/A' AS POD_STATUS
        ")
        ->leftJoin('HWW_SD_06 as b', function ($join) {
            $join->on('b.SalesDoc', '=', 'a.sd_document')
                 ->on('b.Material', '=', 'a.material');
        })
        ->leftJoin('HWW_SD_CUSTLIS as c', 'c.IDMA_ZI', '=', 'b.ZE')
        ->leftJoin('ZHAASD_INV as d', function ($join) {
            $join->on('d.sales_document', '=', 'a.sd_document')
                 ->on('d.material', '=', 'a.material');
        })
        ->leftJoin('ZHWWSD_OB_WO_I as e', function ($join) {
            $join->on('e.SalesDoc', '=', 'a.sd_document')
                 ->on('e.Material', '=', 'a.material');
        })
        ->where('a.sd_document', $SOH_NO)
        ->where('a.sales_document_type',$SOH_TXN_CODE)
        ->groupBy('a.material')
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
