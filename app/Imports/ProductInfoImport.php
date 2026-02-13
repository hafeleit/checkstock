<?php

namespace App\Imports;

use App\Models\ProductInfo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use function Symfony\Component\Translation\t;

class ProductInfoImport implements ToModel, WithHeadingRow
{
    private $fileImportLogId;
    private $updateType;

    public function __construct($fileImportLogId, $updateType)
    {
        $this->fileImportLogId = $fileImportLogId;
        $this->updateType = $updateType;
    }


    public function model(array $row)
    {
        $pattern = '/^\d{3}\.\d{2}\.\d{3}$/';
        $valueToValidate = null;

        if ($this->updateType === 'project-item') {
            $valueToValidate = $row['project_item'] ?? null;
        } elseif ($this->updateType === 'superseded') {
            $valueToValidate = $row['superseded'] ?? null;
        }

        // Validate Item Code
        if (empty($row['item_code']) || !preg_match($pattern, $row['item_code'])) {
            $itemCode = $row['item_code'] ?? 'Empty';
            throw new \Exception("Invalid format for item_code: <strong>{$row['item_code']}</strong><br>Expected: 000.00.000");
        }

        // Validate Project Item / Superseded
        if (!empty($valueToValidate) && !preg_match($pattern, $valueToValidate)) {
            $fieldName = ($this->updateType === 'project-item') ? 'project_item' : 'superseded';
            throw new \Exception("Invalid format for {$fieldName}: <strong>{$valueToValidate}</strong><br>Expected: 000.00.000");
        }
        
        $product = ProductInfo::where('item_code', $row['item_code'])->first();

        $data = [
            'file_import_log_id' => $this->fileImportLogId,
            'updated_by' => auth()->id(),
        ];

        if ($this->updateType === 'project-item') {
            $data['project_item'] = $row['project_item'];
        } elseif ($this->updateType === 'superseded') {
            $data['superseded'] = $row['superseded'];
        }

        if ($product) {
            $product->update($data);
            return;
        }

        return new ProductInfo(array_merge($data, [
            'item_code' => $row['item_code'],
            'project_item' => $row['project_item'] ?? null,
            'superseded' => $row['superseded'] ?? null,
        ]));
    }
}
