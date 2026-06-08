<?php

namespace App\Http\Controllers;

use App\Models\HthAfterSaleTicket;
use App\Models\HthAssSurvey;
use App\Models\HthContactCenter;
use Illuminate\Http\Request;
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
            'pending_data' => $this->calculatePending(),
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
            'pending_data'        => $this->calculatePending(),
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

    public function detail(Request $request, string $chart)
    {
        $handlers = [
            'ud-csi-chart' => 'handleCsiChart',
            'ud-rtat-chart' => 'handleRtatChart',
            'ud-ltp-chart' => 'handleLtpChart',
            'ud-ftf-chart' => 'handleFtfChart',
            'ud-ticket-by-status-chart' => 'handleTicketByStatusChart',
            'ud-aging-chart' => 'handleAgingChart',
            'ud-csi-response-chart' => 'handleCsiResponseChart',
            'ud-pending-reason-chart' => 'handlePendingReasonChart',
            'ud-pending-overview-chart' => 'handlePendingOverviewChart',
            'ud-status-overview-chart' => 'handleStatusOverviewChart',
            'ud-pending-by-region-chart' => 'handlePendingByRegionChart',
            'ud-inhouse-pending-chart' => 'handleInhousePendingChart',
            'ud-asc-pending-by-region-chart' => 'handleAscPendingByRegionChart',
            'ud-pending-by-type-chart' => 'handlePendingByTypeChart',
            'ud-pending-product-group-chart' => 'handlePendingProductGroupChart',
            'ud-ticket-chart' => 'handleTicketChart',
            'ud-contact-chart' => 'handleContractChart',
            'ud-daily-chart' => 'handleDailyChart',
        ];

        if (! isset($handlers[$chart])) {
            abort(404);
        }

        return $this->{$handlers[$chart]}($request);
    }

    private function handleCsiChart(Request $request)
    {
        $csiData       = $this->calculateCsiResponse(now()->month, now()->year);
        $activeStatuses = array_values(array_filter((array) $request->input('status', [])));

        $surveys = HthAssSurvey::query()
            ->whereMonth('completion_time', now()->month)
            ->whereYear('completion_time', now()->year)
            ->where('deleted', 0)
            ->when(!empty($activeStatuses), fn($q) => $q->whereIn('service_team', $activeStatuses))
            ->latest('completion_time')
            ->paginate(15)
            ->withQueryString();

        $allSurvey = HthAssSurvey::query()
            ->whereMonth('completion_time', now()->month)
            ->whereYear('completion_time', now()->year)
            ->where('deleted', 0)
            ->count();

        return view('pages.after-sales.details.csi-chart', [
            'csiData'        => $csiData,
            'surveys'        => $surveys,
            'allSurvey'      => $allSurvey,
            'activeStatuses' => $activeStatuses,
        ]);
    }

    private function handleRtatChart(Request $request)
    {
        $rtatData = $this->calculateRtat(now()->month, now()->year);
        $region = $request->input('region');

        $query = HthAfterSaleTicket::query()
            ->leftJoin(DB::raw('(SELECT postcodemain, master_part_eng FROM hth_ass_regions GROUP BY postcodemain, master_part_eng) as `regions`'), 'hth_after_sale_ticket.zipcode', '=', 'regions.postcodemain')
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->whereMonth('hth_after_sale_ticket_cstm.closed_datetime_c', now()->month)
            ->whereYear('hth_after_sale_ticket_cstm.closed_datetime_c', now()->year)
            ->where('hth_after_sale_ticket.deleted', 0)
            ->where('hth_after_sale_ticket.status', 'Closed')
            ->whereIn('hth_after_sale_ticket.type', ['R', 'I', 'C', 'P', 'O', 'consult_or_advise', 'site_servey'])
            ->when($region, fn($q) => $q->where('regions.master_part_eng', $region));

        if ($region === 'Bangkok Metropolitan') {
            $query->leftJoin('hth_ass_teams', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), '=', 'hth_ass_teams.name')
                ->where('hth_ass_teams.team', 'LIKE', '%BKK%');
        }

        $tickets = $query
            ->select([
                'hth_after_sale_ticket.name',
                'hth_after_sale_ticket_cstm.closed_datetime_c',
                'hth_after_sale_ticket.date_entered',
                'hth_after_sale_ticket.release_date',
                'hth_after_sale_ticket.booking',
                'hth_after_sale_ticket.ticket_number',
                'hth_after_sale_ticket.status',
                'hth_after_sale_ticket.zipcode',
                'hth_after_sale_ticket.note',
                'hth_after_sale_ticket.pending',
                'users.first_name',
                'users.last_name',
                'regions.master_part_eng as master_part_eng',
                DB::raw('DATEDIFF(hth_after_sale_ticket_cstm.closed_datetime_c, hth_after_sale_ticket.date_entered) + 1 as days_diff'),
            ])
            ->orderByDesc('days_diff')
            ->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.rtat-chart', [
            'rtatData'     => $rtatData,
            'tickets'      => $tickets,
            'activeRegion' => $region,
        ]);
    }

    private function handleLtpChart(Request $request)
    {
        $teams = [
            "HA&SA Technician BKK1",
            "HA&SA Technician BKK2",
            "HA&SA Technician BKK3",
            "HA&SA Technician BKK4",
            "HA&SA Technician BKK5",
            "HA&SA Technician BKK6",
            "HA&SA Technician BKK7",
            "HW&FF Technician BKK1",
            "HW&FF Technician BKK2",
            "HW&FF Technician BKK3",
            "HW&FF Technician BKK4",
            "Partner",
            "Service Consultant",
            "Technician BKK",
            "Technician CM",
            "Technician PHK"
        ];

        $ltpData = $this->calculateLtp(now()->month, now()->year);
        $activeFilter = $request->input('filter');

        if ($activeFilter === 'last-30-days') {
            $tickets = HthAfterSaleTicket::query()
                ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
                ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
                ->leftjoin('hth_ass_teams', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), '=', 'hth_ass_teams.name')
                ->where('hth_after_sale_ticket.deleted', 0)
                ->whereNot('hth_after_sale_ticket.status', 'Canceled')
                ->where('hth_after_sale_ticket.date_entered', '>=', now()->subDays(30))
                ->whereIn('hth_ass_teams.team', $teams)
                ->select([
                    'hth_after_sale_ticket.ticket_number',
                    'hth_after_sale_ticket.name',
                    'hth_after_sale_ticket.date_entered',
                    'hth_after_sale_ticket.release_date',
                    'hth_after_sale_ticket.booking',
                    'hth_after_sale_ticket.status',
                    'hth_after_sale_ticket.note',
                    'hth_after_sale_ticket.pending',
                    'hth_after_sale_ticket_cstm.closed_datetime_c',
                    'users.first_name',
                    'users.last_name',
                    DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) + 1 as days_diff'),
                ])
                ->orderByDesc('days_diff')
                ->paginate(15)
                ->withQueryString();
        } else {
            $tickets = HthAfterSaleTicket::query()
                ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
                ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
                ->leftJoin('hth_ass_teams', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), '=', 'hth_ass_teams.name')
                ->where('hth_after_sale_ticket.deleted', 0)
                ->whereNot('hth_after_sale_ticket.status', 'Canceled')
                ->whereRaw("hth_after_sale_ticket.date_entered < date_sub(now(), interval 7 day)")
                ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
                        ->whereRaw("hth_after_sale_ticket.booking < now()");
                    })->orWhere(function ($q) {
                        $q->where('hth_after_sale_ticket.status', 'Open')
                        ->whereNull('hth_after_sale_ticket.booking');
                    });
                })
                ->select([
                    'hth_after_sale_ticket.ticket_number',
                    'hth_after_sale_ticket.name',
                    'hth_after_sale_ticket.date_entered',
                    'hth_after_sale_ticket.release_date',
                    'hth_after_sale_ticket.booking',
                    'hth_after_sale_ticket.status',
                    'hth_after_sale_ticket.note',
                    'hth_after_sale_ticket.pending',
                    'hth_after_sale_ticket_cstm.closed_datetime_c',
                    'users.first_name',
                    'users.last_name',
                    DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) + 1 as days_diff'),
                ])
                ->orderByDesc('days_diff')
                ->paginate(15)
                ->withQueryString();
        }

        return view('pages.after-sales.details.ltp-chart', [
            'ltpData' => $ltpData,
            'tickets' => $tickets,
            'activeFilter' => $activeFilter,
        ]);
    }

    private function handleFtfChart(Request $request)
    {
        $ftfData = $this->calculateFtf(now()->month, now()->year);
        $teams = [
            "HA&SA Technician BKK1",
            "HA&SA Technician BKK2",
            "HA&SA Technician BKK3",
            "HA&SA Technician BKK4",
            "HA&SA Technician BKK5",
            "HA&SA Technician BKK6",
            "HA&SA Technician BKK7",
            "HW&FF Technician BKK1",
            "HW&FF Technician BKK2",
            "HW&FF Technician BKK3",
            "HW&FF Technician BKK4",
            "Partner",
            "Service Consultant",
            "Technician BKK",
            "Technician CM",
            "Technician PHK"
        ];

        $tickets =  HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->leftjoin('hth_ass_teams', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), '=', 'hth_ass_teams.name')
            ->whereMonth('hth_after_sale_ticket_cstm.closed_datetime_c', now()->month)
            ->whereYear('hth_after_sale_ticket_cstm.closed_datetime_c', now()->year)
            ->where('hth_after_sale_ticket.deleted', 0)
            ->where('hth_after_sale_ticket.status', 'Closed')
            ->whereIn('hth_ass_teams.team', $teams)
            ->where('hth_after_sale_ticket.round', '<=', 1)
            ->select([
                'hth_after_sale_ticket.ticket_number',
                'hth_after_sale_ticket.name',
                'hth_after_sale_ticket.status',
                'hth_after_sale_ticket.date_entered',
                'hth_after_sale_ticket.release_date',
                'hth_after_sale_ticket.booking',
                'hth_after_sale_ticket.note',
                'hth_after_sale_ticket.round',
                'hth_after_sale_ticket.pending',
                'hth_after_sale_ticket_cstm.closed_datetime_c',
                'users.first_name',
                'users.last_name',
            ])
            ->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.ftf-chart', [
            'ftfData' => $ftfData,
            'tickets' => $tickets,
        ]);
    }

    private function handleTicketByStatusChart(Request $request)
    {
        $totalStatData  = $this->calculateTotalStat(now()->month, now()->year);
        $activeStatuses = array_values(array_filter((array) $request->input('status', [])));

        $query = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->leftjoin('hth_ass_teams', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), '=', 'hth_ass_teams.name')
            ->where('hth_after_sale_ticket.deleted', 0);

        if (empty($activeStatuses)) {
            // default: show tickets created this month
            $query->whereYear('hth_after_sale_ticket.date_entered', now()->year)
                  ->whereMonth('hth_after_sale_ticket.date_entered', now()->month);
        } else {
            $query->where(function ($q) use ($activeStatuses) {
                foreach ($activeStatuses as $status) {
                    $q->orWhere(function ($sub) use ($status) {
                        if ($status === 'Closed') {
                            $sub->whereYear('hth_after_sale_ticket_cstm.closed_datetime_c', now()->year)
                                ->whereMonth('hth_after_sale_ticket_cstm.closed_datetime_c', now()->month)
                                ->where('hth_after_sale_ticket.status', 'Closed');
                        } elseif ($status === 'Created') {
                            $sub->whereYear('hth_after_sale_ticket.date_entered', now()->year)
                                ->whereMonth('hth_after_sale_ticket.date_entered', now()->month);
                        } elseif ($status === 'Pending') {
                            $sub->where('hth_after_sale_ticket.date_entered', '<=', now())
                                ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason']);
                        } elseif (in_array($status, ['Open', 'In_progress', 'Pending_Reason'])) {
                            $sub->where('hth_after_sale_ticket.date_entered', '<=', now())
                                ->where('hth_after_sale_ticket.status', $status);
                        }
                    });
                }
            });
        }

        $tickets = $query->select(['hth_after_sale_ticket.*', 'users.first_name', 'users.last_name', 'hth_after_sale_ticket_cstm.closed_datetime_c'])
            ->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.ticket-by-status-chart', [
            'total_stat_data' => $totalStatData,
            'tickets'         => $tickets,
            'activeStatuses'  => $activeStatuses,
        ]);
    }

    private function handleAgingChart(Request $request)
    {
        $agingData   = $this->calculateOverallAging(now()->month, now()->year);
        $activeAgings = array_values(array_filter((array) $request->input('aging', [])));

        $query = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason']);

        $query = $this->applyAgingFilters($query, $activeAgings);

        $tickets = $query
            ->select([
                'hth_after_sale_ticket.ticket_number',
                'hth_after_sale_ticket.name',
                'hth_after_sale_ticket.date_entered',
                'hth_after_sale_ticket.release_date',
                'hth_after_sale_ticket.booking',
                'hth_after_sale_ticket.note',
                'hth_after_sale_ticket.status',
                'hth_after_sale_ticket.pending',
                'hth_after_sale_ticket_cstm.closed_datetime_c',
                'users.first_name',
                'users.last_name',
                DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) as days_diff'),
            ])
            ->orderByDesc('days_diff')
            ->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.overall-aging-chart', [
            'agingData'    => $agingData,
            'tickets'      => $tickets,
            'activeAgings' => $activeAgings,
        ]);
    }

    private function handleCsiResponseChart(Request $request)
    {
        $csiData        = $this->calculateCsiResponse(now()->month, now()->year);
        $activeStatuses = array_values(array_filter((array) $request->input('status', [])));

        $surveys = HthAssSurvey::query()
            ->whereMonth('completion_time', now()->month)
            ->whereYear('completion_time', now()->year)
            ->where('deleted', 0)
            ->when(!empty($activeStatuses), fn($q) => $q->whereIn('service_team', $activeStatuses))
            ->latest('completion_time')
            ->paginate(15)
            ->withQueryString();

        $allSurvey = HthAssSurvey::query()
            ->whereMonth('completion_time', now()->month)
            ->whereYear('completion_time', now()->year)
            ->where('deleted', 0)
            ->count();

        // Filtered aggregate — drives the charts when filter is active
        $filteredSurvey = HthAssSurvey::query()
            ->whereMonth('completion_time', now()->month)
            ->whereYear('completion_time', now()->year)
            ->where('deleted', 0)
            ->when(!empty($activeStatuses), fn($q) => $q->whereIn('service_team', $activeStatuses))
            ->selectRaw("
                COUNT(*) as total,
                COUNT(CASE WHEN service_team = 'ดีมาก (Very Good)' THEN 1 END)        as service_very_good,
                COUNT(CASE WHEN service_team = 'ดี (Good)' THEN 1 END)                as service_good,
                COUNT(CASE WHEN service_team = 'ปกติ (Normal)' THEN 1 END)            as service_normal,
                COUNT(CASE WHEN service_team = 'แย่ (Bad)' THEN 1 END)                as service_bad,
                COUNT(CASE WHEN service_team = 'แย่มาก (Very Bad)' THEN 1 END)        as service_very_bad,
                COUNT(CASE WHEN problem_resolved = 'ใช่ (Yes)' THEN 1 END)            as problem_resolved_yes,
                COUNT(CASE WHEN arrive_as_scheduled = 'ใช่ (Yes)' THEN 1 END)         as arrive_as_scheduled_yes,
                COUNT(CASE WHEN polite_and_well_mannered = 'ใช่ (Yes)' THEN 1 END)    as polite_and_well_mannered_yes
            ")
            ->first();

        return view('pages.after-sales.details.csi-response-chart', [
            'csiData'        => $csiData,
            'surveys'        => $surveys,
            'activeStatuses' => $activeStatuses,
            'allSurvey'      => $allSurvey,
            'filteredSurvey' => $filteredSurvey,
        ]);
    }

    private function handlePendingReasonChart(Request $request)
    {
        $pendingData    = $this->calculatePendingReason(now()->month, now()->year);
        $activeAgings   = array_values(array_filter((array) $request->input('aging', [])));
        $activePendings = array_values(array_filter((array) $request->input('pending', [])));

        $namedReasons = [
            'Spare_part_on_progress',
            'Site_not_ready_or_waiting_confirm',
            'Postpone_or_new_appointment',
            'Process_return_or_change_set',
            'Waiting_service_schedule_Technician',
        ];

        $query = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->where('hth_after_sale_ticket.date_entered', '<=', now())
            ->where('hth_after_sale_ticket.deleted', 0)
            ->where('hth_after_sale_ticket.status', 'Pending_Reason')
            ->where(fn($q) => $q->whereIn('hth_after_sale_ticket.pending', $namedReasons)->orWhereNull('hth_after_sale_ticket.pending'));

        if (!empty($activePendings)) {
            $query->where(function ($sub) use ($activePendings) {
                foreach ($activePendings as $p) {
                    if ($p === 'blank') {
                        $sub->orWhereNull('hth_after_sale_ticket.pending');
                    } else {
                        $sub->orWhere('hth_after_sale_ticket.pending', $p);
                    }
                }
            });
        }

        $query = $this->applyAgingFilters($query, $activeAgings);

        $tickets = $query
            ->select([
                'hth_after_sale_ticket.ticket_number',
                'hth_after_sale_ticket.name',
                'hth_after_sale_ticket.date_entered',
                'hth_after_sale_ticket.release_date',
                'hth_after_sale_ticket.booking',
                'hth_after_sale_ticket.note',
                'hth_after_sale_ticket.pending',
                'hth_after_sale_ticket.status',
                'hth_after_sale_ticket_cstm.closed_datetime_c',
                'users.first_name',
                'users.last_name',
                DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) as days_diff'),
            ])
            ->latest('days_diff')
            ->paginate(15)
            ->withQueryString();

        $pendingReasons = [
            'Spare_part_on_progress'            => 'Spare Part',
            'Site_not_ready_or_waiting_confirm' => 'Site Not Ready',
            'Postpone_or_new_appointment'       => 'Postpone',
            'Process_return_or_change_set'      => 'Return/Change',
            'Waiting_service_schedule_Technician' => 'Waiting Technician',
            'blank'                             => 'No Reason',
        ];

        return view('pages.after-sales.details.pending-reason-chart', [
            'pendingData'    => $pendingData,
            'tickets'        => $tickets,
            'activeAgings'   => $activeAgings,
            'activePendings' => $activePendings,
            'pendingReasons' => $pendingReasons,
        ]);
    }

    private function handlePendingOverviewChart(Request $request)
    {
        $pendingData = $this->calculatePending();
        $activeGroup = $request->input('group');

        $tickets = $this->pendingTicketQuery($activeGroup)
            ->with('assignee:id,first_name,last_name')
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->select([
                'hth_after_sale_ticket.ticket_number',
                'hth_after_sale_ticket.name',
                'hth_after_sale_ticket.date_entered',
                'hth_after_sale_ticket.release_date',
                'hth_after_sale_ticket.booking',
                'hth_after_sale_ticket.date_modified',
                'hth_after_sale_ticket.note',
                'hth_after_sale_ticket.status',
                'hth_after_sale_ticket.type',
                'hth_after_sale_ticket.assigned_user_id',
                'hth_after_sale_ticket.pending',
                'hth_after_sale_ticket_cstm.closed_datetime_c',
            ])
            ->latest('hth_after_sale_ticket.date_entered')
            ->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.pending-overview-chart', [
            'pendingData' => $pendingData,
            'tickets'     => $tickets,
            'activeGroup' => $activeGroup,
        ]);
    }

    private function handleStatusOverviewChart(Request $request)
    {
        $statusData    = $this->calculateStatus(now()->month, now()->year);
        $activeAgings  = array_values(array_filter((array) $request->input('aging', [])));
        $activeStatuses = array_values(array_filter((array) $request->input('status', [])));

        $query = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->when(!empty($activeStatuses), fn($q) => $q->whereIn('hth_after_sale_ticket.status', $activeStatuses));

        $query = $this->applyAgingFilters($query, $activeAgings);

        $tickets = $query
            ->select([
                'hth_after_sale_ticket.ticket_number',
                'hth_after_sale_ticket.name',
                'hth_after_sale_ticket.date_entered',
                'hth_after_sale_ticket.release_date',
                'hth_after_sale_ticket.booking',
                'hth_after_sale_ticket.note',
                'hth_after_sale_ticket.status',
                'hth_after_sale_ticket.pending',
                'hth_after_sale_ticket_cstm.closed_datetime_c',
                'users.first_name',
                'users.last_name',
                DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) as days_diff'),
            ])
            ->orderByDesc('days_diff')
            ->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.status-overview-chart', [
            'statusData'     => $statusData,
            'tickets'        => $tickets,
            'activeAgings'   => $activeAgings,
            'activeStatuses' => $activeStatuses,
        ]);
    }

    private function handlePendingByRegionChart(Request $request)
    {
        $pendingData = $this->calculatePendingByRegion(now()->month, now()->year);
        $activeRegions = array_values(array_filter((array) $request->input('region', [])));
        $activeAgings = array_values(array_filter((array) $request->input('aging', [])));

        $regionsSub = DB::raw('(SELECT postcodemain, master_part_eng FROM hth_ass_regions GROUP BY postcodemain, master_part_eng) as `regions`');

        $tickets = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->leftJoin($regionsSub, 'hth_after_sale_ticket.zipcode', '=', 'regions.postcodemain')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->when(!empty($activeRegions), fn($q) => $q->whereIn('regions.master_part_eng', $activeRegions))
            ->when(!empty($activeAgings), fn($q) => $this->applyAgingFilters($q, $activeAgings))
            ->select([
                'hth_after_sale_ticket.ticket_number',
                'hth_after_sale_ticket.name',
                'hth_after_sale_ticket.date_entered',
                'hth_after_sale_ticket.release_date',
                'hth_after_sale_ticket.booking',
                'hth_after_sale_ticket.note',
                'hth_after_sale_ticket.status',
                'hth_after_sale_ticket.pending',
                'hth_after_sale_ticket.zipcode',
                'hth_after_sale_ticket_cstm.closed_datetime_c',
                'users.first_name',
                'users.last_name',
                'regions.master_part_eng as region',
                DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) as days_diff'),
            ])
            ->orderByDesc('days_diff')
            ->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.pending-by-region-chart', [
            'pendingData'   => $pendingData,
            'tickets'       => $tickets,
            'activeRegions' => $activeRegions,
            'activeAgings'  => $activeAgings,
        ]);
    }

    private function handleInhousePendingChart(Request $request)
    {
        $pendingData  = $this->calculateInhousePending(now()->month, now()->year);
        $activeTeams  = array_values(array_filter((array) $request->input('team', [])));
        $activeAgings = array_values(array_filter((array) $request->input('aging', [])));

        $tickets = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->leftJoin('hth_ass_teams', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), '=', 'hth_ass_teams.name')
            ->whereNotNull('hth_ass_teams.team')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->where('hth_after_sale_ticket.date_entered', '<=', now())
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->when(!empty($activeTeams), fn($q) => $q->whereIn('hth_ass_teams.team', $activeTeams))
            ->when(!empty($activeAgings), fn($q) => $q->where(function ($sub) use ($activeAgings) {
                foreach ($activeAgings as $aging) {
                    match ($aging) {
                        '0-3'    => $sub->orWhereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered)'), [0, 3]),
                        '4-7'    => $sub->orWhereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered)'), [4, 7]),
                        '8-15'   => $sub->orWhereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered)'), [8, 15]),
                        '16-30'  => $sub->orWhereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered)'), [16, 30]),
                        'over_30' => $sub->orWhereRaw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) > 30'),
                        default  => null,
                    };
                }
            }))
            ->select([
                'hth_after_sale_ticket.ticket_number',
                'hth_after_sale_ticket.name',
                'hth_after_sale_ticket.date_entered',
                'hth_after_sale_ticket.release_date',
                'hth_after_sale_ticket.booking',
                'hth_after_sale_ticket.note',
                'hth_after_sale_ticket.status',
                'hth_after_sale_ticket.pending',
                'hth_after_sale_ticket_cstm.closed_datetime_c',
                'hth_ass_teams.team as team',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as assignee_name"),
                DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) as days_diff'),
            ])
            ->orderByDesc('days_diff')
            ->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.inhouse-pending-chart', [
            'pendingData'  => $pendingData,
            'tickets'      => $tickets,
            'activeTeams'  => $activeTeams,
            'activeAgings' => $activeAgings,
        ]);
    }

    private function handleAscPendingByRegionChart(Request $request)
    {
        $pendingData = $this->calculateAscPending(now()->month, now()->year);
        $activeRegions = array_values(array_filter((array) $request->input('region', [])));
        $activeAgings = array_values(array_filter((array) $request->input('aging', [])));

        $tickets = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->leftJoin(DB::raw('(SELECT postcodemain, master_part_eng FROM hth_ass_regions GROUP BY postcodemain, master_part_eng) as `regions`'), 'hth_after_sale_ticket.zipcode', '=', 'regions.postcodemain')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->whereHas('assignee', fn($q) => $q->where('first_name', 'LIKE', 'ASC%'))
            ->when(!empty($activeRegions), fn($q) => $q->whereIn('regions.master_part_eng', $activeRegions))
            ->when(!empty($activeAgings), fn($q) => $this->applyAgingFilters($q, $activeAgings))
            ->select([
                'hth_after_sale_ticket.ticket_number',
                'hth_after_sale_ticket.name',
                'hth_after_sale_ticket.date_entered',
                'hth_after_sale_ticket.release_date',
                'hth_after_sale_ticket.booking',
                'hth_after_sale_ticket.note',
                'hth_after_sale_ticket.status',
                'hth_after_sale_ticket.pending',
                'hth_after_sale_ticket_cstm.closed_datetime_c',
                'users.first_name',
                'users.last_name',
                'regions.master_part_eng as region',
                DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) as days_diff'),
            ])
            ->orderByDesc('days_diff')
            ->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.asc-pending-by-region-chart', [
            'pendingData'   => $pendingData,
            'tickets'       => $tickets,
            'activeRegions' => $activeRegions,
            'activeAgings'  => $activeAgings,
        ]);
    }

    private function handlePendingByTypeChart(Request $request)
    {
        $pendingData = $this->calculatePendingType(now()->month, now()->year);
        $activeTypes = array_values(array_filter((array) $request->input('type', [])));

        $tickets = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->whereIn('hth_after_sale_ticket.type', ['R', 'C', 'I', 'spare_part', 'consult_or_advise'])
            ->when(!empty($activeTypes), fn($q) => $q->whereIn('hth_after_sale_ticket.type', $activeTypes))
            ->select([
                'hth_after_sale_ticket.ticket_number',
                'hth_after_sale_ticket.name',
                'hth_after_sale_ticket.date_entered',
                'hth_after_sale_ticket.release_date',
                'hth_after_sale_ticket.booking',
                'hth_after_sale_ticket.note',
                'hth_after_sale_ticket.status',
                'hth_after_sale_ticket.type',
                'hth_after_sale_ticket.pending',
                'hth_after_sale_ticket_cstm.closed_datetime_c',
                'users.first_name',
                'users.last_name',
            ])
            ->latest('hth_after_sale_ticket.date_entered')
            ->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.pending-by-type-chart', [
            'pendingData' => $pendingData,
            'tickets'     => $tickets,
            'activeTypes' => $activeTypes,
        ]);
    }

    private function handlePendingProductGroupChart(Request $request)
    {
        $pendingData = $this->calculatePendingGroup(now()->month, now()->year);
        $activeGroups = array_values(array_filter((array) $request->input('group', [])));

        $tickets = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->leftJoin('aos_product_categories', 'hth_after_sale_ticket.aos_product_categories_id', '=', 'aos_product_categories.id')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->whereIn('aos_product_categories.name', ['Smart Technology', 'Home appliances', 'Sanitary', 'Architectural hardware', 'FF - Furniture Fittings'])
            ->when(!empty($activeGroups), fn($q) => $q->whereIn('aos_product_categories.name', $activeGroups))
            ->select([
                'hth_after_sale_ticket.ticket_number',
                'hth_after_sale_ticket.name',
                'hth_after_sale_ticket.date_entered',
                'hth_after_sale_ticket.release_date',
                'hth_after_sale_ticket.booking',
                'hth_after_sale_ticket.note',
                'hth_after_sale_ticket.status',
                'hth_after_sale_ticket.pending',
                'hth_after_sale_ticket_cstm.closed_datetime_c',
                'aos_product_categories.name as product_group',
                'users.first_name',
                'users.last_name',
            ])
            ->latest('hth_after_sale_ticket.date_entered')
            ->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.pending-product-group-chart', [
            'pendingData'  => $pendingData,
            'tickets'      => $tickets,
            'activeGroups' => $activeGroups,
        ]);
    }

    private function handleTicketChart(Request $request)
    {
        $ticketData = $this->calculateTicket(now()->year);
        $activeMonths = array_values(array_unique(array_map('strval', array_values(array_filter((array) $request->input('month', []))))));
        $activeStatuses = array_values(array_unique(array_map('strval', array_values(array_filter((array) $request->input('status', []))))));

        $openRequested = in_array('opened', $activeStatuses, true);
        $closedRequested = in_array('closed', $activeStatuses, true);

        $query = HthAfterSaleTicket::query()
            ->where('hth_after_sale_ticket.deleted', 0);

        if ($closedRequested && ! $openRequested) {
            $query->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
                ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
                ->when(! empty($activeMonths), fn($q) => $q->whereIn(DB::raw('MONTH(hth_after_sale_ticket_cstm.closed_datetime_c)'), $activeMonths))
                ->whereYear('hth_after_sale_ticket_cstm.closed_datetime_c', now()->year)
                ->where('hth_after_sale_ticket.status', 'Closed')
                ->select('hth_after_sale_ticket.*', 'hth_after_sale_ticket_cstm.closed_datetime_c', 'users.first_name', 'users.last_name');
        } elseif ($openRequested && ! $closedRequested) {
            $query->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
                ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
                ->when(! empty($activeMonths), fn($q) => $q->whereIn(DB::raw('MONTH(hth_after_sale_ticket.date_entered)'), $activeMonths))
                ->whereYear('hth_after_sale_ticket.date_entered', now()->year)
                ->select('hth_after_sale_ticket.*', 'hth_after_sale_ticket_cstm.closed_datetime_c', 'users.first_name', 'users.last_name');
        } else {
            $cols = [
                'hth_after_sale_ticket.ticket_number', 
                'hth_after_sale_ticket.name', 
                'hth_after_sale_ticket.date_entered', 
                'hth_after_sale_ticket.status', 
                'hth_after_sale_ticket.release_date', 
                'hth_after_sale_ticket.booking', 
                'hth_after_sale_ticket.note', 
                'hth_after_sale_ticket.pending', 
                'hth_after_sale_ticket.type', 
                'hth_after_sale_ticket.assigned_user_id'
            ];

            $openQuery = HthAfterSaleTicket::query()
                ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
                ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
                ->where('hth_after_sale_ticket.deleted', 0)
                ->whereYear('hth_after_sale_ticket.date_entered', now()->year)
                ->when(! empty($activeMonths), fn($q) => $q->whereIn(DB::raw('MONTH(hth_after_sale_ticket.date_entered)'), $activeMonths))
                ->select(array_merge($cols, ['users.first_name', 'users.last_name', 'hth_after_sale_ticket_cstm.closed_datetime_c']));

            $closedQuery = HthAfterSaleTicket::query()
                ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
                ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
                ->where('hth_after_sale_ticket.deleted', 0)
                ->where('hth_after_sale_ticket.status', 'Closed')
                ->whereYear('hth_after_sale_ticket_cstm.closed_datetime_c', now()->year)
                ->when(! empty($activeMonths), fn($q) => $q->whereIn(DB::raw('MONTH(hth_after_sale_ticket_cstm.closed_datetime_c)'), $activeMonths))
                ->select(array_merge($cols, ['users.first_name', 'users.last_name', 'hth_after_sale_ticket_cstm.closed_datetime_c']));

            $query = $openQuery->union($closedQuery);
        }

        $tickets = $query->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.ticket-chart', [
            'ticketData'   => $ticketData,
            'tickets'      => $tickets,
            'activeMonths' => $activeMonths,
            'activeStatuses' => $activeStatuses,
        ]);
    }

    private function handleContractChart(Request $request)
    {
        $contractData = $this->calculateContractCenter(now()->year);
        $activeMonths = array_values(array_unique(array_map('strval', (array) $request->input('month', []))));
        $activeYears = array_values(array_unique(array_map('strval', (array) $request->input('year', []))));

        $tickets = HthContactCenter::query()
            ->when(! empty($activeYears), fn($q) => $q->whereIn(DB::raw('YEAR(date_entered)'), $activeYears))
            ->when(! empty($activeMonths), fn($q) => $q->whereIn(DB::raw('MONTH(date_entered)'), $activeMonths))
            ->where(fn($q) => $q->whereYear('date_entered', now()->year)->orWhereYear('date_entered', now()->subYear()->year))
            ->where('deleted', 0)
            ->whereNot('date_entered', '>', now())
            ->select([
                'code',
                'name',
                'date_entered',
                'description',
                'type',
            ])
            ->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.contract-chart', [
            'contractData' => $contractData,
            'tickets'      => $tickets,
            'activeMonths' => $activeMonths,
            'activeYears'  => $activeYears,
        ]);
    }

    private function handleDailyChart(Request $request)
    {
        $dailyData = $this->calculateContractCenterDaily(now()->month, now()->year);
        $activeShift = $request->input('shift');

        $tickets = HthContactCenter::query()
            ->where(db::raw("month(convert_tz(date_entered, '+00:00', '+07:00'))"), now()->month)
            ->where(db::raw("year(convert_tz(date_entered, '+00:00', '+07:00'))"), now()->year)
            ->where('deleted', 0)
            ->when($activeShift === 'day', fn($q) => $q
                ->where(db::raw("time(convert_tz(date_entered, '+00:00', '+07:00'))"), '>=', '08:00:00')
                ->where(db::raw("time(convert_tz(date_entered, '+00:00', '+07:00'))"), '<', '17:00:00')
            )
            ->when($activeShift === 'night', fn($q) => $q->where(fn($q) => $q
                ->where(db::raw("time(convert_tz(date_entered, '+00:00', '+07:00'))"), '>=', '17:00:00')
                ->orWhere(db::raw("time(convert_tz(date_entered, '+00:00', '+07:00'))"), '<', '08:00:00')
            ))
            ->select([
                'code',
                'name',
                'date_entered',
                'description',
                'type',
            ])
            ->orderByDesc('date_entered')
            ->paginate(15)
            ->withQueryString();

        return view('pages.after-sales.details.daily-chart', [
            'dailyData'   => $dailyData,
            'tickets'     => $tickets,
            'activeShift' => $activeShift,
        ]);
    }

    private function applyAgingFilters($query, array $activeAgings)
    {
        if (empty($activeAgings)) {
            return $query;
        }

        return $query->where(function ($sub) use ($activeAgings) {
            foreach ($activeAgings as $aging) {
                match ($aging) {
                    '0-3'    => $sub->orWhereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered)'), [0, 3]),
                    '4-7'    => $sub->orWhereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered)'), [4, 7]),
                    '8-15'   => $sub->orWhereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered)'), [8, 15]),
                    '16-30'  => $sub->orWhereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered)'), [16, 30]),
                    'over_30' => $sub->orWhereRaw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) > 30'),
                    default  => null,
                };
            }
        });
    }

    private function applyAgingFilter($query, ?string $activeAging)
    {
        if ($activeAging === '0-3') {
            return $query->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered)'), [0, 3]);
        }

        if ($activeAging === '4-7') {
            return $query->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered)'), [4, 7]);
        }

        if ($activeAging === '8-15') {
            return $query->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered)'), [8, 15]);
        }

        if ($activeAging === '16-30') {
            return $query->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered)'), [16, 30]);
        }

        if ($activeAging === 'over_30') {
            return $query->whereRaw('DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) > 30');
        }

        return $query;
    }

    private function baseQuery(int $month, int $year)
    {
        return HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->whereMonth('hth_after_sale_ticket_cstm.closed_datetime_c', $month)
            ->whereYear('hth_after_sale_ticket_cstm.closed_datetime_c', $year);
    }

    private function calculateRtat(int $month, int $year)
    {
        $teams = [
            "HA&SA Technician BKK1",
            "HA&SA Technician BKK2",
            "HA&SA Technician BKK3",
            "HA&SA Technician BKK4",
            "HA&SA Technician BKK5",
            "HA&SA Technician BKK6",
            "HA&SA Technician BKK7",
            "HW&FF Technician BKK1",
            "HW&FF Technician BKK2",
            "HW&FF Technician BKK3",
            "HW&FF Technician BKK4",
            "Technician BKK"
        ];

        $result = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->whereMonth('hth_after_sale_ticket_cstm.closed_datetime_c', $month)
            ->whereYear('hth_after_sale_ticket_cstm.closed_datetime_c', $year)
            ->where('hth_after_sale_ticket.deleted', 0)
            ->where('hth_after_sale_ticket.status', 'Closed')
            ->whereIn('hth_after_sale_ticket.type', ['R', 'I', 'C', 'P', 'O', 'consult_or_advise', 'site_servey'])
            ->selectRaw('COUNT(*) as total, SUM(DATEDIFF(hth_after_sale_ticket_cstm.closed_datetime_c, hth_after_sale_ticket.date_entered) + 1) as total_days')
            ->first();

        $bkkResult  = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->leftjoin('hth_ass_teams', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), '=', 'hth_ass_teams.name')
            ->whereMonth('hth_after_sale_ticket_cstm.closed_datetime_c', $month)
            ->whereYear('hth_after_sale_ticket_cstm.closed_datetime_c', $year)
            ->where('hth_after_sale_ticket.deleted', 0)
            ->where('hth_after_sale_ticket.status', 'Closed')
            ->where('hth_ass_teams.team', 'LIKE', '%BKK%')
            ->whereIn('hth_after_sale_ticket.type', ['R', 'I', 'C', 'P', 'O', 'consult_or_advise', 'site_servey'])
            ->whereIn('hth_after_sale_ticket.zipcode', function ($q) {
                $q->select('postcodemain')
                    ->from('hth_ass_regions')
                    ->where('master_part_eng', 'Bangkok Metropolitan');
            })
            ->selectRaw('COUNT(*) as total, SUM(DATEDIFF(hth_after_sale_ticket_cstm.closed_datetime_c, hth_after_sale_ticket.date_entered) + 1) as total_days')
            ->first();

        return [
            'overall' => $result->total > 0
                ? number_format($result->total_days / $result->total, 1)
                : 0,
            'bkk' => $bkkResult->total > 0
                ? number_format($bkkResult->total_days / $bkkResult->total, 1)
                : 0,
            'total_all' => $result->total,
            'total_all_days' => $result->total_days,
            'total_bkk' => $bkkResult->total,
            'total_bkk_days' => $bkkResult->total_days
        ];
    }

    private function calculateLtp(int $month, int $year)
    {
        $teams = [
            "HA&SA Technician BKK1",
            "HA&SA Technician BKK2",
            "HA&SA Technician BKK3",
            "HA&SA Technician BKK4",
            "HA&SA Technician BKK5",
            "HA&SA Technician BKK6",
            "HA&SA Technician BKK7",
            "HW&FF Technician BKK1",
            "HW&FF Technician BKK2",
            "HW&FF Technician BKK3",
            "HW&FF Technician BKK4",
            "Partner",
            "Service Consultant",
            "Technician BKK",
            "Technician CM",
            "Technician PHK"
        ];

        $result = HthAfterSaleTicket::query()
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->leftjoin('hth_ass_teams', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), '=', 'hth_ass_teams.name')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereNot('hth_after_sale_ticket.status', 'Canceled')
            ->selectRaw("
                COUNT(CASE WHEN hth_after_sale_ticket.date_entered < date_sub(now(), interval 7 day) AND (
                    (hth_after_sale_ticket.status in ('Open', 'In_progress', 'Pending_Reason') AND hth_after_sale_ticket.booking < now())
                    OR (hth_after_sale_ticket.status = 'Open' AND hth_after_sale_ticket.booking IS NULL)
                ) THEN 1 END) as overdue_7_days,
                COUNT(CASE WHEN hth_after_sale_ticket.date_entered >= date_sub(now(), interval 30 day) AND hth_ass_teams.team IN ('" . implode("', '", $teams) . "') THEN 1 END) as total_30_days
            ")
            ->first();

        $overdue_7_days = $result->overdue_7_days ?? 0;
        $total_30_days = $result->total_30_days ?? 0;

        $ratio = ($overdue_7_days > 0) ? ($overdue_7_days / $total_30_days) : 0;

        return $result->overdue_7_days > 0
            ? number_format(100 * ($ratio), 1)
            : 0;
    }

    private function calculateFtf(int $month, int $year)
    {
        $teams = [
            "HA&SA Technician BKK1",
            "HA&SA Technician BKK2",
            "HA&SA Technician BKK3",
            "HA&SA Technician BKK4",
            "HA&SA Technician BKK5",
            "HA&SA Technician BKK6",
            "HA&SA Technician BKK7",
            "HW&FF Technician BKK1",
            "HW&FF Technician BKK2",
            "HW&FF Technician BKK3",
            "HW&FF Technician BKK4",
            "Partner",
            "Service Consultant",
            "Technician BKK",
            "Technician CM",
            "Technician PHK"
        ];

        $result = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
            ->leftjoin('hth_ass_teams', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), '=', 'hth_ass_teams.name')
            ->whereMonth('hth_after_sale_ticket_cstm.closed_datetime_c', $month)
            ->whereYear('hth_after_sale_ticket_cstm.closed_datetime_c', $year)
            ->where('hth_after_sale_ticket.deleted', 0)
            ->where('hth_after_sale_ticket.status', 'Closed')
            ->whereIn('hth_ass_teams.team', $teams)
            ->selectRaw('COUNT(*) as total, COUNT(CASE WHEN `round` <= 1 THEN 1 END) as activity')
            ->first();

        return $result->total > 0
            ? number_format(100 * ($result->activity / $result->total), 1)
            : 0;
    }

    private function calculateCsiResponse(int $month, int $year)
    {
        $ticketCount = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->whereMonth('hth_after_sale_ticket_cstm.closed_datetime_c', $month)
            ->whereYear('hth_after_sale_ticket_cstm.closed_datetime_c', $year)
            ->where('hth_after_sale_ticket.status', 'Closed')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.type', ['R', 'I'])
            ->distinct()
            ->count('contact_no');

        $survey = HthAssSurvey::query()
            ->whereMonth('completion_time', $month)
            ->whereYear('completion_time', $year)
            ->where('deleted', 0)
            ->when(request()->status, function ($q) {
                $q->where('service_team', request()->status);
            })
            ->selectRaw("
                COUNT(*) as total,
                COUNT(CASE WHEN service_team = 'ดีมาก (Very Good)' THEN 1 END) as service_very_good,
                COUNT(CASE WHEN service_team = 'ดี (Good)' THEN 1 END) as service_good,
                COUNT(CASE WHEN service_team = 'ปกติ (Normal)' THEN 1 END) as service_normal,
                COUNT(CASE WHEN service_team = 'แย่ (Bad)' THEN 1 END) as service_bad,
                COUNT(CASE WHEN service_team = 'แย่มาก (Very Bad)' THEN 1 END) as service_very_bad,
                COUNT(CASE WHEN problem_resolved = 'ใช่ (Yes)' THEN 1 END) as problem_resolved_yes,
                COUNT(CASE WHEN arrive_as_scheduled = 'ใช่ (Yes)' THEN 1 END) as arrive_as_scheduled_yes,
                COUNT(CASE WHEN polite_and_well_mannered = 'ใช่ (Yes)' THEN 1 END) as polite_and_well_mannered_yes
            ")
            ->first();

        return [
            'total_ticket' => $ticketCount,
            'survey_data' => $survey
        ];
    }

    private function calculatePending()
    {
        $hafele = $this->pendingByType(false, ['R', 'C', 'spare_part', 'consult_or_advise']);
        $asc = $this->pendingByType(true, ['R', 'I']);

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

        $closedRows = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->whereYear('hth_after_sale_ticket_cstm.closed_datetime_c', $year)
            ->where('hth_after_sale_ticket.deleted', 0)
            ->selectRaw("MONTH(hth_after_sale_ticket_cstm.closed_datetime_c) as month, COUNT(CASE WHEN `status` = 'Closed' THEN 1 END) as total_closed")
            ->groupByRaw('MONTH(hth_after_sale_ticket_cstm.closed_datetime_c)')
            ->orderByRaw('MONTH(hth_after_sale_ticket_cstm.closed_datetime_c)')
            ->get()
            ->keyBy('month');

        $openedRows = HthAfterSaleTicket::query()
            ->whereYear('hth_after_sale_ticket.date_entered', $year)
            ->where('hth_after_sale_ticket.deleted', 0)
            ->selectRaw("MONTH(hth_after_sale_ticket.date_entered) as month, COUNT(*) as total_open")
            ->groupByRaw('MONTH(hth_after_sale_ticket.date_entered)')
            ->orderByRaw('MONTH(hth_after_sale_ticket.date_entered)')
            ->get()
            ->keyBy('month');

        $result = [];
        for ($m = 1; $m <= $maxMonth; $m++) {
            $result[$m] = [
                'closed' => (int) ($closedRows[$m]->total_closed ?? 0),
                'open'   => (int) ($openedRows[$m]->total_open ?? 0),
            ];
        }

        return $result;
    }

    private function calculateContractCenter(int $year)
    {
        $currentMonth = now()->month;
        $prevYear = $year - 1;

        $queryRows = fn(int $y) => HthContactCenter::query()
            ->whereYear('date_entered', $y)
            ->where('deleted', 0)
            ->selectRaw('MONTH(date_entered) as month, COUNT(*) as total')
            ->groupByRaw('MONTH(date_entered)')
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
        $maxDay = $daysInMonth;

        $rows = HthContactCenter::query()
            ->whereYear('date_entered', $year)
            ->whereMonth('date_entered', $month)
            ->where('deleted', 0)
            ->selectRaw("
                DAY(convert_tz(date_entered, '+00:00', '+07:00')) as day,
                SUM(CASE WHEN TIME(convert_tz(date_entered, '+00:00', '+07:00')) >= '08:00:00' AND TIME(convert_tz(date_entered, '+00:00', '+07:00')) < '17:00:00' THEN 1 ELSE 0 END) as day_shift,
                SUM(CASE WHEN TIME(convert_tz(date_entered, '+00:00', '+07:00')) < '08:00:00' OR TIME(convert_tz(date_entered, '+00:00', '+07:00')) >= '17:00:00' THEN 1 ELSE 0 END) as night_shift
            ")
            ->groupby(db::raw("date(convert_tz(date_entered, '+00:00', '+07:00'))"))
            ->orderBy('day')
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
        $closedResults = HthAfterSaleTicket::query()
            ->leftJoin('hth_after_sale_ticket_cstm', 'hth_after_sale_ticket.id', '=', 'hth_after_sale_ticket_cstm.id_c')
            ->whereYear('hth_after_sale_ticket_cstm.closed_datetime_c', $year)
            ->whereMonth('hth_after_sale_ticket_cstm.closed_datetime_c', $month)
            ->where('hth_after_sale_ticket.deleted', 0)
            ->where('hth_after_sale_ticket.status', 'Closed')
            ->count();

        $createdResults = HthAfterSaleTicket::query()
            ->whereYear('hth_after_sale_ticket.date_entered', $year)
            ->whereMonth('hth_after_sale_ticket.date_entered', $month)
            ->where('hth_after_sale_ticket.deleted', 0)
            ->count();

        $resultPending = HthAfterSaleTicket::query()
            ->where('date_entered', '<=', now())
            ->where('deleted', 0)
            ->selectRaw("
                COUNT(CASE WHEN status IN ('Open', 'In_progress', 'Pending_Reason') THEN 1 END) as total_pending,
                COUNT(CASE WHEN status = 'In_progress' THEN 1 END) as total_in_prog,
                COUNT(CASE WHEN status = 'Open' THEN 1 END) as total_open,
                COUNT(CASE WHEN status = 'Pending_Reason' THEN 1 END) as total_reason
            ")
            ->first();

        return [
            'total_closed'  => number_format($closedResults ?? 0),
            'total_created' => number_format($createdResults ?? 0),
            'total_pending' => number_format($resultPending->total_pending ?? 0),
            'total_open'    => number_format($resultPending->total_open ?? 0),
            'total_in_prog' => number_format($resultPending->total_in_prog ?? 0),
            'total_reason'  => number_format($resultPending->total_reason ?? 0),
        ];
    }

    private function calculateOverallAging(int $month, int $year)
    {
        $result = HthAfterSaleTicket::query()
            ->where('deleted', 0)
            ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                COUNT(*) as total_days,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_entered) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_entered) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_entered) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_entered) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_entered) > 30 THEN 1 END) as days_over_30
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
            ->where('date_entered', '<=', now())
            ->where('deleted', 0)
            ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                COUNT(*) as grand_total,
                COUNT(CASE WHEN type = 'I' THEN 1 END) as total_installation,
                COUNT(CASE WHEN type = 'R' THEN 1 END) as total_repair,
                COUNT(CASE WHEN type = 'C' THEN 1 END) as total_onsite,
                COUNT(CASE WHEN type = 'spare_part' THEN 1 END) as total_sparepart,
                COUNT(CASE WHEN type = 'consult_or_advise' THEN 1 END) as total_phone
            ")
            ->first();

        return $result;
    }

    private function calculatePendingGroup(int $month, int $year)
    {
        $result = HthAfterSaleTicket::query()
            ->leftJoin('aos_product_categories', 'hth_after_sale_ticket.aos_product_categories_id', '=', 'aos_product_categories.id')
            ->where('hth_after_sale_ticket.date_entered', '<=', now())
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
            ->where('date_entered', '<=', now())
            ->where('deleted', 0)
            ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), date_entered) BETWEEN 0  AND 3  THEN 1 END) as reason_0_3,
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), date_entered) BETWEEN 4  AND 7  THEN 1 END) as reason_4_7,
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), date_entered) BETWEEN 8  AND 15 THEN 1 END) as reason_8_15,
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), date_entered) BETWEEN 16 AND 30 THEN 1 END) as reason_16_30,
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), date_entered) > 30 THEN 1 END) as reason_over_30,

                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), date_entered) BETWEEN 0  AND 3  THEN 1 END) as in_prog_0_3,
                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), date_entered) BETWEEN 4  AND 7  THEN 1 END) as in_prog_4_7,
                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), date_entered) BETWEEN 8  AND 15 THEN 1 END) as in_prog_8_15,
                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), date_entered) BETWEEN 16 AND 30 THEN 1 END) as in_prog_16_30,
                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), date_entered) > 30 THEN 1 END) as in_prog_over_30,

                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), date_entered) BETWEEN 0  AND 3  THEN 1 END) as open_0_3,
                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), date_entered) BETWEEN 4  AND 7  THEN 1 END) as open_4_7,
                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), date_entered) BETWEEN 8  AND 15 THEN 1 END) as open_8_15,
                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), date_entered) BETWEEN 16 AND 30 THEN 1 END) as open_16_30,
                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), date_entered) > 30 THEN 1 END) as open_over_30
            ")
            ->first();

        return $result;
    }

    private function calculateAscPending(int $month, int $year)
    {
        $result = HthAfterSaleTicket::query()
            ->leftJoin(
                DB::raw('(SELECT postcodemain, master_part_eng FROM hth_ass_regions GROUP BY postcodemain, master_part_eng) as `regions`'),
                'hth_after_sale_ticket.zipcode',
                '=',
                'regions.postcodemain'
            )
            ->where('hth_after_sale_ticket.date_entered', '<=', now())
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->whereHas('assignee', function ($q) {
                $q->where('first_name', 'LIKE', 'ASC%');
            })
            ->selectRaw("
                regions.master_part_eng as region,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) > 30 THEN 1 END) as days_over_30
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
            ->where('hth_after_sale_ticket.date_entered', '<=', now())
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                hth_ass_teams.team as team,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) > 30 THEN 1 END) as days_over_30
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
            ->where('date_entered', '<=', now())
            ->where('deleted', 0)
            ->where('status', 'Pending_Reason')
            ->selectRaw("
                COALESCE(pending, 'blank') as reason,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_entered) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_entered) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_entered) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_entered) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), date_entered) > 30 THEN 1 END) as days_over_30
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
            ->leftJoin(
                DB::raw('(SELECT postcodemain, master_part_eng FROM hth_ass_regions GROUP BY postcodemain, master_part_eng) as `regions`'),
                'hth_after_sale_ticket.zipcode',
                '=',
                'regions.postcodemain'
            )
            ->where('hth_after_sale_ticket.date_entered', '<=', now())
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->selectRaw("
                regions.master_part_eng as region,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) > 30 THEN 1 END) as days_over_30
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
            ->leftJoin('aos_product_categories', 'hth_after_sale_ticket.aos_product_categories_id', '=', 'aos_product_categories.id')
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->whereNotNull('aos_product_categories.name')
            ->selectRaw("
                aos_product_categories.name as product,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.date_entered) > 30 THEN 1 END) as days_over_30
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

    private function pendingTicketQuery(?string $group)
    {
        $ascTypes    = ['R', 'I'];
        $hafeleTypes = ['R', 'C', 'spare_part', 'consult_or_advise'];

        return HthAfterSaleTicket::query()
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->when($group === 'asc', fn($q) => $q
                ->whereIn('hth_after_sale_ticket.type', $ascTypes)
                ->whereHas('assignee', fn($q) => $q->where('first_name', 'LIKE', 'ASC%')))
            ->when($group === 'hafele', fn($q) => $q
                ->whereIn('hth_after_sale_ticket.type', $hafeleTypes)
                ->whereHas('assignee', fn($q) => $q->whereNot('first_name', 'LIKE', 'ASC%')))
            ->when(!$group, fn($q) => $q->where(function ($q) use ($ascTypes, $hafeleTypes) {
                $q->where(fn($q) => $q
                    ->whereIn('hth_after_sale_ticket.type', $ascTypes)
                    ->whereHas('assignee', fn($q) => $q->where('first_name', 'LIKE', 'ASC%')))
                    ->orWhere(fn($q) => $q
                        ->whereIn('hth_after_sale_ticket.type', $hafeleTypes)
                        ->whereHas('assignee', fn($q) => $q->whereNot('first_name', 'LIKE', 'ASC%')));
            }));
    }

    private function pendingByType(bool $isAsc, array $types)
    {       
        return $this->pendingTicketQuery($isAsc ? 'asc' : 'hafele')
            ->where('date_entered', '<=', now())
            ->whereIn('hth_after_sale_ticket.type', $types)
            ->select('hth_after_sale_ticket.type', DB::raw('COUNT(*) as total'))
            ->groupBy('hth_after_sale_ticket.type')
            ->get();
    }
}
