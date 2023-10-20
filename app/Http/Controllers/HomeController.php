<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

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

    public function ass_dashboard(){

      $end = new Carbon;
      $lastday = $end->endOfMonth()->format('d');

      $query = DB::connection('remote_mysql')->select("
        SELECT
          b.user_name,
          DATE(CONVERT_TZ(a.booking,'+00:00','+07:00')) AS booking_date,
          COUNT(*) AS cnt

        FROM hthcm_after_sale_ticket a
        INNER JOIN users b ON b.id = a.assigned_user_id
        WHERE
          DATE(CONVERT_TZ(a.booking,'+00:00','+07:00')) BETWEEN '2023-10-01' AND '2023-10-31'
        GROUP BY booking_date, b.user_name
        ORDER BY booking_date, b.user_name asc
      ");

      $data_all = $query;

      $northeastern_ar = ['HTH8851','HTHASC9','HTHASC25','HTHASC28','HTHASC2','HTHASC6','HTHASC35','HTHASC47'];
      $south_ar = ['HTH8831','HTH8834','HTHASC3','HTHASC33','HTHASC44','HTHASC46','HTHASC52','HTHASC53'];
      $central_ar = ['HTHASC5','HTHASC20','HTHASC21','HTHASC22','HTHASC23','HTHASC29','HTHASC30','HTHASC31','HTHASC32','HTHASC34','HTHASC36','HTHASC49','HTHASC51'];

      $hth = [];

      $HTH8851[0] = 'HTH8851'; $HTHASC9[0] = 'HTHASC9'; $HTHASC25[0] = 'HTHASC25'; $HTHASC28[0] = 'HTHASC28'; $HTHASC2[0] = 'HTHASC2'; $HTHASC6[0] = 'HTHASC6'; $HTHASC35[0] = 'HTHASC35'; $HTHASC47[0] = 'HTHASC47';
      $HTH8831[0] = 'HTH8831'; $HTH8834[0] = 'HTH8834';$HTHASC3[0] = 'HTHASC3';$HTHASC33[0] = 'HTHASC33';$HTHASC44[0] = 'HTHASC44';$HTHASC46[0] = 'HTHASC46';$HTHASC52[0] = 'HTHASC52';$HTHASC53[0] = 'HTHASC53';

      $HTHASC5[0] = 'HTHASC5';
      $HTHASC20[0] = 'HTHASC20';
      $HTHASC21[0] = 'HTHASC21';
      $HTHASC22[0] = 'HTHASC22';
      $HTHASC23[0] = 'HTHASC23';
      $HTHASC29[0] = 'HTHASC29';
      $HTHASC30[0] = 'HTHASC30';
      $HTHASC31[0] = 'HTHASC31';
      $HTHASC32[0] = 'HTHASC32';
      $HTHASC34[0] = 'HTHASC34';
      $HTHASC36[0] = 'HTHASC36';
      $HTHASC49[0] = 'HTHASC49';
      $HTHASC51[0] = 'HTHASC51';

      $HTH8805[0] = 'HTH8805';
      $HTH8810[0] = 'HTH8810';
      $HTH8811[0] = 'HTH8811';
      $HTH8812[0] = 'HTH8812';
      $HTH8815[0] = 'HTH8815';
      $HTH8817[0] = 'HTH8817';
      $HTH8818[0] = 'HTH8818';
      $HTH8819[0] = 'HTH8819';
      $HTH8821[0] = 'HTH8821';
      $HTH8822[0] = 'HTH8822';
      $HTH8824[0] = 'HTH8824';
      $HTH8825[0] = 'HTH8825';
      $HTH8828[0] = 'HTH8828';
      $HTH8871[0] = 'HTH8871';
      $HTH8872[0] = 'HTH8872';

      foreach ($data_all as $key => $value) {

        if($value->user_name == 'HTH8851'){ $HTH8851[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC9'){ $HTHASC9[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC25'){ $HTHASC25[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC28'){ $HTHASC28[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC2'){ $HTHASC2[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC6'){ $HTHASC6[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC35'){ $HTHASC35[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC47'){ $HTHASC47[(int)substr($value->booking_date,-2)] = $value->cnt; }

        if($value->user_name == 'HTH8831'){ $HTH8831[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8834'){ $HTH8834[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC3'){ $HTHASC3[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC33'){ $HTHASC33[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC44'){ $HTHASC44[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC46'){ $HTHASC46[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC52'){ $HTHASC52[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC53'){ $HTHASC53[(int)substr($value->booking_date,-2)] = $value->cnt; }

        if($value->user_name == 'HTHASC5'){ $HTHASC5[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC20'){ $HTHASC20[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC21'){ $HTHASC21[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC22'){ $HTHASC22[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC23'){ $HTHASC23[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC29'){ $HTHASC29[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC30'){ $HTHASC30[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC31'){ $HTHASC31[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC32'){ $HTHASC32[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC34'){ $HTHASC34[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC36'){ $HTHASC36[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC49'){ $HTHASC49[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTHASC51'){ $HTHASC51[(int)substr($value->booking_date,-2)] = $value->cnt; }

        if($value->user_name == 'HTH8805'){ $HTH8805[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8810'){ $HTH8810[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8811'){ $HTH8811[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8812'){ $HTH8812[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8815'){ $HTH8815[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8817'){ $HTH8817[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8818'){ $HTH8818[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8819'){ $HTH8819[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8821'){ $HTH8821[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8822'){ $HTH8822[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8824'){ $HTH8824[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8825'){ $HTH8825[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8828'){ $HTH8828[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8871'){ $HTH8871[(int)substr($value->booking_date,-2)] = $value->cnt; }
        if($value->user_name == 'HTH8872'){ $HTH8872[(int)substr($value->booking_date,-2)] = $value->cnt; }

      }

      $northeastern[] = $HTH8851;$northeastern[] = $HTHASC9;$northeastern[] = $HTHASC25;$northeastern[] = $HTHASC28;$northeastern[] = $HTHASC2;$northeastern[] = $HTHASC6;$northeastern[] = $HTHASC35;$northeastern[] = $HTHASC47;

      $south[] = $HTH8831;$south[] = $HTH8834;$south[] = $HTHASC3;$south[] = $HTHASC33;$south[] = $HTHASC44;$south[] = $HTHASC46;$south[] = $HTHASC52;$south[] = $HTHASC53;

      $central[] = $HTHASC5;$central[] = $HTHASC20;$central[] = $HTHASC21;$central[] = $HTHASC22;$central[] = $HTHASC23;$central[] = $HTHASC29;$central[] = $HTHASC30;$central[] = $HTHASC31;
      $central[] = $HTHASC32;$central[] = $HTHASC34;$central[] = $HTHASC36;$central[] = $HTHASC49;$central[] = $HTHASC51;

      $hth[] = $HTH8805;
      $hth[] = $HTH8810;
      $hth[] = $HTH8811;
      $hth[] = $HTH8812;
      $hth[] = $HTH8815;
      $hth[] = $HTH8817;
      $hth[] = $HTH8818;
      $hth[] = $HTH8819;
      $hth[] = $HTH8821;
      $hth[] = $HTH8822;
      $hth[] = $HTH8824;
      $hth[] = $HTH8825;
      $hth[] = $HTH8828;
      $hth[] = $HTH8871;
      $hth[] = $HTH8872;

      return view('pages.ass_dashboard',['northeastern' => $northeastern, 'south' => $south, 'central' => $central, 'hth' => $hth, 'lastday' => $lastday]);
    }

    public function test_db(){
      $users = DB::connection('remote_mysql')
      ->table('users')
      ->where('user_name','HTH7213')
      ->first();
      dd($users);
      return "s";
    }

    public function clr_dashboard()
    {
        $day1 = '2023-10-05';
        $day2 = '2023-10-06';
        $day3 = '2023-10-07';

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
        $pri = "'122012','122013','122014','122015','177050','177051','129881','129882'";
        $clr = "'129881','129882','177152'";

        $pos_today = DB::select("
          SELECT a.SOURCE
            ,CAST(a.INV_DATE AS DATE) AS 'CAST_INV_DATE'
            ,a.BY_CUST
            ,SUM(a.TO_IN_VAT) AS 'SUM_IN_VAT'
            ,COUNT(a.TO_IN_VAT) AS 'CNT_IN_VAT'
          FROM transaction_clr a
          WHERE CAST(a.INV_DATE AS DATE) between '".$day1."' and '".$day3."'
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
          WHERE CAST(a.INV_DATE AS DATE) between '".$day1."' and '".$day3."'
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
          WHERE CAST(a.INV_DATE AS DATE) between '".$day1."' and '".$day3."'
          AND a.SOURCE = 'ORION_IN_CLR'
          AND a.BY_CUST IN (".$clr.")
          GROUP BY a.BY_CUST
          ORDER BY FIELD(a.BY_CUST,".$clr.")
        ");

        $day1_orion_in_dep = 0;
        $day2_orion_in_dep = 0;
        $day3_orion_in_dep = 0;
        $day1_orion_in_clr = 0;
        $day2_orion_in_clr = 0;
        $day3_orion_in_clr = 0;
        $day1_orion_so_pri = 0;
        $day2_orion_so_pri = 0;
        $day3_orion_so_pri = 0;
        $day1_pos = 0;
        $day2_pos = 0;
        $day3_pos = 0;
        $sum_day1 = [];
        $sum_day2 = [];
        $sum_day3 = [];

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
