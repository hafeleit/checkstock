<?php

namespace App\Imports;

use App\Models\ProductSeries;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductSeriesImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    private $fileImportLogId;

    public function __construct($fileImportLogId)
    {
        $this->fileImportLogId = $fileImportLogId;
    }

    public function rules(): array
    {
        return [
            'series_name' => 'required',
            'item_code' => 'required',
            'item_base' => 'required|boolean',
        ];
    }

    public function model(array $row)
    {
        if (empty($row['series_name']) && empty($row['item_code'])) {
            throw new \Exception('Empty row detected. Please ensure there are no empty rows in the file.');
        }
        
        if (empty($row['series_name']) || empty($row['item_code'])) {
            throw new \Exception('Series Name and Item Code are required.');
        }

        // Check for duplicates
        $sameSeries = ProductSeries::where('series_name', $row['series_name'])->first();
        $sameItemCode = ProductSeries::where('item_code', $row['item_code'])->first();
        if ($sameSeries && $sameItemCode) {
            if ($sameSeries->item_code === $row['item_code']) {
                throw new \Exception("Duplicate row: series '{$row['series_name']}' already contains item code '{$row['item_code']}'.");
            }
        }
        if ($sameSeries) {
            throw new \Exception("Series '{$row['series_name']}' already exists. Please import with a different series name or update the existing series.");
        }
        if ($sameItemCode) {
            throw new \Exception("Item code '{$row['item_code']}' already exists in series '{$sameItemCode->series_name}'.");
        }

        // Convert item_base to boolean
        $rawBase = $row['item_base'] ?? '';
        if (is_bool($rawBase)) {
            $isBase = $rawBase;
        } else {
            $val = strtolower(trim((string) $rawBase));
            $isBase = in_array($val, ['true', '1', 'yes'], true);
        }

        return new ProductSeries([
            'series_name' => $row['series_name'],
            'item_code' => $row['item_code'],
            'item_base' => $isBase,
            'updated_by' => auth()->id(),
        ]);
    }
}
