<?php

namespace App\Imports;

use App\Models\HuDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;

class HuDetailImport implements ToModel, WithValidation, WithHeadingRow, WithBatchInserts, WithChunkReading, WithMapping
{
    private $fileImportLogId;

    public function __construct(int $fileImportLogId)
    {
        $this->fileImportLogId = $fileImportLogId;
    }

    public function map($row): array
    {
        return [
            'shipment_number' => strval($row['shipment_number']),
            'erp_original_delivery_number' => strval($row['erp_original_delivery_number']),
            'total_weight' => number_format($row['total_weight'], 2),
            'weight_unit' => $row['weight_unit'],
            'total_volume' => number_format($row['total_volume'], 2),
            'handling_units' => number_format(1, 2),
            'file_import_log_id' => $this->fileImportLogId,
        ];
    }
    public function model(array $row)
    {
        return new HuDetail([
            'shipment_number' => $row['shipment_number'],
            'erp_document' => $row['erp_original_delivery_number'],
            'total_weight' => $row['total_weight'],
            'weight_unit' => $row['weight_unit'],
            'total_volume' => $row['total_volume'],
            'handling_units' => $row['handling_units'],
            'file_import_log_id' => $row['file_import_log_id'],
        ]);
    }

    public function rules(): array
    {
        return [
            'shipment_number' => 'nullable',
            'erp_original_delivery_number' => 'nullable',
            'total_weight' => 'nullable',
            'weight_unit' => 'nullable',
            'total_volume' => 'nullable',
        ];
    }

    public function customValidationMessages()
    {
        return [];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
