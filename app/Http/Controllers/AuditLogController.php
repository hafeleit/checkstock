<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AuditLogController extends Controller
{

    public function details()
    {
        $mappedData = [];

        if (request()->search_account) {
            $allLogs = AuditLog::query()
                ->with('user')
                ->when(request()->search_account, function ($q) {
                    $q->whereHas('user', function ($r) {
                        $r->where('email', 'LIKE', '%' . request()->search_account . '%');
                    });
                })
                ->latest()
                ->get();

            $allMappedData = $allLogs->flatMap(function ($log) {
                $oldValues = json_decode($log->old_values, true) ?? [];
                $newValues = json_decode($log->new_values, true) ?? [];

                $updates = [];

                if ($log->event == 'role_permissions_updated') {
                    $updates[] = [
                        'auditable_id' => $log->auditable_id,
                        'auditable_type' => $log->auditable_type,
                        'event' => $log->event,
                        'status' => $log->status,
                        'field' => 'permissions',
                        'old_value' => collect($oldValues)->sort()->values()->all(),
                        'new_value' => collect($newValues)->sort()->values()->all(),
                        'email' => $log->user->email ?? '-',
                        'date' => $log->created_at,
                    ];
                } else if ($log->event == 'login' || $log->event == 'external_login') {
                    $updates[] =  $log;
                } else {
                    unset($oldValues['updated_at']);
                    unset($newValues['updated_at']);

                    $updatedFields = array_diff_assoc($newValues, $oldValues);

                    if ($updatedFields) {
                        foreach ($updatedFields as $field => $newValue) {
                            $oldValue = $oldValues[$field] ?? null;

                            $updates[] = [
                                'auditable_id' => $log->auditable_id,
                                'auditable_type' => $log->auditable_type,
                                'event' => $log->event,
                                'status' => $log->status,
                                'field' => $field,
                                'old_value' => $oldValue,
                                'new_value' => $newValue,
                                'email' => $log->user->email,
                                'date' => $log->created_at,
                            ];
                        }
                    } else {
                        $updates[] =  $log;
                    }
                }

                return $updates;
            });

            $perPage = 15;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = $allMappedData->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $mappedData = new LengthAwarePaginator(
                $currentItems,
                $allMappedData->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        return view('pages.audit-log.details', [
            'logs' => $mappedData,
            'title' => 'Log Details',
            'params' => request()->all()
        ]);
    }

    public function loginLog()
    {
        $logs = AuditLog::query()
            ->with('user')
            ->whereIn('event', ['external_login', 'login'])
            ->latest()
            ->paginate(50);

        return view('pages.audit-log.login', [
            'logs' => $logs,
            'title' => 'Login Logs',
        ]);
    }

    public function activityLog()
    {
        $allLogs = AuditLog::query()
            ->with('user')
            ->whereNotIn('event', ['external_login', 'login'])
            ->where('status', 'pass')
            ->latest()
            ->get();

        $allMappedData = $allLogs->flatMap(function ($log) {
            $oldValues = json_decode($log->old_values, true) ?? [];
            $newValues = json_decode($log->new_values, true) ?? [];

            $updates = [];

            if ($log->event == 'role_permissions_updated') {
                $updates[] = [
                    'auditable_id' => $log->auditable_id,
                    'auditable_type' => $log->auditable_type,
                    'event' => $log->event,
                    'field' => 'permissions',
                    'old_value' => collect($oldValues)->sort()->values()->all(),
                    'new_value' => collect($newValues)->sort()->values()->all(),
                    'email' => $log->user->email ?? '-',
                    'date' => $log->created_at,
                ];
            } else {
                unset($oldValues['updated_at']);
                unset($newValues['updated_at']);

                $updatedFields = array_diff_assoc($newValues, $oldValues);

                foreach ($updatedFields as $field => $newValue) {
                    $oldValue = $oldValues[$field] ?? null;

                    $updates[] = [
                        'auditable_id' => $log->auditable_id,
                        'auditable_type' => $log->auditable_type,
                        'event' => $log->event,
                        'field' => $field,
                        'old_value' => $oldValue,
                        'new_value' => $newValue,
                        'email' => $log->user->email ?? '-',
                        'date' => $log->created_at,
                    ];
                }
            }
            return $updates;
        });

        $perPage = 15;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $allMappedData->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $mappedData = new LengthAwarePaginator(
            $currentItems,
            $allMappedData->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('pages.audit-log.activity', [
            'logs' => $mappedData,
            'title' => 'Activity Logs',
        ]);
    }

    public function errorLog()
    {
        $logs = AuditLog::query()
            ->with('user')
            ->where('status', 'fail')
            ->latest()
            ->paginate(50);

        return view('pages.audit-log.error', [
            'logs' => $logs,
            'title' => 'Error Logs',
        ]);
    }
}
