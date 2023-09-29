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
        $day1 = '2022-10-06';
        $day2 = '2022-10-07';
        $day3 = '2022-10-08';

        $query = DB::select("
          SELECT
          	CAST(a.INV_DATE AS DATE) AS CAST_IN_DATE
          	,a.SOURCE
          	,SUM(a.TO_IN_VAT) AS SUM_IN_VAT
          FROM
          	transaction_clr a
          WHERE
          	CAST(a.INV_DATE AS DATE) BETWEEN '".$day1."' AND '".$day3."'
          GROUP BY
          	CAST_IN_DATE
          	,a.SOURCE
          ORDER BY
          	CAST_IN_DATE
        ");

        $pos = "'124652','124653','124654','124655','124656','127164','105817','140734','140735'";
        $pri = "'122012','122013','122014','122015','129881','129882','177050','177051'";
        $clr = "'105817','124652','124653','124654','124655','124656','127164','140734','140735'";

        $pos_today = DB::select("
          SELECT a.SOURCE
            ,CAST(a.INV_DATE AS DATE) AS 'CAST_INV_DATE'
            ,a.BY_CUST
            ,SUM(a.TO_IN_VAT) AS 'SUM_IN_VAT'
            ,COUNT(a.TO_IN_VAT) AS 'CNT_IN_VAT'
          FROM transaction_clr a
          WHERE CAST(a.INV_DATE AS DATE) = '2022-10-08'
          AND a.SOURCE = 'POS'
          AND a.BY_CUST IN (".$pos.")
          GROUP BY a.BY_CUST
          ORDER BY FIELD(a.BY_CUST,".$pos.")
        ");

        $pri_today = DB::select("
          SELECT a.SOURCE
            ,CAST(a.INV_DATE AS DATE) AS 'CAST_INV_DATE'
            ,a.BY_CUST
            ,SUM(a.TO_IN_VAT) AS 'SUM_IN_VAT'
            ,COUNT(a.TO_IN_VAT) AS 'CNT_IN_VAT'
          FROM transaction_clr a
          WHERE CAST(a.INV_DATE AS DATE) = '2022-10-08'
          AND a.SOURCE = 'ORION_SO_PRI'
          AND a.BY_CUST IN (".$pri.")
          GROUP BY a.BY_CUST
          ORDER BY FIELD(a.BY_CUST,".$pri.")
        ");

        $clr_today = DB::select("
          SELECT a.SOURCE
            ,CAST(a.INV_DATE AS DATE) AS 'CAST_INV_DATE'
            ,a.BY_CUST
            ,SUM(a.TO_IN_VAT) AS 'SUM_IN_VAT'
            ,COUNT(a.TO_IN_VAT) AS 'CNT_IN_VAT'
          FROM transaction_clr a
          WHERE CAST(a.INV_DATE AS DATE) = '2022-10-08'
          AND a.SOURCE = 'ORION_IN_CLR'
          AND a.BY_CUST IN (".$clr.")
          GROUP BY a.BY_CUST
          ORDER BY FIELD(a.BY_CUST,".$clr.")
        ");
        $day1_orion_in_dep = 0;
        foreach ($query as $key => $value) {

          $sum_day1[] = ($value->CAST_IN_DATE == $day1) ? $value->SUM_IN_VAT : 0;
          $sum_day2[] = ($value->CAST_IN_DATE == $day2) ? $value->SUM_IN_VAT : 0;
          $sum_day3[] = ($value->CAST_IN_DATE == $day3) ? $value->SUM_IN_VAT : 0;

          if($value->SOURCE == 'ORION_IN_CLR' && $value->CAST_IN_DATE == $day1){
            $day1_orion_in_clr = $value->SUM_IN_VAT;
          }

          if($value->SOURCE == 'ORION_IN_CLR' && $value->CAST_IN_DATE == $day2){
            $day2_orion_in_clr = $value->SUM_IN_VAT;
          }

          if($value->SOURCE == 'ORION_IN_CLR' && $value->CAST_IN_DATE == $day3){
            $day3_orion_in_clr = $value->SUM_IN_VAT;
          }

          if($value->SOURCE == 'ORION_SO_PRI' && $value->CAST_IN_DATE == $day1){
            $day1_orion_so_pri = $value->SUM_IN_VAT;
          }

          if($value->SOURCE == 'ORION_SO_PRI' && $value->CAST_IN_DATE == $day2){
            $day2_orion_so_pri = $value->SUM_IN_VAT;
          }

          if($value->SOURCE == 'ORION_SO_PRI' && $value->CAST_IN_DATE == $day3){
            $day3_orion_so_pri = $value->SUM_IN_VAT;
          }

          if($value->SOURCE == 'ORION_IN_DEP' && $value->CAST_IN_DATE == $day1){
            $day1_orion_in_dep = $value->SUM_IN_VAT;
          }

          if($value->SOURCE == 'ORION_IN_DEP' && $value->CAST_IN_DATE == $day2){
            $day2_orion_in_dep = $value->SUM_IN_VAT;
          }

          if($value->SOURCE == 'ORION_IN_DEP' && $value->CAST_IN_DATE == $day3){
            $day3_orion_in_dep = $value->SUM_IN_VAT;
          }

          if($value->SOURCE == 'POS' && $value->CAST_IN_DATE == $day1){
            $day1_pos = $value->SUM_IN_VAT;
          }

          if($value->SOURCE == 'POS' && $value->CAST_IN_DATE == $day2){
            $day2_pos = $value->SUM_IN_VAT;
          }

          if($value->SOURCE == 'POS' && $value->CAST_IN_DATE == $day3){
            $day3_pos = $value->SUM_IN_VAT;
          }

        }

        $clr_total = [
          'day1_total' => array_sum($sum_day1),
          'day2_total' => array_sum($sum_day2),
          'day3_total' => array_sum($sum_day3),
          'day_total' => array_sum($sum_day1) + array_sum($sum_day2) + array_sum($sum_day3),
          'day1_pos' => $day1_pos ?? 0,
          'day2_pos' => $day2_pos ?? 0,
          'day3_pos' => $day3_pos ?? 0,
          'day1_orion_in_clr' => $day1_orion_in_clr ?? 0,
          'day2_orion_in_clr' => $day2_orion_in_clr ?? 0,
          'day3_orion_in_clr' => $day3_orion_in_clr ?? 0,
          'day1_orion_so_pri' => $day1_orion_so_pri ?? 0,
          'day2_orion_so_pri' => $day2_orion_so_pri ?? 0,
          'day3_orion_so_pri' => $day3_orion_so_pri ?? 0,
          'day1_orion_in_dep' => $day1_orion_in_dep ?? 0,
          'day2_orion_in_dep' => $day2_orion_in_dep ?? 0,
          'day3_orion_in_dep' => $day3_orion_in_dep ?? 0,
          'orion_total' => $day1_orion_in_clr+$day2_orion_in_clr+$day3_orion_in_clr + $day1_orion_so_pri+$day2_orion_so_pri+$day3_orion_so_pri + $day1_orion_in_dep+$day2_orion_in_dep+$day3_orion_in_dep,
          'pos_total' => $day1_pos+$day2_pos+$day3_pos,
        ];

        return view('pages.clr_dashboard',[
          'clr_total' => $clr_total,
          'pos_today' => $pos_today,
          'pri_today' => $pri_today,
          'clr_today' => $clr_today,
        ]);
    }
}
