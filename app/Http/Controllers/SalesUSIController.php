<?php

namespace App\Http\Controllers;

use App\Exports\TemplateExport;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SalesUSIController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:salesusi view|salesusi manager|salesusi iodetail', ['only' => ['index', 'search_usi', 'inbound', 'outbound']]);
    }
    public function index()
    {
        $query = DB::table('ZHWWMM_OPEN_ORDERS')
            ->select('created_at')
            ->first();

        $created_at = $query->created_at;

        return view('pages.sales_usi.index', ['created_at' => $created_at]);
    }

    public function indexPC()
    {
        $query = DB::table('ZHWWMM_OPEN_ORDERS')
            ->select('created_at')
            ->first();

        $created_at = $query->created_at;

        return view('pages.sales_usi.index-pc', ['created_at' => $created_at]);
    }

    public function search_usi(Request $request)
    {
        if (!auth()->check()) {
            abort(403);
        }
        // Validator
        request()->validate([
            'item_code' => 'required|string|max:10'
        ]);

        $item_code = request()->item_code ?? '';

        // Mapping Data to Array
        $pgrMapping = $this->getPgrMapping();
        $stMapping = $this->getStMapping();
        $lageMapping = $this->getLageMapping();
        $dmMapping = $this->getDmMapping();

        // Part 1: USI Query
        $usiQuery = DB::table('ZHWWBCQUERYDIR as m')
            ->select([
                DB::raw("CASE WHEN m.material IS NULL OR m.material = '' THEN 'N/A' ELSE m.material END AS NSU_ITEM_CODE"),
                DB::raw("CASE WHEN m.kurztext IS NULL OR m.kurztext = '' THEN 'N/A' ELSE m.kurztext END AS NSU_ITEM_NAME"),
                DB::raw("CASE WHEN m.dm IS NULL OR m.dm = '' THEN 'N/A' ELSE m.dm END AS NSU_ITEM_DM"),
                DB::raw("CASE WHEN m.bun IS NULL OR m.bun = '' THEN 'N/A' ELSE m.bun END AS NSU_ITEM_UOM_CODE"),
                DB::raw("CONCAT(COALESCE(m.product_group_manager, ''), '-', COALESCE(um.name_en, '')) as NSU_PROD_MGR"),
                DB::raw("CASE WHEN u.uom_text IS NULL OR u.uom_text = '' THEN 'N/A' ELSE u.uom_text END AS NSU_PACK_UOM_CODE"),
                DB::raw("CASE WHEN m.numer IS NULL OR m.numer = '' THEN 'N/A' ELSE m.numer END AS NSU_CONV_BASE_UOM"),
                DB::raw("CASE WHEN m.gross_weight IS NULL OR m.gross_weight = '' THEN 'N/A' ELSE CONCAT(FORMAT(m.gross_weight, 2), ' ', m.wun) END AS NSU_PACK_WEIGHT"),
                DB::raw("CASE WHEN m.volume IS NULL OR m.volume = '' THEN 'N/A' ELSE CONCAT(FORMAT(m.volume, 2), ' ', m.vun) END AS NSU_PACK_VOLUME"),
                DB::raw("CASE WHEN mf.TDLINE IS NULL OR mf.TDLINE = '' THEN 'N/A' ELSE mf.TDLINE END AS NSU_EXCL_REMARK"),
                DB::raw("CASE WHEN pm.certificate IS NULL OR pm.certificate = '' THEN 'N/A' ELSE pm.certificate END AS NSU_ITEM_BRAND"),
                DB::raw("CASE WHEN m.follow_up_material IS NULL OR m.follow_up_material = '' THEN 'N/A' ELSE m.follow_up_material END AS NSU_NEW_ITEM_CODE"),
                DB::raw("CASE WHEN p.planned_deliv_time IS NULL OR p.planned_deliv_time = '' THEN 'N/A' ELSE p.planned_deliv_time END AS NSU_SUPP_REPL_TIME"),
                DB::raw("CASE WHEN p.minimum_order_qty IS NULL OR p.minimum_order_qty = '' THEN 'N/A' ELSE p.minimum_order_qty END AS NSU_PURC_MOQ"),
                DB::raw("CASE WHEN p.vendor_material_number IS NULL OR p.vendor_material_number = '' THEN 'N/A' ELSE p.vendor_material_number END AS NSU_SUPP_ITEM_CODE"),
                DB::raw("CASE WHEN p.ean_upc IS NULL OR p.ean_upc = '' THEN 'N/A' ELSE p.ean_upc END AS ean_upc"),
                DB::raw("CASE WHEN i.unrestricted IS NULL OR i.unrestricted = '' THEN '0' ELSE FORMAT(i.unrestricted,0) END AS NSU_FREE_STK_QTY")
            ])
            ->selectRaw($this->generateCaseStatement('m.pgr', $pgrMapping, 'NSU_PURCHASER'))
            ->selectRaw($this->generateCaseStatement('m.st', $stMapping, 'NSU_ITEM_STATUS', 'Active'))
            ->selectRaw($this->generateCaseStatement('m.lage', $lageMapping, 'NSU_ITEM_INV_CODE'))
            ->selectRaw($this->generateDmDescriptionCase($dmMapping))
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
                    ->where('i.storage_location', 'TH02')
                    ->whereNull('i.special_stock');
            })
            ->leftJoin('FIS_MPM_OUT as mf', 'mf.MATNR', '=', 'm.material')
            ->leftJoin('ZMM_MATZERT as pm', 'pm.material', '=', 'm.material')
            ->leftJoin('UOM_Mapping as u', 'u.uom', '=', 'm.aun')
            ->leftJoin('ZORDPOSKONV_ZPL as zpl', 'zpl.material', '=', 'm.material')
            ->leftJoin('zplv', 'zplv.material', '=', 'm.material')
            ->leftJoin('ZHAASD_ORD as od', 'od.material', '=', 'm.material')
            ->where('m.material', $item_code)
            ->orderBy('m.numer', 'asc');

        $usis = $usiQuery->get();
        $count = $usis->count();

        // Part 2: Monthly Stock (MSS)
        $monthwise = DB::table('OW_MONTHWISE_STK_SUM_WEB_HAFL')
            ->where('MSS_ITEM_CODE', $item_code)
            ->first();

        $mss = $this->processMonthwiseData($monthwise);

        // Part 3: Weekly Stock (WSS)
        $material = $item_code;
        $poQuery = $this->buildPoQuery($material);
        $soQuery = $this->buildSoQuery($material);
        $stockQuery = $this->buildStockQuery($material);

        $wss = $this->buildWssQuery($poQuery, $soQuery, $stockQuery);

        // Part 4: UOM
        $uomQuery = $this->buildUomQuery($item_code);
        $uom = $uomQuery->get();

        // Part 5: Stocks
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
            ->first();

        // Part 6: BOM
        $flg = DB::table('zhwwmm_bom_vko')->where('material', $item_code)->exists() ? 'material' : 'component';
        $bomQuery = $this->buildBomQuery($item_code, $flg);
        $bom = $bomQuery->get()->map(function ($item) {
            $item->comp_stk = number_format($item->comp_stk, 0);
            $item->cal_stk = number_format($item->cal_stk, 0);
            return $item;
        });

        return response()->json([
            'status' => true,
            'count' => $count,
            'data' => $usis,
            'mss' => $mss,
            'wss' => $wss,
            'uom' => $uom,
            'stocks' => $stocks,
            'bom' => $bom,
        ]);
    }

    public function inbound(Request $request)
    {
        //  Validate and Sanitize input
        request()->validate([
            'item_code' => 'nullable|string|max:10',
            'ipd_week_no' => 'nullable|string',
        ]);

        $item_code = $request->item_code ?? '940.99.961';
        $ipd_week_no = $request->ipd_week_no ?? '2346';

        // Subqueries
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
                'po_transport_time',
                'position_no',
                DB::raw("ROW_NUMBER() OVER (
                    PARTITION BY purch_doc, position_no
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
                'planned_delivery_time',
                'po_transport_time',
                'position_no',
            );

        $subqueryWar = DB::table('ZHWWBCQUERYDIR')
            ->select('war', 'material')
            ->where('material', $item_code)
            ->groupBy('material');

        // Main query
        $query = DB::table('ZHWWMM_OPEN_ORDERS as a')
            ->leftJoinSub(
                $rankedSubquery,
                'b',
                fn($join) => $join->on('a.purchasing_document', '=', 'b.purch_doc')
                    ->on('a.material', '=', 'b.material')
            )
            ->leftJoin('ZHAAMM_IFVMG as c', 'c.material', '=', 'a.material')
            ->leftJoinSub(
                $subqueryWar,
                'd',
                fn($join) => $join->on('d.material', '=', 'a.material')
            )
            ->select([
                DB::raw("COALESCE(a.purchasing_document, '') AS IPD_DOC_NO"),
                DB::raw("DATE_FORMAT(STR_TO_DATE(a.created_on_purchasing_doc, '%m/%d/%Y'),'%d/%m/%Y') AS IPD_DOC_DT"),
                DB::raw("COALESCE(a.po_order_unit, '') AS IPD_UOM_CODE"),
                DB::raw("COALESCE(b.order_quantity, '') AS IPD_QTY"),
                DB::raw("DATE_FORMAT(STR_TO_DATE(a.vendor_output_date, '%m/%d/%Y'),'%d/%m/%Y') AS IPD_ETS"),
                DB::raw("IF(a.delivered_quantity > 0, 'S', IF(a.confirmed_issue_date IS NOT NULL, 'C', 'U')) AS IPD_STATUS"),
                DB::raw("
                    DATE_FORMAT(
                        CASE
                            WHEN b.confirm_category = 'LA' THEN DATE_ADD(STR_TO_DATE(b.inb_act_arrival_date, '%m/%d/%Y'), INTERVAL (COALESCE(d.war,0)) DAY)
                            WHEN b.confirm_category = 'AB' THEN DATE_ADD(STR_TO_DATE(b.cf_exp_out_date, '%m/%d/%Y'), INTERVAL (b.po_transport_time + COALESCE(d.war,0)) DAY)
                            WHEN b.confirm_category IS NULL THEN DATE_ADD(STR_TO_DATE(b.po_exp_out_date, '%m/%d/%Y'), INTERVAL (b.po_transport_time + COALESCE(d.war,0)) DAY)
                        END,
                    '%d/%m/%Y'
                    ) AS IPD_ETA
                ")
            ])
            ->where('a.material', $item_code)
            ->whereRaw("
                WEEK(
                    CASE
                        WHEN b.confirm_category = 'LA' THEN DATE_ADD(STR_TO_DATE(b.inb_act_arrival_date, '%m/%d/%Y'), INTERVAL (COALESCE(d.war, 0)) DAY)
                        WHEN b.confirm_category = 'AB' THEN DATE_ADD(STR_TO_DATE(b.cf_exp_out_date, '%m/%d/%Y'), INTERVAL (b.po_transport_time + COALESCE(d.war, 0)) DAY)
                        WHEN b.confirm_category IS NULL THEN DATE_ADD(STR_TO_DATE(b.po_exp_out_date, '%m/%d/%Y'), INTERVAL (b.po_transport_time + COALESCE(d.war, 0)) DAY)
                    END, 3
                ) = ?", [$ipd_week_no])
            ->groupBy('a.purchasing_document', 'b.position_no');

        $inbound = $query->get();
        $count = $inbound->count();

        return response()->json([
            'status' => true,
            'count' => $count,
            'data' => $inbound,
        ]);
    }

    public function outbound(Request $request)
    {
        // Validate and Sanitize input
        request()->validate([
            'item_code' => 'nullable|string|max:10',
            'week_no' => 'nullable|integer',
            'year_no' => 'nullable|integer',
        ]);

        $material = $request->item_code ?? '';
        $week = $request->week_no ?? '';
        $year = $request->year_no ?? '';

        // Subquery t1
        $subquery1 = DB::table('ZHINSD_VA05 as a')
            ->select(
                'a.material',
                'a.status',
                'a.sold_to_party',
                'a.name1',
                'a.goods_issue_date',
                DB::raw("COALESCE(a.sd_document, '') AS ISD_DOC_NO"),
                DB::raw("COALESCE(DATE_FORMAT(STR_TO_DATE(a.document_date, '%d/%m/%Y'), '%m/%d/%Y'), '') AS ISD_DOC_DT"),
                DB::raw("COALESCE(a.unit_of_measure, '') AS ISD_UOM_CODE"),
                DB::raw("COALESCE(SUM(a.order_quantity), 0) AS ISD_ORD_QTY"),
                DB::raw("COALESCE(SUM(a.confirmed_quantity), 0) AS ISD_RESV_QTY"),
                DB::raw("COALESCE(b1.sum_del_qty, 0) AS ISD_DEL_QTY"),
                DB::raw("COALESCE(a.net_price, 0) AS ISD_RATE"),
                DB::raw("COALESCE(a.order_quantity * a.pricing_unit, 0) AS ISD_VALUE"),
                DB::raw("COALESCE(CONCAT_WS(' ', d.ZI, d.ISD_ADMIN), '') AS ISD_ADMIN"),
                DB::raw("COALESCE(CONCAT_WS(' ', d.ZE, d.ISD_REP), '') AS ISD_REP"),
                DB::raw("RIGHT(LEFT(YEARWEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 3), 4), 2) AS years"),
                DB::raw("WEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 3) AS weeks")
            )
            ->leftJoinSub(
                DB::table('ZHAASD_ORD')
                    ->selectRaw('material, sd_document, SUM(delivered_qty) AS sum_del_qty')
                    ->where('material', $material)
                    ->groupBy('sd_document'),
                'b1',
                fn($join) => $join->on('b1.sd_document', '=', 'a.sd_document')
            )
            ->leftJoinSub(
                DB::table('HWW_SD_06 as a')
                    ->selectRaw('DISTINCT a.SalesDoc, a.Material, a.ZI, a.ZE, b1.IDMA_ZI_NAME AS ISD_ADMIN, b2.IDMA_ZI_NAME AS ISD_REP')
                    ->leftJoin('HWW_SD_CUSTLIS as b1', 'b1.IDMA_ZI', '=', 'a.ZI')
                    ->leftJoin('HWW_SD_CUSTLIS as b2', 'b2.IDMA_ZI', '=', 'a.ZE')
                    ->where('a.Material', $material),
                'd',
                fn($join) => $join->on('d.SalesDoc', '=', 'a.sd_document')
                    ->on('d.Material', '=', 'a.material')
            )
            ->where('a.material', $material)
            ->where('a.status', '!=', 'Completed');

        // Conditions: week, year
        if ($year !== null) {
            $subquery1->whereRaw("LEFT(YEARWEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 3), 4) = ?", ['20' . $year]);
        }

        if ($week !== null) {
            $subquery1->whereRaw("WEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 3) = ?", [$week]);
        }

        $subquery1->groupBy('a.sd_document');

        // Subquery t2
        $subquery2 = DB::table('ZHAASD_INV as b')
            ->selectRaw('b.sales_document, b.material, SUM(b.invoiced_quantity) AS ISD_INV_QTY')
            ->where('b.material', $material)
            ->groupBy('b.sales_document', 'b.material');

        // Query, Join Subqueries
        $data = DB::query()
            ->fromSub($subquery1, 't1')
            ->leftJoinSub(
                $subquery2,
                't2',
                fn($join) => $join->on('t1.material', '=', 't2.material')
                    ->on('t1.ISD_DOC_NO', '=', 't2.sales_document')
            )
            ->selectRaw("
                t1.*,
                COALESCE(t2.ISD_INV_QTY, 0) AS ISD_INV_QTY,
                CASE
                    WHEN COALESCE(t2.ISD_INV_QTY, 0) > 0 THEN COALESCE(t1.goods_issue_date, '')
                    ELSE ''
                END AS ISD_DEL_DT
            ");

        $count = $data->count();
        $outbound = $data->get();

        return response()->json([
            'status' => true,
            'count' => $count,
            'data' => $outbound,
            'sql' => $data->toSql(),
        ]);
    }

    public function showProductInfo()
    {
        return view('pages.sales_usi.product-info.show', [
            'item_code' => request()->item_code
        ]);
    }

    public function editProductInfo()
    {
        return view('pages.sales_usi.product-info.edit');
    }

    public function indexProductInfo()
    {
        // get data from new table => product information (item_code, project item, super seed, spare part ...)
        $productInformations = [];
        
        return view('pages.sales_usi.product-info.index', [
            'productInformations' => $productInformations
        ]);
    }

    public function downloadExcelTemplate($type)
    {
        $fileName = "template_{$type}_" . now()->format('Ymd') . ".xlsx";
        
        return Excel::download(new TemplateExport($type), $fileName);
    }

    private function getPgrMapping(): array
    {
        return [
            'T01' => 'T01-Unchalee Yensawad',
            'T02' => 'T02-Ruthairat K.',
            'T03' => 'T03-Vacant 1',
            'T04' => 'T04-Supasinee Kanyamee',
            'T05' => 'T05-Sucharee Sripa',
            'T06' => 'T06-Benjamas Boonfak',
            'T07' => 'T07-Kanokporn Chalaem',
            'T08' => 'T08-Hathaipat Buangam',
            'T09' => 'T09-Thitiluk Apichaiwo',
            'T10' => 'T10-Monchaya Somsuk',
            'T11' => 'T11-Vipavin Nisayun',
            'T12' => 'T12-Rapeepan Soongrang',
            'T13' => 'T13-Pornpimol K.',
            'T14' => 'T14-Wannisa Kongin',
            'T15' => 'T15-Siriporn Pinkaew',
            'T16' => 'T16-Wanthana S.',
            'T17' => 'T17-Chaninat Kongkarun',
            'T18' => 'T18-Kanokon Pakaedam',
            'T19' => 'T19-Chanikarn Yati',
            'T20' => 'T20-Vacant 3',
            'T21' => 'T21-Vacant 4',
            'T22' => 'T22-Vacant 5',
            'T23' => 'T23-Vacant 6',
            'T24' => 'T24-Kotchaporn S.',
            'T25' => 'T25-Thanat A.',
            'T26' => 'T26-Khwanvalee P.',
            'T31' => 'T31-HTH EHK PurGrp 1',
            'T32' => 'T32-HTH EHK PurGrp 2',
            'T33' => 'T33-HTH EHK PurGrp 3',
            'T99' => 'T99-Relocation',
            'TH1' => 'TH1-SCM (Non-trade)',
            'TH2' => 'TH2-IT (Non-trade)',
            'TH3' => 'TH3-Fin.&Adm. (NT)',
            'TH4' => 'TH4-Retail Sales (NT)',
            'TH5' => 'TH5-Project Sales (NT)',
            'TH6' => 'TH6-PCM (NT)',
            'TH7' => 'TH7-CS (Non-trade)',
            'TH8' => 'TH8-Logistics (NT)',
            'TH9' => 'TH9-HR-POA (NT)',
            'THA' => 'THA-HR-POD (NT)',
            'THB' => 'THB-HR-TA&HRBP (NT)',
            'THC' => 'THC-Marketing (NT)'
        ];
    }

    private function getStMapping(): array
    {
        return [
            'Z1' => 'Z1-Basic data not compl',
            'Z2' => 'Z2-Article not distrib.',
            'ZB' => 'ZB-Sales Blocked',
            'ZC' => 'ZC-Sales Blocked for QC',
            'ZD' => 'ZD-Arranged for Delet.',
            'ZL' => 'ZL-Unpacked',
            'ZM' => 'ZM-Sell no minim.quant.',
            'ZR' => 'ZR-Sell out & delete',
            'ZS' => 'ZS-Sales Stopped',
        ];
    }

    private function getLageMapping(): array
    {
        return [
            'NLW' => 'NLW-Not storage goods',
            'LW' => 'LW-Stock goods',
        ];
    }

    private function getDmMapping(): array
    {
        return [
            'LW|Z4' => 'Stock Item',
            'LW|ZM' => 'Stock Item',
            'LW|PD' => 'C Item',
            'NLW|ZX' => 'C Item',
            'NLW|ZD' => 'C Item',
        ];
    }

    private function generateCaseStatement(string $columnName, array $mapping, string $alias, string $default = 'N/A'): string
    {
        $cases = collect($mapping)->map(function ($value, $key) use ($columnName) {
            return "WHEN {$columnName} = '{$key}' THEN '{$value}'";
        })->implode("\n");

        $elseName = $columnName === 'm.pgr' ? "'Unknown'" : $columnName;

        return "
            CASE
                WHEN {$columnName} IS NULL OR {$columnName} = '' THEN '{$default}'
                {$cases}
                ELSE {$elseName}
            END AS {$alias}
        ";
    }

    private function generateDmDescriptionCase(array $mapping): string
    {
        $cases = collect($mapping)->map(function ($value, $key) {
            list($lage, $dm) = explode('|', $key);
            return "WHEN m.lage = '{$lage}' AND m.dm = '{$dm}' THEN CONCAT(m.dm, '-', '{$value}')";
        })->implode("\n");

        return "
            CASE
                {$cases}
                ELSE NULL
            END AS NSU_ITEM_DM_DESC
        ";
    }

    private function processMonthwiseData(?object $monthwise): array
    {
        $mss = ['inv' => [], 'cust' => [], 'tot' => ['qty' => [], 'ls' => []], 'sold' => ['qty' => [], 'ls' => []]];

        for ($i = 1; $i <= 13; $i++) {
            $seq = str_pad($i, 2, "0", STR_PAD_LEFT);
            $mss['tot']['qty'][] = $monthwise->{'MSS_TOT_QTY_' . $seq} ?? '';
            $mss['tot']['ls'][] = $monthwise->{'MSS_TOT_QTY_LS_' . $seq} ?? '';
            $mss['sold']['qty'][] = $monthwise->{'MSS_SOLD_QTY_' . $seq} ?? '';
            $mss['sold']['ls'][] = $monthwise->{'MSS_SOLD_QTY_LS_' . $seq} ?? '';
            $mss['inv'][] = $monthwise->{'MSS_INV_COUNT_' . $seq} ?? '';
            $mss['cust'][] = $monthwise->{'MSS_CUST_COUNT_' . $seq} ?? '';
        }

        return $mss;
    }

    private function buildPoQuery(string $material)
    {
        $rankedPoItemsQuery = DB::table('zhtrmm_pol')
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
                'po_transport_time',
                'position_no',
                DB::raw("ROW_NUMBER() OVER (
                    PARTITION BY purch_doc, position_no
                    ORDER BY
                        CASE confirm_category
                            WHEN 'LA' THEN 1 
                            WHEN 'AB' THEN 2 
                            WHEN NULL THEN 3 
                            ELSE 4
                        END
                    ) as rn
                ")
            )
            ->where('material', $material);

        $poItemSubquery = DB::query()
            ->fromSub($rankedPoItemsQuery, 'poItemsQuery')
            ->where('rn', 1)
            ->select('*');

        $warSubquery = DB::table('ZHWWBCQUERYDIR')
            ->select('war', 'material')
            ->where('material', $material)
            ->groupBy('material');

        $date_expression = "CASE
                WHEN b.confirm_category = 'LA' THEN DATE_ADD(STR_TO_DATE(b.inb_act_arrival_date, '%m/%d/%Y'), INTERVAL (COALESCE(d.war,0)) DAY)
                WHEN b.confirm_category = 'AB' THEN DATE_ADD(STR_TO_DATE(b.cf_exp_out_date, '%m/%d/%Y'), INTERVAL (b.po_transport_time + COALESCE(d.war,0)) DAY)
                WHEN b.confirm_category IS NULL THEN DATE_ADD(STR_TO_DATE(b.po_exp_out_date, '%m/%d/%Y'), INTERVAL (b.po_transport_time + COALESCE(d.war,0)) DAY)
            END";

        $poQuery = DB::table('ZHWWMM_OPEN_ORDERS as a')
            ->leftJoinSub($poItemSubquery, 'b', function ($join) {
                $join->on('a.purchasing_document', '=', 'b.purch_doc')
                    ->on('a.material', '=', 'b.material');
            })
            ->leftJoinSub(
                $warSubquery,
                'd',
                function ($join) {
                    $join->on('d.material', '=', 'a.material');
                }
            )
            ->select([
                'a.material',
                'b.position_no',
                DB::raw("RIGHT(LEFT(YEARWEEK($date_expression, 3), 4), 2) AS years"),
                DB::raw("WEEK($date_expression, 3) AS weeks"),
                'a.po_order_unit AS WSS_ITEM_UOM_CODE',
                'b.order_quantity',
                'a.delivered_quantity'
            ])
            ->where('a.material', $material)
            ->groupBy('a.material', 'b.position_no', 'years', 'weeks');

        $aggregatedPoQuery = DB::query()
            ->fromSub($poQuery, 'poquery')
            ->select([
                'material',
                'years',
                'weeks',
                'WSS_ITEM_UOM_CODE',
                DB::raw("COALESCE(SUM(order_quantity), 0) AS WSS_INCOMING_QTY"),
                DB::raw("COALESCE(SUM(delivered_quantity), 0) AS WSS_RCV_QTY"),
            ])
            ->where('material', $material)
            ->groupBy('material', 'years', 'weeks');

        return $aggregatedPoQuery;
    }

    private function buildSoQuery(string $material)
    {
        $t1 = DB::table('ZHINSD_VA05 as a')
            ->select(
                'a.material',
                DB::raw("COALESCE(a.sd_document, '') AS ISD_DOC_NO"),
                DB::raw("COALESCE(SUM(a.confirmed_quantity), 0) AS sum_order_qty"),
                DB::raw("RIGHT(LEFT(YEARWEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 3), 4), 2) AS years"),
                DB::raw("WEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 3) AS weeks")
            )
            ->where('a.material', $material)
            ->where('a.status', '!=', 'Completed')
            ->groupBy(
                DB::raw("WEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 3)"),
                DB::raw("RIGHT(LEFT(YEARWEEK(STR_TO_DATE(a.delivery_date, '%m/%d/%Y'), 3), 4), 2)")
            );

        $t2 = DB::table('ZHAASD_INV as b')
            ->select(
                'b.sales_document',
                'b.material',
                DB::raw('SUM(b.invoiced_quantity) AS sum_inv_qty')
            )
            ->where('b.material', $material)
            ->groupBy('b.sales_document', 'b.material');

        return DB::table(DB::raw("({$t1->toSql()}) as t1"))
            ->mergeBindings($t1)
            ->leftJoin(DB::raw("({$t2->toSql()}) as t2"), function ($join) {
                $join->on('t1.material', '=', 't2.material')
                    ->on('t1.ISD_DOC_NO', '=', 't2.sales_document');
            })
            ->mergeBindings($t2)
            ->select(
                't1.material',
                't1.years',
                't1.weeks',
                't1.sum_order_qty',
                't2.sum_inv_qty',
                DB::raw('COALESCE(t1.sum_order_qty, 0) - COALESCE(t2.sum_inv_qty, 0) AS WSS_RES_QTY')
            );
    }

    private function buildStockQuery(string $material)
    {
        return DB::table('MB52 as a')
            ->select(DB::raw("COALESCE(SUM(a.unrestricted), 0) AS WSS_AVAIL_QTY"))
            ->where('a.material', $material)
            ->where('a.storage_location', 'TH02')
            ->whereNull('a.special_stock')
            ->groupBy('a.material');
    }

    private function buildWssQuery(Builder $poQuery, Builder $soQuery, Builder $stockQuery)
    {
        $weekSequence = DB::table(DB::raw('(WITH RECURSIVE week_sequence AS (
                SELECT WEEK(DATE_SUB(CURDATE(), INTERVAL 1 WEEK), 1) AS week_number, -1 AS week_offset, RIGHT(YEAR(DATE_SUB(CURDATE(), INTERVAL 1 WEEK)), 2) AS year_number
                UNION ALL
                SELECT WEEK(DATE_ADD(CURDATE(), INTERVAL week_offset + 1 WEEK), 1), week_offset + 1, RIGHT(YEAR(DATE_ADD(CURDATE(), INTERVAL week_offset + 1 WEEK)), 2) AS year_number
                FROM week_sequence
                WHERE week_offset < 52
            ) SELECT * FROM week_sequence) as week_sequence'))
            ->select('week_number', 'week_offset', 'year_number');

        return DB::table(DB::raw("({$weekSequence->toSql()}) as week_sequence"))
            ->mergeBindings($weekSequence)
            ->leftJoin(DB::raw('(' . $poQuery->toSql() . ') as po'), function ($join) {
                $join->on('po.weeks', '=', 'week_sequence.week_number')
                    ->on('po.years', '=', 'week_sequence.year_number');
            })
            ->mergeBindings($poQuery)
            ->leftJoin(DB::raw('(' . $soQuery->toSql() . ') as so'), function ($join) {
                $join->on('so.weeks', '=', 'week_sequence.week_number')
                    ->on('so.years', '=', 'week_sequence.year_number');
            })
            ->mergeBindings($soQuery)
            ->leftJoin(DB::raw("({$stockQuery->toSql()}) as un"), DB::raw('1'), DB::raw('1'))
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
    }

    private function buildUomQuery(string $item_code)
    {
        $subquery = DB::table('zhwwmm_bom_vko as bom')
            ->selectRaw('SUM(CASE WHEN im.mvgr4 = "Z00" THEN 0 WHEN b.amount IS NOT NULL THEN (b.amount / b.per) * bom.quantity ELSE 0 END)')
            ->leftJoin('ZORDPOSKONV_ZPL as b', 'bom.component', '=', 'b.material')
            ->leftJoin('zhaamm_ifvmg_mat as im', 'bom.component', '=', 'im.matnr')
            ->whereColumn('bom.material', 'a.material');

        if (auth()->user()->hasPermissionTo('salesusi manager')) {
            return DB::table('ZHWWBCQUERYDIR as a')
                ->select([
                    'a.material as IUW_ITEM_CODE',
                    'a.bun as IUW_UOM_CODE',
                    DB::raw("
                        CASE
                            WHEN im.mvgr4 = 'Z00' THEN 'Check price with BD/PCM'
                            WHEN b.Amount IS NOT NULL THEN CONCAT(FORMAT(b.Amount / b.per, 2), ' THB')
                            ELSE CONCAT(FORMAT(({$subquery->toSql()}), 2), ' THB')
                        END as IUW_PRICE
                    "),
                    DB::raw("CASE WHEN d.Amount IS NOT NULL THEN CONCAT(FORMAT(d.Amount / d.Pricing_unit, 2),' THB') ELSE '0 THB' END as NEW_ZPLV_COST"),
                    DB::raw("CASE WHEN c.Amount IS NOT NULL THEN FORMAT(c.Amount / c.per, 2) ELSE '0' END as NEW_ZPE_COST"),
                    DB::raw("CASE WHEN a.mov_avg_price IS NOT NULL THEN FORMAT(a.mov_avg_price / a.per, 2) ELSE '0' END as NEW_MAP_COST")
                ])
                ->mergeBindings($subquery)
                ->leftJoin('ZORDPOSKONV_ZPL as b', 'a.material', '=', 'b.Material')
                ->leftJoin('ZORDPOSKONV_ZPE as c', 'a.material', '=', 'c.Material')
                ->leftJoin('zplv as d', 'a.material', '=', 'd.Material')
                ->leftJoin('zhaamm_ifvmg_mat as im', 'im.matnr', '=', 'a.material')
                ->where('a.material', $item_code)
                ->groupBy('c.material', 'c.uom');
        } else {
            return DB::table('ZHWWBCQUERYDIR as a')
                ->select([
                    'a.material as IUW_ITEM_CODE',
                    'a.bun as IUW_UOM_CODE',
                    DB::raw("
                        CASE
                            WHEN im.mvgr4 = 'Z00' THEN 'Check price with BD/PCM'
                            WHEN b.Amount IS NOT NULL THEN CONCAT(FORMAT(b.Amount / b.per, 2), ' THB')
                            ELSE CONCAT(FORMAT(({$subquery->toSql()}), 2), ' THB')
                        END as IUW_PRICE
                    "),
                    DB::raw("CASE WHEN d.Amount IS NOT NULL THEN CONCAT(FORMAT(d.Amount / d.Pricing_unit, 2),' THB') ELSE '0 THB' END as NEW_ZPLV_COST")
                ])
                ->mergeBindings($subquery)
                ->leftJoin('ZORDPOSKONV_ZPL as b', 'a.material', '=', 'b.Material')
                ->leftJoin('ZORDPOSKONV_ZPE as c', 'a.material', '=', 'c.Material')
                ->leftJoin('zplv as d', 'a.material', '=', 'd.Material')
                ->leftJoin('zhaamm_ifvmg_mat as im', 'im.matnr', '=', 'a.material')
                ->where('a.material', $item_code)
                ->groupBy('c.material', 'c.uom');
        }
    }

    private function buildBomQuery(string $item_code, string $flg)
    {
        $query = DB::table('zhwwmm_bom_vko as a')
            ->leftJoin('MB52 as b', function ($join) {
                $join->on('b.material', '=', 'a.component')
                    ->where('b.storage_location', 'TH02');
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
                DB::raw('(COALESCE(b.unrestricted, 0) / a.quantity) * a.base_quantity as cal_stk'),
                DB::raw("'" . $flg . "' as flg"),
                DB::raw('CONCAT(FORMAT(SUM(CASE WHEN im.mvgr4 = "Z00" THEN 0 WHEN c.amount IS NOT NULL THEN (c.amount / c.per) ELSE 0 END), 2), " THB") as price_per_unit')
            );

        if ($flg === 'material') {
            $query->where('a.material', $item_code)
                ->where(function ($q) {
                    $q->where('a.bom_usg', '!=', 1)
                        ->orWhere(function ($q2) {
                            $q2->where('a.bom_usg', 1)
                                ->where('a.proc_type', 'E');
                        });
                })
                ->groupBy('a.component');
        } else {
            $query->where('a.component', $item_code)
                ->groupBy('a.material');
        }

        return $query->orderBy('cal_stk', 'asc');
    }
}
