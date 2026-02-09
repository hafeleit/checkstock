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
    }

    public function index()
    {
        // product info
        $productInformations = ProductInfo::query()
            ->when(request()->item_code, function ($q) {
                $q->where('item_code', 'LIKE', '%' . request()->item_code . '%');
            })
            ->paginate(50);

        // pdf files
        $catalogueFiles = ProductInfoFile::where('item_code', request()->item_code)
            ->where('type', 'catalogue')
            ->get();
        $manualFiles = ProductInfoFile::where('item_code', request()->item_code)
            ->where('type', 'manual')
            ->get();
        $specsheetFiles = ProductInfoFile::where('item_code', request()->item_code)
            ->where('type', 'specsheet')
            ->get();

        session(['product_info_return_url' => request()->fullUrl()]);

        return view('pages.sales_usi.product-info.index', [
            'productInformations' => $productInformations,
            'params' => request()->all(),
            'catalogueFiles' => $catalogueFiles,
            'manualFiles' => $manualFiles,
            'specsheetFiles' => $specsheetFiles,
        ]);
    }

    public function show($itemCode)
    {
        // product info
        $productInfo = ProductInfo::where('item_code', $itemCode)->first();
        
        // pdf files
        $catalogueFiles = ProductInfoFile::where('item_code', $itemCode)
            ->where('type', 'catalogue')
            ->get();
        $manualFiles = ProductInfoFile::where('item_code', $itemCode)
            ->where('type', 'manual')
            ->get();
        $specsheetFiles = ProductInfoFile::where('item_code', $itemCode)
            ->where('type', 'specsheet')
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
        // product info
        $product = ProductInfo::with('imageFile', 'catalogueFiles', 'manualFiles', 'specsheetFiles')
            ->where('item_code', $itemCode)->firstOrFail();
        
        if (!$product) {
            abort(404);
        }

        // pdf files
        $catalogueFiles = ProductInfoFile::where('item_code', $itemCode)
            ->where('type', 'catalogue')
            ->get();
        $manualFiles = ProductInfoFile::where('item_code', $itemCode)
            ->where('type', 'manual')
            ->get();
        $specsheetFiles = ProductInfoFile::where('item_code', $itemCode)
            ->where('type', 'specsheet')
            ->get();

        return view('pages.sales_usi.product-info.edit', [
            'imageProduct' => $product->imageFile,
            'product' => $product,
            'catalogues' => $catalogueFiles,
            'manuals' => $manualFiles,
            'specSheets' => $specsheetFiles,
        ]);
    }

    public function update()
    {
        request()->validate([
            'project_item' => 'nullable|string|regex:/^\d{3}\.\d{2}\.\d{3}$/',
            'superseded' => 'nullable|string|regex:/^\d{3}\.\d{2}\.\d{3}$/',
        ]);

        $product = ProductInfo::where('item_code', request()->item_code)->firstOrFail();

        try {
            DB::beginTransaction();
            $product->update(request()->all());
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

            foreach ($files as $file) {
                if (request()->type === 'product') {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = request()->item_code . "." . $extension;
                    // $fileName = request()->bu_detail . '-' . request()->item_code . '-PIC-' . now()->format('YmdHisu') . '.' . $extension;
                } else {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = request()->bu_detail . '-' . request()->item_code . '-' . request()->doc_type . '-' . now()->format('YmdHisu') . '.' . $extension;
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
                        'path' => $path,
                        'file_name' => $fileName,
                        'updated_by' =>  auth()->id()
                    ]);
                    continue;
                }

                // create new file
                ProductInfoFile::create([
                    'item_code' => request()->item_code,
                    'type' => request()->type === 'product' ? 'image' : request()->type,
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

        $fileImportLog = FileImportLog::create([
            'file_name'     => $fileName,
            'file_size'     => $fileSize,
            'type'          => $fileType,
            'status'        => 'pending',
            'created_by'    => auth()->id()
        ]);

        Excel::import(new ProductInfoImport($fileImportLog->id, request()->type), request()->file('file'));

        $fileImportLog->update(['status' => 'processed']);

        return back()->with('success', 'Updated project items successfully');
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
}
