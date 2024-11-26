<?php

namespace App\Imports;

use App\Models\ProductItem;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductitemsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return ProductItem::updateOrCreate(
            ['id' => $row[0]],
            [
                'bar_code' => $row[1],
                'item_desc_en' => $row[2],
                'suggest_text' => $row[3],
                'made_by' => $row[4],
                'material_text' => $row[5],
                'warning_text' => $row[6],
                'how_to_text' => $row[7],
                'product_name' => $row[8],
                'item_code' => $row[9],
                'grade_code_1' => $row[10],
                'material_color' => $row[11],
                'remark' => $row[12],
                'item_size' => $row[13],
                'item_amout' => $row[14],
                'item_type' => $row[15],
                'factory_name' => $row[16],
                'factory_address' => $row[17],
                'format_id' => $row[18],
                'supplier_code' => $row[19],
                'supplier_item' => $row[20],
                'type' => $row[21],
                'format' => $row[22],
                'model' => $row[23],
                'price' => $row[24],
                'hafele_addr' => $row[25],
                'manf_date' => $row[26],
                'country_code' => $row[27],
                'defrosting' => $row[28],
                'gross_int' => $row[29],
                'nominal_voltage' => $row[30],
                'nominal_freq' => $row[31],
                'defrosting_power' => $row[32],
                'nominal_electricity' => $row[33],
                'max_power_of_lamp' => $row[34],
                'electric_power_phase' => $row[35],
                'nominal_power' => $row[36],
                'star_rating_freezer' => $row[37],
                'energy_cons_per_year' => $row[38],
                'climate_class' => $row[39],
                'refrigerant' => $row[40],
                'tis_1' => $row[41],
                'tis_2' => $row[42],
                'series_name' => $row[43],
                'qr_code' => $row[44],
                'color' => $row[45],
            ]
        );
    }
}
