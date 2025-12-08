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
use Maatwebsite\Excel\HeadingRowImport;
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
                $requiredHeaders = ['billdoc', 'delivery'];
                $this->checkRequireHeader($requiredHeaders, $file, $fileImportLog);
                Excel::queueImport(new InvoiceImport($fileImportLog->id), $file);
            } else if ($fileType === 'address') {
                $requiredHeaders = ['delivery', 'name', 'street', 'city', 'postl_code'];
                $this->checkRequireHeader($requiredHeaders, $file, $fileImportLog);

                Address::query()->delete();
                Excel::queueImport(new AddressImport($fileImportLog->id), $file);
            } else if ($fileType === 'hu_detail') {
                $requiredHeaders = ['shipment_number', 'erp_original_delivery_number', 'total_weight', 'weight_unit', 'total_volume'];
                $this->checkRequireHeader($requiredHeaders, $file, $fileImportLog);

                HuDetail::query()->delete();
                Excel::queueImport(new HuDetailImport($fileImportLog->id), $file);
            }

            event(new FileImported('App\Models\FileImportLog', auth()->id(), 'import', 'pass', $fileName, $fileSize, null, $fileImportLog->id));
            return redirect()->back()->with('success', 'Data uploaded and imported successfully!');
        } catch (ValidationException $e) {
            if ($fileImportLog) {
                $fileImportLog->update(['status' => 'failed']);
            }

            $failures = $e->failures();

            event(new FileImported('App\Models\FileImportLog', auth()->id(), 'import', 'fail', $fileName, $fileSize, $e->getMessage(), $fileImportLog->id));
            return redirect()->back()->with('error', "Validation failed: " . count($failures) . " row(s) have errors.");
        } catch (\Exception $e) {
            if ($fileImportLog) {
                $fileImportLog->update(['status' => 'failed']);
            }

            event(new FileImported('App\Models\FileImportLog', auth()->id(), 'import', 'fail', $fileName, $fileSize, $e->getMessage(), $fileImportLog->id));
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function checkRequireHeader($requiredHeaders, $file, FileImportLog $fileImportLog)
    {
        try {
            $headings = (new HeadingRowImport)->toArray($file);
            $missingHeaders = array_diff($requiredHeaders, $headings[0][0]);

            if (!empty($missingHeaders)) {
                $cleanHeaders = array_map(function ($header) {
                    $temp = str_replace('_', ' ', $header);
                    return ucfirst($temp);
                }, $missingHeaders);
                
                $missing = implode(', ', $cleanHeaders);
                $fileImportLog->update(['status' => 'failed']);

                throw new \Exception("The uploaded file is missing the following required columns: **{$missing}**.");
            }
        } catch (\Throwable $th) {
            if (strpos($th->getMessage(), 'Missing required columns') === false) {
                $fileImportLog->update(['status' => 'failed']);
                throw $th;
            }

            throw $th;
        }
    }
}
