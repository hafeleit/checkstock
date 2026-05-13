<?php

namespace App\Imports;

use App\Models\CommissionsAr;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CommissionsArImport implements WithMultipleSheets, ToModel
{
    protected $commissionId;
    protected $activeSheet = false;

    public function __construct($commissionId)
    {
        $this->commissionId = $commissionId;
    }

    public function sheets(): array
    {
        return [
            'Original' => $this, // ให้ Sheet 'Original' ใช้ instance นี้เอง
        ];
    }

    public function model(array $row)
    {
        static $i = 0;
        $i++;
        if ($i === 1) return null; // ข้าม header row

        // 👉 ข้าม row ที่ไม่มีค่า account
        if (empty(trim($row[1] ?? ''))) {
            return null;
        }

        // 👉 เงื่อนไข: ต้องเป็น document_type ที่กำหนดเท่านั้น
        $allowedDocTypes = ['RV', 'DR', 'DG', 'V2', 'DM'];
        $documentType = trim($row[8] ?? '');
        if (!in_array($documentType, $allowedDocTypes)) {
            return null;
        }

        // 👉 เงื่อนไข: ไม่เอา posting_key 08, 15
        $postingKey = trim($row[35] ?? '');
        if (in_array($postingKey, ['08', '15'])) {
            return null;
        }

        // 👉 เงื่อนไข: $row[46] ต้องไม่มีข้อมูล
        if (!empty(trim($row[46] ?? ''))) {
            return null;
        }

        // 👉 ถอด VAT 7% เฉพาะเมื่อช่อง AK == 121000
        $amountExVat = (trim($row[36] ?? '') == '121000')
            ? round(floatval(str_replace(',', '', $row[24] ?? 0)) / 1.07, 2)
            : floatval(str_replace(',', '', $row[24] ?? 0));

        $headerText = ltrim($row[33] ?? '', '0');

        return new CommissionsAr([
            'commissions_id'           => $this->commissionId,
            'type'                     => 'AR',
            'account'                  => $row[1] ?? null,
            'name'                     => $row[2] ?? null,
            'document_type'            => $row[8] ?? null,
            'reference'                => $row[9] ?? null,
            'reference_key'            => $row[10] ?? null,
            'document_date'            => $this->parseDate($row[18] ?? null),
            'clearing_date'            => $this->parseDate($row[19] ?? null),
            'amount_in_local_currency' => $amountExVat,
            'local_currency'           => $row[25] ?? null,
            'clearing_document'        => $row[26] ?? null,
            'text'                     => $row[32] ?? null,
            'header_text'              => $headerText,
            'posting_key'              => $row[35] ?? null,
            'sales_rep'                => $row[40] ?? null,
        ]);
    }

    private function parseDate($val)
    {
        try {
            if (is_numeric($val)) {
                return Date::excelToDateTimeObject($val)->format('Y-m-d');
            }
            return Carbon::parse(trim($val))->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
