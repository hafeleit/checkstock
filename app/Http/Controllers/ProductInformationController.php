<?php

namespace App\Http\Controllers;

use App\Exports\TemplateExport;
use App\Imports\ProductInfoImport;
use App\Models\FileImportLog;
use App\Models\ProductInfo;
use App\Models\ProductInfoFile;
use App\Models\ZHWWBCQUERYDIR;
use ErrorException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductInformationController extends Controller
{
    public function index()
    {
        $productInformations = ProductInfo::query()
            ->with('catalogueFiles', 'manualFiles', 'specsheetFiles')
            ->when(request()->item_code, function ($q) {
                $q->where('item_code', 'LIKE', '%' . request()->item_code . '%');
            })
            ->paginate(50);

        return view('pages.sales_usi.product-info.index', [
            'productInformations' => $productInformations,
            'params' => request()->all()
        ]);
    }

    public function show($itemCode)
    {
        $productInfo = ProductInfo::with('catalogueFiles', 'manualFiles', 'specsheetFiles')
            ->where('item_code', $itemCode)->firstOrFail();

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
        $spareParts = collect();

        // Image
        $filePath = public_path('storage/img/products/' . $itemCode . '.jpg');
        $imgPath = File::exists($filePath) ? '/storage/img/products/' . $itemCode . '.jpg' : null;

        return view('pages.sales_usi.product-info.show', [
            'productInfo' => $productInfo,
            'productDetail' => $productDetail,
            'spareParts' => $spareParts,
            'imgPath' => $imgPath,
        ]);
    }

    public function edit($itemCode)
    {
        $product = ProductInfo::where('item_code', $itemCode)->firstOrFail();
        if (!$product) {
            abort(404);
        }

        // Product image
        $fileName = $itemCode . '.jpg';
        $filePath = public_path('storage/img/products/') . DIRECTORY_SEPARATOR . $fileName;
        $imageProduct = File::exists($filePath) ? '/storage/img/products/' . $itemCode . '.jpg' : null;

        // Catalogues
        $catalogues = ProductInfoFile::where('item_code', $itemCode)
            ->where('type', 'catalogue')
            ->get();

        // Manuals
        $manuals = ProductInfoFile::where('item_code', $itemCode)
            ->where('type', 'manual')
            ->get();

        // Spec Sheet
        $specSheets = ProductInfoFile::where('item_code', $itemCode)
            ->where('type', 'specsheet')
            ->get();

        return view('pages.sales_usi.product-info.edit', [
            'imageProduct' => $imageProduct,
            'product' => $product,
            'catalogues' => $catalogues,
            'manuals' => $manuals,
            'specSheets' => $specSheets,
        ]);
    }

    public function update()
    {
        request()->validate([
            'project_item' => 'nullable|string',
            'superseded' => 'nullable|string',
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

            foreach ($files as $file) {
                if (request()->type === 'product') {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = request()->item_code . '.' . $extension;
                } else {
                    $fileName = $file->getClientOriginalName();
                }

                // Delete existing file if name conflicts
                $filePath = $fullDirectoryPath . DIRECTORY_SEPARATOR . $fileName;
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }

                // pdf ต้อง update บน db ด้วย -> ชื่อ file pdf

                $file->move($fullDirectoryPath, $fileName);
                $path = '/' . $subPath . '/' . $fileName;

                // create new file
                if (request()->type !== 'product') {
                    ProductInfoFile::create([
                        'item_code' => request()->item_code,
                        'type' => request()->type,
                        'path' => $path,
                        'file_name' => $fileName,
                        'updated_by' => auth()->id()
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Uploaded successfully',
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
