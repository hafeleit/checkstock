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
            $row->user_position,
            $row->effecttive_date,

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
      /*
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

                'ar_rate',
                'ar_rate_percent',
                'commissions',
                'adjuster',
                'remark',
            ])
            ->get();
            */

            $subUser = DB::table('user_masters as u1')
                ->select(
                    'u1.job_code as job_code',
                    'u1.name_en as name_en',
                    'u1.division as division',
                    'u1.effecttive_date as effecttive_date',
                    'u1.status as user_status',
                    'u1.position as user_position'
                )
                ->whereRaw("
                    NOT EXISTS (
                        SELECT 1
                        FROM user_masters u2
                        WHERE u2.job_code = u1.job_code
                        AND (
                            CASE u2.status
                                WHEN 'Current' THEN 1
                                WHEN 'Probation' THEN 2
                                WHEN 'Resign' THEN 3
                                ELSE 4
                            END
                            < CASE u1.status
                                WHEN 'Current' THEN 1
                                WHEN 'Probation' THEN 2
                                WHEN 'Resign' THEN 3
                                ELSE 4
                            END
                            OR (
                                CASE u2.status
                                    WHEN 'Current' THEN 1
                                    WHEN 'Probation' THEN 2
                                    WHEN 'Resign' THEN 3
                                    ELSE 4
                                END
                                = CASE u1.status
                                    WHEN 'Current' THEN 1
                                    WHEN 'Probation' THEN 2
                                    WHEN 'Resign' THEN 3
                                    ELSE 4
                                END
                                AND u2.effecttive_date > u1.effecttive_date
                            )
                        )
                    )
                ");


            return CommissionsAr::select([
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

                'user_masters.user_status as user_status',
                'user_masters.user_position as user_position',
                'effecttive_date',

                'ar_rate',
                'ar_rate_percent',
                'commissions',
                'adjuster',
                'remark',
            ])
            ->leftJoinSub($subUser, 'user_masters', function ($join) {
                $join->on(DB::raw("SUBSTRING(commissions_ars.sales_rep, 4)"), '=', 'user_masters.job_code');
            })
            ->where('commissions_id',$this->commissionId)
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
          'user position',
          'effecttive_date',

          'ar_rate',
          'ar_rate_percent',
          'commissions',
          'adjuster',
          'remark',

        ];
    }
}
