<?php

namespace App\Http\Controllers;

use App\Models\WarrantyLog;
use Illuminate\Http\Request;

class WarrantyLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:warranty view log', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        $query = WarrantyLog::with(['warranty', 'performer'])
            ->when($request->filled('action_type'), fn($q) => $q->where('action_type', $request->action_type))
            ->when($request->filled('date_from'), fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->latest();

        $logs = $query->paginate(20)->withQueryString();

        return view('pages.warranty.log', compact('logs'));
    }
}
