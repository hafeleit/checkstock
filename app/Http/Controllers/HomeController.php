<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.dashboard');
    }

    public function clr_dashboard()
    {
        $clr_total = DB::select("
        SELECT 'DAY1' AS 'DAYS',a.SOURCE,SUM(a.TO_IN_VAT) sum_price FROM transaction_clr a
        WHERE a.INV_DATE BETWEEN '2022-10-06 00:00:00' AND '2022-10-06 23:59:59'
        GROUP BY a.SOURCE
        UNION


        SELECT 'DAY2' AS 'DAYS',a.SOURCE,SUM(a.TO_IN_VAT) sum_price FROM transaction_clr a
        WHERE a.INV_DATE BETWEEN '2022-10-07 00:00:00' AND '2022-10-07 23:59:59'
        GROUP BY a.SOURCE
        UNION

        SELECT 'DAY3' AS 'DAYS',a.SOURCE,SUM(a.TO_IN_VAT) sum_price FROM transaction_clr a
        WHERE a.INV_DATE BETWEEN '2022-10-08 00:00:00' AND '2022-10-08 23:59:59'
        GROUP BY a.SOURCE
        ");

        $pos_total = DB::select("
        SELECT a.BY_CUST,SUM(a.TO_IN_VAT) sum_price FROM transaction_clr a
        WHERE a.INV_DATE BETWEEN '2022-10-08 00:00:00' AND '2022-10-08 23:59:59'
        AND a.SOURCE = 'POS'
        GROUP BY a.BY_CUST
        ");

        //dd($crl_data);
        return view('pages.clr_dashboard',['clr_total' => $clr_total,'pos_total' => $pos_total]);
    }
}
