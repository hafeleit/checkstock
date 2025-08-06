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

        return CommissionsAr::select(
                'commissions_ars.sales_rep',
                'user_masters.name_en',
                'user_masters.division',
                DB::raw('SUM(commissions_ars.commissions) as total_commissions')
            )
            ->leftJoin('user_masters', function ($join) {
                $join->on(DB::raw("SUBSTRING(commissions_ars.sales_rep, 4)"), '=', 'user_masters.job_code')
                     ->where('user_masters.status', 'Current');
            })
            ->where('commissions_ars.commissions_id', $this->commissionId)
            ->groupBy('commissions_ars.sales_rep')
            ->whereNotNull('commissions_ars.commissions')
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
