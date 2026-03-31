<?php

namespace App\Http\Controllers;

use App\Models\HthAfterSaleTicket;
use App\Models\HthAssSurvey;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AfterSalesDashboardController extends Controller
{
    public function index()
    {
        $month = now()->month;
        $year = now()->year;

        return view('pages.after-sales.display', [
            // dashboard 1
            'rtat' => $this->calculateRtat($month, $year),
            'ltp'  => $this->calculateLtp($month, $year),
            'ftf'  => $this->calculateFtf($month, $year),
            'pending_data' => $this->calculatePending($month, $year),
            'ticket_status_data' => $this->calculateTicket($year),
            'contract_center_data' => $this->calculateContractCenter($year),
            'contract_daily_data' => $this->calculateContractCenterDaily($month, $year),
            'csi_response_data' => $this->calculateCsiResponse($month, $year),

            // dashboard 2
            'total_stat_data' => $this->calculateTotalStat($month, $year),
            'aging_data' => $this->calculateOverallAging($month, $year),
            'pending_type_data' => $this->calculatePendingType($month, $year),
            'pending_group_data' => $this->calculatePendingGroup($month, $year),
            'status_data' => $this->calculateStatus($month, $year),
            'asc_pending_data' => $this->calculateAscPending($month, $year),
            'inhouse_pending_data' => $this->calculateInhousePending($month, $year),
            'pending_reason_data' => $this->calculatePendingReason($month, $year),
            'pending_region_data' => $this->calculatePendingByRegion($month, $year),
            'product_data' => $this->calculatePendingByProduct($month, $year),
        ]);
    }

    public function userDashboard()
    {
        $month = now()->month;
        $year  = now()->year;

        return view('pages.after-sales.user-dashboard', [
            // dashboard-1
            'rtat'                => $this->calculateRtat($month, $year),
            'ltp'                 => $this->calculateLtp($month, $year),
            'ftf'                 => $this->calculateFtf($month, $year),
            'csi_response_data'   => $this->calculateCsiResponse($month, $year),
            'pending_data'        => $this->calculatePending($month, $year),
            'ticket_status_data'  => $this->calculateTicket($year),
            'contract_center_data' => $this->calculateContractCenter($year),
            'contract_daily_data' => $this->calculateContractCenterDaily($month, $year),

            // dashboard-2
            'total_stat_data'     => $this->calculateTotalStat($month, $year),
            'aging_data'          => $this->calculateOverallAging($month, $year),
            'pending_type_data'   => $this->calculatePendingType($month, $year),
            'status_data'         => $this->calculateStatus($month, $year),
            'asc_pending_data'    => $this->calculateAscPending($month, $year),
            'inhouse_pending_data' => $this->calculateInhousePending($month, $year),
            'pending_reason_data' => $this->calculatePendingReason($month, $year),
            'pending_region_data' => $this->calculatePendingByRegion($month, $year),
            'pending_group_data'  => $this->calculatePendingGroup($month, $year),
            'product_data'        => $this->calculatePendingByProduct($month, $year),
        ]);
    }

    public function detail($chart)
    {
        if ($chart === 'ud-csi-chart') {
            $csiData = $this->calculateCsiResponse(now()->month, now()->year);

            $surveys = HthAssSurvey::query()
                ->whereMonth('start_time', now()->month)
                ->whereYear('start_time', now()->year)
                ->where('service_team', 'ดีมาก (Very Good)')
                ->latest('start_time')
                ->paginate(15);

            return view('pages.after-sales.details.csi-chart', [
                'csiData' => $csiData,
                'surveys' => $surveys,
            ]);
        } else if ($chart === 'ud-rtat-chart') {
            $rtatData = $this->calculateRtat(now()->month, now()->year);

            $month  = now()->month;
            $year   = now()->year;
            $region = request('region');

            $tickets = HthAfterSaleTicket::query()
                ->leftJoin('hth_ass_regions', 'hth_after_sale_ticket.zipcode', '=', 'hth_ass_regions.postcodemain')
                ->whereMonth('hth_after_sale_ticket.date_modified', $month)
                ->whereYear('hth_after_sale_ticket.date_modified', $year)
                ->where('hth_after_sale_ticket.deleted', 0)
                ->where('hth_after_sale_ticket.status', 'Closed')
                ->when($region, fn($q) => $q->where('hth_ass_regions.master_part_eng', $region))
                ->select([
                    'hth_after_sale_ticket.name',
                    'hth_after_sale_ticket.date_modified',
                    'hth_after_sale_ticket.release_date',
                    'hth_after_sale_ticket.ticket_number',
                    'hth_after_sale_ticket.status',
                    'hth_after_sale_ticket.zipcode',
                    'hth_ass_regions.master_part_eng as master_part_eng',
                    DB::raw('DATEDIFF(hth_after_sale_ticket.date_modified, hth_after_sale_ticket.release_date) as days_diff')
                ])
                ->latest('hth_after_sale_ticket.date_modified')
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.rtat-chart', [
                'rtatData'      => $rtatData,
                'tickets'       => $tickets,
                'activeRegion'  => $region,
            ]);
        } else if ($chart === 'ud-ltp-chart') {
            $ltpData = $this->calculateLtp(now()->month, now()->year);

            $tickets = $this->baseQuery(now()->month, now()->year)
                ->where('deleted', 0)
                ->whereNotIn('status', ['Closed', 'Canceled'])
                ->where('release_date', '<', now()->subDays(7))
                ->select([
                    'ticket_number',
                    'name',
                    'release_date',
                    'status',
                    DB::raw('DATEDIFF(NOW(), release_date) - 7 as days_diff')
                ])
                ->orderByDesc('days_diff')
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.ltp-chart', [
                'ltpData' => $ltpData,
                'tickets' => $tickets,
            ]);
        } else if ($chart === 'ud-ftf-chart') {
            $ftfData = $this->calculateFtf(now()->month, now()->year);

            $tickets = $this->baseQuery(now()->month, now()->year)
                ->where('deleted', 0)
                ->where('status', 'Closed')
                ->where('round', '!=', 0)
                ->select([
                    'ticket_number',
                    'name',
                    'release_date',
                    'status',
                    'round'
                ])
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.ftf-chart', [
                'ftfData' => $ftfData,
                'tickets' => $tickets,
            ]);
        } else if ($chart === 'ud-ticket-by-status-chart') {
            $ticketStatusData = $this->calculateTicket(now()->year);
            $totalStatData    = $this->calculateTotalStat(now()->month, now()->year);
            $activeStatus     = request('status');

            dd($ticketStatusData, $totalStatData, $activeStatus);
            $tickets = HthAfterSaleTicket::query()
                ->whereYear('release_date', now()->year)
                // ->where('deleted', 0)
                // ->whereNot('status', 'Canceled')
                ->get();
                // ->when($activeStatus, function ($q) use ($activeStatus) {
                //     $q->where('status', $activeStatus);
                // })
                // ->select(['ticket_number', 'name', 'release_date', 'date_modified', 'status'])
                // ->latest('release_date')
                // ->paginate(15)
                // ->withQueryString();

            dd($tickets);

            return view('pages.after-sales.details.ticket-by-status-chart', [
                'ticketStatusData' => $ticketStatusData,
                'total_stat_data'  => $totalStatData,
                'tickets'          => $tickets,
                'activeStatus'     => $activeStatus,
            ]);
        } else {
            dd($chart);
        }
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

        $bkkResult  = HthAfterSaleTicket::query()
            ->leftJoin('hth_ass_regions', 'hth_after_sale_ticket.zipcode', '=', 'hth_ass_regions.postcodemain')
            ->whereMonth('hth_after_sale_ticket.date_modified', $month)
            ->whereYear('hth_after_sale_ticket.date_modified', $year)
            ->where('hth_after_sale_ticket.deleted', 0)
            ->where('hth_after_sale_ticket.status', 'Closed')
            ->where('hth_ass_regions.master_part_eng', 'Bangkok Metropolitan')
            ->selectRaw('COUNT(*) as total, SUM(DATEDIFF(hth_after_sale_ticket.date_modified, hth_after_sale_ticket.release_date)) as total_days')
            ->first();

        return [
            'overall' => $result->total > 0
                ? round($result->total_days / $result->total, 1)
                : 0,
            'bkk' => $bkkResult->total > 0
                ? round($bkkResult->total_days / $bkkResult->total, 1)
                : 0,
        ];
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
            ->selectRaw('COUNT(*) as total, COUNT(CASE WHEN `round` != 0 THEN 1 END) as activity')
            ->first();

        return $result->total > 0
            ? round(100 * ($result->activity / $result->total), 1)
            : 0;
    }

    private function calculateCsiResponse(int $month, int $year)
    {
        $ticketCount = HthAfterSaleTicket::query()
            ->whereMonth('date_modified', $month)
            ->whereYear('date_modified', $year)
            ->count();

        $survey = HthAssSurvey::query()
            ->whereMonth('start_time', $month)
            ->whereYear('start_time', $year)
            ->selectRaw("
                COUNT(*) as total,
                COUNT(CASE WHEN service_team = 'ดีมาก (Very Good)' THEN 1 END) as service_very_good,
                COUNT(CASE WHEN service_team = 'ดี (Good)' THEN 1 END) as service_good,
                COUNT(CASE WHEN service_team = 'ปกติ (Normal)' THEN 1 END) as service_normal,
                COUNT(CASE WHEN service_team = 'แย่ (Bad)' THEN 1 END) as service_bad,
                COUNT(CASE WHEN service_team = 'แย่มาก (Very Bad)' THEN 1 END) as service_very_bad,
                COUNT(CASE WHEN problem_resolved = 'ใช่ (Yes)' THEN 1 END) as problem_resolved_yes,
                COUNT(CASE WHEN arrive_as_scheduled = 'ใช่ (Yes)' THEN 1 END) as arrive_as_scheduled_yes,
                COUNT(CASE WHEN polite_and_well_mannered = 'ใช่ (Yes)' THEN 1 END) as polite_and_well_mannered_yes,
                COUNT(CASE WHEN charged_expenses = 'ใช่ (Yes)' THEN 1 END) as charged_expenses_yes
            ")
            ->first();

        return [
            'total_ticket' => $ticketCount,
            'survey_data' => $survey
        ];
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
    }

    private function calculateTicket(int $year)
    {
        $maxMonth = ($year === now()->year) ? now()->month : 12;

        $rows = HthAfterSaleTicket::query()
            ->whereYear('release_date', $year)
            ->where('deleted', 0)
            ->whereNot('status', 'Canceled')
            ->selectRaw("MONTH(release_date) as month, COUNT(CASE WHEN `status` = 'Closed' THEN 1 END) as total_closed, COUNT(*) as total_open")
            ->groupByRaw('MONTH(release_date)')
            ->orderByRaw('MONTH(release_date)')
            ->get()
            ->keyBy('month');

        $result = [];
        for ($m = 1; $m <= $maxMonth; $m++) {
            $result[$m] = [
                'closed' => (int) ($rows[$m]->total_closed ?? 0),
                'open'   => (int) ($rows[$m]->total_open ?? 0),
            ];
        }

        return $result;
    }

    private function calculateContractCenter(int $year)
    {
        $currentMonth = now()->month;
        $prevYear = $year - 1;

        $queryRows = fn(int $y) => HthAfterSaleTicket::query()
            ->whereYear('release_date', $y)
            ->where('deleted', 0)
            ->selectRaw('MONTH(release_date) as month, COUNT(*) as total')
            ->groupByRaw('MONTH(release_date)')
            ->get()
            ->keyBy('month');

        $currentRows = $queryRows($year);
        $prevRows    = $queryRows($prevYear);

        $current = [];
        for ($m = 1; $m <= $currentMonth; $m++) {
            $current[$m] = (int) ($currentRows[$m]->total ?? 0);
        }

        $prev = [];
        for ($m = 1; $m <= 12; $m++) {
            $prev[$m] = (int) ($prevRows[$m]->total ?? 0);
        }

        return [
            'current_year' => $year,
            'prev_year'    => $prevYear,
            'current'      => $current,
            'prev'         => $prev,
        ];
    }

    private function calculateContractCenterDaily(int $month, int $year)
    {
        $daysInMonth = now()->setYear($year)->setMonth($month)->daysInMonth;
        $maxDay = ($year === now()->year && $month === now()->month) ? now()->day : $daysInMonth;

        $rows = HthAfterSaleTicket::query()
            ->whereYear('release_date', $year)
            ->whereMonth('release_date', $month)
            ->where('deleted', 0)
            ->selectRaw("
                DAY(release_date) as day,
                COUNT(CASE WHEN TIME(release_date) BETWEEN '08:00:00' AND '17:00:00' THEN 1 END) as day_shift,
                COUNT(CASE WHEN TIME(release_date) NOT BETWEEN '08:00:00' AND '17:00:00' THEN 1 END) as night_shift
            ")
            ->groupByRaw('DAY(release_date)')
            ->orderByRaw('DAY(release_date)')
            ->get()
            ->keyBy('day');

        $result = [];
        for ($d = 1; $d <= $maxDay; $d++) {
            $result[$d] = [
                'day_shift'   => (int) ($rows[$d]->day_shift ?? 0),
                'night_shift' => (int) ($rows[$d]->night_shift ?? 0),
            ];
        }

        return $result;
    }

    private function calculateTotalStat(int $month, int $year)
    {
        $result = HthAfterSaleTicket::query()
            ->where('deleted', 0)
            ->whereNot('status', 'Canceled')
            ->selectRaw("
                COUNT(*) as total,
                COUNT(CASE WHEN status IN ('Open', 'In_progress', 'Pending_Reason') THEN 1 END) as total_pending,
                COUNT(CASE WHEN status = 'Closed' THEN 1 END) as total_closed,
                COUNT(CASE WHEN status = 'Open' THEN 1 END) as total_open,
                COUNT(CASE WHEN status = 'In_progress' THEN 1 END) as total_in_prog,
                COUNT(CASE WHEN status = 'Pending_Reason' THEN 1 END) as total_reason
            ")
            ->first();

        return [
            'total'         => number_format($result->total ?? 0),
            'total_pending' => number_format($result->total_pending ?? 0),
            'total_closed'  => number_format($result->total_closed ?? 0),
            'total_open'    => number_format($result->total_open ?? 0),
            'total_in_prog' => number_format($result->total_in_prog ?? 0),
            'total_reason'  => number_format($result->total_reason ?? 0),
        ];
    }

    private function calculateOverallAging(int $month, int $year)
    {
        $result = HthAfterSaleTicket::query()
            // ->whereMonth('date_modified', $month)
            // ->whereYear('date_modified', $year)
            ->where('deleted', 0)
            ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                COUNT(*) as total_days,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) > 30 THEN 1 END) as days_over_30
            ")
            ->first();

        return [
            'total'   => (int) ($result->total_days  ?? 0),
            '0-3'     => (int) ($result->days_0_3    ?? 0),
            '4-7'     => (int) ($result->days_4_7    ?? 0),
            '8-15'    => (int) ($result->days_8_15   ?? 0),
            '16-30'   => (int) ($result->days_16_30  ?? 0),
            'over_30' => (int) ($result->days_over_30 ?? 0),
        ];
    }

    private function calculatePendingType(int $month, int $year)
    {
        $result = HthAfterSaleTicket::query()
            ->where('deleted', 0)
            ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                COUNT(*) as grand_total,
                COUNT(CASE WHEN type = 'I' THEN 1 END) as total_installation,
                COUNT(CASE WHEN type = 'R' THEN 1 END) as total_repair,
                COUNT(CASE WHEN type = 'spare_part' THEN 1 END) as total_sparepart,
                COUNT(CASE WHEN type = 'C' THEN 1 END) as total_onsite,
                COUNT(CASE WHEN type = 'consult_or_advise' THEN 1 END) as total_phone
            ")
            ->first();

        return $result;
    }

    private function calculatePendingGroup(int $month, int $year)
    {
        $result = HthAfterSaleTicket::query()
            ->leftJoin('aos_product_categories', 'hth_after_sale_ticket.aos_product_categories_id', '=', 'aos_product_categories.id')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                COUNT(CASE WHEN aos_product_categories.name = 'Smart Technology' THEN 1 END) as total_smart_tech,
                COUNT(CASE WHEN aos_product_categories.name = 'Home appliances' THEN 1 END) as total_home_appl,
                COUNT(CASE WHEN aos_product_categories.name = 'Sanitary' THEN 1 END) as total_sanitary,
                COUNT(CASE WHEN aos_product_categories.name = 'Architectural hardware' THEN 1 END) as total_arch_hardware,
                COUNT(CASE WHEN aos_product_categories.name = 'FF - Furniture Fittings' THEN 1 END) as total_furniture_fitting
            ")
            ->first();

        return $result;
    }

    private function calculateStatus(int $month, int $year)
    {
        $result = HthAfterSaleTicket::query()
            // ->whereMonth('date_modified', $month)
            // ->whereYear('date_modified', $year)
            ->where('deleted', 0)
            ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), date_modified) BETWEEN 0  AND 3  THEN 1 END) as reason_0_3,
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), date_modified) BETWEEN 4  AND 7  THEN 1 END) as reason_4_7,
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), date_modified) BETWEEN 8  AND 15 THEN 1 END) as reason_8_15,
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), date_modified) BETWEEN 16 AND 30 THEN 1 END) as reason_16_30,
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), date_modified) > 30 THEN 1 END) as reason_over_30,

                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), date_modified) BETWEEN 0  AND 3  THEN 1 END) as in_prog_0_3,
                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), date_modified) BETWEEN 4  AND 7  THEN 1 END) as in_prog_4_7,
                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), date_modified) BETWEEN 8  AND 15 THEN 1 END) as in_prog_8_15,
                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), date_modified) BETWEEN 16 AND 30 THEN 1 END) as in_prog_16_30,
                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), date_modified) > 30 THEN 1 END) as in_prog_over_30,

                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), date_modified) BETWEEN 0  AND 3  THEN 1 END) as open_0_3,
                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), date_modified) BETWEEN 4  AND 7  THEN 1 END) as open_4_7,
                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), date_modified) BETWEEN 8  AND 15 THEN 1 END) as open_8_15,
                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), date_modified) BETWEEN 16 AND 30 THEN 1 END) as open_16_30,
                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), date_modified) > 30 THEN 1 END) as open_over_30
            ")
            ->first();

        return $result;
    }

    private function calculateAscPending(int $month, int $year)
    {
        $result = HthAfterSaleTicket::query()
            ->leftJoin('hth_ass_regions', 'hth_ass_regions.postcodemain', '=', 'hth_after_sale_ticket.zipcode')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->whereHas('assignee', function ($q) {
                $q->where('first_name', 'LIKE', 'ASC%');
            })
            ->selectRaw("
                hth_ass_regions.master_part_eng as region,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) > 30 THEN 1 END) as days_over_30
            ")
            ->groupBy("region")
            ->get()
            ->keyBy('region');

        return $result;
    }

    private function calculateInhousePending(int $month, int $year)
    {
        $result = HthAfterSaleTicket::query()
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->leftJoin('hth_ass_teams', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), '=', 'hth_ass_teams.name')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                hth_ass_teams.team as team,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) > 30 THEN 1 END) as days_over_30
            ")
            ->groupBy('hth_ass_teams.team')
            ->get()
            ->keyBy('team');

        return $result;
    }

    private function calculatePendingReason(int $month, int $year)
    {
        $reasons = [
            'Spare_part_on_progress',
            'Site_not_ready_or_waiting_confirm',
            'Postpone_or_new_appointment',
            'Process_return_or_change_set',
            'Waiting_service_schedule_Technician',
        ];

        $rows = HthAfterSaleTicket::query()
            ->where('deleted', 0)
            ->where('status', 'Pending_Reason')
            ->selectRaw("
                COALESCE(pending, 'blank') as reason,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) > 30 THEN 1 END) as days_over_30
            ")
            ->groupByRaw("COALESCE(pending, 'blank')")
            ->get()
            ->keyBy('reason');

        $allReasons = array_merge($reasons, ['blank']);
        $result = [];
        foreach ($allReasons as $r) {
            $result[$r] = [
                '0-3'     => (int) ($rows[$r]->days_0_3    ?? 0),
                '4-7'     => (int) ($rows[$r]->days_4_7    ?? 0),
                '8-15'    => (int) ($rows[$r]->days_8_15   ?? 0),
                '16-30'   => (int) ($rows[$r]->days_16_30  ?? 0),
                'over_30' => (int) ($rows[$r]->days_over_30 ?? 0),
            ];
        }

        return $result;
    }

    private function calculatePendingByRegion(int $month, int $year)
    {
        $result = HthAfterSaleTicket::query()
            ->leftJoin('hth_ass_regions', 'hth_ass_regions.postcodemain', '=', 'hth_after_sale_ticket.zipcode')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                hth_ass_regions.master_part_eng as region,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) > 30 THEN 1 END) as days_over_30
            ")
            ->groupBy("region")
            ->get()
            ->keyBy("region");

        return $result;
    }

    private function calculatePendingByProduct(int $month, int $year)
    {
        $products = [
            'Smart Technology',
            'Home appliances',
            'Sanitary'
        ];

        $rows = HthAfterSaleTicket::query()
            ->whereMonth('hth_after_sale_ticket.release_date', $month)
            ->whereYear('hth_after_sale_ticket.release_date', $year)
            ->leftJoin('aos_product_categories', 'hth_after_sale_ticket.aos_product_categories_id', '=', 'aos_product_categories.id')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->whereNotNull('aos_product_categories.name')
            ->selectRaw("
                aos_product_categories.name as product,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) > 30 THEN 1 END) as days_over_30
            ")
            ->groupBy('aos_product_categories.name')
            ->get()
            ->keyBy('product');

        $allProducts = $products;
        $result = [];
        foreach ($allProducts as $p) {
            $result[$p] = [
                '0-3'     => (int) ($rows[$p]->days_0_3    ?? 0),
                '4-7'     => (int) ($rows[$p]->days_4_7    ?? 0),
                '8-15'    => (int) ($rows[$p]->days_8_15   ?? 0),
                '16-30'   => (int) ($rows[$p]->days_16_30  ?? 0),
                'over_30' => (int) ($rows[$p]->days_over_30 ?? 0),
            ];
        }

        return $result;
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
            ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
            ->whereIn('type', $types)
            ->select('type', DB::raw('COUNT(*) as total'))
            ->groupBy('type')
            ->get();
    }
}
