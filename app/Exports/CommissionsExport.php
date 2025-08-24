<?php
namespace App\Exports;

use App\Models\CommissionsAr;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class CommissionsExport implements FromCollection, WithHeadings
{
    protected $commissionId;
    protected $salesRep;

    public function __construct($commissionId, $salesRep)
    {
        $this->commissionId = $commissionId;
        $this->salesRep     = $salesRep;
    }

    public function collection()
    {
      return CommissionsAr::where('commissions_id', $this->commissionId)
          ->where('sales_rep', $this->salesRep)
          ->where('status', 'Approve')
          ->orderBy('document_date', 'asc')
          ->select(
              'type',
              DB::raw("CONCAT(account, ' - ', name) as account_name"),
              'reference_key',
              'document_date',
              'clearing_date',
              'amount_in_local_currency',
              'clearing_document',
              'ar_rate',
              'ar_rate_percent',
              'commissions',
              'remark'
          )
          ->get();
    }

    public function headings(): array
    {
        return [
            'Type',
            'Account',
            'Reference Document',
            'Document Date',
            'Clearing Date',
            'Amount',
            'Clearing Document',
            'Rate (days)',
            'Rate (%)',
            'Commission',
            'Remark'
        ];
    }
}
