<?php

namespace App\Http\Controllers;

use App\Events\FileImported;
use App\Imports\AddressImport;
use App\Imports\HuDetailImport;
use App\Imports\InvoiceImport;
use App\Models\Address;
use App\Models\FileImportLog;
use App\Models\HuDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:delivery import file', ['only' => ['index', 'store']]);
    }

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
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
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
                Address::query()->delete();
                Excel::import(new AddressImport($fileImportLog->id), $file);
            } else if ($fileType === 'hu_detail') {
                HuDetail::query()->delete();
                Excel::import(new HuDetailImport($fileImportLog->id), $file);
            }

            $fileImportLog->update(['status' => 'processed']);

            event(new FileImported('App\Models\FileImportLog', auth()->id(), 'import', 'pass', $fileName, $fileSize));
            return redirect()->back()->with('success', 'Data uploaded and imported successfully!');
        } catch (ValidationException $e) {
            if ($fileImportLog) {
                $fileImportLog->update(['status' => 'failed']);
            }

            $failures = $e->failures();

            event(new FileImported('App\Models\FileImportLog', auth()->id(), 'import', 'fail', $fileName, $fileSize, $e->getMessage()));
            return redirect()->back()->with('error', "Validation failed: " . count($failures) . " row(s) have errors.");
        } catch (\Exception $e) {
            if ($fileImportLog) {
                $fileImportLog->update(['status' => 'failed']);
            }

            event(new FileImported('App\Models\FileImportLog', auth()->id(), 'import', 'fail', $fileName, $fileSize, $e->getMessage()));
            return redirect()->back()->with('error', 'An error occurred. Please check the file.');
        }
    }
}
