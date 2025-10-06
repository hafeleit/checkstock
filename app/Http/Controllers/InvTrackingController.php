<?php

namespace App\Http\Controllers;

use App\Exports\OverAllExport;
use App\Exports\PendingExport;
use App\Models\Driver;
use App\Models\InvTracking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InvTrackingController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:delivery view lists', ['only' => ['index']]);
        $this->middleware('permission:delivery view details', ['only' => ['detail']]);
        $this->middleware('permission:delivery edit deliver', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delivery delete deliver', ['only' => ['destroy']]);
        $this->middleware('permission:delivery export overall report', ['only' => ['exportOverall']]);
        $this->middleware('permission:delivery export pending report', ['only' => ['exportPending']]);
    }

    public function index()
    {
        $drivers = Driver::get();

        $invTrackings = InvTracking::with('user')
            ->when(request()->logi_track_id, function ($q) {
                $q->where('logi_track_id', 'LIKE', '%' . request()->logi_track_id . '%');
            })
            ->when(request()->driver_or_sent_to, function ($q) {
                $q->where('driver_or_sent_to', 'LIKE', '%' . request()->driver_or_sent_to . '%');
            })
            ->when(request()->delivery_date, function ($q) {
                $q->where('delivery_date', request()->delivery_date);
            })
            ->get();

        $groupedData = $invTrackings->groupBy('logi_track_id');

        $mappedData = $groupedData->map(function ($items, $logiTrackId) {
            $firstItem = $items->first();

            $isCompleted = $items->every(function ($item) {
                return $item->status === 'completed';
            });

            return [
                "id"                => $firstItem->id,
                "logi_track_id"     => $logiTrackId,
                "erp_documents"     => $items->pluck('erp_document')->toArray(),
                "driver_or_sent_to" => $firstItem->driver_or_sent_to,
                "type"              => $firstItem->type,
                "status"            => $isCompleted ? 'completed' : 'pending',
                "created_date"      => $firstItem->created_date,
                "delivery_date"     => $firstItem->delivery_date,
                "created_by"        => $firstItem->created_by,
                "updated_by"        => $firstItem->updated_by,
                "remark"            => $firstItem->remark,
                "created_at"        => $firstItem->created_at,
                "updated_at"        => $firstItem->updated_at,
                "user"              => $firstItem->user,
            ];
        });

        $sortedData = $mappedData->sortByDesc('created_at')->values();

        $perPage = 10;
        $currentPage = request()->input('page', 1);
        $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
            $sortedData->forPage($currentPage, $perPage),
            $sortedData->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('pages.inv_tracking.index', [
            'invTrackings' => $paginatedData,
            'drivers' => $drivers,
            'params' => request()->all()
        ]);
    }

    public function detail()
    {
        $drivers = Driver::get();
        $invTrackings = InvTracking::with('user')
            ->when(request()->logi_track_id, function ($q) {
                $q->where('logi_track_id', 'LIKE', '%' . request()->logi_track_id . '%');
            })
            ->when(request()->driver_or_sent_to, function ($q) {
                $q->where('driver_or_sent_to', 'LIKE', '%' . request()->driver_or_sent_to . '%');
            })
            ->when(request()->erp_document, function ($q) {
                $q->where('erp_document', 'LIKE', '%' . request()->erp_document . '%');
            })
            ->when(request()->bill_no, function ($q) {
                $q->where('invoice_id', 'LIKE', '%' . request()->bill_no . '%');
            })
            ->when(request()->type, function ($q) {
                $q->where('type', request()->type);
            })
            ->when(request()->status, function ($q) {
                $q->where('status', request()->status);
            })
            ->when(request()->delivery_date, function ($q) {
                $q->where('delivery_date', request()->delivery_date);
            })
            ->latest()
            ->paginate(10);

        return view('pages.inv_tracking.detail', [
            'invTrackings' => $invTrackings,
            'drivers' => $drivers,
            'params' => request()->all()
        ]);
    }

    public function edit($logiTrackId)
    {
        $invTrackings = InvTracking::where('logi_track_id', $logiTrackId)->get();
        
        if ($invTrackings->isEmpty()) {
            abort(404);
        }

        $invTracking = InvTracking::with('user')->where('logi_track_id', $logiTrackId)->first();
        $erpDocuments = $invTrackings->pluck('erp_document')->toArray();

        return view('pages.inv_tracking.edit', [
            'user' => Auth()->user(),
            'invTracking' => $invTracking,
            'erpDocuments' => $erpDocuments
        ]);
    }

    public function update($logiTrackId)
    {
        request()->validate([
            'finalData.erp_documents' => 'required|array',
            'finalData.remark' => 'nullable|string',
        ]);

        $finalData = request()->input('finalData');

        DB::transaction(function () use ($logiTrackId, $finalData) {
            $invTracking = InvTracking::where('logi_track_id', $logiTrackId)->first();
            if (!$invTracking) {
                abort(404);
            }

            InvTracking::where('logi_track_id', $logiTrackId)->delete();

            foreach ($finalData['erp_documents'] as $item) {
                InvTracking::create([
                    'logi_track_id' => $logiTrackId,
                    'erp_document' => $item,
                    'invoice_id' => null,
                    'driver_or_sent_to' => $invTracking['driver_or_sent_to'],
                    'type' => $invTracking['type'],
                    'status' => $invTracking['type'] === 'deliver' ? 'pending' : 'completed',
                    'delivery_date' => $invTracking['delivery_date'] ?? null,
                    'created_date' => $invTracking['created_date'],
                    'created_by' => $invTracking['created_by'],
                    'updated_by' => Auth()->user()->id,
                    'remark' => $finalData['remark'] ?? $invTracking->remark
                ]);
            }

            return redirect()->back();
        });
    }

    public function destroy($logiTrackId)
    {
        try {
            DB::transaction(function () use ($logiTrackId) {
                $invTrackings = InvTracking::where('logi_track_id', $logiTrackId)->get();

                if ($invTrackings->isEmpty()) {
                    throw new \Exception('Record not found.');
                }

                InvTracking::where('logi_track_id', $logiTrackId)->delete();
            });

            return redirect()->back()->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function exportOverall()
    {
        $invTrackings = InvTracking::with('user', 'updatedUser')->get();
        $mappedData = $invTrackings->map(function ($invTracking, $index) {
            return [
                'no' => $index + 1,
                'logi_track_id' => $invTracking->logi_track_id,
                'driver_or_sent_to' => $invTracking->driver_or_sent_to,
                'erp_document' => $invTracking->erp_document,
                'invoice_id' => $invTracking->invoice_id,
                'created_date' => $invTracking->created_date ? Carbon::parse($invTracking->created_date)->format('d/m/Y') : null,
                'delivery_date' => $invTracking->delivery_date ? Carbon::parse($invTracking->delivery_date)->format('d/m/Y') : null,
                'type' => $invTracking->type,
                'created_by' => $invTracking->user->username,
                'updated_by' => $invTracking->updatedUser->username ?? null,
                'remark' => $invTracking->remark ?? ''
            ];
        });
        return Excel::download(new OverAllExport($mappedData->toArray()), 'overall_document_' . Carbon::now()->format('Ymd') . '.xlsx');
    }

    public function exportPending()
    {
        $invTrackings = InvTracking::query()
            ->select('erp_document', 'invoice_id')
            ->selectRaw('MIN(delivery_date) as oldest_delivery_date')
            ->selectRaw('DATEDIFF(CURDATE(), MIN(delivery_date)) as days_since_delivery')
            ->selectSub(function ($query) {
                $query->select('driver_or_sent_to')
                    ->from('inv_trackings as sub')
                    ->whereColumn('sub.erp_document', 'inv_trackings.erp_document')
                    ->where('sub.type', 'deliver')
                    ->where('sub.status', 'pending')
                    ->orderByDesc('sub.delivery_date')
                    ->limit(1);
            }, 'driver_or_sent_to')
            ->where('type', 'deliver')
            ->where('status', 'pending')
            ->groupBy('erp_document', 'invoice_id')
            ->get();

        $mappedData = $invTrackings->map(function ($invTracking, $index) {
            return [
                'delivery_date' => $invTracking->oldest_delivery_date,
                'erp_document' => $invTracking->erp_document,
                'invoice_id' => $invTracking->invoice_id,
                'driver_or_sent_to' => $invTracking->driver_or_sent_to,
                'duration' => $invTracking->days_since_delivery ?? ''
            ];
        });

        return Excel::download(new PendingExport($mappedData->toArray()), 'pending_document_' . Carbon::now()->format('Ymd') . '.xlsx');
    }
}
