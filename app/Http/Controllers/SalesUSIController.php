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

      //$wss = DB::table('OW_WEEKWISE_STK_SUM_WEB_HAFL')->where('WSS_ITEM_CODE', $item_code)->get();
      $material = $item_code;

      // สร้าง Common Table Expression (CTE) เพื่อสร้างลำดับสัปดาห์
      $weekSequence = DB::table(DB::raw('(WITH RECURSIVE week_sequence AS (
          SELECT WEEK(DATE_SUB(CURDATE(), INTERVAL 6 WEEK), 1) AS week_number, -6 AS week_offset
          UNION ALL
          SELECT WEEK(DATE_ADD(CURDATE(), INTERVAL week_offset + 1 WEEK), 1), week_offset + 1
          FROM week_sequence
          WHERE week_offset < 6
      ) SELECT * FROM week_sequence) as week_sequence'))
          ->select('week_number', 'week_offset');

      // Query สำหรับ PO (การสั่งซื้อ)
      $poQuery = DB::table('zhwwmm_open_orders as a')
          ->select([
              'a.material',
              DB::raw("WEEK(STR_TO_DATE(a.created_on_purchasing_doc, '%d/%m/%Y'), 1) AS weeks"),
              'a.po_order_unit AS WSS_ITEM_UOM_CODE',
              DB::raw("COALESCE(SUM(a.quantity_po) - SUM(a.delivered_quantity), 0) AS WSS_INCOMING_QTY"),
              DB::raw("COALESCE(SUM(a.delivered_quantity), 0) AS WSS_RCV_QTY")
          ])
          ->where('a.material', $material)
          ->groupBy('a.material', DB::raw('weeks'));

      // Query สำหรับ SO (การขาย)
      $soQuery = DB::table('zhinsd_va05 as b')
          ->select([
              'b.material',
              DB::raw("WEEK(STR_TO_DATE(b.delivery_date, '%m/%d/%Y'), 1) AS weeks"),
              DB::raw("COALESCE(SUM(b.order_quantity), 0) AS WSS_RES_QTY")
          ])
          ->where('b.material', $material)
          ->groupBy('b.material', DB::raw('weeks'));

      // Query สำหรับ Stock (สินค้าคงคลัง)
      $stockQuery = DB::table('mb52 as a')
          ->select(DB::raw("COALESCE(SUM(a.unrestricted), 0) AS WSS_AVAIL_QTY"))
          ->where('a.material', $material)
          ->groupBy('a.material');

      // รวมทั้งหมดเข้าด้วยกัน
      $wss = DB::table(DB::raw("({$weekSequence->toSql()}) as week_sequence"))
          ->mergeBindings($weekSequence)
          ->leftJoin(DB::raw("({$poQuery->toSql()}) as po"), 'po.weeks', '=', 'week_sequence.week_number')
          ->mergeBindings($poQuery)
          ->leftJoin(DB::raw("({$soQuery->toSql()}) as so"), 'so.weeks', '=', 'week_sequence.week_number')
          ->mergeBindings($soQuery)
          ->leftJoin(DB::raw("({$stockQuery->toSql()}) as un"), DB::raw('1'), DB::raw('1')) // ทำให้ stockQuery ใช้ค่าเดียวกันกับทุก row
          ->mergeBindings($stockQuery)
          ->select([
              'week_sequence.week_number',
              DB::raw("COALESCE(po.WSS_ITEM_UOM_CODE, '') AS WSS_ITEM_UOM_CODE"),
              DB::raw("COALESCE(po.WSS_INCOMING_QTY, 0) AS WSS_INCOMING_QTY"),
              DB::raw("COALESCE(so.WSS_RES_QTY, 0) AS WSS_RES_QTY"),
              DB::raw("COALESCE(un.WSS_AVAIL_QTY, 0) AS WSS_AVAIL_QTY"),
              DB::raw("COALESCE(po.WSS_RCV_QTY, 0) AS WSS_RCV_QTY"),
          ])
          ->get();



      //dd($wss);
      //$uom = DB::table('OW_ITEM_UOM_WEB_HAFL')->where('IUW_ITEM_CODE', $item_code)->orderBy('IUW_CONV_FACTOR','ASC')->get();
      //$t20_3 = DB::table('OW_LAST3MON_T20_CUST_WEB_HAFL')->where('LTC_ITEM_CODE', $item_code)->get();
      //$t20_12 = DB::table('OW_LAST12MON_T20_CUST_WEB_HAFL')->where('LT_ITEM_CODE', $item_code)->get();

      $uom = DB::table('zhwwbcquerydir as a')
      ->select([
          DB::raw('CASE WHEN a.material IS NOT NULL THEN a.material ELSE "N/A" END as IUW_ITEM_CODE'),
          DB::raw('CASE WHEN c.UoM IS NOT NULL THEN c.UoM ELSE "N/A" END as IUW_UOM_CODE'),
          DB::raw('CASE WHEN b.Amount IS NOT NULL THEN FORMAT(b.Amount, 0) ELSE "N/A" END as IUW_PRICE'),
          DB::raw('CASE WHEN c.Amount IS NOT NULL THEN FORMAT(c.Amount, 0) ELSE "N/A" END as NEW_ZPE_COST'),
          DB::raw('CASE WHEN a.mov_avg_price IS NOT NULL THEN a.mov_avg_price ELSE "N/A" END as NEW_MAP_COST')
      ])
      ->leftJoin('zordposkonv_zpl as b', 'a.material', '=', 'b.Material')
      ->leftJoin('zordposkonv_zpe as c', 'a.material', '=', 'c.Material')
      ->where('a.material', '=', $item_code)
      ->groupBy('c.material', 'c.uom')
      ->get();

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

      //$query = DB::table('OW_ITEMWISE_PO_DTLS_WEB_HAFL')->where('IPD_ITEM_CODE', $item_code)->where('IPD_WEEK_NO', $ipd_week_no);
      $query = DB::table('zhwwmm_open_orders as a')
        ->select([
          DB::raw("IFNULL(a.purchasing_document, '') as IPD_DOC_NO"),
          DB::raw("IFNULL(a.created_on_purchasing_doc, '') as IPD_DOC_DT"),
          DB::raw("IFNULL(a.po_order_unit, '') as IPD_UOM_CODE"),
          DB::raw("IFNULL(a.quantity_po, '') as IPD_QTY"),
          DB::raw("IFNULL(a.vendor_output_date, '') as IPD_ETS"),
          DB::raw("IFNULL(a.confirmed_issue_date, '') as IPD_STATUS"),
        ])
        ->where('a.material', $item_code)
        ->whereRaw("WEEK(STR_TO_DATE(a.created_on_purchasing_doc, '%d/%m/%Y'), 1) = ?", [$ipd_week_no]);

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

      //$query = DB::table('OW_ITEMWISE_SO_DTLS_WEB_HAFL')->where('ISD_ITEM_CODE', $item_code)->where('ISD_WEEK_NO', $ipd_week_no);
