<?php

namespace App\Imports;

use App\Models\UserMaster;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class UserMasterImport implements ToModel, WithStartRow, WithMultipleSheets
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function startRow(): int
    {
        return 2;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function model(array $row)
    {

      if($row[1] != ''){ //skip job code null in excel
        return new UserMaster([
            'uuid' => $row[0] ?? '',
            'job_code' => $row[1] ?? '',
            'name_en' => $row[2] ?? '',
            'name_th' => $row[3] ?? '',
            'dept' => $row[5] ?? '',
            'position' => $row[6] ?? '',
            'location' => $row[10] ?? '',
            'email' => $row[13] ?? '',
        ]);
      }

    }
}
