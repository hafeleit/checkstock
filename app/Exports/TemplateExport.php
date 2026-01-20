<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateExport implements FromArray, WithHeadings
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function headings(): array
    {
        return ($this->type === 'project-item')
            ? ['item_id']
            : ['superseded_id'];
    }

    public function array(): array
    {
        return [];
    }
}
