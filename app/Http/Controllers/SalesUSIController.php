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
        return view('pages.sales_usi.index');
    }

    public function search_usi(Request $request){

      // NEW SALES USI //
      $item_code = $request->item_code ?? '494.02.483';
      $usi = DB::table('ow_new_sales_usi_web_hafl')
                ->where('NSU_ITEM_CODE', $item_code);
      $count = $usi->count();
      $usis = $usi->first();
      // END NEW SALES USI //

      // MONTH //
      $monthwise = DB::table('ow_monthwise_stk_sum_web_hafl')->where('MSS_ITEM_CODE', $item_code)->first();
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
        $tot_qty = $tot_qty_fields.$seq;
        $tot_qty_ls = $tot_qty_ls_fields.$seq;
        $inv = $inv_fields.$seq;
        $cust = $cust_fields.$seq;
        $tot['qty'][] = $monthwise->$tot_qty;
        $tot['ls'][] = $monthwise->$tot_qty_ls;
        $sold_qty = $sold_qty_fields.$seq;
        $sold_qty_ls = $sold_qty_ls_fields.$seq;
        $sold['qty'][] = $monthwise->$sold_qty;
        $sold['ls'][] = $monthwise->$sold_qty_ls;
        $mss['inv'][] = $monthwise->$inv;
        $mss['cust'][] = $monthwise->$cust;
      }

      $mss['tot'] = $tot;
      $mss['sold'] = $sold;
      // END MONTH //

      $wss = DB::table('ow_weekwise_stk_sum_web_hafl')->where('WSS_ITEM_CODE', $item_code)->get();
      $uom = DB::table('ow_item_uom_web_hafl')->where('IUW_ITEM_CODE', $item_code)->get();
      $t20_3 = DB::table('ow_last3mon_t20_cust_web_hafl')->where('LTC_ITEM_CODE', $item_code)->get();
      $t20_12 = DB::table('ow_last12mon_t20_cust_web_hafl')->where('LT_ITEM_CODE', $item_code)->get();

      return response()->json([
        'status' => true,
        'count' => $count,
        'data' => $usis,
        'mss' => $mss,
        'wss' => $wss,
        'uom' => $uom,
        't20_3' => $t20_3,
        't20_12' => $t20_12,
      ]);

    }

    public function inbound(Request $request){
      $item_code = $request->item_code ?? '940.99.961';
      $ipd_week_no = $request->ipd_week_no ?? '2346';

      $query = DB::table('ow_itemwise_po_dtls_web_hafl')->where('IPD_ITEM_CODE', $item_code)->where('IPD_WEEK_NO', $ipd_week_no);
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

      $query = DB::table('ow_itemwise_so_dtls_web_hafl')->where('ISD_ITEM_CODE', $item_code)->where('ISD_WEEK_NO', $ipd_week_no);
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
