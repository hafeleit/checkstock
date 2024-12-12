<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesUSIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $q = DB::table('OW_NEW_SALES_USI_WEB_HAFL')->select('created_at')->first();
        $created_at = $q->created_at;
        return view('pages.sales_usi.index',['created_at' => $created_at]);
    }

    public function search_usi(Request $request){

      $item_code = $request->item_code ?? '';
      // NEW SALES USI //
      /*
      $usi = DB::table('OW_NEW_SALES_USI_WEB_HAFL')->where('NSU_ITEM_CODE', $item_code);
      $count = $usi->count();

      if($count == 0){
        return response()->json([
          'status' => false,
          'count' => $count,
        ]);
      }
      $usis = $usi->first();*/
      $query = DB::table('zhwwbcquerydir as m')
        ->select([
            'm.material as NSU_ITEM_CODE',
            'm.kurztext as NSU_ITEM_NAME',
            'm.bun as NSU_ITEM_UOM_CODE',
            'm.pgr as NSU_PURCHASER',
            'm.product_group_manager as NSU_PROD_MGR',
            'm.su as NSU_PACK_UOM_CODE',
            'm.numer as NSU_CONV_BASE_UOM',
            'm.gross_weight as NSU_PACK_WEIGHT',
            'm.volume as NSU_PACK_VOLUME',
            'm.st as NSU_ITEM_STATUS',
            'm.lage as NSU_ITEM_INV_CODE',
            'p.planned_deliv_time as NSU_SUPP_REPL_TIME', // aplfz
            'p.minimum_order_qty as NSU_PURC_MOQ', // minbm
            'p.vendor_material_number as NSU_SUPP_ITEM_CODE', // zzhwwidnlf
            'i.unrestricted as NSU_FREE_STK_QTY',
            'mf.TDLINE as NSU_EXCL_REMARK',
            'pm.certificate as NSU_ITEM_BRAND',
            'od.customer_material as NSU_NEW_ITEM_CODE',
        ])
        ->distinct()
        ->leftJoin('zhaamm_ifvmg as p', 'p.material', '=', 'm.material')
        ->leftJoin('mb52 as i', 'i.material', '=', 'm.material')
        ->leftJoin('fis_mpm_out as mf', 'mf.MATNR', '=', 'm.material')
        ->leftJoin('zmm_matzert as pm', 'pm.material', '=', 'm.material')
        ->leftJoin('zhaasd_ord as od', 'od.material', '=', 'm.material')
        ->where('m.material', '=', '000.07.815');
        $usis = $query->first();
        $count = $query->count();

      // END NEW SALES USI //

      // MONTH //
      $query = DB::table('OW_MONTHWISE_STK_SUM_WEB_HAFL')->where('MSS_ITEM_CODE', $item_code);
      $monthwise = $query->first();
      $mss = [];
      $tot = [];
      $tot_qty_fields = 'MSS_TOT_QTY_';
      $tot_qty_ls_fields = 'MSS_TOT_QTY_LS_';
      $sold = [];
      $sold_qty_fields = 'MSS_SOLD_QTY_';
      $sold_qty_ls_fields = 'MSS_SOLD_QTY_LS_';

      $inv_fields = 'MSS_INV_COUNT_';
      $cust_fields = 'MSS_CUST_COUNT_';

      for ($i=1; $i <= 13; $i++) {
        $seq = str_pad($i, 2, "0", STR_PAD_LEFT);
        $tot_qty = $tot_qty_fields.$seq ?? '';
        $tot_qty_ls = $tot_qty_ls_fields.$seq ?? '';
        $inv = $inv_fields.$seq ?? '';
        $cust = $cust_fields.$seq ?? '';
        $tot['qty'][] = $monthwise->$tot_qty ?? '';
        $tot['ls'][] = $monthwise->$tot_qty_ls ?? '';
        $sold_qty = $sold_qty_fields.$seq ?? '';
        $sold_qty_ls = $sold_qty_ls_fields.$seq ?? '';
        $sold['qty'][] = $monthwise->$sold_qty ?? '';
        $sold['ls'][] = $monthwise->$sold_qty_ls ?? '';
        $mss['inv'][] = $monthwise->$inv ?? '';
        $mss['cust'][] = $monthwise->$cust ?? '';
      }

      $mss['tot'] = $tot;
      $mss['sold'] = $sold;
      // END MONTH //

      $wss = DB::table('OW_WEEKWISE_STK_SUM_WEB_HAFL')->where('WSS_ITEM_CODE', $item_code)->get();
      $uom = DB::table('OW_ITEM_UOM_WEB_HAFL')->where('IUW_ITEM_CODE', $item_code)->orderBy('IUW_CONV_FACTOR','ASC')->get();
      //$t20_3 = DB::table('OW_LAST3MON_T20_CUST_WEB_HAFL')->where('LTC_ITEM_CODE', $item_code)->get();
      //$t20_12 = DB::table('OW_LAST12MON_T20_CUST_WEB_HAFL')->where('LT_ITEM_CODE', $item_code)->get();

      return response()->json([
        'status' => true,
        'count' => $count,
        'data' => $usis,
        'mss' => $mss,
        'wss' => $wss,
        'uom' => $uom,
        //'t20_3' => $t20_3,
        //'t20_12' => $t20_12,
      ]);

    }

    public function inbound(Request $request){
      $item_code = $request->item_code ?? '940.99.961';
      $ipd_week_no = $request->ipd_week_no ?? '2346';

      $query = DB::table('OW_ITEMWISE_PO_DTLS_WEB_HAFL')->where('IPD_ITEM_CODE', $item_code)->where('IPD_WEEK_NO', $ipd_week_no);
      $count = $query->count();
      $inbound = $query->get();
      //dd($inbound);
      return response()->json([
        'status' => true,
        'count' => $count,
        'data' => $inbound,
      ]);
    }

    public function outbound(Request $request){
      $item_code = $request->item_code ?? '940.99.961';
      $ipd_week_no = $request->ipd_week_no ?? '2346';

      $query = DB::table('OW_ITEMWISE_SO_DTLS_WEB_HAFL')->where('ISD_ITEM_CODE', $item_code)->where('ISD_WEEK_NO', $ipd_week_no);
      $count = $query->count();
      $outbound = $query->get();
      //dd($inbound);
      return response()->json([
        'status' => true,
        'count' => $count,
        'data' => $outbound,
      ]);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
