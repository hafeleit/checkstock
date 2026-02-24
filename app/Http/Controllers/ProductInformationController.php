<?php

namespace App\Http\Controllers;

use App\Exports\TemplateExport;
use App\Imports\ProductInfoImport;
use App\Models\FileImportLog;
use App\Models\ProductInfo;
use App\Models\ProductInfoFile;
use App\Models\ZHWWBCQUERYDIR;
use App\Models\ZHWWMM_BOM_VKO;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class ProductInformationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:salesusi productinfo view')->only(['index']);
        $this->middleware('permission:salesusi productinfo view detail')->only(['show']);
        $this->middleware('permission:salesusi productinfo edit')->only(['edit', 'update', 'uploadFiles', 'importInfo', 'downloadTemplate', 'togglePdfStatus', 'deletePdf']);
        $this->middleware('permission:salesusi productinfo delete')->only(['destroy']);
        $this->middleware('permission:salesusi update superseded|salesusi update project item')->only(['importInfo', 'downloadTemplate']);
        $this->middleware('permission:salesusi update info')->only(['update']);
        $this->middleware('permission:salesusi import catalogues|salesusi import manuals|salesusi import specsheets')->only(['uploadFiles']);
    }

    public function index()
    {
        $query = ZHWWBCQUERYDIR::query()
            ->select('material')
            ->whereNotNull('material')
            ->groupBy('material');

        if ($itemCode = request('item_code')) {
            $query->where('material', 'LIKE', '%' . trim($itemCode) . '%');
        }

        $productInformations = $query->paginate(20);

        if ($productInformations->isNotEmpty()) {
            $productInformations->getCollection()->load([
                'product_info.imageFile',
                'product_info.catalogueFiles',
                'product_info.manualFiles',
                'product_info.specsheetFiles',
            ]);
        }

        session(['product_info_return_url' => request()->fullUrl()]);

        return view('pages.sales_usi.product-info.index', [
            'productInformations' => $productInformations,
            'params' => request()->all(),
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

        return view('pages.sales_usi.product-info.show', [
            'productInfo' => $productInfo,
            'productDetail' => $productDetail,
            'spareParts' => $spareParts,
            'imgPath' => $imageFile,
            'catalogueFiles' => $catalogueFiles,
            'manualFiles' => $manualFiles,
            'specsheetFiles' => $specsheetFiles,
        ]);
    }

    public function edit($itemCode)
    {
        $product = ZHWWBCQUERYDIR::where('material', $itemCode)
            ->with('product_info', 'product_info.imageFile')
            ->select('material')
            ->firstOrFail();

        if (!$product) {
            abort(404);
        }

        $filesByType = ProductInfoFile::where('item_code', $itemCode)
            ->whereIn('type', ['catalogue', 'manual', 'specsheet'])
            ->get()
            ->groupBy('type');

        return view('pages.sales_usi.product-info.edit', [
            'imageProduct'  => $product->product_info ? $product->product_info->imageFile : null,
            'product'       => $product->product_info,
            'catalogues'    => $filesByType->get('catalogue', collect()),
            'manuals'       => $filesByType->get('manual', collect()),
            'specSheets'    => $filesByType->get('specsheet', collect()),
        ]);
    }

    public function update()
    {
        request()->validate([
            'project_item' => 'nullable|string|regex:/^\d{3}\.\d{2}\.\d{3}$/',
            'superseded' => 'nullable|string|regex:/^\d{3}\.\d{2}\.\d{3}$/',
        ]);

        // master data check
        $this->validateMasterData(request()->only(['project_item', 'superseded']));

        try {
            DB::beginTransaction();

            $product = ProductInfo::where('item_code', request()->item_code)->first();

            if (!$product) {
                $product = ProductInfo::create([
                    'item_code' => request()->item_code,
                    'project_item' => request()->project_item ?? null,
                    'superseded' => request()->superseded ?? null,
                    'updated_by' => auth()->id(),
                ]);
            } else {
                $product->update(request()->all());
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Product updated successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function uploadFiles()
    {
        request()->validate([
            'file' => 'required',
            'file.*' => 'mimes:jpg,jpeg,pdf',
            'type' => 'required|in:product,manual,catalogue,specsheet',
            'bu_detail' => 'required_if:type,manual,catalogue|string',
            'doc_type' => 'nullable|string',
        ]);

        $type = request('type');

        if (request()->hasFile('file')) {
            $files = request()->file('file');

            if (!is_array($files)) {
                $files = [$files];
            }

            $subPath = $type === 'product' ? 'storage/img/products' : 'storage/img/user_manual';
            $fullDirectoryPath = public_path($subPath);

            // Create directory if it doesn't exist
            if (!File::isDirectory($fullDirectoryPath)) {
                File::makeDirectory($fullDirectoryPath, 0775, true);
            }

            $uploadedPaths = [];

            // counter for versioning
            $counter = 0;
            if (request()->type !== 'product') {
                $existingFiles = ProductInfoFile::where('item_code', request()->item_code)
                    ->where('bu', request()->bu_detail)
                    ->where('doc_type', request()->doc_type)
                    ->where('file_name', 'like', request()->bu_detail . '-' . request()->item_code . '-' . request()->doc_type . '-' . now()->format('Ymd') . '-V%')
                    ->get();

                if ($existingFiles->isNotEmpty()) {
                    $counter = $existingFiles->map(function ($file) {
                        if (preg_match('/-V(\d+)\./', $file->file_name, $matches)) {
                            return (int) $matches[1];
                        }
                        return 0;
                    })->max();
                }
            }

            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();

                if (request()->type === 'product') {
                    $fileName = request()->item_code . "." . $extension;
                    // $fileName = request()->bu_detail . '-' . request()->item_code . '-PIC-' . now()->format('YmdHisu') . '.' . $extension;
                } else {
                    $counter++;
                    $fileName = request()->bu_detail . '-' . request()->item_code . '-' . request()->doc_type . '-' . now()->format('Ymd') . '-V' . $counter . '.' . $extension;
                }

                // Delete existing file if name conflicts
                if (request()->type === 'product') {
                    // $pattern = $fullDirectoryPath . DIRECTORY_SEPARATOR . '*' . request()->item_code . '-PIC-*';
                    $pattern = $fullDirectoryPath . DIRECTORY_SEPARATOR . request()->item_code;
                    $existingFiles = glob($pattern);
                    foreach ($existingFiles as $existingFile) {
                        File::delete($existingFile);
                    }
                } else {
                    $filePath = $fullDirectoryPath . DIRECTORY_SEPARATOR . $fileName;
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }

                // pdf ต้อง update บน db ด้วย -> ชื่อ file pdf
                $file->move($fullDirectoryPath, $fileName);
                $path = '/' . $subPath . '/' . $fileName;
                $uploadedPaths[] = $path;

                // Check for existing image file
                $existingImgFile = ProductInfoFile::where('item_code', request()->item_code)
                    ->where('type', 'image')
                    ->first();

                // update existing image file
                if (request()->type === 'product' && $existingImgFile) {
                    $existingImgFile->update([
                        'bu' => request()->bu_detail ?? null,
                        'doc_type' => 'PIC',
                        'version' => null,
                        'path' => $path,
                        'file_name' => $fileName,
                        'updated_by' =>  auth()->id(),
                        'updated_at' => now(),
                    ]);
                    continue;
                }

                // create new file
                ProductInfoFile::create([
                    'item_code' => request()->item_code,
                    'type' => request()->type === 'product' ? 'image' : request()->type,
                    'bu' => request()->bu_detail ?? null,
                    'doc_type' => request()->type === 'product' ? 'PIC' : request()->doc_type,
                    'version' => request()->type === 'product' ? null : $counter,
                    'path' => $path,
                    'file_name' => $fileName,
                    'updated_by' => auth()->id()
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Uploaded successfully',
            'data' => $uploadedPaths,
        ]);
    }

    public function importInfo()
    {
        request()->validate([
            'file' => 'required|mimes:xlsx',
            'type' => 'required|string|in:project-item,superseded',
        ]);

        $file = request()->file('file');
        $fileType = request()->input('type');
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $fileImportLog = null;

        DB::beginTransaction();

        try {

            $fileImportLog = FileImportLog::create([
                'file_name'     => $fileName,
                'file_size'     => $fileSize,
                'type'          => $fileType,
                'status'        => 'pending',
                'created_by'    => auth()->id()
            ]);

            Excel::import(new ProductInfoImport($fileImportLog->id, request()->type), request()->file('file'));
            $fileImportLog->update(['status' => 'processed']);

            DB::commit();
            return response()->json(['message' => 'Updated successfully'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function downloadTemplate($type)
    {
        $fileName = "template_{$type}_" . now()->format('Ymd') . ".xlsx";

        return Excel::download(new TemplateExport($type), $fileName);
    }

    public function destroy($itemCode)
    {
        DB::beginTransaction();
        try {
            $product = ProductInfo::where('item_code', $itemCode)->firstOrFail();
            $pdfFiles = ProductInfoFile::where('item_code', $itemCode)->get();

            $product->delete();
            ProductInfoFile::where('item_code', $itemCode)->delete();

            // ลบรูปภาพ
            $directoryImgPath = public_path("storage/img/products/{$itemCode}.jpg");
            if (File::exists($directoryImgPath)) {
                File::isDirectory($directoryImgPath)
                    ? File::deleteDirectory($directoryImgPath)
                    : File::delete($directoryImgPath);
            }

            // ลบไฟล์ PDF
            foreach ($pdfFiles as $file) {
                $directoryPdfPath = public_path($file->path);
                if (File::exists($directoryPdfPath)) {
                    File::isDirectory($directoryPdfPath)
                        ? File::deleteDirectory($directoryPdfPath)
                        : File::delete($directoryPdfPath);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'product deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deletePdf($id)
    {
        $file = ProductInfoFile::findOrFail($id);

        try {
            DB::beginTransaction();
            $directoryFilePath = public_path($file->path);
            if (File::exists($directoryFilePath)) {
                File::isDirectory($directoryFilePath)
                    ? File::deleteDirectory($directoryFilePath)
                    : File::delete($directoryFilePath);
            }

            $file->delete();
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Catalogue deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $th->getMessage(),
            ], 500);
        }
    }

    public function togglePdfStatus($item_code, $id)
    {
        $file = ProductInfoFile::findOrFail($id);

        try {
            DB::beginTransaction();
            $file->is_active = !$file->is_active;
            $file->save();
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'File status updated successfully',
                'data' => [
                    'is_active' => $file->is_active
                ]
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $th->getMessage(),
            ], 500);
        }
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

    private function validateMasterData(array $fields)
    {
        foreach ($fields as $key => $value) {
            $exits = ZHWWBCQUERYDIR::where('material', $value)->exists();
            if ($value && !$exits) {
                $label = $key === 'project_item' ? 'project item' : 'superseded';
                throw new \Exception("Master data not found for $label: $value");
            }
        }
    }
}
