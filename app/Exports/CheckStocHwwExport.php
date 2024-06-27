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
        return Product::where(function($query){
          $query->whereRaw("ITEM_STATUS IN ('8_PHASED OUT','9_OBSOLETE') AND (FREE_STOCK - PENDING_SO) > 0 ");
          $query->orWhereRaw("ITEM_STATUS NOT IN ('8_PHASED OUT','9_OBSOLETE')");
        })
          ->selectRaw("
            ITEM_CODE,
          	ITEM_NAME,
          	CASE
          		WHEN ITEM_STATUS = '1_NEW' THEN 'Active'
          		WHEN ITEM_STATUS = '2_ACTIVE' THEN 'Active'
          		WHEN ITEM_STATUS = '3_INACTIVE' THEN 'Active'
          		ELSE 'Discontinued'
          	END AS Material_Status,
          	CASE
          		WHEN ITEM_INVENTORY_CODE = 'STOCK' THEN 'Stock'
          		ELSE 'Non-stock'
          	END AS Inventory_type,
          	(FREE_STOCK - PENDING_SO) AS Free_stock,
          	round(CURRWAC + ((CURRWAC / 100) * 12 ),2) AS Estimated_tranfer_price,
          	CASE
          		WHEN ITEM_TYPE = '0_NORMAL' THEN SUPP_NAME
          		ELSE 'INHOUSE'
          	END AS Supplier,
          	CASE
          		WHEN ITEM_TYPE = '0_NORMAL' THEN ITEM_LEAD_TIME
          		ELSE 'Check with HTH'
          	END AS Supplier_lead_time
          ")
          ->get();
    }

    public function headings(): array
    {
        return [
            "Mateiral No.",
            "Description",
            "Material Status",
            "Inventory Type",
            "Free Stock",
            "Estimated Transfer Price",
            "Supplier",
            "Supplier Lead Time",
          ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,
            'C' => 15,
            'D' => 15,
            'E' => 12,
            'F' => 27,
            'G' => 11,
            'H' => 22,
        ];
    }
}