$query = DB::table('ZHINSD_VA05 as a')
    ->selectRaw("
      COALESCE(a.sd_document, '') AS ISD_DOC_NO,
      COALESCE(a.document_date, '') AS ISD_DOC_DT,
      COALESCE(a.unit_of_measure, '') AS ISD_UOM_CODE,
      COALESCE(a.order_quantity, 0) AS ISD_ORD_QTY,
      COALESCE(a.confirmed_quantity, 0) AS ISD_RESV_QTY,
      COALESCE(b.delivered_qty, 0) AS ISD_DEL_QTY,
      COALESCE(SUM(c.invoiced_quantity), 0) AS ISD_INV_QTY,
      COALESCE(a.goods_issue_date, '') AS ISD_DEL_DT,
      COALESCE(a.net_price, 0) AS ISD_RATE,
      COALESCE(a.order_quantity * a.pricing_unit, 0) AS ISD_VALUE,
      COALESCE(CONCAT_WS(' ', d.ZI, e.IDMA_ZI_NAME), '') AS ISD_ADMIN,
      COALESCE(CONCAT_WS(' ', d.ZE, e2.IDMA_ZI_NAME), '') AS ISD_REP
    ")
    ->leftJoin('zhaasd_ord as b', function ($join) {
        $join->on('b.material', '=', 'a.material')
             ->on('b.sd_document', '=', 'a.sd_document');
    })
    ->leftJoin('zhaasd_inv as c', function ($join) {
        $join->on('c.material', '=', 'a.material')
             ->on('c.sales_document', '=', 'a.sd_document');
    })
    ->leftJoin('hww_sd_06 as d', 'd.Material', '=', 'a.material')
    ->leftJoin('hww_sd_custlis as e', 'd.ZI', '=', 'e.IDMA_ZI')
    ->leftJoin('hww_sd_custlis as e2', 'd.ZE', '=', 'e2.IDMA_ZI')
    ->where('a.material', '=', '311.03.101')
    ->groupBy('c.material');


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
