<?php

namespace App\Http\Controllers;

use App\Helpers\EmployeeTeamHelper;
use App\Helpers\ZipcodeRegionHelper;
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
            // dashboard 1
            'rtat' => $this->calculateRtat($month, $year),
            'ltp'  => $this->calculateLtp($month, $year),
            'ftf'  => $this->calculateFtf($month, $year),
            'pending_data' => $this->calculatePending($month, $year),
            'ticket_status_data' => $this->calculateTicket($year),
            'contract_center_data' => $this->calculateContractCenter($year),
            'contract_daily_data' => $this->calculateContractCenterDaily($month, $year),

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

        $bangkokPostalCodes = [
            10100,
            10110,
            10120,
            10130,
            10140,
            10150,
            10160,
            10170,
            10180,
            10200,
            10210,
            10220,
            10230,
            10240,
            10250,
            10260,
            10270,
            10280,
            10290,
            10300,
            10310,
            10320,
            10330,
            10340,
            10350,
            10360,
            10370,
            10400,
            10500,
            10600,
            10700,
            10800,
            10900,
        ];

        $bkkResult = $this->baseQuery($month, $year)
            ->where('deleted', 0)
            ->where('status', 'Closed')
            ->whereIn('zipcode', $bangkokPostalCodes)
            ->selectRaw('COUNT(*) as total, SUM(DATEDIFF(date_modified, release_date)) as total_days')
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
            'total'        => number_format($result->total ?? 0),
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
        $regionExpr = ZipcodeRegionHelper::sqlExpr();

        $rows = HthAfterSaleTicket::query()
            ->whereHas('assignee', function ($q) {
                $q->where('first_name', 'LIKE', 'ASC%');
            })
            ->where('deleted', 0)
            ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                ($regionExpr) as region,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) > 30 THEN 1 END) as days_over_30
            ")
            ->groupByRaw("($regionExpr)")
            ->get()
            ->keyBy('region');

        $regions = ['bkk', 'southern', 'eastern', 'northern', 'northeastern', 'western', 'central', 'blank'];
        $result = [];
        foreach ($regions as $r) {
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

    private function calculateInhousePending(int $month, int $year)
    {
        $teamExpr = EmployeeTeamHelper::sqlExpr('users.first_name', 'users.last_name');

        $rows = HthAfterSaleTicket::query()
            ->join('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                ($teamExpr) as team,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) > 30 THEN 1 END) as days_over_30
            ")
            ->groupByRaw("($teamExpr)")
            ->get()
            ->keyBy('team');

        $teams = EmployeeTeamHelper::teams();
        $result = [];
        foreach ($teams as $t) {
            $result[$t] = [
                '0-3'     => (int) ($rows[$t]->days_0_3    ?? 0),
                '4-7'     => (int) ($rows[$t]->days_4_7    ?? 0),
                '8-15'    => (int) ($rows[$t]->days_8_15   ?? 0),
                '16-30'   => (int) ($rows[$t]->days_16_30  ?? 0),
                'over_30' => (int) ($rows[$t]->days_over_30 ?? 0),
            ];
        }

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
        $regionExpr = ZipcodeRegionHelper::sqlExpr();

        $rows = HthAfterSaleTicket::query()
            ->where('deleted', 0)
            ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                ($regionExpr) as region,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_modified) > 30 THEN 1 END) as days_over_30
            ")
            ->groupByRaw("($regionExpr)")
            ->get()
            ->keyBy('region');

        $regions = ['bkk', 'southern', 'eastern', 'northern', 'northeastern', 'western', 'central', 'blank'];
        $result = [];
        foreach ($regions as $r) {
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

    private function calculatePendingByProduct(int $month, int $year)
    {
        $products = [
            'Smart Technology',
            'Home appliances',
            'Sanitary'
        ];

        $rows = HthAfterSaleTicket::query()
            ->whereMonth('hth_after_sale_ticket.date_modified', $month)
            ->whereYear('hth_after_sale_ticket.date_modified', $year)
            ->leftJoin('aos_product_categories', 'hth_after_sale_ticket.aos_product_categories_id', '=', 'aos_product_categories.id')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->whereNotNull('aos_product_categories.name')
            ->selectRaw("
                aos_product_categories.name as product,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_modified) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_modified) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_modified) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_modified) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_modified) > 30 THEN 1 END) as days_over_30
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
