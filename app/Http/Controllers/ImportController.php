<?php

namespace App\Http\Controllers;

use App\Imports\AddressImport;
use App\Imports\HuDetailImport;
use App\Imports\InvoiceImport;
use App\Models\FileImportLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportController extends Controller
{
    public function index()
    {
        $types = ['invoice', 'address', 'hu_detail'];
        $latestLogs = [];

        foreach ($types as $type) {
            $latestLogs[$type] = FileImportLog::where('type', $type)
                ->where('status', 'processed')
                ->latest()
                ->first();
        }

        return view('pages.inv_tracking.import.index', [
            'latestLogs' => $latestLogs
        ]);
    }

    public function store()
    {
        request()->validate([
            'file' => 'required|mimes:xlsx',
            'type' => 'required|string|in:address,hu_detail,invoice',
        ]);

        $file = request()->file('file');
        $fileType = request()->input('type');

        $fileImportLog = null;

        try {
            $fileImportLog = FileImportLog::create([
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'type' => $fileType,
                'status' => 'pending',
                'created_by' => Auth()->user()->id,
            ]);

            if ($fileType === 'invoice') {
                Excel::import(new InvoiceImport, $file);
            } else if ($fileType === 'address') {
                Excel::import(new AddressImport($fileImportLog->id), $file);
            } else if ($fileType === 'hu_detail') {
                Excel::import(new HuDetailImport($fileImportLog->id), $file);
            }

            $fileImportLog->update(['status' => 'processed']);
            return redirect()->back()->with('success', 'Data uploaded and imported successfully!');
        } catch (ValidationException $e) {
            $failures = $e->failures();
            return redirect()->back()->with('error', "Validation failed: " . count($failures) . " row(s) have errors.");
        } catch (\Exception $e) {
            $cleanMessage = str_replace('"', '', $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $cleanMessage);
        }
    }
}
