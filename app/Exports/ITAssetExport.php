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
        $res = ITAsset::leftJoin('i_t_asset_owns', 'i_t_assets.computer_name', 'i_t_asset_owns.computer_name')
            ->leftJoin('user_masters', 'i_t_asset_owns.user', 'user_masters.job_code')
            ->leftJoin('i_t_asset_types', 'i_t_asset_types.type_code', 'i_t_assets.type')
            ->leftjoin('softwares', 'softwares.computer_name', 'i_t_assets.computer_name')
            ->select(
                'i_t_assets.id',
                'i_t_assets.computer_name',
                'i_t_assets.serial_number',
                'i_t_assets.type as type_code',
                'i_t_assets.color',
                'i_t_assets.model',
                'i_t_assets.fixed_asset_no',
                'i_t_assets.purchase_date',
                'i_t_assets.warranty',
                'i_t_assets.status',
                'i_t_assets.location',
                'i_t_assets.create_by',
                'i_t_assets.delete',
                'i_t_assets.created_at',
                'i_t_assets.updated_at',
                \DB::raw('GROUP_CONCAT(softwares.software_name ORDER BY softwares.software_name ASC SEPARATOR \', \') AS software_name'),
                'i_t_assets.old_user',
                'i_t_assets.old_name',
                'i_t_assets.old_department',
                'i_t_assets.update_by',
                'i_t_assets.reason_broken',
                'i_t_asset_owns.user as job_code',
                'user_masters.name_en as user_name',
                'user_masters.dept',
                'user_masters.position',
                'i_t_asset_types.type_desc'
            )
            ->groupBy('i_t_assets.computer_name')
            ->where('i_t_assets.delete', '0')
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
            "software_name",
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
