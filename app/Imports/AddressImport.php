<?php

namespace App\Imports;

use App\Models\Address;
use App\Models\FileImportLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;

class AddressImport implements ToModel, WithValidation, WithHeadingRow, WithBatchInserts, WithChunkReading, WithMapping, ShouldQueue, WithEvents
{
    private $fileImportLogId;

    public function __construct(int $fileImportLogId)
    {
        $this->fileImportLogId = $fileImportLogId;
    }

    public function map($row): array
    {
        return [
            'delivery' => strval($row['delivery']),
            'name' => $row['name'],
            'street' => $row['street'],
            'city' => $row['city'],
            'postl_code' => $row['postl_code'],
            'file_import_log_id' => $this->fileImportLogId,
        ];
    }
    public function model(array $row)
    {
        return new Address([
            'delivery' => $row['delivery'],
            'name' => $row['name'],
            'street' => $row['street'],
            'city' => $row['city'],
            'postal_code' => $row['postl_code'],
            'file_import_log_id' => $row['file_import_log_id'],
        ]);
    }

    public function rules(): array
    {
        return [
            'delivery' => 'required',
            'name' => 'nullable|string',
            'street' => 'nullable|string',
            'city' => 'nullable|string',
            'postl_code' => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'delivery.required' => 'The Delivery column is required',
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                $log = FileImportLog::find($this->fileImportLogId);
                if ($log) {
                    $log->update(['status' => 'processed']);
                }
            },
        ];
    }
}
