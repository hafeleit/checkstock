<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class TemplateExport implements FromArray, WithHeadings, WithColumnWidths
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function headings(): array
    {
        return match ($this->type) {
            'project-item' => ['item_code', 'project_item'],
            'superseded' => ['item_code', 'superseded'],
            'qr-code' => ['customer_name', 'customer_code', 'amount'],
            default => [],
        };
    }

    public function columnWidths(): array
    {
        return match ($this->type) {
            'project-item' => ['A' => 15, 'B' => 20],
            'superseded' => ['A' => 15, 'B' => 20],
            'qr-code' => ['A' => 18, 'B' => 18, 'C' => 12],
            default => [],
        };
    }

    public function array(): array
    {
        return [];
    }
}
