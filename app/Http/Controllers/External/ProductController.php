<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use App\Models\External\Product;
use App\Models\External\ZHWWBCQUERYDIR as ExternalZHWWBCQUERYDIR;
use App\Models\ProductInfo;
use App\Models\ProductInfoFile;
use App\Models\ZHWWBCQUERYDIR;
use App\Models\ZHWWMM_BOM_VKO;
use App\Services\ExternalProductApiService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        if (!auth()->user()) {
            abort(404);
        }

        // กำหนดวันเวลา Go-live
        $goLive = \Carbon\Carbon::create(2025, 8, 22, 8, 0, 0, 'Asia/Bangkok');

        // ถ้ายังไม่ถึงเวลา Go-live → แสดงหน้านับถอยหลัง
        if (now('Asia/Bangkok')->lt($goLive)) {
            return view('pages.countdown');
        }

        if (empty(request()->all()) || !is_array(request()->all()) || !request()->item_code) {
            return view('external.products.index', [
                'user' => auth()->user(),
            ]);
        }

        $item_code = request()->item_code;

        $api = new ExternalProductApiService();
        $product = $api->getProductData($item_code);

        $stMapping = $this->getStMapping();
        $dmMapping = $this->getDmMapping();
        $productExternal = ExternalZHWWBCQUERYDIR::query()
            ->selectRaw($this->generateCaseStatement('st', $stMapping, 'item_status', 'Active'))
            ->selectRaw($this->generateDmDescriptionCase($dmMapping))
            ->where('material', $item_code)
            ->first();

        $productInternal = DB::table('ZHWWBCQUERYDIR as m')
            ->leftJoin('ZHAAMM_IFVMG as p', 'p.material', '=', 'm.material')
            ->leftJoin('zhaamm_ifvmg_mat as im', 'im.matnr', '=', 'm.material')
            ->leftJoin('ZORDPOSKONV_ZPL as zpl', 'zpl.material', '=', 'm.material')
            ->select([
                DB::raw("COALESCE(NULLIF(TRIM(p.planned_deliv_time), ''), 'N/A') AS NSU_SUPP_REPL_TIME"),
                DB::raw("COALESCE(NULLIF(TRIM(p.minimum_order_qty), ''), 0) AS NSU_PURC_MOQ"),
                DB::raw("
                    CASE
                        WHEN im.mvgr4 = 'Z00' THEN 'Check price with BD/PCM'
                        WHEN zpl.amount IS NULL OR zpl.per IS NULL OR zpl.per = 0 THEN '0 THB'
                        ELSE CONCAT(FORMAT(zpl.amount / zpl.per, 2), ' THB')
                    END AS NSU_BASE_PRICE"
                )
            ])
            ->where('m.material', $item_code)
            ->first();

        return view('external.products.index', [
            'product'           => $product,
            'product_external'    => $productExternal,
            'product_internal'    => $productInternal,
            'searched'          => true,
            'item_code'         => $item_code,
            'user'              => auth()->user(),
        ]);
    }

    public function show($itemCode)
    {
        // product info
        $productInfo = ProductInfo::where('item_code', $itemCode)->first();

        // pdf files
        $catalogueFiles = ProductInfoFile::where('item_code', $itemCode)
            ->where('type', 'catalogue')
            ->where('is_active', true)
            ->get();
        $manualFiles = ProductInfoFile::where('item_code', $itemCode)
            ->where('type', 'manual')
            ->where('is_active', true)
            ->get();
        $specsheetFiles = ProductInfoFile::where('item_code', $itemCode)
            ->where('type', 'specsheet')
            ->where('is_active', true)
            ->get();

        $stMapping = $this->getStMapping();
        $dmMapping = $this->getDmMapping();
        $productDetail = ZHWWBCQUERYDIR::query()
            ->with('zmm_matzert')
            ->select('material', 'kurztext as item_desc')
            ->selectRaw($this->generateCaseStatement('st', $stMapping, 'item_status', 'Active'))
            ->selectRaw($this->generateDmDescriptionCase($dmMapping))
            ->where('material', $itemCode)
            ->first();

        // spare parts
        $spareParts = ZHWWMM_BOM_VKO::query()
            ->with('spareparts:material,kurztext')
            ->where('material', $itemCode)
            ->where('bom_usg', 4)
            ->get();

        // image file
        $fileImgPath = 'storage/img/products/' . $itemCode . '.jpg';
        if (File::exists($fileImgPath)) {
            $imageFile = '/' . $fileImgPath;
        } else if ($productInfo && $productInfo->imageFile) {
            $imageFile = $productInfo->imageFile->path;
        } else {
            $imageFile = null;
        }

        return view('external.products.show', [
            'productInfo' => $productInfo,
            'productDetail' => $productDetail,
            'spareParts' => $spareParts,
            'imgPath' => $imageFile,
            'catalogueFiles' => $catalogueFiles,
            'manualFiles' => $manualFiles,
            'specsheetFiles' => $specsheetFiles,
        ]);
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
            return "WHEN lage = '{$lage}' AND dm = '{$dm}' THEN CONCAT(dm, '-', '{$value}')";
        })->implode("\n");

        return "
            CASE
                {$cases}
                ELSE NULL
            END AS mrp
        ";
    }
}
