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
    private array $importedSeriesNames = [];

    public function __construct($fileImportLogId)
    {
        $this->fileImportLogId = $fileImportLogId;
    }

    public function rules(): array
    {
        return [
            'series_name' => 'required',
            'item_code' => 'required',
            'item_base' => 'nullable|boolean',
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
        $exactDuplicate = ProductSeries::where('series_name', $row['series_name'])
            ->where('item_code', $row['item_code'])
            ->exists();
        if ($exactDuplicate) {
            throw new \Exception("Duplicate row: series '{$row['series_name']}' already contains item code '{$row['item_code']}'.");
        }

        $sameItemCode = ProductSeries::where('item_code', $row['item_code'])->first();
        if ($sameItemCode) {
            throw new \Exception("Item code '{$row['item_code']}' already exists in series '{$sameItemCode->series_name}'.");
        }

        //  Block adding new items to a series that already existed before this import
        $seriesName = $row['series_name'];
        if (!in_array($seriesName, $this->importedSeriesNames)) {
            $seriesExistsInDb = ProductSeries::where('series_name', $seriesName)->exists();
            if ($seriesExistsInDb) {
                throw new \Exception("Series '{$seriesName}' already exists. Please use the edit feature to add items to an existing series.");
            }
            $this->importedSeriesNames[] = $seriesName;
        }

        // Convert item_base to boolean
        $rawBase = $row['item_base'] ?? false;
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
