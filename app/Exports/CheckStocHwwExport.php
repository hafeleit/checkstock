<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class CheckStocHwwExport implements FromCollection, WithHeadings, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $export_product = Product::where(function($query){
          $query->whereRaw("products.ITEM_STATUS IN ('8_PHASED OUT','9_OBSOLETE') AND (products.FREE_STOCK - products.PENDING_SO) > 0 ");
          $query->orWhereRaw("products.ITEM_STATUS NOT IN ('8_PHASED OUT','9_OBSOLETE')");
        })->leftJoin('product_new_price_lists','product_new_price_lists.ITEM_CODE','products.ITEM_CODE')
          ->selectRaw("
            products.ITEM_CODE,
          	products.ITEM_NAME,
          	products.ITEM_UOM_CODE,
          	CASE
          		WHEN products.ITEM_STATUS = '1_NEW' THEN 'Active'
          		WHEN products.ITEM_STATUS = '2_ACTIVE' THEN 'Active'
          		WHEN products.ITEM_STATUS = '3_INACTIVE' THEN 'Active'
          		ELSE 'Discontinued'
          	END AS Material_Status,
          	CASE
          		WHEN products.ITEM_INVENTORY_CODE = 'STOCK' THEN 'Stock'
          		ELSE 'Non-stock'
          	END AS Inventory_type,
          	(products.FREE_STOCK - products.PENDING_SO) AS Free_stock,

            CASE
          		WHEN product_new_price_lists.PRICE != '' THEN ROUND(product_new_price_lists.PRICE,2)
              WHEN products.CURRWAC + ((products.CURRWAC / 100) * 12 ) > 0 THEN ROUND(products.CURRWAC + ((products.CURRWAC / 100) * 12 ),2)
		          ELSE 'Please check with HTH'
          	END AS Estimated_tranfer_price,
          	CASE
          		WHEN products.ITEM_TYPE = '0_NORMAL' THEN products.ITEM_LEAD_TIME
          		ELSE 'Check with HTH'
          	END AS Supplier_lead_time,
            CASE
          		WHEN products.ITEM_TYPE = '0_NORMAL' THEN products.MOQ
          		ELSE 'Check with HTH'
          	END AS Moq,
          	products.ITEM_REMARK
          ")
          ->get();

          return $export_product;
    }

    public function headings(): array
    {
        return [
            "Mateiral No.",
            "Description",
            "UOM",
            "Material Status",
            "Inventory Type",
            "Free Stock",
            "Estimated Transfer Price",
            "Supplier Lead Time",
            "MOQ",
            "Remark",
          ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 13,
            'G' => 25,
            'H' => 18,
        ];
    }
}
