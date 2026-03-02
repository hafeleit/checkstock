<?php

namespace App\Imports;

use App\Models\CustomerQrCode;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerQrCodeImport implements ToModel, WithHeadingRow
{
    private $fileImportLogId;

    public function __construct($fileImportLogId)
    {
        $this->fileImportLogId = $fileImportLogId;
    }

    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row['customer_name']) && empty($row['customer_code'])) {
            throw new \Exception('Empty row detected. Please ensure there are no empty rows in the file.');
        }

        // Validate required fields
        if (empty($row['customer_name']) || empty($row['customer_code'])) {
            throw new \Exception('Customer Name and Customer Code are required.');
        }

        // Validate amount
        $amount = (float) $row['amount'];

        // Validate amount is numeric and positive
        if (!empty($row['amount']) && (!is_numeric($row['amount']) || $amount <= 0)) {
            throw new \Exception('Amount must be a positive number.');
        }

        // Generate QR payload
        $taxId = '0105537076950';
        $suffix = '00';
        $payload = $this->generatePayload($taxId, $suffix, $row['customer_code'], $row['customer_name'], $amount);

        return new CustomerQrCode([
            'customer_name' => $row['customer_name'],
            'customer_code' => $row['customer_code'],
            'amount' => $amount,
            'qr_payload' => $payload,
            'created_date' => Carbon::now(),
            'created_by' => auth()->id(),
            'file_import_log_id' => $this->fileImportLogId,
        ]);
    }

    private function generatePayload($taxId, $suffix, $ref1, $ref2, $amount)
    {
        $ref1 = preg_replace('/\s+/', '', $ref1);
        $ref2 = preg_replace('/\s+/', '', $ref2);

        $prefix = "|";
        $taxIdFormatted = str_pad($taxId, 13, "0", STR_PAD_LEFT);
        $suffixFormatted = str_pad($suffix, 2, "0", STR_PAD_LEFT);
        $field2 = $taxIdFormatted . $suffixFormatted . "\r";
        $field3 = str_pad(substr($ref1, 0, 18), 18, "0", STR_PAD_LEFT) . "\r";
        $field4 = str_pad(substr($ref2, 0, 18), 18, "0", STR_PAD_LEFT) . "\r";
        $amountInSatangs = number_format($amount, 2, '', '');
        $field5 = str_pad($amountInSatangs, 10, "0", STR_PAD_LEFT);

        return $prefix . $field2 . $field3 . $field4 . $field5;
    }
}
