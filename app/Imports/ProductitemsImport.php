<?php

namespace App\Imports;

use App\Models\ProductItem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductitemsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $id = $row['id'] ?? null;

        $data = [
            'bar_code'              => isset($row['bar_code']) ? (string) $row['bar_code'] : null,
            'item_desc_en'          => $row['item_desc_en'] ?? null,
            'suggest_text'          => $row['suggest_text'] ?? null,
            'made_by'               => $row['made_by'] ?? null,
            'material_text'         => $row['material_text'] ?? null,
            'warning_text'          => $row['warning_text'] ?? null,
            'how_to_text'           => $row['how_to_text'] ?? null,
            'product_name'          => $row['product_name'] ?? null,
            'item_code'             => $row['item_code'] ?? null,
            'grade_code_1'          => $row['grade_code_1'] ?? null,
            'material_color'        => $row['material_color'] ?? null,
            'remark'                => $row['remark'] ?? null,
            'item_size'             => $row['item_size'] ?? null,
            'item_amout'            => $row['item_amout'] ?? null,
            'item_type'             => $row['item_type'] ?? null,
            'factory_name'          => $row['factory_name'] ?? null,
            'factory_address'       => $row['factory_address'] ?? null,
            'format_id'             => $row['format_id'] ?? null,
            'supplier_code'         => isset($row['supplier_code']) ? (string) $row['supplier_code'] : null,
            'supplier_item'         => $row['supplier_item'] ?? null,
            'type'                  => $row['type'] ?? null,
            'format'                => $row['format'] ?? null,
            'model'                 => $row['model'] ?? null,
            'price'                 => $row['price'] ?? null,
            'hafele_addr'           => $row['hafele_addr'] ?? null,
            'manf_date'             => $row['manf_date'] ?? null,
            'country_code'          => $row['country_code'] ?? null,
            'defrosting'            => $row['defrosting'] ?? null,
            'gross_int'             => $row['gross_int'] ?? null,
            'nominal_voltage'       => $row['nominal_voltage'] ?? null,
            'nominal_freq'          => $row['nominal_freq'] ?? null,
            'defrosting_power'      => $row['defrosting_power'] ?? null,
            'nominal_electricity'   => $row['nominal_electricity'] ?? null,
            'max_power_of_lamp'     => $row['max_power_of_lamp'] ?? null,
            'electric_power_phase'  => $row['electric_power_phase'] ?? null,
            'nominal_power'         => $row['nominal_power'] ?? null,
            'star_rating_freezer'   => $row['star_rating_freezer'] ?? null,
            'energy_cons_per_year'  => $row['energy_cons_per_year'] ?? null,
            'climate_class'         => $row['climate_class'] ?? null,
            'refrigerant'           => $row['refrigerant'] ?? null,
            'tis_1'                 => $row['tis_1'] ?? null,
            'tis_2'                 => $row['tis_2'] ?? null,
            'series_name'           => $row['series_name'] ?? null,
            'qr_code'               => $row['qr_code'] ?? null,
            'color'                 => $row['color'] ?? null,
            'status'                => $row['status'] ?? null,
        ];

        if ($id) {
            return ProductItem::updateOrCreate(['id' => $id], $data);
        }

        return new ProductItem($data);
    }
}
