<?php

namespace App\Imports;

use App\Models\ProductNewPriceList;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductNewPriceListImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function startRow(): int
    {
        return 5;
    }

    public function model(array $row)
    {
        return new ProductNewPriceList([
          'ITEM_CODE' => $row[0],
          'PRICE' => $row[5],
          'USD_PRICE' => $row[7],
        ]);
    }
}
