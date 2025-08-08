<?php

namespace App\Imports;

use App\Models\UserMaster;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Carbon\Carbon;

class UserMasterImport implements ToModel, WithStartRow, WithMultipleSheets, WithCalculatedFormulas
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
            'employee_code' => $row[0] ?? '',
            'division' => $row[6] ?? '',
            'manager' => $row[7] ?? '',
            'status' => $row[8] ?? '',
            'employment_date' => $this->parseDate($row[9] ?? null),
            'effecttive_date' => $this->parseDate($row[10] ?? null),
            'job_code' => $row[1] ?? '',
            'name_en' => $row[2] ?? '',
            'name_th' => $row[3] ?? '',
            'dept' => $row[5] ?? '',
            'position' => $row[12] ?? '',
            'email' => $row[11] ?? '',
        ]);
      }

    }

    private function parseDate($val)
    {
        try {
            // ✅ ถ้าไม่มีค่าเลย (null, '', หรือช่องว่าง) ให้ return null
            if (empty(trim($val))) {
                return null;
            }

            // กรณีเป็น Excel serial number เช่น 45115
            if (is_numeric($val)) {
                return Date::excelToDateTimeObject($val)->format('Y-m-d');
            }
    
            // กรณีเป็น string เช่น "25/07/2025"
            return Carbon::parse(trim($val))->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

}
