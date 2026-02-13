<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use App\Models\External\Product;
use App\Models\ProductInfo;
use App\Models\ProductInfoFile;
use App\Models\ZHWWBCQUERYDIR;
use App\Models\ZHWWMM_BOM_VKO;
use Carbon\Carbon;
use DB;
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
        
        $last_update = Carbon::now()->subDay()->setHour(20)->setMinute(0)->setSecond(0);
        if (empty(request()->all()) || !is_array(request()->all())) {
            return view('external.products.index', [
                'date_now' => Carbon::now(),
                'user' => auth()->user(),
                'last_update' => $last_update
            ]);
        }

        //$product = Product::where('item_code', request()->item_code)->first();
        $product = DB::connection('external_mysql')
            ->table('ZHWWBCQUERYDIR')
            ->leftJoin('ZORDPOSKONV_ZPL', 'ZHWWBCQUERYDIR.Material', '=', 'ZORDPOSKONV_ZPL.Material')
            ->leftJoin('MB52', function ($join) {
                $join->on('ZHWWBCQUERYDIR.Material', '=', 'MB52.material')
                    ->where('MB52.storage_location', '=', 'TH02');
            })
            ->where('ZHWWBCQUERYDIR.Material', request()->item_code)
            ->select(
                'ZHWWBCQUERYDIR.Material',
                'ZHWWBCQUERYDIR.kurztext',
                DB::raw('ZORDPOSKONV_ZPL.Amount / NULLIF(ZORDPOSKONV_ZPL.per, 0) AS Amount'),
                'MB52.unrestricted',
                'ZHWWBCQUERYDIR.bun',
            )
            ->first();

        if ($product) {
            return view('external.products.index', [
                'product' => $product,
                'searched' => true,
                'item_code' => request()->item_code,
                'date_now' => Carbon::now(),
                'user' => auth()->user(),
                'last_update' => $last_update
            ]);
        }

        return view('external.products.index', [
            'product' => null,
            'searched' => true,
            'item_code' => request()->item_code,
            'date_now' => Carbon::now(),
            'user' => auth()->user(),
            'last_update' => $last_update
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
        $lageMapping = $this->getLageMapping();
        $productDetail = ZHWWBCQUERYDIR::query()
            ->with('zmm_matzert')
            ->select('material', 'kurztext as item_desc')
            ->selectRaw($this->generateCaseStatement('st', $stMapping, 'item_status', 'Active'))
            ->selectRaw($this->generateCaseStatement('lage', $lageMapping, 'inventory_code'))
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

    private function getLageMapping(): array
    {
        return [
            'NLW' => 'NLW-Not storage goods',
            'LW' => 'LW-Stock goods',
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
