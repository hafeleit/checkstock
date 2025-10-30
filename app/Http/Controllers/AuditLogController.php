<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function loginLog()
    {
        $logs = AuditLog::query()
            ->whereIn('event', ['external_login', 'login'])
            ->where('status', 'pass')
            ->latest()
            ->paginate(50);

        return view('pages.audit-log.index', [
            'logs' => $logs,
            'title' => 'Login Logs',
        ]);
    }

    public function activityLog()
    {
        $logs = AuditLog::query()
            ->whereNotIn('event', ['external_login', 'login'])
            ->where('status', 'pass')
            ->latest()
            ->paginate(50);

        return view('pages.audit-log.index', [
            'logs' => $logs,
            'title' => 'Activity Logs',
        ]);
    }

    public function errorLog()
    {
        $logs = AuditLog::query()
            ->where('status', 'fail')
            ->latest()
            ->paginate(50);

        return view('pages.audit-log.index', [
            'logs' => $logs,
            'title' => 'Error Logs',
        ]);
    }
}
