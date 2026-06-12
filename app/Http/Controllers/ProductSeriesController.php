<?php

namespace App\Http\Controllers;

use App\Exports\TemplateExport;
use App\Imports\ProductSeriesImport;
use App\Models\FileImportLog;
use App\Models\ProductSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductSeriesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $productSeries = ProductSeries::with('updatedBy')
            ->where('item_base', true)
            ->when($search !== null && $search !== '', function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('series_name', 'like', "%{$search}%")
                        ->orWhere('item_code', 'like', "%{$search}%");
                });
            })
            ->orderBy('series_name', 'asc')
            ->paginate(20);

        return view('pages.sales_usi.product-series.index', [
            'productSeries' => $productSeries,
            'params' => $search ? ['search' => $search] : [],
        ]);
    }

    public function create()
    {
        return view('pages.sales_usi.product-series.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'series_name' => 'required|string|max:255',
            'items'       => 'required|array|min:1',
            'items.*'     => 'required|string|max:255',
            'item_base'   => 'required|string|max:255',
        ]);

        if (!in_array(request()->input('item_base'), request()->input('items'))) {
            return back()
                ->withErrors(['item_base' => 'Item base must be one of the provided item codes.'])
                ->withInput();
        }

        $baseCode = request()->input('item_base');

        $sameSeries = ProductSeries::where('series_name', request()->input('series_name'))->first();
        if ($sameSeries) {
            return back()
                ->withErrors(['series_name' => "Series '{$sameSeries->series_name}' already exists. Please create with a different series name or update the existing series."])
                ->withInput();
        }

        try {
            DB::transaction(function () use ($baseCode) {
                foreach (request()->input('items') as $itemCode) {
                    // Check for duplicates
                    $sameItemCode = ProductSeries::where('item_code', $itemCode)->first();
                    if ($sameItemCode) {
                        throw new \Exception("Item code '{$itemCode}' already exists in series '{$sameItemCode->series_name}'.");
                    }

                    ProductSeries::create([
                        'series_name' => request()->input('series_name'),
                        'item_code'   => $itemCode,
                        'item_base'   => $itemCode === $baseCode,
                        'updated_by'  => auth()->id(),
                    ]);
                }
            });
        } catch (\Throwable $e) {
            return back()
                ->withErrors(['items' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('product-series.index')->with('status', 'Product series created successfully.');
    }

    public function edit(ProductSeries $productSeries)
    {
        $seriesItems = ProductSeries::where('series_name', $productSeries->series_name)
            ->orderBy('item_base', 'desc')
            ->orderBy('item_code', 'asc')
            ->get();

        return view('pages.sales_usi.product-series.edit', [
            'productSeries' => $seriesItems->first(),
            'seriesItems' => $seriesItems,
        ]);
    }

    public function update(Request $request, ProductSeries $productSeries)
    {
        $validated = $request->validate([
            'series_name' => 'required|string|max:255',
            'items'       => 'required|array|min:1',
            'items.*'     => 'required|string|max:255',
            'item_base'   => 'required|string|max:255',
        ]);

        if (! in_array($validated['item_base'], $validated['items'], true)) {
            return back()
                ->withErrors(['item_base' => 'Item base must be one of the provided item codes.'])
                ->withInput();
        }

        if (count($validated['items']) !== count(array_unique($validated['items']))) {
            return back()
                ->withErrors(['items' => 'Item codes must be unique.'])
                ->withInput();
        }

        $oldSeriesName = $productSeries->series_name;
        $baseCode = $validated['item_base'];

        DB::transaction(function () use ($validated, $oldSeriesName, $baseCode) {
            ProductSeries::where('series_name', $oldSeriesName)->delete();

            foreach ($validated['items'] as $itemCode) {
                ProductSeries::create([
                    'series_name' => $validated['series_name'],
                    'item_code'   => $itemCode,
                    'item_base'   => $itemCode === $baseCode,
                    'updated_by'  => auth()->id(),
                ]);
            }
        });

        return redirect()->route('product-series.index')->with('status', 'Product series updated successfully.');
    }

    public function destroy(ProductSeries $productSeries)
    {
        $productSeries->delete();

        return redirect()->route('product-series.index')->with('status', 'Product series deleted successfully.');
    }

    public function import(Request $request)
    {
        request()->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = request()->file('file');
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $fileImportLog = null;

        DB::beginTransaction();

        try {
            $fileImportLog = FileImportLog::create([
                'file_name'     => $fileName,
                'file_size'     => $fileSize,
                'type'          => 'product_series',
                'status'        => 'pending',
                'created_by'    => auth()->id()
            ]);

            Excel::import(new ProductSeriesImport($fileImportLog->id), request()->file('file'));
            $fileImportLog->update(['status' => 'processed']);

            DB::commit();
            return response()->json(['message' => 'Updated successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function exportTemplate()
    {
        $fileName = "product_series_template" . now()->format('Ymd') . ".xlsx";

        return Excel::download(new TemplateExport('product-series'), $fileName);
    }
}
