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
            'qr-code' => ['customer_code', 'customer_name'],
            'product-series' => ['series_name', 'item_code', 'item_base'],
            'product-items' => [
                'id',
                'bar_code',
                'item_desc_en',
                'suggest_text',
                'made_by',
                'material_text',
                'warning_text',
                'how_to_text',
                'product_name',
                'item_code',
                'grade_code_1',
                'material_color',
                'remark',
                'item_size',
                'item_amout',
                'item_type',
                'factory_name',
                'factory_address',
                'format_id',
                'supplier_code',
                'supplier_item',
                'type',
                'format',
                'model',
                'price',
                'hafele_addr',
                'manf_date',
                'country_code',
                'defrosting',
                'gross_int',
                'nominal_voltage',
                'nominal_freq',
                'defrosting_power',
                'nominal_electricity',
                'max_power_of_lamp',
                'electric_power_phase',
                'nominal_power',
                'star_rating_freezer',
                'energy_cons_per_year',
                'climate_class',
                'refrigerant',
                'tis_1',
                'tis_2',
                'series_name',
                'qr_code',
                'color',
                'status'
            ],
            default => [],
        };
    }

    public function columnWidths(): array
    {
        return match ($this->type) {
            'project-item' => ['A' => 15, 'B' => 20],
            'superseded' => ['A' => 15, 'B' => 20],
            'qr-code' => ['A' => 18, 'B' => 18, 'C' => 12],
            'product-items' => array_combine(
                [...range('A', 'Z'), ...array_map(fn($l) => "A$l", range('A', 'T'))],
                array_fill(0, 46, 18)
            ),
            default => [],
        };
    }

    public function array(): array
    {
        return [];
    }
}
