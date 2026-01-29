<?php

namespace App\Imports;

use App\Models\ProductInfo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

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
