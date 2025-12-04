<?php

namespace App\Imports;

use App\Models\FileImportLog;
use App\Models\InvTracking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;

class InvoiceImport implements ToCollection, WithHeadingRow, WithValidation, WithChunkReading, ShouldQueue, WithEvents
{
    private $fileImportLogId;

    public function __construct(int $fileImportLogId)
    {
        $this->fileImportLogId = $fileImportLogId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $invTrackings = InvTracking::where('erp_document', $row['delivery'])->get();

            if ($invTrackings->isNotEmpty()) {
                $invTrackings->each(function ($invTracking) use ($row) {
                    $invTracking->update(['invoice_id' => $row['billdoc']]);
                });
            }
        }
    }

    public function rules(): array
    {
        return [
            'billdoc' => 'required|string',
            'delivery' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'billdoc.required' => 'The Bill.Doc. column is required',
            'delivery.required' => 'The Delivery column is required',
        ];
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
