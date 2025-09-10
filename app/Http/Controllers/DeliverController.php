<?php

namespace App\Http\Controllers;

use App\Exports\DeliverExport;
use App\Exports\RTTExport;
use App\Helpers\LogiTrackIdHelper;
use App\Models\Address;
use App\Models\Driver;
use App\Models\HuDetail;
use App\Models\InvTracking;
use App\Models\PostalMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DeliverController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:delivery create deliver', ['only' => ['index', 'store']]);
        $this->middleware('permission:delivery export deliver report', ['only' => ['export']]);
        $this->middleware('permission:delivery export rtt report', ['only' => ['exportRTT']]);
    }

    public function index()
    {
        $drivers = Driver::get();

        return view('pages.inv_tracking.deliver.create', [
            'user' => Auth()->user(),
            'drivers' => $drivers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver_or_sent_to' => 'required|string',
            'delivery_date' => 'required|string',
            'erp_documents' => 'required|array',
            'remark' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            $logiTrackId = LogiTrackIdHelper::generate('deliver');

            $driver = Driver::where('code', $request->driver_or_sent_to)->first();
            if (!$driver) {
                Driver::create([
                    'code' => $request->driver_or_sent_to,
                ]);
            }

            foreach ($request->erp_documents as $erpDocument) {
                InvTracking::create([
                    'logi_track_id' => $logiTrackId,
                    'erp_document' => $erpDocument,
                    'invoice_id' => null,
                    'driver_or_sent_to' => $request->driver_or_sent_to,
                    'type' => 'deliver',
                    'status' => 'pending',
                    'delivery_date' => Carbon::parse($request->delivery_date),
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

        $invTrackings = InvTracking::with('user')
            ->where('logi_track_id', $logiTrackId)
            ->where('type', 'deliver')
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

        return Excel::download(new DeliverExport($mappedData->toArray(), $headerData), 'deliver_job_sheet_' . $invTrackings[0]->logi_track_id . '.xlsx');
    }

    public function exportRTT()
    {
        $logiTrackId = request()->query('logi_track_id');
        $invTrackings = InvTracking::with('user')
            ->where('logi_track_id', $logiTrackId)
            ->where('type', 'deliver')
            ->get();

        $ercDocuments = $invTrackings->pluck('erp_document');

        $huDetails = HuDetail::query()
            ->select('erp_document', 'shipment_number', 'weight_unit')
            ->selectRaw('SUM(total_weight) as total_weight, SUM(total_volume) as total_volume, COUNT(*) as handling_units')
            ->whereIn('erp_document', $ercDocuments)
            ->groupBy('erp_document', 'shipment_number', 'weight_unit')
            ->get();

        $mappedData = $invTrackings->map(function ($invTracking) use ($huDetails) {
            $huDetail = $huDetails->where('erp_document', $invTracking['erp_document'])->first();
            $address = Address::query()->where('delivery', $invTracking['erp_document'])->first();
            if ($address) {
                $postal = PostalMaster::query()->where('postal', $address['postal_code'])->first();
            } else {
                $postal = null;
            }

            return [
                'erp_document' => $invTracking['erp_document'] ?? null,
                'job_number' => $invTracking['logi_track_id'] ?? null,
                'shipment_number' => $huDetail['shipment_number'] ?? null,
                'weight' => $huDetail['total_weight'] ?? null,
                'volume' => ($huDetail['total_volume'] ?? null) ? ($huDetail['total_volume'] / 1000000) : null,
                'handling_units' => $huDetail['handling_units'] ?? null,
                'address' => $address['street'] ?? null,
                'city' => $address['city'] ?? null,
                'province' => $postal['province'] ?? null,
                'postal_code' => $address['postal_code'] ?? null
            ];
        });

        return Excel::download(new RTTExport($mappedData->toArray()), 'RTT_document_' . Carbon::now()->format('Ymd') . '.xlsx');
    }
}
