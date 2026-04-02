<?php

namespace App\Http\Controllers;

use App\Models\HthAfterSaleTicket;
use App\Models\HthAssSurvey;
use App\Models\HthContactCenter;
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
            $csiData      = $this->calculateCsiResponse(now()->month, now()->year);
            $activeStatus = request('status');

            $surveys = HthAssSurvey::query()
                ->whereMonth('start_time', now()->month)
                ->whereYear('start_time', now()->year)
                ->when($activeStatus, fn($q) => $q->where('service_team', $activeStatus))
                ->latest('start_time')
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.csi-chart', [
                'csiData'      => $csiData,
                'surveys'      => $surveys,
                'activeStatus' => $activeStatus,
            ]);
        } else if ($chart === 'ud-rtat-chart') {
            $rtatData = $this->calculateRtat(now()->month, now()->year);

            $month  = now()->month;
            $year   = now()->year;
            $region = request('region');

            $tickets = HthAfterSaleTicket::query()
                ->leftJoin(
                    DB::raw('(SELECT postcodemain, master_part_eng FROM hth_ass_regions GROUP BY postcodemain, master_part_eng) as `regions`'),
                    'hth_after_sale_ticket.zipcode',
                    '=',
                    'regions.postcodemain'
                )
                ->whereMonth('hth_after_sale_ticket.date_modified', $month)
                ->whereYear('hth_after_sale_ticket.date_modified', $year)
                ->where('hth_after_sale_ticket.deleted', 0)
                ->where('hth_after_sale_ticket.status', 'Closed')
                ->when($region, fn($q) => $q->where('regions.master_part_eng', $region))
                ->whereNot('hth_after_sale_ticket.release_date', '>', now())
                ->select([
                    'hth_after_sale_ticket.name',
                    'hth_after_sale_ticket.date_modified',
                    'hth_after_sale_ticket.release_date',
                    'hth_after_sale_ticket.ticket_number',
                    'hth_after_sale_ticket.status',
                    'hth_after_sale_ticket.zipcode',
                    'regions.master_part_eng as master_part_eng',
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
            $totalStatData    = $this->calculateTotalStat(now()->month, now()->year);
            $activeStatus     = request('status');

            $tickets = HthAfterSaleTicket::query()
                ->when($activeStatus, fn($q) => $q->where('status', $activeStatus))
                ->where('deleted', 0)
                ->whereNot('status', 'Canceled')
                ->select([
                    'ticket_number',
                    'name',
                    'release_date',
                    'date_modified',
                    'status',
                ])
                ->orderByDesc('date_modified')
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.ticket-by-status-chart', [
                'total_stat_data'  => $totalStatData,
                'tickets'          => $tickets,
                'activeStatus'     => $activeStatus,
            ]);
        } else if ($chart === 'ud-aging-chart') {
            $agingData = $this->calculateOverallAging(now()->month, now()->year);
            $activeAging = request('aging');

            $query = HthAfterSaleTicket::query()
                ->where('deleted', 0)
                ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason']);

            if ($activeAging === '0-3') {
                $query->whereBetween(DB::raw('DATEDIFF(NOW(), release_date)'), [0, 3]);
            } else if ($activeAging === '4-7') {
                $query->whereBetween(DB::raw('DATEDIFF(NOW(), release_date)'), [4, 7]);
            } else if ($activeAging === '8-15') {
                $query->whereBetween(DB::raw('DATEDIFF(NOW(), release_date)'), [8, 15]);
            } else if ($activeAging === '16-30') {
                $query->whereBetween(DB::raw('DATEDIFF(NOW(), release_date)'), [16, 30]);
            } else if ($activeAging === 'over_30') {
                $query->whereRaw('DATEDIFF(NOW(), release_date) > 30');
            }

            $tickets = $query
                ->select([
                    'ticket_number',
                    'name',
                    'release_date',
                    'date_modified',
                    'status',
                    DB::raw('DATEDIFF(NOW(), release_date) as days_diff')
                ])
                ->orderByDesc('release_date')
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.overall-aging-chart', [
                'agingData'    => $agingData,
                'tickets'      => $tickets,
                'activeAging'  => $activeAging,
            ]);
        } else if ($chart === 'ud-csi-response-chart') {
            $csiData      = $this->calculateCsiResponse(now()->month, now()->year);
            $serviceStatus = request('status');

            $surveys = HthAssSurvey::query()
                ->whereMonth('start_time', now()->month)
                ->whereYear('start_time', now()->year)
                ->when($serviceStatus, fn($q) => $q->where('service_team', $serviceStatus))
                ->latest('start_time')
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.csi-response-chart', [
                'csiData'      => $csiData,
                'surveys'      => $surveys,
                'serviceStatus' => $serviceStatus,
            ]);
        } else if ($chart === 'ud-pending-reason-chart') {
            $pendingData = $this->calculatePendingReason(now()->month, now()->year);
            $activeAging = request('aging');
            $activePending = request('pending');

            $namedReasons = [
                'Spare_part_on_progress',
                'Site_not_ready_or_waiting_confirm',
                'Postpone_or_new_appointment',
                'Process_return_or_change_set',
                'Waiting_service_schedule_Technician',
            ];

            $query = HthAfterSaleTicket::query()
                ->where('deleted', 0)
                ->where('status', 'Pending_Reason')
                ->where(fn($q) => $q->whereIn('pending', $namedReasons)->orWhereNull('pending'));

            if ($activePending === 'blank') {
                $query->whereNull('pending');
            } elseif ($activePending) {
                $query->where('pending', $activePending);
            }

            if ($activeAging === '0-3') {
                $query->whereBetween(DB::raw('DATEDIFF(NOW(), release_date)'), [0, 3]);
            } elseif ($activeAging === '4-7') {
                $query->whereBetween(DB::raw('DATEDIFF(NOW(), release_date)'), [4, 7]);
            } elseif ($activeAging === '8-15') {
                $query->whereBetween(DB::raw('DATEDIFF(NOW(), release_date)'), [8, 15]);
            } elseif ($activeAging === '16-30') {
                $query->whereBetween(DB::raw('DATEDIFF(NOW(), release_date)'), [16, 30]);
            } elseif ($activeAging === 'over_30') {
                $query->whereRaw('DATEDIFF(NOW(), release_date) > 30');
            }

            $tickets = $query
                ->select([
                    'ticket_number',
                    'name',
                    'release_date',
                    'date_modified',
                    'pending',
                    'status',
                    DB::raw('DATEDIFF(NOW(), release_date) as days_diff')
                ])
                ->latest('release_date')
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.pending-reason-chart', [
                'pendingData'   => $pendingData,
                'tickets'       => $tickets,
                'activeAging'   => $activeAging,
                'activePending' => $activePending,
            ]);
        } else if ($chart === 'ud-pending-overview-chart') {
            $pendingData  = $this->calculatePending(now()->month, now()->year);
            $activeGroup  = request('group');

            $ascTypes    = ['R', 'I'];
            $hafeleTypes = ['R', 'C', 'spare_part', 'consult_or_advise'];

            $tickets = HthAfterSaleTicket::query()
                ->with('assignee:id,first_name,last_name')
                ->whereMonth('date_modified', now()->month)
                ->whereYear('date_modified', now()->year)
                ->where('deleted', 0)
                ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
                ->when($activeGroup === 'asc', function ($q) use ($ascTypes) {
                    $q->whereIn('type', $ascTypes)
                        ->whereHas('assignee', fn($q) => $q->where('first_name', 'LIKE', 'ASC%'));
                })
                ->when($activeGroup === 'hafele', function ($q) use ($hafeleTypes) {
                    $q->whereIn('type', $hafeleTypes)
                        ->whereHas('assignee', fn($q) => $q->whereNot('first_name', 'LIKE', 'ASC%'));
                })
                ->when(!$activeGroup, function ($q) use ($ascTypes, $hafeleTypes) {
                    $q->where(function ($q) use ($ascTypes, $hafeleTypes) {
                        $q->where(fn($q) => $q->whereIn('type', $ascTypes)
                            ->whereHas('assignee', fn($q) => $q->where('first_name', 'LIKE', 'ASC%')))
                            ->orWhere(fn($q) => $q->whereIn('type', $hafeleTypes)
                                ->whereHas('assignee', fn($q) => $q->whereNot('first_name', 'LIKE', 'ASC%')));
                    });
                })
                ->select([
                    'ticket_number',
                    'name',
                    'release_date',
                    'date_modified',
                    'status',
                    'type',
                    'assigned_user_id'
                ])
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.pending-overview-chart', [
                'pendingData'  => $pendingData,
                'tickets'      => $tickets,
                'activeGroup'  => $activeGroup,
            ]);
        } else if ($chart === 'ud-status-overview-chart') {
            $statusData  = $this->calculateStatus(now()->month, now()->year);
            $activeAging  = request('aging');
            $activeStatus = request('status');

            $tickets = HthAfterSaleTicket::query()
                ->where('deleted', 0)
                ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
                ->when($activeStatus, fn($q) => $q->where('status', $activeStatus))
                ->when($activeAging === '0-3', fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), release_date)'), [0, 3]))
                ->when($activeAging === '4-7', fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), release_date)'), [4, 7]))
                ->when($activeAging === '8-15', fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), release_date)'), [8, 15]))
                ->when($activeAging === '16-30', fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), release_date)'), [16, 30]))
                ->when($activeAging === 'over_30', fn($q) => $q->whereRaw('DATEDIFF(NOW(), release_date) > 30'))
                ->select([
                    'ticket_number',
                    'name',
                    'release_date',
                    'date_modified',
                    'status',
                    'pending',
                    DB::raw('DATEDIFF(NOW(), release_date) as days_diff'),
                ])
                ->latest('release_date')
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.status-overview-chart', [
                'statusData'   => $statusData,
                'tickets'      => $tickets,
                'activeAging'  => $activeAging,
                'activeStatus' => $activeStatus,
            ]);
        } else if ($chart === 'ud-pending-by-region-chart') {
            $pendingData  = $this->calculatePendingByRegion(now()->month, now()->year);
            $activeRegion = request('region');
            $activeAging  = request('aging');

            $regionsSub = DB::raw('(SELECT postcodemain, master_part_eng FROM hth_ass_regions GROUP BY postcodemain, master_part_eng) as `regions`');

            $tickets = HthAfterSaleTicket::query()
                ->leftJoin($regionsSub, 'hth_after_sale_ticket.zipcode', '=', 'regions.postcodemain')
                ->where('hth_after_sale_ticket.deleted', 0)
                ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
                ->whereNot('hth_after_sale_ticket.release_date', '>', now())
                ->when($activeRegion, fn($q) => $q->where('regions.master_part_eng', $activeRegion))
                ->when($activeAging === '0-3', fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date)'), [0, 3]))
                ->when($activeAging === '4-7', fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date)'), [4, 7]))
                ->when($activeAging === '8-15', fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date)'), [8, 15]))
                ->when($activeAging === '16-30', fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date)'), [16, 30]))
                ->when($activeAging === 'over_30', fn($q) => $q->whereRaw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date) > 30'))
                ->select([
                    'hth_after_sale_ticket.ticket_number',
                    'hth_after_sale_ticket.name',
                    'hth_after_sale_ticket.release_date',
                    'hth_after_sale_ticket.date_modified',
                    'hth_after_sale_ticket.status',
                    'hth_after_sale_ticket.pending',
                    'hth_after_sale_ticket.zipcode',
                    'regions.master_part_eng as region',
                    DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date) as days_diff'),
                ])
                ->latest('hth_after_sale_ticket.release_date')
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.pending-by-region-chart', [
                'pendingData'  => $pendingData,
                'tickets'      => $tickets,
                'activeRegion' => $activeRegion,
                'activeAging'  => $activeAging,
            ]);
        } else if ($chart === 'ud-inhouse-pending-chart') {
            $pendingData = $this->calculateInhousePending(now()->month, now()->year);
            $activeTeam  = request('team');
            $activeAging = request('aging');

            $tickets = HthAfterSaleTicket::query()
                ->leftJoin('users', 'users.id', '=', 'hth_after_sale_ticket.assigned_user_id')
                ->leftJoin('hth_ass_teams', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), '=', 'hth_ass_teams.name')
                ->whereNotNull('hth_ass_teams.team')
                ->where('hth_after_sale_ticket.deleted', 0)
                ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
                ->whereNot('hth_after_sale_ticket.release_date', '>', now())
                ->when($activeTeam, fn($q) => $q->where('hth_ass_teams.team', $activeTeam))
                ->when($activeAging === '0-3', fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date)'), [0, 3]))
                ->when($activeAging === '4-7', fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date)'), [4, 7]))
                ->when($activeAging === '8-15', fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date)'), [8, 15]))
                ->when($activeAging === '16-30', fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date)'), [16, 30]))
                ->when($activeAging === 'over_30', fn($q) => $q->whereRaw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date) > 30'))
                ->select([
                    'hth_after_sale_ticket.ticket_number',
                    'hth_after_sale_ticket.name',
                    'hth_after_sale_ticket.release_date',
                    'hth_after_sale_ticket.date_modified',
                    'hth_after_sale_ticket.status',
                    'hth_ass_teams.team as team',
                    DB::raw("CONCAT(users.first_name, ' ', users.last_name) as assignee_name"),
                    DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date) as days_diff'),
                ])
                ->latest('hth_after_sale_ticket.release_date')
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.inhouse-pending-chart', [
                'pendingData' => $pendingData,
                'tickets'     => $tickets,
                'activeTeam'  => $activeTeam,
                'activeAging' => $activeAging,
            ]);
        } else if ($chart === 'ud-asc-pending-by-region-chart') {
            $pendingData = $this->calculateAscPending(now()->month, now()->year);
            $activeRegion = request('region');
            $activeAging  = request('aging');

            $tickets = HthAfterSaleTicket::query()
                ->leftJoin(
                    DB::raw('(SELECT postcodemain, master_part_eng FROM hth_ass_regions GROUP BY postcodemain, master_part_eng) as `regions`'),
                    'hth_after_sale_ticket.zipcode',
                    '=',
                    'regions.postcodemain'
                )
                ->where('hth_after_sale_ticket.deleted', 0)
                ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
                ->whereNot('hth_after_sale_ticket.release_date', '>', now())
                ->whereHas('assignee', fn($q) => $q->where('first_name', 'LIKE', 'ASC%'))
                ->when($activeRegion,  fn($q) => $q->where('regions.master_part_eng', $activeRegion))
                ->when($activeAging === '0-3',    fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date)'), [0, 3]))
                ->when($activeAging === '4-7',    fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date)'), [4, 7]))
                ->when($activeAging === '8-15',   fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date)'), [8, 15]))
                ->when($activeAging === '16-30',  fn($q) => $q->whereBetween(DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date)'), [16, 30]))
                ->when($activeAging === 'over_30', fn($q) => $q->whereRaw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date) > 30'))
                ->select([
                    'hth_after_sale_ticket.ticket_number',
                    'hth_after_sale_ticket.name',
                    'hth_after_sale_ticket.release_date',
                    'hth_after_sale_ticket.date_modified',
                    'hth_after_sale_ticket.status',
                    'regions.master_part_eng as region',
                    DB::raw('DATEDIFF(NOW(), hth_after_sale_ticket.release_date) as days_diff'),
                ])
                ->latest('hth_after_sale_ticket.release_date')
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.asc-pending-by-region-chart', [
                'pendingData' => $pendingData,
                'tickets'     => $tickets,
                'activeRegion'  => $activeRegion,
                'activeAging' => $activeAging,
            ]);
        } else if ($chart === 'ud-pending-by-type-chart') {
            $pendingData = $this->calculatePendingType(now()->month, now()->year);
            $activeType  = request('type');

            $tickets = HthAfterSaleTicket::query()
                ->where('deleted', 0)
                ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
                ->whereIn('type', ['R', 'C', 'I', 'spare_part', 'consult_or_advise'])
                ->whereNot('release_date', '>', now())
                ->when($activeType, fn($q) => $q->where('type', $activeType))
                ->select([
                    'ticket_number',
                    'name',
                    'release_date',
                    'date_modified',
                    'status',
                    'type'
                ])
                ->latest('release_date')
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.pending-by-type-chart', [
                'pendingData' => $pendingData,
                'tickets'     => $tickets,
                'activeType'  => $activeType,
            ]);
        } else if ($chart === 'ud-pending-product-group-chart') {
            $pendingData = $this->calculatePendingGroup(now()->month, now()->year);
            $activeGroup  = request('group');

            $tickets = HthAfterSaleTicket::query()
                ->leftJoin('aos_product_categories', 'hth_after_sale_ticket.aos_product_categories_id', '=', 'aos_product_categories.id')
                ->where('hth_after_sale_ticket.deleted', 0)
                ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
                ->whereIn('aos_product_categories.name', ['Smart Technology', 'Home appliances', 'Sanitary', 'Architectural hardware', 'FF - Furniture Fittings'])
                ->whereNot('hth_after_sale_ticket.release_date', '>', now())
                ->when($activeGroup, fn($q) => $q->where('aos_product_categories.name', $activeGroup))
                ->select([
                    'hth_after_sale_ticket.ticket_number',
                    'hth_after_sale_ticket.name',
                    'hth_after_sale_ticket.release_date',
                    'hth_after_sale_ticket.date_modified',
                    'hth_after_sale_ticket.status',
                    'aos_product_categories.name as product_group'
                ])
                ->latest('hth_after_sale_ticket.release_date')
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.pending-product-group-chart', [
                'pendingData' => $pendingData,
                'tickets'     => $tickets,
                'activeGroup'  => $activeGroup,
            ]);
        } else if ($chart === 'ud-ticket-chart') {
            $ticketData = $this->calculateTicket(now()->year);
            $activeMonth = request('month');
            $activeStatusClosed = request('status-closed');

            $tickets = HthAfterSaleTicket::query()
                ->whereYear('release_date', now()->year)
                ->where('deleted', 0)
                ->whereNot('status', 'Canceled')
                ->whereNot('release_date', '>', now())
                ->when($activeMonth, fn($q) => $q->whereMonth('release_date', $activeMonth))
                ->when($activeStatusClosed, fn($q) => $q->where('status', 'Closed'))
                ->select([
                    'ticket_number',
                    'name',
                    'release_date',
                    'date_modified',
                    'status',
                ])
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.ticket-chart', [
                'ticketData' => $ticketData,
                'tickets'    => $tickets,
                'activeMonth' => $activeMonth,
                'activeStatusClosed' => $activeStatusClosed,
            ]);
        } else if ($chart === 'ud-contract-chart') {
            $contractData = $this->calculateContractCenter(now()->year);
            $activeMonth = request('month');
            $activeYear = request('year');

            $tickets = HthContactCenter::query()
                ->when($activeYear, fn($q) => $q->whereYear('date_entered', $activeYear))
                ->when($activeMonth, fn($q) => $q->whereMonth('date_entered', $activeMonth))
                ->where(fn($q) => $q->whereYear('date_entered', now()->year)->orWhereYear('date_entered', now()->subYear()->year))
                ->where('deleted', 0)
                ->whereNot('date_entered', '>', now())
                ->select([
                    'code',
                    'name',
                    'date_entered',
                    'description',
                    'type'
                ])
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.contract-chart', [
                'contractData' => $contractData,
                'tickets'    => $tickets,
                'activeMonth' => $activeMonth,
                'activeYear' => $activeYear,
            ]);
        } else if ($chart === 'ud-daily-chart') {
            $dailyData = $this->calculateContractCenterDaily(now()->month, now()->year);
            $activeShift = request('shift');

            $tickets = HthContactCenter::query()
                ->whereMonth('date_entered', now()->month)
                ->whereYear('date_entered', now()->year)
                ->where('deleted', 0)
                ->whereNot('date_entered', '>', now())
                ->when($activeShift === 'day', fn($q) => $q->whereTime('date_entered', '>=', '08:00:00')->whereTime('date_entered', '<', '17:00:00'))
                ->when($activeShift === 'night', fn($q) => $q->where(fn($q) => $q->whereTime('date_entered', '>=', '17:00:00')->orWhereTime('date_entered', '<', '08:00:00')))
                ->select([
                    'code',
                    'name',
                    'date_entered',
                    'description',
                    'type'
                ])
                ->paginate(15)
                ->withQueryString();

            return view('pages.after-sales.details.daily-chart', [
                'dailyData' => $dailyData,
                'tickets'    => $tickets,
                'activeShift' => $activeShift,
            ]);
        } else {
            abort(404);
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
            ->whereNot('release_date', '>', now())
            ->selectRaw('COUNT(*) as total, SUM(DATEDIFF(date_modified, release_date)) as total_days')
            ->first();

        $bkkResult  = HthAfterSaleTicket::query()
            ->whereMonth('date_modified', $month)
            ->whereYear('date_modified', $year)
            ->whereNot('release_date', '>', now())
            ->where('deleted', 0)
            ->where('status', 'Closed')
            ->whereIn('zipcode', function ($q) {
                $q->select('postcodemain')
                    ->from('hth_ass_regions')
                    ->where('master_part_eng', 'Bangkok Metropolitan');
            })
            ->selectRaw('COUNT(*) as total, SUM(DATEDIFF(date_modified, release_date)) as total_days')
            ->first();
            // dd($result, $bkkResult);

        return [
            'overall' => $result->total > 0
                ? round($result->total_days / $result->total, 1)
                : 0,
            'bkk' => $bkkResult->total > 0
                ? round($bkkResult->total_days / $bkkResult->total, 1)
                : 0,
            'total_all' => $result->total,
            'total_all_days' => $result->total_days,
            'total_bkk' => $bkkResult->total,
            'total_bkk_days' => $bkkResult->total_days
        ];
    }

    private function calculateLtp(int $month, int $year)
    {
        $result = $this->baseQuery($month, $year)
            ->where('deleted', 0)
            ->whereNotIn('status', ['Closed', 'Canceled'])
            ->whereNot('release_date', '>', now())
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
            ->whereNot('release_date', '>', now())
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
            ->whereNot('release_date', '>', now())
            ->where('status', 'Closed')
            ->where('deleted', 0)
            ->whereIn('type', ['R', 'I'])
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
            ->whereNot('release_date', '>', now())
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
        $maxDay = ($year === now()->year && $month === now()->month) ? now()->day : $daysInMonth;

        $rows = HthContactCenter::query()
            ->whereYear('date_entered', $year)
            ->whereMonth('date_entered', $month)
            ->where('deleted', 0)
            ->selectRaw("
                DAY(date_entered) as day,
                COUNT(CASE WHEN TIME(date_entered) >= '08:00:00' AND TIME(date_entered) < '17:00:00' THEN 1 END) as day_shift,
                COUNT(CASE WHEN TIME(date_entered) < '08:00:00' OR TIME(date_entered) >= '17:00:00' THEN 1 END) as night_shift
            ")
            ->groupByRaw('DAY(date_entered)')
            ->orderByRaw('DAY(date_entered)')
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
            ->whereNot('release_date', '>', now())
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
            ->where('deleted', 0)
            ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
            ->whereNot('release_date', '>', now())
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
            ->whereNot('release_date', '>', now())
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
            ->whereNot('hth_after_sale_ticket.release_date', '>', now())
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
            ->where('deleted', 0)
            ->whereIn('status', ['Open', 'In_progress', 'Pending_Reason'])
            ->whereNot('release_date', '>', now())
            ->selectRaw("
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), release_date) BETWEEN 0  AND 3  THEN 1 END) as reason_0_3,
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), release_date) BETWEEN 4  AND 7  THEN 1 END) as reason_4_7,
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), release_date) BETWEEN 8  AND 15 THEN 1 END) as reason_8_15,
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), release_date) BETWEEN 16 AND 30 THEN 1 END) as reason_16_30,
                COUNT(CASE WHEN status = 'Pending_Reason' AND DATEDIFF(NOW(), release_date) > 30 THEN 1 END) as reason_over_30,

                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), release_date) BETWEEN 0  AND 3  THEN 1 END) as in_prog_0_3,
                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), release_date) BETWEEN 4  AND 7  THEN 1 END) as in_prog_4_7,
                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), release_date) BETWEEN 8  AND 15 THEN 1 END) as in_prog_8_15,
                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), release_date) BETWEEN 16 AND 30 THEN 1 END) as in_prog_16_30,
                COUNT(CASE WHEN status = 'In_progress' AND DATEDIFF(NOW(), release_date) > 30 THEN 1 END) as in_prog_over_30,

                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), release_date) BETWEEN 0  AND 3  THEN 1 END) as open_0_3,
                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), release_date) BETWEEN 4  AND 7  THEN 1 END) as open_4_7,
                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), release_date) BETWEEN 8  AND 15 THEN 1 END) as open_8_15,
                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), release_date) BETWEEN 16 AND 30 THEN 1 END) as open_16_30,
                COUNT(CASE WHEN status = 'Open' AND DATEDIFF(NOW(), release_date) > 30 THEN 1 END) as open_over_30
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
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->whereNot('hth_after_sale_ticket.release_date', '>', now())
            ->whereHas('assignee', function ($q) {
                $q->where('first_name', 'LIKE', 'ASC%');
            })
            ->selectRaw("
                regions.master_part_eng as region,
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
            ->whereNot('hth_after_sale_ticket.release_date', '>', now())
            ->selectRaw("
                hth_ass_teams.team as team,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), hth_after_sale_ticket.release_date) > 30 THEN 1 END) as days_over_30
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
            ->whereNot('release_date', '>', now())
            ->selectRaw("
                COALESCE(pending, 'blank') as reason,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 0  AND 3  THEN 1 END) as days_0_3,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 4  AND 7  THEN 1 END) as days_4_7,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 8  AND 15 THEN 1 END) as days_8_15,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) BETWEEN 16 AND 30 THEN 1 END) as days_16_30,
                COUNT(CASE WHEN DATEDIFF(NOW(), release_date) > 30 THEN 1 END) as days_over_30
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
            ->where('hth_after_sale_ticket.deleted', 0)
            ->whereIn('hth_after_sale_ticket.status', ['Open', 'In_progress', 'Pending_Reason'])
            ->whereNot('hth_after_sale_ticket.release_date', '>', now())
            ->selectRaw("
                regions.master_part_eng as region,
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
            ->whereNot('hth_after_sale_ticket.release_date', '>', now())
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
            ->whereNot('release_date', '>', now())
            ->select('type', DB::raw('COUNT(*) as total'))
            ->groupBy('type')
            ->get();
    }
}
