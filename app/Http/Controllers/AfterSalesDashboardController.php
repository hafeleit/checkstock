<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AfterSalesDashboardController extends Controller
{
    public function index()
    {
        $users = DB::connection('crm')->table('users')->first();
        
        return view('pages.after-sales.display');
    }
}
