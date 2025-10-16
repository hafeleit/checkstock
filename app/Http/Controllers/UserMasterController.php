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
        $file = $request->file('file');
        if (!$file) {
            return back()->with('error', '❌ กรุณาเลือกไฟล์ก่อนนำเข้า');
        }

        // ✅ ตรวจสอบเฉพาะ .xlsx
        if ($file->getClientOriginalExtension() !== 'xlsx') {
            return back()->with('error', '❌ กรุณาเลือกไฟล์ที่เป็น .xlsx เท่านั้น');
        }
        UserMaster::truncate();
        Excel::import(new UserMasterImport,request()->file('file'));

        return back()->with('succes','Import successfully');;
    }
}
