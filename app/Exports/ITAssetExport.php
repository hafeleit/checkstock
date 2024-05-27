<?php

namespace App\Exports;

use App\Models\ITAsset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ITAssetExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ITAsset::all();
    }

    public function headings(): array
    {
        return [
            "id", 
            "computer_name",
            "serial_number",
            "type",
            "color",
            "model",
            "fixed_asset_no",
            "purchase_date",
            "warranty",
            "status",
            "location",
            "create_by",
            "delete",
            "created_at",
            "updated_at",
          ];
    }
}
