<?php

namespace App\Exports;

use App\Models\CommissionsAr;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class CommissionSummaryExport implements FromCollection, WithHeadings
{
    protected $commissionId;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($commissionId)
    {
        $this->commissionId = $commissionId;
    }

    public function collection()
    {

      $subUser = DB::table('user_masters as u1')
          ->select(
              'u1.job_code',
              DB::raw('u1.name_en as name_en'),
              DB::raw('u1.division as division'),
              DB::raw('u1.effecttive_date as effecttive_date')
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

        return CommissionsAr::select(
                'commissions_ars.sales_rep',
                'user_masters.name_en',
                'user_masters.division',
                DB::raw('SUM(commissions_ars.commissions) as total_commissions')
            )
            ->leftJoinSub($subUser, 'user_masters', function ($join) {
                $join->on(DB::raw("SUBSTRING(commissions_ars.sales_rep, 4)"), '=', 'user_masters.job_code');
            })
            ->where('status','Approve')
            ->where('commissions_ars.commissions_id', $this->commissionId)
            ->groupBy('commissions_ars.sales_rep')
            ->orderBy('commissions_ars.sales_rep')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Sales Rep',
            'Sales Name',
            'Division',
            'Total Commission',
        ];
    }
}
