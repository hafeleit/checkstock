<?php

namespace App\Exports;

use App\Models\CommissionsAr;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CommissionExport implements FromCollection, WithHeadings
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
        return CommissionsAr::where('commissions_id', $this->commissionId)
            ->select([
                'sales_rep',
                'cn_no',
                'document_date',
                'clearing_date',
                'amount_in_local_currency',
                'ar_rate_percent',
                'ar_rate',
                'commissions',
            ])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Sales Rep',
            'CN No.',
            'Document Date',
            'Clearing Date',
            'Amount (Local)',
            'Rate (%)',
            'AR Rate (days)',
            'Commission (Calculated)',
        ];
    }
}
