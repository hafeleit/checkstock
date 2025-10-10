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
        return view('pages.sales_usi.index', ['created_at' => $created_at]);
    }

    public function search_usi(Request $request)
    {
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
                        WHEN m.pgr = 'T07' THEN 'T07-Kanokporn Chalaem'
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
                        WHEN m.pgr = 'T26' THEN 'T26-Khwanvalee P.'
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
                //DB::raw("CASE WHEN m.product_group_manager IS NULL OR m.product_group_manager = '' THEN 'N/A' ELSE m.product_group_manager END AS NSU_PROD_MGR"),
                DB::raw("CONCAT(m.product_group_manager, '-', um.name_en) as NSU_PROD_MGR"),
                DB::raw("CASE WHEN u.uom_text IS NULL OR u.uom_text = '' THEN 'N/A' ELSE u.uom_text END AS NSU_PACK_UOM_CODE"),
                DB::raw("CASE WHEN m.numer IS NULL OR m.numer = '' THEN 'N/A' ELSE m.numer END AS NSU_CONV_BASE_UOM"),
                DB::raw("CASE WHEN m.gross_weight IS NULL OR m.gross_weight = '' THEN 'N/A' ELSE CONCAT(m.gross_weight, ' ', m.wun) END AS NSU_PACK_WEIGHT"),
                DB::raw("CASE WHEN m.volume IS NULL OR m.volume = '' THEN 'N/A' ELSE CONCAT(m.volume, ' ', m.vun) END AS NSU_PACK_VOLUME"),
                DB::raw("
                    CASE
                        WHEN m.st = 'Z1' THEN 'Z1-Basic data not compl'
                        WHEN m.st = 'Z2' THEN 'Z2-Article not distrib.'
                        WHEN m.st = 'ZB' THEN 'ZB-Sales Blocked'
                        WHEN m.st = 'ZC' THEN 'ZC-Sales Blocked for QC'
                        WHEN m.st = 'ZD' THEN 'ZD-Arranged for Delet.'
                        WHEN m.st = 'ZL' THEN 'ZL-Unpacked'
                        WHEN m.st = 'ZM' THEN 'ZM-Sell no minim.quant.'
                        WHEN m.st = 'ZR' THEN 'ZR-Sell out & delete'
                        WHEN m.st = 'ZS' THEN 'ZS-Sales Stopped'
                        WHEN m.st IS NULL OR m.st = '' THEN 'Active'
                        ELSE m.st
                    END AS NSU_ITEM_STATUS"
                ),
                //DB::raw("CASE WHEN m.lage IS NULL OR m.lage = '' THEN 'N/A' ELSE m.lage END AS NSU_ITEM_INV_CODE"),
                DB::raw("
                    CASE
                        WHEN m.lage IS NULL OR m.lage = '' THEN 'N/A'
                        WHEN m.lage = 'NLW' THEN 'NLW-Not storage goods'
                        WHEN m.lage = 'LW' THEN 'LW-Stock goods'
                        ELSE m.lage
                    END AS NSU_ITEM_INV_CODE
                "),
                DB::raw("
                    CASE
                        WHEN m.lage = 'LW' AND (m.dm = 'Z4' OR m.dm = 'ZM') THEN CONCAT(m.dm,'-','Stock Item')
                        WHEN m.lage = 'LW' AND m.dm = 'PD' THEN CONCAT(m.dm,'-','C Item')
                        WHEN m.lage = 'NLW' AND (m.dm = 'ZX' OR m.dm = 'ZD') THEN CONCAT(m.dm,'-','C Item')
                        ELSE NULL
                    END AS NSU_ITEM_DM_DESC
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
                    WHEN im.mvgr4 = 'Z00' THEN 'Check price with BD/PCM'
                    WHEN zpl.amount IS NULL OR zpl.per IS NULL OR zpl.per = 0 THEN '0 THB'
                    ELSE CONCAT(FORMAT(zpl.amount / zpl.per, 2), ' THB')
                END AS NSU_BASE_PRICE
            ")
            ->selectRaw("
                CASE
                    WHEN zplv.amount IS NULL OR zplv.Pricing_unit IS NULL OR zplv.Pricing_unit = 0 THEN '0 THB'
                    ELSE CONCAT(FORMAT(zplv.amount / zplv.Pricing_unit, 2), ' THB')
                END AS NSU_BASE_PRICE_ZPLV
            ")
            ->leftJoin('ZHAAMM_IFVMG as p', 'p.material', '=', 'm.material')
            ->leftJoin('zhaamm_ifvmg_mat as im', 'im.matnr', '=', 'm.material')
            ->leftJoin('user_masters as um', function ($join) {
                $join->on(DB::raw("m.product_group_manager"), '=', DB::raw("CONCAT('HTH', um.job_code)"))
                    ->where(DB::raw('LOWER(um.status)'), 'current');
            })
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
            ->orderBy('m.numer', 'asc')
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

        for ($i = 1; $i <= 13; $i++) {
            $seq = str_pad($i, 2, "0", STR_PAD_LEFT);
            $tot_qty = $tot_qty_fields . $seq ?? '';
            $tot_qty_ls = $tot_qty_ls_fields . $seq ?? '';
            $inv = $inv_fields . $seq ?? '';
            $cust = $cust_fields . $seq ?? '';
            $tot['qty'][] = $monthwise->$tot_qty ?? '';
            $tot['ls'][] = $monthwise->$tot_qty_ls ?? '';
            $sold_qty = $sold_qty_fields . $seq ?? '';
            $sold_qty_ls = $sold_qty_ls_fields . $seq ?? '';
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

        // $subqueryPol = DB::table('zhtrmm_pol')
        //     ->select(
        //         'material',
        //         'purch_doc',
        //         'order_quantity',
        //         'po_prod_time',
        //         'po_exp_out_date',
        //         'cf_exp_out_date',
        //         'inb_act_arrival_date',
        //         'planned_delivery_time',
        //         DB::raw("SUBSTRING_INDEX(
        //             GROUP_CONCAT(confirm_category ORDER BY 
        //             CASE 
        //                 WHEN confirm_category = 'LA' THEN 1
        //                 WHEN confirm_category = 'AB' THEN 2
        //                 ELSE 3
        //             END
        //             ), ',', 1
        //         ) AS confirm_category")
        //     )
        //     ->where('material', $material)
        //     ->groupBy('purch_doc');
        $subqueryPol = DB::table('zhtrmm_pol')
            ->select(
                'material',
                'purch_doc',
                'order_quantity',
                'po_prod_time',
                'po_exp_out_date',
                'cf_exp_out_date',
                'inb_act_arrival_date',
                'confirm_category',
                'planned_delivery_time',
                DB::raw("ROW_NUMBER() OVER (
                    PARTITION BY purch_doc
                    ORDER BY
                        CASE confirm_category
                            WHEN 'LA' THEN 1
                            WHEN 'AB' THEN 2
                            WHEN NULL THEN 3
                            ELSE 4
                        END
                ) as rn")
            )
            ->where('material', $material);

        $rankedSubquery = DB::query()
            ->fromSub($subqueryPol, 'subquery')
            ->where('rn', 1)
            ->select(
                'material',
                'purch_doc',
                'order_quantity',
                'po_prod_time',
                'po_exp_out_date',
                'cf_exp_out_date',
                'inb_act_arrival_date',
                'confirm_category',
                'planned_delivery_time'
            );
            
        // Query สำหรับ PO (การสั่งซื้อ)
        $poQuery = DB::table('ZHWWMM_OPEN_ORDERS as a')
            ->leftJoinSub(
                $rankedSubquery,
                'b',
                function ($join) {
                    $join->on('a.purchasing_document', '=', 'b.purch_doc')
                        ->on('a.material', '=', 'b.material');
                }
            )
            ->leftJoin(DB::raw("(SELECT d1.war, d1.material FROM ZHWWBCQUERYDIR d1 WHERE d1.material = '{$material}' GROUP BY d1.material) as d"), 'd.material', '=', 'a.material')
            ->select([
                'a.material',
                DB::raw("
                    RIGHT(
                        YEAR(
                            CASE
                                WHEN b.confirm_category = 'LA' THEN DATE_ADD(STR_TO_DATE(b.inb_act_arrival_date, '%m/%d/%Y'), INTERVAL (COALESCE(d.war,0)) DAY)
                                WHEN b.confirm_category = 'AB' THEN DATE_ADD(STR_TO_DATE(b.cf_exp_out_date, '%m/%d/%Y'), INTERVAL (b.planned_delivery_time - b.po_prod_time + COALESCE(d.war,0)) DAY)
                                WHEN b.confirm_category IS NULL THEN DATE_ADD(STR_TO_DATE(b.po_exp_out_date, '%m/%d/%Y'), INTERVAL (b.planned_delivery_time - b.po_prod_time + COALESCE(d.war,0)) DAY)
                            END
                        ),
                        2
                    ) as years
                "),
                DB::raw("
                    WEEK(
                        CASE
                            WHEN b.confirm_category = 'LA' THEN DATE_ADD(STR_TO_DATE(b.inb_act_arrival_date, '%m/%d/%Y'), INTERVAL (COALESCE(d.war,0)) DAY)
                            WHEN b.confirm_category = 'AB' THEN DATE_ADD(STR_TO_DATE(b.cf_exp_out_date, '%m/%d/%Y'), INTERVAL (b.planned_delivery_time - b.po_prod_time + COALESCE(d.war,0)) DAY)
                            WHEN b.confirm_category IS NULL THEN DATE_ADD(STR_TO_DATE(b.po_exp_out_date, '%m/%d/%Y'), INTERVAL (b.planned_delivery_time - b.po_prod_time + COALESCE(d.war,0)) DAY)
                        END,
                        1
                    ) as weeks
                "),
                'a.po_order_unit AS WSS_ITEM_UOM_CODE',
                DB::raw("COALESCE(SUM(b.order_quantity), 0) AS WSS_INCOMING_QTY"),
                DB::raw("COALESCE(SUM(a.delivered_quantity), 0) AS WSS_RCV_QTY"),
            ])
            ->where('a.material', $material)
            ->groupBy('a.material', DB::raw('weeks'), DB::raw('years'));

        // Subquery t1
        $t1 = DB::table('ZHINSD_VA05 as a')
            ->select(
                'a.material',
                DB::raw("COALESCE(a.sd_document, '') AS ISD_DOC_NO"),
                DB::raw("COALESCE(SUM(a.confirmed_quantity), 0) AS sum_order_qty"),
                DB::raw("RIGHT(YEAR(STR_TO_DATE(a.delivery_date, '%m/%d/%Y')), 2) AS years"),
                DB::raw("WEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 1) AS weeks")
            )
            ->where('a.material', $material)
            ->where('a.status', '!=', 'Completed')
            ->groupBy(
                DB::raw("WEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 1)"),
                DB::raw("RIGHT(YEAR(STR_TO_DATE(a.delivery_date, '%m/%d/%Y')), 2)")
            );

        // Subquery t2
        $t2 = DB::table('ZHAASD_INV as b')
            ->select(
                'b.sales_document',
                'b.material',
                DB::raw('SUM(b.invoiced_quantity) AS sum_inv_qty')
            )
            ->where('b.material', $material)
            ->groupBy('b.sales_document', 'b.material');

        // Main query
        $soQuery = DB::table(DB::raw("({$t1->toSql()}) as t1"))
            ->mergeBindings($t1) // VERY IMPORTANT!
            ->leftJoin(DB::raw("({$t2->toSql()}) as t2"), function ($join) {
                $join->on('t1.material', '=', 't2.material')
                    ->on('t1.ISD_DOC_NO', '=', 't2.sales_document');
            })
            ->mergeBindings($t2) // VERY IMPORTANT!
            ->select(
                't1.material',
                't1.years',
                't1.weeks',
                't1.sum_order_qty',
                't2.sum_inv_qty',
                DB::raw('COALESCE(t1.sum_order_qty, 0) - COALESCE(t2.sum_inv_qty, 0) AS WSS_RES_QTY')
            );

        // Query สำหรับ Stock (สินค้าคงคลัง)
        $stockQuery = DB::table('MB52 as a')
            ->select(DB::raw("COALESCE(SUM(a.unrestricted), 0) AS WSS_AVAIL_QTY"))
            ->where('a.material', $material)
            ->where('a.storage_location', 'TH02')
            ->whereNull('a.special_stock')
            ->groupBy('a.material');

            // dd($poQuery->get());
        // รวมทั้งหมดเข้าด้วยกัน
        $wss = DB::table(DB::raw("({$weekSequence->toSql()}) as week_sequence"))
            ->mergeBindings($weekSequence)
            //->leftJoin(DB::raw("({$poQuery->toSql()}) as po"), 'po.weeks', '=', 'week_sequence.week_number')
            ->leftJoin(DB::raw('(' . $poQuery->toSql() . ') as po'), function ($join) {
                $join->on('po.weeks', '=', 'week_sequence.week_number')
                    ->on('po.years', '=', 'week_sequence.year_number');
            })
            ->mergeBindings($poQuery)
            //->leftJoin(DB::raw("({$soQuery->toSql()}) as so"), 'so.weeks', '=', 'week_sequence.week_number')
            ->leftJoin(DB::raw('(' . $soQuery->toSql() . ') as so'), function ($join) {
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

    $subquery = DB::table('zhwwmm_bom_vko as bom')
        ->selectRaw('SUM(CASE WHEN im.mvgr4 = "Z00" THEN 0 WHEN b.amount IS NOT NULL THEN (b.amount / b.per) * bom.quantity ELSE 0 END)')
        ->leftJoin('ZORDPOSKONV_ZPL as b', 'bom.component', '=', 'b.material')
        ->leftJoin('zhaamm_ifvmg_mat as im', 'bom.component', '=', 'im.matnr')
        ->whereColumn('bom.material', 'a.material');

    $uom = DB::table('ZHWWBCQUERYDIR as a')
        ->select([
            'a.material as IUW_ITEM_CODE',
            'a.bun as IUW_UOM_CODE',
            DB::raw('
                CASE
                    WHEN im.mvgr4 = "Z00" THEN "Check price with BD/PCM"
                    WHEN b.Amount IS NOT NULL THEN CONCAT(FORMAT(b.Amount / b.per, 2), " THB")
                    ELSE CONCAT(FORMAT((' . $subquery->toSql() . '), 2), " THB")
                END as IUW_PRICE'),
            DB::raw('
                CASE
                    WHEN d.Amount IS NOT NULL THEN CONCAT(FORMAT(d.Amount / d.Pricing_unit, 2)," THB")
                    ELSE "0 THB"
                END as NEW_ZPLV_COST'),
            DB::raw('CASE WHEN c.Amount IS NOT NULL THEN FORMAT(c.Amount / c.per, 2) ELSE "0" END as NEW_ZPE_COST'),
            DB::raw('CASE WHEN a.mov_avg_price IS NOT NULL THEN FORMAT(a.mov_avg_price / a.per, 2) ELSE "0" END as NEW_MAP_COST')
        ])
        ->mergeBindings($subquery)
        ->leftJoin('ZORDPOSKONV_ZPL as b', 'a.material', '=', 'b.Material')
        ->leftJoin('ZORDPOSKONV_ZPE as c', 'a.material', '=', 'c.Material')
        ->leftJoin('zplv as d', 'a.material', '=', 'd.Material')
        ->leftJoin('zhaamm_ifvmg_mat as im', 'im.matnr', '=', 'a.material')
        ->where('a.material', '=', $item_code)
        ->groupBy('c.material', 'c.uom')
        ->get();

        $stocks = DB::table('MB52')
            ->selectRaw("
                COALESCE(SUM(CASE WHEN storage_location = 'TH02' THEN unrestricted ELSE 0 END), 0) AS TH02,
                COALESCE(SUM(CASE WHEN storage_location = 'THS2' THEN unrestricted ELSE 0 END), 0) AS THS2,
                COALESCE(SUM(CASE WHEN storage_location = 'THS3' THEN unrestricted ELSE 0 END), 0) AS THS3,
                COALESCE(SUM(CASE WHEN storage_location = 'THS4' THEN unrestricted ELSE 0 END), 0) AS THS4,
                COALESCE(SUM(CASE WHEN storage_location = 'THS5' THEN unrestricted ELSE 0 END), 0) AS THS5,
                COALESCE(SUM(CASE WHEN storage_location = 'THS6' THEN unrestricted ELSE 0 END), 0) AS THS6
            ")
            ->where('material', $item_code)
            ->whereIn('storage_location', ['TH02', 'THS2', 'THS3', 'THS4', 'THS5', 'THS6'])
            ->first(); // ดึงแถวเดียว

        // ตรวจสอบว่ามีข้อมูลจาก material หรือไม่
        $flg = '';
        $check = DB::table('zhwwmm_bom_vko')->where('material', $item_code)->exists();

        // ตั้งค่า flag
        $flg = $check ? 'material' : 'component';

          // เริ่ม query
          $query = DB::table('zhwwmm_bom_vko as a')
              //->leftJoin('MB52 as b', 'b.material', '=', 'a.component')
              ->leftJoin('MB52 as b', function($join) {
                  $join->on('b.material', '=', 'a.component')
                       ->where('b.storage_location', '=', 'TH02');
              })
              ->leftJoin('ZORDPOSKONV_ZPL as c', 'a.component', '=', 'c.material')
              ->leftJoin('zhaamm_ifvmg_mat as im', 'a.component', '=', 'im.matnr')
              ->select(
                  'a.material as parent',
                  'a.bom_usg',
                  'a.base_quantity as parent_qty',
                  'a.component as comp',
                  'a.quantity as comp_qty',
                  'b.unrestricted as comp_stk',
                  DB::raw('(b.unrestricted / a.quantity) * a.base_quantity as cal_stk'),
                  DB::raw("'" . $flg . "' as flg"),
                  DB::raw('CONCAT(FORMAT(SUM(CASE WHEN im.mvgr4 = "Z00" THEN 0 WHEN c.amount IS NOT NULL THEN (c.amount / c.per) ELSE 0 END), 2), " THB") as price_per_unit')
              );

        // ใส่เงื่อนไข where ตาม flag
        if ($flg === 'material') {
            $query->where('a.material', $item_code)
                ->where(function ($q) {
                    $q->where('a.bom_usg', '!=', 1)  // ถ้า bom_usg ไม่ใช่ 1 => ผ่าน
                        ->orWhere(function ($q2) {
                            $q2->where('a.bom_usg', 1)   // ถ้า bom_usg เป็น 1
                                ->where('a.proc_type', 'E'); // ต้องมี proc_type = E
                        });
                })
                ->groupBy('a.component');
        } else {
            $query->where('a.component', $item_code)
                ->groupBy('a.material');
        }

        // สั่งเรียงลำดับ
        $bom = $query->orderBy('cal_stk', 'asc')
            ->get()
            ->map(function ($item) {
                $item->comp_stk = number_format($item->comp_stk, 0);
                $item->cal_stk = number_format($item->cal_stk, 0);
                return $item;
            });

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
            'bom' => $bom,
            //'t20_3' => $t20_3,
            //'t20_12' => $t20_12,
        ]);
    }

    public function inbound(Request $request)
    {
        $item_code = $request->item_code ?? '940.99.961';
        $ipd_week_no = $request->ipd_week_no ?? '2346';

        //$query = DB::table('OW_ITEMWISE_PO_DTLS_WEB_HAFL')->where('IPD_ITEM_CODE', $item_code)->where('IPD_WEEK_NO', $ipd_week_no);

        // $subqueryPol = DB::table('zhtrmm_pol')
        //     ->select(
        //         'material',
        //         'purch_doc',
        //         'order_quantity',
        //         'po_prod_time',
        //         'po_exp_out_date',
        //         'cf_exp_out_date',
        //         'inb_act_arrival_date',
        //         'planned_delivery_time',
        //         DB::raw("SUBSTRING_INDEX(
        //             GROUP_CONCAT(confirm_category ORDER BY 
        //             CASE 
        //                 WHEN confirm_category = 'LA' THEN 1
        //                 WHEN confirm_category = 'AB' THEN 2
        //                 ELSE 3
        //             END
        //             ), ',', 1
        //         ) AS confirm_category")
        //     )
        //     ->where('material', $item_code)
        //     ->groupBy('purch_doc');
        $subqueryPol = DB::table('zhtrmm_pol')
            ->select(
                'material',
                'purch_doc',
                'order_quantity',
                'po_prod_time',
                'po_exp_out_date',
                'cf_exp_out_date',
                'inb_act_arrival_date',
                'confirm_category',
                'planned_delivery_time',
                DB::raw("ROW_NUMBER() OVER (
                    PARTITION BY purch_doc
                    ORDER BY
                        CASE confirm_category
                            WHEN 'LA' THEN 1
                            WHEN 'AB' THEN 2
                            WHEN NULL THEN 3
                            ELSE 4
                        END
                ) as rn")
            )
            ->where('material', $item_code);

        $rankedSubquery = DB::query()
            ->fromSub($subqueryPol, 'subquery')
            ->where('rn', 1)
            ->select(
                'material',
                'purch_doc',
                'order_quantity',
                'po_prod_time',
                'po_exp_out_date',
                'cf_exp_out_date',
                'inb_act_arrival_date',
                'confirm_category',
                'planned_delivery_time'
            );

        $query = DB::table('ZHWWMM_OPEN_ORDERS as a')
            ->leftJoinSub(
                $rankedSubquery,
                'b',
                function ($join) {
                    $join->on('a.purchasing_document', '=', 'b.purch_doc')
                        ->on('a.material', '=', 'b.material');
                }
            )
            ->leftJoin('ZHAAMM_IFVMG as c', 'c.material', '=', 'a.material')
            ->leftJoin(DB::raw("(SELECT d1.war, d1.material FROM ZHWWBCQUERYDIR d1 WHERE d1.material = '{$item_code}' GROUP BY d1.material) as d"), 'd.material', '=', 'a.material')
            ->select([
                DB::raw("IFNULL(a.purchasing_document, '') as IPD_DOC_NO"),
                DB::raw("IFNULL(DATE_FORMAT(STR_TO_DATE(a.created_on_purchasing_doc, '%m/%d/%Y'),'%d/%m/%Y'),'') as IPD_DOC_DT"),
                DB::raw("IFNULL(a.po_order_unit, '') as IPD_UOM_CODE"),
                DB::raw("IFNULL(b.order_quantity, '') as IPD_QTY"),
                // DB::raw("IFNULL(SUM(a.quantity_po), '') as IPD_QTY"),
                DB::raw("IFNULL(DATE_FORMAT(STR_TO_DATE(a.vendor_output_date, '%m/%d/%Y'),'%d/%m/%Y'),'') as IPD_ETS"),
                DB::raw("IF(a.delivered_quantity > 0, 'S',IF(a.confirmed_issue_date IS NOT NULL, 'C', 'U')) as IPD_STATUS"),
                DB::raw("
                    DATE_FORMAT(
                        CASE
                            WHEN b.confirm_category = 'LA' THEN DATE_ADD(STR_TO_DATE(b.inb_act_arrival_date, '%m/%d/%Y'), INTERVAL (COALESCE(d.war,0)) DAY)
                            WHEN b.confirm_category = 'AB' THEN DATE_ADD(STR_TO_DATE(b.cf_exp_out_date, '%m/%d/%Y'), INTERVAL (b.planned_delivery_time - b.po_prod_time + COALESCE(d.war,0)) DAY)
                            WHEN b.confirm_category IS NULL THEN DATE_ADD(STR_TO_DATE(b.po_exp_out_date, '%m/%d/%Y'), INTERVAL (b.planned_delivery_time - b.po_prod_time + COALESCE(d.war,0)) DAY)
                        END,
                    '%d/%m/%Y'
                    ) as IPD_ETA
                ")
            ])
            ->where('a.material', $item_code)
            /*->whereRaw("WEEK(STR_TO_DATE(a.created_on_purchasing_doc, '%m/%d/%Y'), 1) = ?", [$ipd_week_no]);*/
            ->whereRaw("
                WEEK(
                    CASE
                        WHEN b.confirm_category = 'LA' THEN DATE_ADD(STR_TO_DATE(b.inb_act_arrival_date, '%m/%d/%Y'), INTERVAL (COALESCE(d.war,0)) DAY)
                        WHEN b.confirm_category = 'AB' THEN DATE_ADD(STR_TO_DATE(b.cf_exp_out_date, '%m/%d/%Y'), INTERVAL (b.planned_delivery_time - b.po_prod_time + COALESCE(d.war,0)) DAY)
                        WHEN b.confirm_category IS NULL THEN DATE_ADD(STR_TO_DATE(b.po_exp_out_date, '%m/%d/%Y'), INTERVAL (b.planned_delivery_time - b.po_prod_time + COALESCE(d.war,0)) DAY)
                    END,
                    1
                ) = ?
                ", [$ipd_week_no])
            ->groupBy('a.purchasing_document');

        $count = $query->count();
        $inbound = $query->get();
        //dd($inbound);
        return response()->json([
            'status' => true,
            'count' => $count,
            'data' => $inbound,
        ]);
    }

    public function outbound(Request $request)
    {

        $material = $request->item_code ?? '';
        $week = $request->week_no ?? '';
        $year = $request->year_no ?? '';

        $data = DB::table(DB::raw("(
          SELECT
              a.material,
              a.status,
              a.sold_to_party,
              a.name1,
              a.goods_issue_date,
              COALESCE(a.sd_document, '') AS ISD_DOC_NO,
              COALESCE(DATE_FORMAT(STR_TO_DATE(a.document_date, '%d/%m/%Y'), '%m/%d/%Y'), '') AS ISD_DOC_DT,
              COALESCE(a.unit_of_measure, '') AS ISD_UOM_CODE,
              COALESCE(SUM(a.order_quantity), 0) AS ISD_ORD_QTY,
              COALESCE(SUM(a.confirmed_quantity), 0) AS ISD_RESV_QTY,
              COALESCE(b1.sum_del_qty, 0) AS ISD_DEL_QTY,
              COALESCE(a.net_price, 0) AS ISD_RATE,
              COALESCE(a.order_quantity * a.pricing_unit, 0) AS ISD_VALUE,
              COALESCE(CONCAT_WS(' ', d.ZI, d.ISD_ADMIN), '') AS ISD_ADMIN,
              COALESCE(CONCAT_WS(' ', d.ZE, d.ISD_REP), '') AS ISD_REP,
              RIGHT(YEAR(STR_TO_DATE(a.delivery_date, '%m/%d/%Y')), 2) AS years,
              WEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 1) AS weeks
          FROM ZHINSD_VA05 a
          LEFT JOIN (
              SELECT b.material, b.sd_document, SUM(b.delivered_qty) AS sum_del_qty
              FROM ZHAASD_ORD b
              WHERE b.material = '$material'
              GROUP BY b.sd_document
          ) AS b1 ON b1.sd_document = a.sd_document
          LEFT JOIN (
              SELECT DISTINCT
                  a.SalesDoc, a.Material, a.ZI, a.ZE,
                  b1.IDMA_ZI_NAME AS ISD_ADMIN,
                  b2.IDMA_ZI_NAME AS ISD_REP
              FROM HWW_SD_06 a
              LEFT JOIN HWW_SD_CUSTLIS b1 ON b1.IDMA_ZI = a.ZI
              LEFT JOIN HWW_SD_CUSTLIS b2 ON b2.IDMA_ZI = a.ZE
              WHERE a.Material = '$material'
          ) AS d ON d.SalesDoc = a.sd_document AND d.Material = a.material
          WHERE a.material = '$material'
          AND a.status != 'Completed'
          AND RIGHT(YEAR(STR_TO_DATE(a.delivery_date, '%m/%d/%Y')), 2) = $year
          AND WEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 1) = $week
          GROUP BY a.sd_document
      ) AS t1"))
            ->leftJoin(DB::raw("(
          SELECT
              b.sales_document,
              b.material,
              SUM(b.invoiced_quantity) AS ISD_INV_QTY
          FROM ZHAASD_INV b
          WHERE b.material = '$material'
          GROUP BY b.sales_document, b.material
      ) AS t2"), function ($join) {
                $join->on('t1.material', '=', 't2.material')
                    ->on('t1.ISD_DOC_NO', '=', 't2.sales_document');
            })
            ->select(DB::raw("
          t1.*,
          COALESCE(t2.ISD_INV_QTY, 0) AS ISD_INV_QTY,
          CASE
              WHEN COALESCE(t2.ISD_INV_QTY, 0) > 0 THEN COALESCE(t1.goods_issue_date, '')
              ELSE ''
          END AS ISD_DEL_DT
      "));


        $sql = '';
        $count = $data->count();
        $outbound = $data->get();
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
