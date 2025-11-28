<?php

namespace App\Http\Controllers;

use App\Events\FileExported;
use App\Exports\ReturnExport;
use App\Helpers\LogiTrackIdHelper;
use App\Models\Driver;
use App\Models\InvTracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReturnController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:delivery create return', ['only' => ['index', 'store']]);
        $this->middleware('permission:delivery export return report', ['only' => ['export']]);
    }

    public function index()
    {
        $drivers = Driver::get();

        return view('pages.inv_tracking.return.create', [
            'user' => Auth()->user(),
            'drivers' => $drivers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver_or_sent_to' => 'required|string',
            'erp_documents' => 'required|array',
            'remark' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            $logiTrackId = LogiTrackIdHelper::generate('return');

            $driver = Driver::where('code', $request->driver_or_sent_to)->first();
            if (!$driver) {
                Driver::create([
                    'code' => $request->driver_or_sent_to,
                ]);
            }

            foreach ($request->erp_documents as $erpDocument) {
                InvTracking::query()
                    ->where('erp_document', $erpDocument)
                    ->where('type', 'deliver')
                    ->update([
                        'status' => 'completed',
                        'updated_by' => auth()->user()->id
                    ]);

                $existingInvoice = InvTracking::query()
                    ->where('erp_document', $erpDocument)
                    ->where('type', 'deliver')
                    ->first();

                InvTracking::create([
                    'logi_track_id' => $logiTrackId,
                    'erp_document' => $erpDocument,
                    'invoice_id' => $existingInvoice['invoice_id'] ?? null,
                    'driver_or_sent_to' => $request->driver_or_sent_to,
                    'type' => 'return',
                    'status' => 'completed',
                    'created_date' => Carbon::now(),
                    'created_by' => Auth()->user()->id,
                    'remark' => $request->remark ?? null
                ]);
            }
        });

        return redirect()->back();
    }

    public function export()
    {
        $logiTrackId = request()->query('logi_track_id');
        $fileName = 'return_document_sheet_' . $logiTrackId . '.xlsx';

        try {
            $invTrackings = InvTracking::with('user')
                ->where('logi_track_id', $logiTrackId)
                ->where('type', 'return')
                ->get();

            $mappedData = $invTrackings->map(function ($invTracking, $index) {
                return [
                    'no' => $index + 1,
                    'erp_document' => $invTracking->erp_document,
                    'created_date' => Carbon::parse($invTracking->created_date)->format('d/m/Y'),
                    'invoice_id' => $invTracking->invoice_id,
                    'remark' => $invTracking->remark ?? ''
                ];
            });

            $headerData = [
                'job_no' => $invTrackings[0]->logi_track_id,
                'exported_on' => Carbon::now()->format('Y-m-d'),
                'driver_id' => $invTrackings[0]->driver_or_sent_to,
                'created_by' => $invTrackings[0]->user->username,
            ];

            event(new FileExported('App\Models\InvTracking', auth()->id(), 'export', 'pass', $fileName, null));
            return Excel::download(new ReturnExport($mappedData->toArray(), $headerData), $fileName);
        } catch (\Throwable $th) {
            event(new FileExported('App\Models\InvTracking', auth()->id(), 'export', 'fail', $fileName, null, $th->getMessage()));
            return back()->with('error', '❌ An error occurred during export: ' . $th->getMessage());
        }
    }
}
