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
        $q = DB::table('ZHWWMM_OPEN_ORDERS')->select('created_at')->first();
        $created_at = $q->created_at;
        return view('pages.sales_usi.index',['created_at' => $created_at]);
    }

    public function search_usi(Request $request){

      $item_code = $request->item_code ?? '';

      $query = DB::table('ZHWWBCQUERYDIR as m')
      ->select([
        DB::raw("CASE WHEN m.material IS NULL OR m.material = '' THEN 'N/A' ELSE m.material END AS NSU_ITEM_CODE"),
        DB::raw("CASE WHEN m.kurztext IS NULL OR m.kurztext = '' THEN 'N/A' ELSE m.kurztext END AS NSU_ITEM_NAME"),
        DB::raw("CASE WHEN m.dm IS NULL OR m.dm = '' THEN 'N/A' ELSE m.dm END AS NSU_ITEM_DM"),
        DB::raw("CASE WHEN m.bun IS NULL OR m.bun = '' THEN 'N/A' ELSE m.bun END AS NSU_ITEM_UOM_CODE"),
        //DB::raw("CASE WHEN m.pgr IS NULL OR m.pgr = '' THEN 'N/A' ELSE m.pgr END AS NSU_PURCHASER"),
        DB::raw("
            CASE
                WHEN m.pgr IS NULL OR m.pgr = '' THEN 'N/A'
                WHEN m.pgr = 'T01' THEN 'T01-Unchalee Yensawad'
                WHEN m.pgr = 'T02' THEN 'T02-Ruthairat K.'
                WHEN m.pgr = 'T03' THEN 'T03-Vacant 1'
                WHEN m.pgr = 'T04' THEN 'T04-Supasinee Kanyamee'
                WHEN m.pgr = 'T05' THEN 'T05-Sucharee Sripa'
                WHEN m.pgr = 'T06' THEN 'T06-Benjamas Boonfak'
                WHEN m.pgr = 'T07' THEN 'T07-Vacant 2'
                WHEN m.pgr = 'T08' THEN 'T08-Hathaipat Buangam'
                WHEN m.pgr = 'T09' THEN 'T09-Thitiluk Apichaiwo'
                WHEN m.pgr = 'T10' THEN 'T10-Monchaya Somsuk'
                WHEN m.pgr = 'T11' THEN 'T11-Vipavin Nisayun'
                WHEN m.pgr = 'T12' THEN 'T12-Rapeepan Soongrang'
                WHEN m.pgr = 'T13' THEN 'T13-Pornpimol K.'
                WHEN m.pgr = 'T14' THEN 'T14-Wannisa Kongin'
                WHEN m.pgr = 'T15' THEN 'T15-Siriporn Pinkaew'
                WHEN m.pgr = 'T16' THEN 'T16-Wanthana S.'
                WHEN m.pgr = 'T17' THEN 'T17-Chaninat Kongkarun'
                WHEN m.pgr = 'T18' THEN 'T18-Kanokon Pakaedam'
                WHEN m.pgr = 'T19' THEN 'T19-Chanikarn Yati'
                WHEN m.pgr = 'T20' THEN 'T20-Vacant 3'
                WHEN m.pgr = 'T21' THEN 'T21-Vacant 4'
                WHEN m.pgr = 'T22' THEN 'T22-Vacant 5'
                WHEN m.pgr = 'T23' THEN 'T23-Vacant 6'
                WHEN m.pgr = 'T24' THEN 'T24-Kotchaporn S.'
                WHEN m.pgr = 'T25' THEN 'T25-Thanat A.'
                WHEN m.pgr = 'T31' THEN 'T31-HTH EHK PurGrp 1'
                WHEN m.pgr = 'T32' THEN 'T32-HTH EHK PurGrp 2'
                WHEN m.pgr = 'T33' THEN 'T33-HTH EHK PurGrp 3'
                WHEN m.pgr = 'T99' THEN 'T99-Relocation'
                WHEN m.pgr = 'TH1' THEN 'TH1-SCM (Non-trade)'
                WHEN m.pgr = 'TH2' THEN 'TH2-IT (Non-trade)'
                WHEN m.pgr = 'TH3' THEN 'TH3-Fin.&Adm. (NT)'
                WHEN m.pgr = 'TH4' THEN 'TH4-Retail Sales (NT)'
                WHEN m.pgr = 'TH5' THEN 'TH5-Project Sales (NT)'
                WHEN m.pgr = 'TH6' THEN 'TH6-PCM (NT)'
                WHEN m.pgr = 'TH7' THEN 'TH7-CS (Non-trade)'
                WHEN m.pgr = 'TH8' THEN 'TH8-Logistics (NT)'
                WHEN m.pgr = 'TH9' THEN 'TH9-HR-POA (NT)'
                WHEN m.pgr = 'THA' THEN 'THA-HR-POD (NT)'
                WHEN m.pgr = 'THB' THEN 'THB-HR-TA&HRBP (NT)'
                WHEN m.pgr = 'THC' THEN 'THC-Marketing (NT)'
                ELSE 'Unknown'
            END AS NSU_PURCHASER
        "),
        DB::raw("CASE WHEN m.product_group_manager IS NULL OR m.product_group_manager = '' THEN 'N/A' ELSE m.product_group_manager END AS NSU_PROD_MGR"),
        DB::raw("CASE WHEN u.uom_text IS NULL OR u.uom_text = '' THEN 'N/A' ELSE u.uom_text END AS NSU_PACK_UOM_CODE"),
        DB::raw("CASE WHEN m.numer IS NULL OR m.numer = '' THEN 'N/A' ELSE m.numer END AS NSU_CONV_BASE_UOM"),
        DB::raw("CASE WHEN m.gross_weight IS NULL OR m.gross_weight = '' THEN 'N/A' ELSE CONCAT(m.gross_weight, ' ', m.wun) END AS NSU_PACK_WEIGHT"),
        DB::raw("CASE WHEN m.volume IS NULL OR m.volume = '' THEN 'N/A' ELSE CONCAT(m.volume, ' ', m.vun) END AS NSU_PACK_VOLUME"),
        DB::raw("CASE
                  WHEN m.st IS NULL OR m.st = '' THEN 'Active'
                  WHEN m.st = 'Z1' THEN 'Z1-Basic data not compl'
                  WHEN m.st = 'Z2' THEN 'Z2-Article not distrib.'
                  WHEN m.st = 'ZB' THEN 'ZB-Sales Blocked'
                  WHEN m.st = 'ZC' THEN 'ZC-Sales Blocked for QC'
                  WHEN m.st = 'ZD' THEN 'ZD-Arranged for Delet.'
                  WHEN m.st = 'ZL' THEN 'ZL-Unpacked'
                  WHEN m.st = 'ZM' THEN 'ZM-Sell no minim.quant.'
                  WHEN m.st = 'ZR' THEN 'ZR-Sell out & delete'
                  WHEN m.st = 'ZS' THEN 'ZS-Sales Stopped'
                  ELSE m.st
              END AS NSU_ITEM_STATUS"),
        //DB::raw("CASE WHEN m.lage IS NULL OR m.lage = '' THEN 'N/A' ELSE m.lage END AS NSU_ITEM_INV_CODE"),
        DB::raw("
            CASE
                WHEN m.lage IS NULL OR m.lage = '' THEN 'N/A'
                WHEN m.lage = 'NLW' THEN 'NLW-Not storage goods'
                WHEN m.lage = 'LW' THEN 'LW-Stock goods'
                ELSE m.lage
            END AS NSU_ITEM_INV_CODE
        "),
        DB::raw("CASE WHEN p.planned_deliv_time IS NULL OR p.planned_deliv_time = '' THEN 'N/A' ELSE p.planned_deliv_time END AS NSU_SUPP_REPL_TIME"),
        DB::raw("CASE WHEN p.minimum_order_qty IS NULL OR p.minimum_order_qty = '' THEN 'N/A' ELSE p.minimum_order_qty END AS NSU_PURC_MOQ"),
        DB::raw("CASE WHEN p.vendor_material_number IS NULL OR p.vendor_material_number = '' THEN 'N/A' ELSE p.vendor_material_number END AS NSU_SUPP_ITEM_CODE"),
        DB::raw("CASE WHEN p.ean_upc IS NULL OR p.ean_upc = '' THEN 'N/A' ELSE p.ean_upc END AS ean_upc"),
        DB::raw("CASE WHEN i.unrestricted IS NULL OR i.unrestricted = '' THEN '0' ELSE FORMAT(i.unrestricted,0) END AS NSU_FREE_STK_QTY"),
        DB::raw("CASE WHEN mf.TDLINE IS NULL OR mf.TDLINE = '' THEN 'N/A' ELSE mf.TDLINE END AS NSU_EXCL_REMARK"),
        DB::raw("CASE WHEN pm.certificate IS NULL OR pm.certificate = '' THEN 'N/A' ELSE pm.certificate END AS NSU_ITEM_BRAND"),
        DB::raw("CASE WHEN m.follow_up_material IS NULL OR m.follow_up_material = '' THEN 'N/A' ELSE m.follow_up_material END AS NSU_NEW_ITEM_CODE")
    ])
    ->selectRaw("
        CASE
            WHEN zpl.amount IS NULL OR zpl.per IS NULL OR zpl.per = 0 THEN '0'
            ELSE FORMAT(zpl.amount / zpl.per, 2)
        END AS NSU_BASE_PRICE
    ")
    ->selectRaw("
        CASE
            WHEN zplv.amount IS NULL OR zplv.Pricing_unit IS NULL OR zplv.Pricing_unit = 0 THEN '0'
            ELSE FORMAT(zplv.amount / zplv.Pricing_unit, 2)
        END AS NSU_BASE_PRICE_ZPLV
    ")
        ->leftJoin('ZHAAMM_IFVMG as p', 'p.material', '=', 'm.material')
        //->leftJoin('MB52 as i', 'i.material', '=', 'm.material')
        ->leftJoin('MB52 as i', function ($join) {
            $join->on('i.material', '=', 'm.material')
                 ->where('i.storage_location', '=', 'TH02')
                 ->whereNull('i.special_stock');
        })
        ->leftJoin('FIS_MPM_OUT as mf', 'mf.MATNR', '=', 'm.material')
        ->leftJoin('ZMM_MATZERT as pm', 'pm.material', '=', 'm.material')
        ->leftJoin('ZHAASD_ORD as od', 'od.material', '=', 'm.material')
        ->leftJoin('ZORDPOSKONV_ZPL as zpl', 'zpl.material', '=', 'm.material')
        ->leftJoin('zplv', 'zplv.material', '=', 'm.material')
        ->leftJoin('UOM_Mapping as u', 'u.uom', '=', 'm.aun')
        ->where('m.material', '=', $item_code)
        //->whereColumn('m.bun', '!=', 'm.aun')
        //->where('m.aun', '!=', 'ZPU')
        ->orderBy('m.numer','asc')
        //->limit(1)
        ;
        $usi_sql = $query->toSql();
        $usis = $query->get();
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
          SELECT WEEK(DATE_SUB(CURDATE(), INTERVAL 1 WEEK), 1) AS week_number, -1 AS week_offset, RIGHT(YEAR(DATE_SUB(CURDATE(), INTERVAL 1 WEEK)), 2) AS year_number
          UNION ALL
          SELECT WEEK(DATE_ADD(CURDATE(), INTERVAL week_offset + 1 WEEK), 1), week_offset + 1, RIGHT(YEAR(DATE_ADD(CURDATE(), INTERVAL week_offset + 1 WEEK)), 2) AS year_number
          FROM week_sequence
          WHERE week_offset < 52
      ) SELECT * FROM week_sequence) as week_sequence'))
          ->select('week_number', 'week_offset', 'year_number');

      // Query สำหรับ PO (การสั่งซื้อ)
      $poQuery = DB::table('ZHWWMM_OPEN_ORDERS as a')
          ->leftJoin('574_ekko_expo as b', function($join) {
              $join->on('a.material', '=', 'b.material')
                   ->on('a.purchasing_document', '=', 'b.purch_doc');
          })
          ->leftJoin('ZHAAMM_IFVMG as c', 'c.material', '=', 'a.material')
          ->select([
              'a.material',
              /*DB::raw('RIGHT(YEAR(STR_TO_DATE(a.created_on_purchasing_doc, "%m/%d/%Y")), 2) AS years'),*/
              DB::raw("
                RIGHT(
                  YEAR(
                    DATE_ADD(
                      STR_TO_DATE(b.vdr_outp_date, '%m/%d/%Y'),
                      INTERVAL (c.planned_deliv_time - b.production_time_in_days) DAY
                    )
                  ),
                  2
                ) as years
              "),
              DB::raw("
                WEEK(
                  DATE_ADD(
                    STR_TO_DATE(b.vdr_outp_date, '%m/%d/%Y'),
                    INTERVAL (c.planned_deliv_time - b.production_time_in_days) DAY
                  ),
                  1
                ) as weeks
              "),
              /*DB::raw("WEEK(STR_TO_DATE(a.created_on_purchasing_doc, '%m/%d/%Y'), 1) AS weeks"),*/
              'a.po_order_unit AS WSS_ITEM_UOM_CODE',
              DB::raw("COALESCE(SUM(a.quantity_po) - SUM(a.delivered_quantity), 0) AS WSS_INCOMING_QTY"),
              DB::raw("COALESCE(SUM(a.delivered_quantity), 0) AS WSS_RCV_QTY"),
              /*DB::raw("
                DATE_FORMAT(
                  DATE_ADD(
                    STR_TO_DATE(b.vdr_outp_date, '%m/%d/%Y'),
                    INTERVAL (c.planned_deliv_time - b.production_time_in_days) DAY
                  ),
                  '%d/%m/%Y'
                ) as IPD_ETA
              ")*/
          ])
          ->where('a.material', $material)
          ->groupBy('a.material', DB::raw('weeks'), DB::raw('years'));

      // Query สำหรับ SO (การขาย)
      /*$soQuery = DB::table('ZHINSD_VA05 as b')
          ->select([
              'b.material',
              DB::raw('RIGHT(YEAR(STR_TO_DATE(b.delivery_date, "%m/%d/%Y")), 2) AS years'),
              DB::raw("WEEK(STR_TO_DATE(b.delivery_date, '%m/%d/%Y'), 1) AS weeks"),
              DB::raw("COALESCE(SUM(b.order_quantity), 0) - COALESCE(inv.invoiced_quantity, 0) AS WSS_RES_QTY")
          ])
          ->leftJoin('ZHAASD_INV as inv', function ($join) {
              $join->on('inv.material', '=', 'b.material')
                   ->on('inv.sales_document', '=', 'b.sd_document');
          })
          ->where('b.material', $material)
          //->whereRaw('COALESCE(b.order_quantity, 0) - COALESCE(inv.invoiced_quantity, 0) != 0')
          ->groupBy('b.sd_document', DB::raw('weeks'), DB::raw('years'));*/
          $subQuery = DB::table('ZHINSD_VA05 as b')
              ->leftJoin('ZHAASD_INV as inv', function ($join) {
                  $join->on('inv.material', '=', 'b.material')
                       ->on('inv.sales_document', '=', 'b.sd_document');
              })
              ->selectRaw(
                  'b.material,
                  RIGHT(YEAR(STR_TO_DATE(b.delivery_date, "%m/%d/%Y")), 2) AS years,
                  WEEK(STR_TO_DATE(b.delivery_date, "%m/%d/%Y"), 1) AS weeks,
                  SUM(b.order_quantity) - COALESCE(inv.invoiced_quantity, 0) AS WSS_RES_QTY'
              )
              ->where('b.material', $material)
              ->groupBy('b.sd_document')
              ->groupByRaw('WEEK(STR_TO_DATE(b.delivery_date, "%m/%d/%Y"), 1)')
              ->groupByRaw('RIGHT(YEAR(STR_TO_DATE(b.delivery_date, "%m/%d/%Y")), 2)');

          $soQuery = DB::table(DB::raw('(' . $subQuery->toSql() . ') as t'))
              ->mergeBindings($subQuery)
              ->selectRaw('t.years, t.weeks, SUM(t.WSS_RES_QTY) AS WSS_RES_QTY')
              ->groupBy('t.years', 't.weeks');

      // Query สำหรับ Stock (สินค้าคงคลัง)
      $stockQuery = DB::table('MB52 as a')
          ->select(DB::raw("COALESCE(SUM(a.unrestricted), 0) AS WSS_AVAIL_QTY"))
          ->where('a.material', $material)
          ->where('a.storage_location', 'TH02')
          ->where('a.special_stock', '')
          ->groupBy('a.material');

      // รวมทั้งหมดเข้าด้วยกัน
      $wss = DB::table(DB::raw("({$weekSequence->toSql()}) as week_sequence"))
          ->mergeBindings($weekSequence)
          //->leftJoin(DB::raw("({$poQuery->toSql()}) as po"), 'po.weeks', '=', 'week_sequence.week_number')
          ->leftJoin(DB::raw('(' . $poQuery->toSql() . ') as po'), function($join) {
            $join->on('po.weeks', '=', 'week_sequence.week_number')
                ->on('po.years', '=', 'week_sequence.year_number');
            })
          ->mergeBindings($poQuery)
          //->leftJoin(DB::raw("({$soQuery->toSql()}) as so"), 'so.weeks', '=', 'week_sequence.week_number')
          ->leftJoin(DB::raw('(' . $soQuery->toSql() . ') as so'), function($join) {
              $join->on('so.weeks', '=', 'week_sequence.week_number')
                   ->on('so.years', '=', 'week_sequence.year_number');
          })
          ->mergeBindings($soQuery)
          ->leftJoin(DB::raw("({$stockQuery->toSql()}) as un"), DB::raw('1'), DB::raw('1')) // ทำให้ stockQuery ใช้ค่าเดียวกันกับทุก row
          ->mergeBindings($stockQuery)
          ->select([
              'week_sequence.week_number',
              'week_sequence.year_number',
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

      $uom = DB::table('ZHWWBCQUERYDIR as a')
      ->select([
          DB::raw('CASE WHEN a.material IS NOT NULL THEN a.material ELSE "N/A" END as IUW_ITEM_CODE'),
          DB::raw('CASE WHEN c.UoM IS NOT NULL THEN c.UoM ELSE "N/A" END as IUW_UOM_CODE'),
          DB::raw('CASE WHEN b.Amount IS NOT NULL THEN FORMAT(b.Amount / b.per, 2) ELSE "0" END as IUW_PRICE'),
          DB::raw('CASE WHEN d.Amount IS NOT NULL THEN FORMAT(d.Amount / d.Pricing_unit, 2) ELSE "0" END as NEW_ZPLV_COST'),
          DB::raw('CASE WHEN c.Amount IS NOT NULL THEN FORMAT(c.Amount / c.per, 2) ELSE "0" END as NEW_ZPE_COST'),
          DB::raw('CASE WHEN a.mov_avg_price IS NOT NULL THEN FORMAT(a.mov_avg_price / a.per, 2) ELSE "0" END as NEW_MAP_COST')
      ])
      ->leftJoin('ZORDPOSKONV_ZPL as b', 'a.material', '=', 'b.Material')
      ->leftJoin('ZORDPOSKONV_ZPE as c', 'a.material', '=', 'c.Material')
      ->leftJoin('zplv as d', 'a.material', '=', 'd.Material')
      ->where('a.material', '=', $item_code)
      ->groupBy('c.material', 'c.uom')
      ->get();


      $stocks = DB::table('MB52')
          ->selectRaw("
              SUM(CASE WHEN storage_location = 'TH02' THEN unrestricted ELSE 0 END) AS TH02,
              SUM(CASE WHEN storage_location = 'THS2' THEN unrestricted ELSE 0 END) AS THS2,
              SUM(CASE WHEN storage_location = 'THS3' THEN unrestricted ELSE 0 END) AS THS3,
              SUM(CASE WHEN storage_location = 'THS4' THEN unrestricted ELSE 0 END) AS THS4,
              SUM(CASE WHEN storage_location = 'THS5' THEN unrestricted ELSE 0 END) AS THS5,
              SUM(CASE WHEN storage_location = 'THS6' THEN unrestricted ELSE 0 END) AS THS6
          ")
          ->where('material', $item_code)
          ->whereIn('storage_location', ['TH02','THS2','THS3','THS4','THS5','THS6'])
          ->first(); // ดึงแถวเดียว

      return response()->json([
        'status' => true,
        'count' => $count,
        'data' => $usis,
        'usi_sql' => $usi_sql,
        'so_sql' => $soQuery->toSql(),
        'mss' => $mss,
        'wss' => $wss,
        'uom' => $uom,
        'stocks' => $stocks,
        //'t20_3' => $t20_3,
        //'t20_12' => $t20_12,
      ]);

    }

    public function inbound(Request $request){

      $item_code = $request->item_code ?? '940.99.961';
      $ipd_week_no = $request->ipd_week_no ?? '2346';

      //$query = DB::table('OW_ITEMWISE_PO_DTLS_WEB_HAFL')->where('IPD_ITEM_CODE', $item_code)->where('IPD_WEEK_NO', $ipd_week_no);
      $query = DB::table('ZHWWMM_OPEN_ORDERS as a')
        ->leftJoin('574_ekko_expo as b', function($join) {
            $join->on('a.material', '=', 'b.material')
                 ->on('a.purchasing_document', '=', 'b.purch_doc');
        })
        ->leftJoin('ZHAAMM_IFVMG as c', 'c.material', '=', 'a.material')
        ->select([
          DB::raw("IFNULL(a.purchasing_document, '') as IPD_DOC_NO"),
          DB::raw("IFNULL(DATE_FORMAT(STR_TO_DATE(a.created_on_purchasing_doc, '%m/%d/%Y'),'%d/%m/%Y'),'') as IPD_DOC_DT"),
          DB::raw("IFNULL(a.po_order_unit, '') as IPD_UOM_CODE"),
          DB::raw("IFNULL(a.quantity_po, '') as IPD_QTY"),
          DB::raw("IFNULL(DATE_FORMAT(STR_TO_DATE(a.vendor_output_date, '%m/%d/%Y'),'%d/%m/%Y'),'') as IPD_ETS"),
          DB::raw("IF(a.delivered_quantity > 0, 'S',IF(a.confirmed_issue_date IS NOT NULL, 'C', 'U')) as IPD_STATUS"),
          DB::raw("
            DATE_FORMAT(
              DATE_ADD(
                STR_TO_DATE(b.vdr_outp_date, '%m/%d/%Y'),
                INTERVAL (c.planned_deliv_time - b.production_time_in_days) DAY
              ),
              '%d/%m/%Y'
            ) as IPD_ETA
          ")
        ])

        ->where('a.material', $item_code)
        /*->whereRaw("WEEK(STR_TO_DATE(a.created_on_purchasing_doc, '%m/%d/%Y'), 1) = ?", [$ipd_week_no]);*/
        ->whereRaw("
          WEEK(
            DATE_ADD(
              STR_TO_DATE(b.vdr_outp_date, '%m/%d/%Y'),
              INTERVAL (c.planned_deliv_time - b.production_time_in_days) DAY
            ),
            1
          ) = ?
        ", [$ipd_week_no]);

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
      $week_no = $request->week_no ?? '';
      $year_no = $request->year_no ?? '';

      //$query = DB::table('OW_ITEMWISE_SO_DTLS_WEB_HAFL')->where('ISD_ITEM_CODE', $item_code)->where('ISD_WEEK_NO', $ipd_week_no);
      $query = DB::table('ZHINSD_VA05 as a')
          ->selectRaw("

            a.sold_to_party,
            a.name1,
            COALESCE(a.sd_document, '') AS ISD_DOC_NO,
            COALESCE(a.document_date, '') AS ISD_DOC_DT,
            COALESCE(a.unit_of_measure, '') AS ISD_UOM_CODE,
            COALESCE(sum(a.order_quantity), 0) AS ISD_ORD_QTY,
            COALESCE(sum(a.confirmed_quantity), 0) AS ISD_RESV_QTY,
            COALESCE(b.delivered_qty, 0) AS ISD_DEL_QTY,
            COALESCE(c.invoiced_quantity, 0) AS ISD_INV_QTY,
            CASE
                WHEN COALESCE(b.delivered_qty, 0) > 0 THEN COALESCE(a.goods_issue_date, '')
                ELSE ''
            END AS ISD_DEL_DT,
            COALESCE(a.net_price, 0) AS ISD_RATE,
            COALESCE(a.order_quantity * a.pricing_unit, 0) AS ISD_VALUE,
            COALESCE(CONCAT_WS(' ', d.ZI, e.IDMA_ZI_NAME), '') AS ISD_ADMIN,
            COALESCE(CONCAT_WS(' ', d.ZE, e2.IDMA_ZI_NAME), '') AS ISD_REP,
            RIGHT(YEAR(STR_TO_DATE(a.delivery_date, '%m/%d/%Y')),2) AS years,
		        WEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 1) AS weeks
          ")
          ->leftJoin('ZHAASD_ORD as b', function ($join) {
              $join->on('b.material', '=', 'a.material')
                   ->on('b.sd_document', '=', 'a.sd_document');
          })
          ->leftJoin('ZHAASD_INV as c', function ($join) {
              $join->on('c.material', '=', 'a.material')
                   ->on('c.sales_document', '=', 'a.sd_document');
          })
          /*->leftJoin('HWW_SD_06 as d', function ($join) {
              $join->on('d.Material', '=', 'a.material')
                   ->on('d.SalesDoc', '=', 'a.sd_document');
          })*/
          ->leftJoin(DB::raw('(SELECT SalesDoc, Material, ZI, ZE FROM HWW_SD_06 GROUP BY SalesDoc) as d'), function ($join) {
              $join->on('d.SalesDoc', '=', 'a.sd_document')
                   ->on('d.Material', '=', 'a.material');
          })
          //->leftJoin('HWW_SD_CUSTLIS as e', 'd.ZI', '=', 'e.IDMA_ZI')
          //->leftJoin('HWW_SD_CUSTLIS as e2', 'd.ZE', '=', 'e2.IDMA_ZI')
          ->leftJoin(DB::raw('(SELECT IDMA_ZI, IDMA_ZI_NAME FROM HWW_SD_CUSTLIS GROUP BY IDMA_ZI) as e'), 'e.IDMA_ZI', '=', 'd.ZI')
          ->leftJoin(DB::raw('(SELECT IDMA_ZI, IDMA_ZI_NAME FROM HWW_SD_CUSTLIS GROUP BY IDMA_ZI) as e2'), 'e2.IDMA_ZI', '=', 'd.ZE')
          ->where('a.material', '=', $item_code)
          ->whereRaw("RIGHT(YEAR(STR_TO_DATE(a.delivery_date, '%m/%d/%Y')), 2) = $year_no")
          ->whereRaw("WEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 1) = $week_no")
          //->whereRaw('COALESCE(sum(a.order_quantity), 0) - COALESCE(c.invoiced_quantity, 0) != 0')
          ->groupBy(DB::raw("a.sd_document, RIGHT(YEAR(STR_TO_DATE(a.delivery_date, '%m/%d/%Y')),2), WEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 1)"))

          ;

      $sql = $query->toSql();
      $count = $query->count();
      $outbound = $query->get();
      //dd($inbound);
      return response()->json([
        'status' => true,
        'count' => $count,
        'data' => $outbound,
        'sql' => $sql,
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
