<?php

namespace App\Imports;

use App\Models\CommissionsAr;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CommissionsCnImport implements ToModel
{
    protected $commissionId;

    public function __construct($commissionId)
    {
        $this->commissionId = $commissionId;
    }

    public function model(array $row)
    {
        static $rowIndex = 0;
        $rowIndex++;
        if ($rowIndex === 1) {
            return null; // ข้าม header row
        }

        return new CommissionsAr([
            'commissions_id'   => $this->commissionId,
            'type'      => 'CN',
            'cn_billing_ref'      => $row[0] ?? null,
            'cn_sales_doc'        => $row[1] ?? null,
            'cn_order_date'       => $this->parseDate($row[2] ?? null),
            'cn_no'            => $row[3] ?? null,
            'cn_date'          => $this->parseDate($row[4] ?? null),
            'amount_in_local_currency'        => $row[5] ?? null,
            'sales_rep'        => $row[9] ?? null,
            'cn_sales_name'   => $row[10] ?? null,
            'cn_tax_invoice'      => $row[14] ?? null,
            'cn_sales_doc_name'   => $row[15] ?? null,
        ]);
    }

    private function parseDate($val)
    {
        try {
            // กรณีเป็น Excel serial number (เช่น 45115)
            if (is_numeric($val)) {
                return Date::excelToDateTimeObject($val)->format('Y-m-d');
            }

            // กรณีเป็น string เช่น "25/07/2025"
            return Carbon::parse(trim($val))->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
