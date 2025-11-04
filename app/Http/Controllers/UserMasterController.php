<?php

namespace App\Http\Controllers;

use App\Events\FileImported;
use App\Models\UserMaster;
use Illuminate\Http\Request;

use App\Imports\UserMasterImport;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class UserMasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:hthemployee import', ['only' => ['import']]);
    }

    public function import(Request $request)
    {
        $fileName = null;
        $fileSize = null;

        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx'
            ]);

            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();

            UserMaster::truncate();
            Excel::import(new UserMasterImport, $file);

            event(new FileImported('App\Models\UserMaster', auth()->id(), 'import', 'pass', $fileName, $fileSize));
            return back()->with('succes', 'Import successfully');
        } catch (ValidationException $e) {
            $file = $request->file('file');
            if (!$file) {
                event(new FileImported('App\Models\UserMaster', auth()->id(), 'import', 'fail', $fileName, $fileSize, $e->getMessage()));
                return back()->with('error', '❌ กรุณาเลือกไฟล์ก่อนนำเข้า');
            } else {
                $fileName = $request->hasFile('file') ? $request->file('file')->getClientOriginalName() : null;
                $fileSize = $request->hasFile('file') ? $request->file('file')->getSize() : null;

                event(new FileImported('App\Models\UserMaster', auth()->id(), 'import', 'fail', $fileName, $fileSize, $e->getMessage()));
                return back()->with('error', '❌ กรุณาเลือกไฟล์ที่เป็น .xlsx เท่านั้น');
            }
        } catch (\Throwable $th) {
            event(new FileImported('App\Models\UserMaster', auth()->id(), 'import', 'fail', $fileName, $fileSize, $th->getMessage()));
            return back()->with('error', '❌ ' . $th->getMessage());
        }
    }
}
