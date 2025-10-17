<?php

namespace App\Http\Controllers;

use App\Models\UserMaster;
use Illuminate\Http\Request;

use App\Imports\UserMasterImport;
use Maatwebsite\Excel\Facades\Excel;

class UserMasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user import', ['only' => ['import']]);
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls',
            ]);

            \DB::beginTransaction();

            UserMaster::truncate();
            Excel::import(new UserMasterImport, request()->file('file'));

            \DB::commit();

            return back()->with('success', 'Import successfully');
        } catch (\Throwable $th) {
            \DB::rollBack();
            return back()->with('error', '❌ เกิดข้อผิดพลาดในการนำเข้าไฟล์ กรุณาตรวจสอบรูปแบบข้อมูล');
        }
    }
}
