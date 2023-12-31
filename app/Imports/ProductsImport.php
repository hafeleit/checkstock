<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;

class ProductsImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function __construct()
    {
      Product::truncate();
    }
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {

      return new Product([
          'ITEM_CODE' => $row[0],
          'ITEM_NAME' => $row[1] ?? '',
          'ITEM_STATUS' => $row[2] ?? '',
          'ITEM_INVENTORY_CODE' => $row[3] ?? '',
          'ITEM_REPL_TIME' => $row[4] ?? '',
          'ITEM_GRADE_CODE_1' => $row[5] ?? '',
          'ITEM_UOM_CODE' => $row[6] ?? '',

          'STOCK_IN_HAND' => $row[7] ?? '',
          'AVAILABLE_STOCK' => $row[8] ?? '',
          'PENDING_SO' => $row[9] ?? '',
          'PROJECT_ITEM' => $row[10] ?? '',
          'RATE' => $row[11] ?? '',
          'NEW_ITEM' => $row[12] ?? '',
      ]);


    }
}
