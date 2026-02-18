<?php

namespace App\Imports;

use App\Models\ProductInfo;
use App\Models\ZHWWBCQUERYDIR;
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
        // validate template
        $this->validateTemplate($row);
        
        $pattern = '/^\d{3}\.\d{2}\.\d{3}$/';
        $field = $this->updateType === 'project-item' ? 'project_item' : 'superseded';

        $itemCode = $row['item_code'];
        $targetValue = $row[$field] ?? null;

        // validate format
        $this->validateFormat($itemCode, 'item_code', $pattern);
        $this->validateFormat($targetValue, $field, $pattern);

        // validate existance in master data
        $itemsToCheck = [
            'item_code' => $row['item_code'] ?? null,
            $field => $row[$field] ?? null,
        ];

        foreach ($itemsToCheck as $label => $materialCode) {
            if (empty($materialCode)) {
                throw new \Exception("The $label is missing or empty.");
            }

            $exists = ZHWWBCQUERYDIR::where('material', $materialCode)->exists();

            if (!$exists) {
                throw new \Exception("Master data not found for $label: $materialCode");
            }
        }

        // prepare data
        $data = [
            'file_import_log_id' => $this->fileImportLogId,
            'updated_by' => auth()->id(),
            $field => $targetValue
        ];

        if ($this->updateType === 'project-item') {
            $data['project_item'] = $row['project_item'];
        } elseif ($this->updateType === 'superseded') {
            $data['superseded'] = $row['superseded'];
        }

        // update or create
        $product = ProductInfo::where('item_code', $row['item_code'])->first();
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

    private function validateTemplate($row)
    {
        if (!array_key_exists('item_code', $row)) {
            throw new \Exception("Invalid template: Missing <strong>item_code</strong> column.");
        }

        if ($this->updateType === 'project-item') {
            if (!array_key_exists('project_item', $row)) {
                throw new \Exception("Invalid template: You selected <strong>Project Item</strong> but the file is missing that column.");
            }
        }

        if ($this->updateType === 'superseded') {
            if (!array_key_exists('superseded', $row)) {
                throw new \Exception("Invalid template: You selected <strong>Superseded</strong> but the file is missing that column.");
            }
        }
    }

    private function validateFormat($value, $fieldName, $pattern)
    {
        if (empty($value) || !preg_match($pattern, $value)) {
            throw new \Exception("Invalid format for $fieldName: <strong>$value</strong><br>expected: 000.00.000");
        }
    }
}
