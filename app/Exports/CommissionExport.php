<?php

namespace App\Exports;

use App\Models\CommissionsAr;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\DB;

class CommissionExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $commissionId;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($commissionId)
    {
        $this->commissionId = $commissionId;
    }

    public function map($row): array
    {
        return [
            $row->type,
            $row->account,
            $row->name,
            $row->document_type,
            $row->reference,
            $row->reference_key,
            $row->document_date,
            $row->clearing_date,
            $row->amount_in_local_currency,
            $row->local_currency,

            // Column K (index 10) => Force to string
            (string) $row->clearing_document,

            $row->text,
            $row->posting_key,
            $row->sales_rep,

            $row->user_status,
            $row->effecttive_date,

            $row->cn_billing_ref,
            $row->cn_sales_doc,
            $row->cn_order_date,
            $row->cn_no,
            $row->cn_date,
            $row->cn_sales_name,
            $row->cn_tax_invoice,
            $row->cn_sales_doc_name,

            $row->ar_rate,
            $row->ar_rate_percent,
            $row->commissions,
            $row->adjuster,
            $row->remark,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'K' => NumberFormat::FORMAT_TEXT, // 👉 Column K
        ];
    }

    public function collection()
    {
        // สร้าง Subquery ที่จัดอันดับ row ต่อ job_code โดยเรียง status -> effecttive_date
        $subQuery = DB::table('user_masters')
            ->select('*')
            ->selectRaw('ROW_NUMBER() OVER (
                PARTITION BY job_code
                ORDER BY
                    CASE
                        WHEN status = "Current" THEN 0
                        WHEN status = "Probation" THEN 1
                        ELSE 2
                    END,
                    effecttive_date DESC
            ) AS rn');

        // Query หลักจาก commissions_ars
        return CommissionsAr::where('commissions_id', $this->commissionId)
            ->leftJoinSub($subQuery, 'user_masters', function ($join) {
                $join->on(DB::raw("SUBSTRING(commissions_ars.sales_rep, 4)"), '=', 'user_masters.job_code')
                     ->where('user_masters.rn', '=', 1);
            })
            ->select([
                'type',
                'account',
                'name',
                'document_type',
                'reference',
                'reference_key',
                'document_date',
                'clearing_date',
                'amount_in_local_currency',
                'local_currency',
                'clearing_document',
                'text',
                'posting_key',
                'sales_rep',

                'user_masters.status as user_status',
                'effecttive_date',

                'cn_billing_ref',
                'cn_sales_doc',
                'cn_order_date',
                'cn_no',
                'cn_date',
                'cn_sales_name',
                'cn_tax_invoice',
                'cn_sales_doc_name',

                'ar_rate',
                'ar_rate_percent',
                'commissions',
                'adjuster',
                'remark',
            ])
            ->get();
    }



    public function headings(): array
    {
        return [
          'type',
          'account',
          'name',
          'document_type',
          'reference',
          'reference_key',
          'document_date',
          'clearing_date',
          'amount_in_local_currency',
          'local_currency',
          'clearing_document',
          'text',
          'posting_key',
          'sales_rep',

          'user status',
          'effecttive_date',

          'cn_billing_ref',
          'cn_sales_doc',
          'cn_order_date',
          'cn_no',
          'cn_date',
          'cn_sales_name',
          'cn_tax_invoice',
          'cn_sales_doc_name',

          'ar_rate',
          'ar_rate_percent',
          'commissions',
          'adjuster',
          'remark',

        ];
    }
}
