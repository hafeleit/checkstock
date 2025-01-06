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
        $res = ITAsset::leftJoin('i_t_asset_owns','i_t_assets.computer_name','i_t_asset_owns.computer_name')
                          ->leftJoin('user_masters','i_t_asset_owns.user','user_masters.job_code')
                          ->leftJoin('i_t_asset_types','i_t_asset_types.type_code','i_t_assets.type')
                          ->select('i_t_assets.*','i_t_asset_owns.user','user_masters.name_en','user_masters.dept','user_masters.position','i_t_asset_types.type_desc')
                          ->groupBy('i_t_assets.computer_name')
                          ->where('i_t_assets.delete','0')
                          ->get();

        return $res;
    }

    public function headings(): array
    {
        return [
            "id",
            "computer_name",
            "serial_number",
            "type_code",
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
            "old_user",
            "old_name",
            "old_department",
            "update_by",
            "reason_broken",
            "job_code",
            "user_name",
            "dept",
            "position",
            "type_desc",
          ];
    }
}
