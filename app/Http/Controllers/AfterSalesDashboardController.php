<?php

namespace App\Http\Controllers;

use App\Models\HthAfterSaleTicket;
use App\Models\HthAfterSaleUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AfterSalesDashboardController extends Controller
{
    public function index()
    {
        $month = now()->month;
        $year = now()->year;

        return view('pages.after-sales.display', [
            'rtat' => $this->calculateRtat($month, $year),
            'ltp'  => $this->calculateLtp($month, $year),
            'ftf'  => $this->calculateFtf($month, $year),
            'pending_data' => $this->calculatePending($month, $year),
        ]);
    }

    private function baseQuery(int $month, int $year)
    {
        return HthAfterSaleTicket::query()
            ->whereMonth('date_modified', $month)
            ->whereYear('date_modified', $year);
    }

    private function calculateRtat(int $month, int $year)
    {
        $result = $this->baseQuery($month, $year)
            ->where('deleted', 0)
            ->where('status', 'Closed')
            ->selectRaw('COUNT(*) as total, SUM(DATEDIFF(date_modified, release_date)) as total_days')
            ->first();

        return $result->total > 0
            ? round($result->total_days / $result->total, 1)
            : 0;
    }

    private function calculateLtp(int $month, int $year)
    {
        $result = $this->baseQuery($month, $year)
            ->where('deleted', 0)
            ->whereNotIn('status', ['Closed', 'Canceled'])
            ->selectRaw('COUNT(*) as total, SUM(release_date < ?) as overdue', [now()->subDays(7)])
            ->first();

        return $result->total > 0
            ? round(100 * ($result->overdue / $result->total), 1)
            : 0;
    }

    private function calculateFtf(int $month, int $year)
    {
        $result = $this->baseQuery($month, $year)
            ->where('deleted', 0)
            ->where('status', 'Closed')
            ->selectRaw('COUNT(*) as total, SUM(`round` != 0) as activity')
            ->first();

        return $result->total > 0
            ? round(100 * ($result->activity / $result->total), 1)
            : 0;
    }

    private function calculatePending(int $month, int $year)
    {
        $hafele = $this->pendingByType($month, $year, false, ['R', 'C', 'spare_part', 'consult_or_advise']);
        $asc = $this->pendingByType($month, $year, true, ['R', 'I']);

        return [
            'grandHafeleTotal'  => $hafele->sum('total'),
            'grandAscTotal'     => $asc->sum('total'),
            'grandTotal'        => $hafele->sum('total') + $asc->sum('total'),
            'hafeleData'        => $hafele,
            'ascData'           => $asc,
        ];

        // $hafele = $this->baseQuery($month, $year)
        //     ->with('assignee')
        //     ->whereHas('assignee', function ($q) {
        //         $q->whereNot('first_name', 'LIKE', 'ASC%');
        //     })
        //     ->where('deleted', 0)
        //     ->whereNotIn('status', ['Closed', 'Canceled'])
        //     ->whereIn('type', ['R', 'C', 'spare_part', 'consult_or_advise'])
        //     ->select('type', DB::raw('COUNT(*) as total'))
        //     ->groupBy('type')
        //     ->get();

        // $asc = $this->baseQuery($month, $year)
        //     ->with('assignee')
        //     ->whereHas('assignee', function ($q) {
        //         $q->where('first_name', 'LIKE', 'ASC%');
        //     })
        //     ->where('deleted', 0)
        //     ->whereNotIn('status', ['Closed', 'Canceled'])
        //     ->whereIn('type', ['R', 'I'])
        //     ->select('type', DB::raw('COUNT(*) as total'))
        //     ->groupBy('type')
        //     ->get();

        // $grandHafeleTotal = $hafele->sum('total');
        // $grandAscTotal = $asc->sum('total');
        // $grandTotal = $grandHafeleTotal + $grandAscTotal;

        // return [
        //     'grandHafeleTotal' => $grandHafeleTotal,
        //     'grandAscTotal' => $grandAscTotal,
        //     'hafeleData' => $hafele,
        //     'ascData' => $asc,
        // ];
    }

    private function pendingByType(int $month, int $year, bool $isAsc, array $types)
    {
        return $this->baseQuery($month, $year)
            ->whereHas('assignee', function ($q) use ($isAsc) {
                $isAsc
                    ? $q->where('first_name', 'LIKE', 'ASC%')
                    : $q->whereNot('first_name', 'LIKE', 'ASC%');
            })
            ->where('deleted', 0)
            ->whereNotIn('status', ['Closed', 'Canceled'])
            ->whereIn('type', $types)
            ->select('type', DB::raw('COUNT(*) as total'))
            ->groupBy('type')
            ->get();
    }
}
