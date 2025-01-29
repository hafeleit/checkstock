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
        DB::raw("CASE WHEN m.material IS NULL OR m.material = '' THEN 'N/A' ELSE m.material END AS NSU_ITEM_CODE"),
        DB::raw("CASE WHEN m.kurztext IS NULL OR m.kurztext = '' THEN 'N/A' ELSE m.kurztext END AS NSU_ITEM_NAME"),
        DB::raw("CASE WHEN m.bun IS NULL OR m.bun = '' THEN 'N/A' ELSE m.bun END AS NSU_ITEM_UOM_CODE"),
        DB::raw("CASE WHEN m.pgr IS NULL OR m.pgr = '' THEN 'N/A' ELSE m.pgr END AS NSU_PURCHASER"),
        DB::raw("CASE WHEN m.product_group_manager IS NULL OR m.product_group_manager = '' THEN 'N/A' ELSE m.product_group_manager END AS NSU_PROD_MGR"),
        DB::raw("CASE WHEN m.su IS NULL OR m.su = '' THEN 'N/A' ELSE m.su END AS NSU_PACK_UOM_CODE"),
        DB::raw("CASE WHEN m.numer IS NULL OR m.numer = '' THEN 'N/A' ELSE m.numer END AS NSU_CONV_BASE_UOM"),
        DB::raw("CASE WHEN m.gross_weight IS NULL OR m.gross_weight = '' THEN 'N/A' ELSE m.gross_weight END AS NSU_PACK_WEIGHT"),
        DB::raw("CASE WHEN m.volume IS NULL OR m.volume = '' THEN 'N/A' ELSE m.volume END AS NSU_PACK_VOLUME"),
        DB::raw("CASE WHEN m.st IS NULL OR m.st = '' THEN 'N/A' ELSE m.st END AS NSU_ITEM_STATUS"),
        DB::raw("CASE WHEN m.lage IS NULL OR m.lage = '' THEN 'N/A' ELSE m.lage END AS NSU_ITEM_INV_CODE"),
        DB::raw("CASE WHEN p.planned_deliv_time IS NULL OR p.planned_deliv_time = '' THEN 'N/A' ELSE p.planned_deliv_time END AS NSU_SUPP_REPL_TIME"),
        DB::raw("CASE WHEN p.minimum_order_qty IS NULL OR p.minimum_order_qty = '' THEN 'N/A' ELSE p.minimum_order_qty END AS NSU_PURC_MOQ"),
        DB::raw("CASE WHEN p.vendor_material_number IS NULL OR p.vendor_material_number = '' THEN 'N/A' ELSE p.vendor_material_number END AS NSU_SUPP_ITEM_CODE"),
        DB::raw("CASE WHEN i.unrestricted IS NULL OR i.unrestricted = '' THEN 'N/A' ELSE i.unrestricted END AS NSU_FREE_STK_QTY"),
        DB::raw("CASE WHEN mf.TDLINE IS NULL OR mf.TDLINE = '' THEN 'N/A' ELSE mf.TDLINE END AS NSU_EXCL_REMARK"),
        DB::raw("CASE WHEN pm.certificate IS NULL OR pm.certificate = '' THEN 'N/A' ELSE pm.certificate END AS NSU_ITEM_BRAND"),
        DB::raw("CASE WHEN od.customer_material IS NULL OR od.customer_material = '' THEN 'N/A' ELSE od.customer_material END AS NSU_NEW_ITEM_CODE")
    ])
    ->selectRaw("
        CASE
            WHEN zpl.amount IS NULL OR zpl.per IS NULL OR zpl.per = 0 THEN 'N/A'
            ELSE FORMAT(zpl.amount / zpl.per, 0)
        END AS NSU_BASE_PRICE
    ")
        ->distinct()
        ->leftJoin('zhaamm_ifvmg as p', 'p.material', '=', 'm.material')
        ->leftJoin('mb52 as i', 'i.material', '=', 'm.material')
        ->leftJoin('fis_mpm_out as mf', 'mf.MATNR', '=', 'm.material')
        ->leftJoin('zmm_matzert as pm', 'pm.material', '=', 'm.material')
        ->leftJoin('zhaasd_ord as od', 'od.material', '=', 'm.material')
        ->leftJoin('zordposkonv_zpl as zpl', 'zpl.material', '=', 'm.material')
        ->where('m.material', '=', $item_code);
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
