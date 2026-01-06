<?php

namespace App\Imports;

use App\Models\InvTracking;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class InvoiceImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // --- Deliver ---
            $deliveryInvTracking = InvTracking::query()
                ->where('erp_document', $row['delivery'])
                ->where('type', 'deliver')
                ->first();

            if ($deliveryInvTracking) {
                if (!$deliveryInvTracking->invoice_id) {
                    $deliveryInvTracking->update(['invoice_id' => $row['billdoc']]);
                } elseif ($deliveryInvTracking->invoice_id != $row['billdoc']) {
                    $existsDeliver = InvTracking::where('erp_document', $row['delivery'])
                        ->where('invoice_id', $row['billdoc'])
                        ->where('type', 'deliver')
                        ->exists();

                    if (!$existsDeliver) {
                        InvTracking::create([
                            'logi_track_id'         => $deliveryInvTracking->logi_track_id,
                            'erp_document'          => $deliveryInvTracking->erp_document,
                            'invoice_id'            => $row['billdoc'],
                            'driver_or_sent_to'     => $deliveryInvTracking->driver_or_sent_to,
                            'type'                  => 'deliver',
                            'status'                => 'pending',
                            'delivery_date'         => Carbon::parse($deliveryInvTracking->delivery_date),
                            'created_date'          => Carbon::now(),
                            'created_by'            => auth()->id(),
                            'remark'                => $deliveryInvTracking->remark,
                            'is_system_generated'   => true
                        ]);
                    }
                }
            }

            // --- Return ---
            $returnInvTracking = InvTracking::query()
                ->where('erp_document', $row['delivery'])
                ->where('type', 'return')
                ->first();

            if ($returnInvTracking) {
                if (!$returnInvTracking->invoice_id) {
                    $returnInvTracking->update(['invoice_id' => $row['billdoc']]);
                } elseif ($returnInvTracking->invoice_id != $row['billdoc']) {
                    $existsReturn = InvTracking::where('erp_document', $row['delivery'])
                        ->where('invoice_id', $row['billdoc'])
                        ->where('type', 'return')
                        ->exists();

                    if (!$existsReturn) {
                        InvTracking::create([
                            'logi_track_id'         => $returnInvTracking->logi_track_id,
                            'erp_document'          => $returnInvTracking->erp_document,
                            'invoice_id'            => $row['billdoc'],
                            'driver_or_sent_to'     => $returnInvTracking->driver_or_sent_to,
                            'type'                  => 'return',
                            'status'                => 'completed',
                            'created_date'          => Carbon::now(),
                            'created_by'            => auth()->id(),
                            'remark'                => $returnInvTracking->remark,
                            'is_system_generated'   => true
                        ]);
                    }
                }
            }
        }
    }

    public function rules(): array
    {
        return [
            'billdoc' => 'required',
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
