<?php

namespace App\Imports;

use App\Models\InvTracking;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class InvoiceImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $invTracking = InvTracking::where('erp_document', $row['delivery'])->first();
            if ($invTracking) {
                $invTracking->update(['invoice_id' => $row['billdoc']]);
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
}
