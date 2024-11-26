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
            ]
        );
    }
}
