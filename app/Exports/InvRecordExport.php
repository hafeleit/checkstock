<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\InvRecord;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvRecordExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Create Date',
            'Sheet ID',
            'Creator',
            'Invoice Number',
            'Invoice Status',
            'Approve',
            'Approval By',
            'Approve Date',
        ];
    }
}
