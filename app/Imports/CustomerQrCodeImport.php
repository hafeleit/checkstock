<?php

namespace App\Imports;

use App\Models\CustomerQrCode;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomerQrCodeImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    private $fileImportLogId;

    public function __construct($fileImportLogId)
    {
        $this->fileImportLogId = $fileImportLogId;
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'required',
            'customer_code' => 'required|min:9|max:9|unique:customer_qr_codes,customer_code'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'customer_code.min' => 'รหัสลูกค้า ":input" ต้องมี 9 หลัก',
            'customer_code.max' => 'รหัสลูกค้า ":input" ต้องมี 9 หลัก',
            'customer_code.unique' => 'รหัสลูกค้า ":input" มีอยู่ในระบบแล้ว',
        ];
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

        // Generate QR payload
        $taxId = '0105537076950';
        $suffix = '00';
        $customer_name = preg_replace('/[^A-Za-z0-9]/', '', $row['customer_name']);
        $customer_name = substr($customer_name, 0, 18);

        $payload = $this->generatePayload($taxId, $suffix, $row['customer_code'],$customer_name);

        return new CustomerQrCode([
            'customer_full_name' => $row['customer_name'],
            'customer_name' => $customer_name,
            'customer_code' => $row['customer_code'],
            'qr_payload' => $payload,
            'created_date' => Carbon::now(),
            'created_by' => auth()->id(),
            'file_import_log_id' => $this->fileImportLogId,
        ]);
    }

    private function generatePayload($taxId, $suffix, $ref1, $ref2 = null, $amount = 0)
    {
        $ref1 = preg_replace('/\s+/', '', $ref1);

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
