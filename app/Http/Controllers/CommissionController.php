<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;
use App\Models\CommissionsAr;
use App\Models\UserMaster;
use App\Models\CommissionsSchemaDetail;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CommissionsArImport;
use App\Imports\CommissionsCnImport;
use App\Exports\CommissionExport;
use App\Exports\CommissionSummaryExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function export($id)
     {
       $commission = Commission::findOrFail($id);

       $subId = $commission->sub_id ?? 'NOID';
       $date = Carbon::now()->format('dmY'); // รูปแบบ วดป เช่น 040825

       $filename = "{$subId}_{$date}.xlsx";

       return Excel::download(new CommissionExport($id), $filename);
     }

     public function summary_export($id)
     {
       $commission = Commission::findOrFail($id);

       $subId = $commission->sub_id ?? 'NOID';
       $date = Carbon::now()->format('dmY'); // รูปแบบ วดป เช่น 040825

       $filename = "summary_{$subId}_{$date}.xlsx";

       return Excel::download(new CommissionSummaryExport($id), $filename);
     }

     public function importAll(Request $request)
     {

         $insertedAr = 0;
         $insertedCn = 0;

         $now = now();
         $prefix = $now->format('Ym'); // เช่น 202507

         $commissionsThisMonth = Commission::where('sub_id', 'like', "$prefix-%")->get();

         if ($commissionsThisMonth->isNotEmpty()) {
         //if (false) {
             $allDeleted = $commissionsThisMonth->every(fn($c) => $c->delete == true);

             if (! $allDeleted) {
                 return back()->with('error', 'มีการ import เดือนนี้แล้ว และยังไม่ได้ลบทั้งหมด');
             }

             // ให้ run number ถัดไป
             $latestSubId = $commissionsThisMonth->pluck('sub_id')->sortDesc()->first();
             $lastParts = explode('-', $latestSubId);
             $lastRun = isset($lastParts[1]) ? (int)$lastParts[1] : 0;
             $nextRun = $lastRun + 1;
         } else {
             // ครั้งแรกของเดือน
             $nextRun = 1;
         }

         $subId = sprintf('%s-%02d', $prefix, $nextRun);
         $latestSchemaId = CommissionsSchemaDetail::max('commissions_schemas_id');
         // สร้าง Commission แม่ก่อน
         $commission = Commission::create([
             'sub_id' => $subId,
             'status' => 'imported',
             'schema_id' => $latestSchemaId,
             'create_by' => auth()->id() ?? 'system',
         ]);

         if ($request->hasFile('file1')) {
             Excel::import(new CommissionsArImport($commission->id), $request->file('file1'));
         }

         if ($request->hasFile('file2')) {
             Excel::import(new CommissionsCnImport($commission->id), $request->file('file2'));
         }

         return back()->with('succes', 'Import สำเร็จ!');


     }

     public function adjust(Request $request, $id)
     {
         $request->validate([
             'sales_rep' => 'required|string|max:255',
             /*'reference_key' => 'required|string|max:255|unique:commissions_ars,reference_key',*/
             'reference_key' => 'required|string|max:255',
             'commissions' => 'required|numeric',
             'remark' => 'nullable|string|max:1000',
         ], [
             'reference_key.unique' => 'Invoice นี้มีอยู่ในระบบแล้ว',
         ]);

         CommissionsAr::create([
             'commissions_id' => $id,
             'sales_rep' => $request->sales_rep,
             'reference_key' => $request->reference_key,
             'commissions' => $request->commissions,
             'remark' => $request->remark,
             'type' => 'Adjust',
             'adjuster' => Auth::user()->username,
         ]);

         return redirect()->back()->with('adjust_success', true);
     }

     public function adjustUpdate(Request $request, $id)
     {
         $request->validate([
             'sales_rep' => 'required|string|max:255',
             /*'reference_key' => 'required|string|max:255|unique:commissions_ars,reference_key,' . $id,*/
             'reference_key' => 'required|string|max:255',
             'commissions' => 'required|numeric',
             'remark' => 'nullable|string|max:1000',
         ], [
             'reference_key.unique' => 'Invoice นี้มีอยู่ในระบบแล้ว',
         ]);

         $adjust = CommissionsAr::findOrFail($id);
         $adjust->update([
             'sales_rep' => $request->sales_rep,
             'reference_key' => $request->reference_key,
             'commissions' => $request->commissions,
             'remark' => $request->remark,
         ]);

         return redirect()->back()->with('adjust_updated', true);
     }

     public function salesSummary(Request $request, $id)
     {
         $search = $request->input('search');
         // ✅ ดึง Commission รายการเดียว
         $commission = Commission::findOrFail($id);

         // ✅ Summary ราย Sales Rep
         $summary = CommissionsAr::select(
                 'commissions_ars.sales_rep',
                 'user_masters.name_en',
                 'user_masters.division',
                 DB::raw('SUM(commissions_ars.commissions) as total_commissions'),
                 DB::raw("SUM(CASE WHEN commissions_ars.type = 'Adjust' THEN commissions_ars.commissions ELSE 0 END) AS total_adjust"),
                 DB::raw("SUM(CASE WHEN commissions_ars.type != 'Adjust' THEN commissions_ars.commissions ELSE 0 END) AS total_initial")
             )
             ->leftJoin('user_masters', function ($join) {
                 $join->on(DB::raw("SUBSTRING(commissions_ars.sales_rep, 4)"), '=', 'user_masters.job_code')
                      ->where('user_masters.status', 'Current');
             })
             ->where('commissions_ars.commissions_id', $id)
             ->whereNotNull('commissions_ars.commissions')
             ->when($search, function ($query) use ($search) {
                 $query->where(function ($q) use ($search) {
                     $q->where('commissions_ars.sales_rep', 'like', "%$search%")
                       ->orWhere('user_masters.name_en', 'like', "%$search%");
                 });
             })
             ->groupBy('commissions_ars.sales_rep')
             ->orderBy('commissions_ars.sales_rep','desc')
             ->get();

         $totalInitial = CommissionsAr::where('commissions_id', $id)->where('type','!=','Adjust')->sum('commissions');
         $totalAdjustment = CommissionsAr::where('commissions_id', $id)->where('type','Adjust')->sum('commissions');
         $totalCommissions = CommissionsAr::where('commissions_id', $id)->sum('commissions');


         return view('pages.commissions.sales_summary', compact(
             'commission',
             'summary',
             'search',
             'totalInitial',
             'totalAdjustment',
             'totalCommissions',
         ));
     }

     public function updateStatus(Request $request, $id)
     {
         $request->validate([
             'status' => 'required|string|max:50',
         ]);

         $commission = Commission::findOrFail($id);
         $commission->status = $request->status;
         $commission->save();

         return back()->with('succes', 'Status updated successfully.');
     }


     public function index()
     {
       $commissions = Commission::where('delete', false)
               ->with('creator')       // โหลดข้อมูลผู้สร้างด้วย
               ->orderByDesc('created_at')
               ->get();

         return view('pages.commissions.index', compact('commissions'));
     }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
     public function check(Request $request, $id)
     {

        $users = 'HTH4090';
        $search = $request->input('search');
        $commission = Commission::findOrFail($id);
        $commissionArs = CommissionsAr::where('commissions_id',$id)->where('sales_rep', $users)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->Where('commissions_ars.reference_key', 'like', "%$search%");
                });
            })
            ->get();
        // ตรวจสอบก่อนดึง
        $schemaTable = [];
        $columns = ['0-30', '31-60', '61-90', '91-120', '121-150', '151-365'];

        if ($commission->schema_id) {
            $schemaDetails = CommissionsSchemaDetail::where('commissions_schemas_id', $commission->schema_id)->get();

            foreach ($schemaDetails as $detail) {
                $division = $detail->division_name;
                $range = $detail->ar_end > 150 ? '151-365' : "{$detail->ar_start}-{$detail->ar_end}";

                if (!isset($schemaTable[$division])) {
                    $schemaTable[$division] = [];
                }

                $schemaTable[$division][$range] = number_format($detail->rate_percent, 2) . '%';
            }
        }

        $totalInitial = CommissionsAr::where('commissions_id', $id)->where('sales_rep', $users)->where('type','!=','Adjust')->sum('commissions');
        $totalAdjustment = CommissionsAr::where('commissions_id', $id)->where('sales_rep', $users)->where('type','Adjust')->sum('commissions');
        $totalCommissions = CommissionsAr::where('commissions_id', $id)->where('sales_rep', $users)->sum('commissions');

        return view('pages.commissions.check', compact('commissionArs','commission','schemaTable','columns','totalInitial','totalAdjustment','totalCommissions'));
     }

     public function show(Commission $commission, Request $request)
     {

         $search = $request->input('search');

         $commissionArs = CommissionsAr::select('commissions_ars.*', 'user_masters.division', 'user_masters.name_en')
             ->leftJoin('user_masters', function ($join) {
                 $join->on(DB::raw("SUBSTRING(commissions_ars.sales_rep, 4)"), '=', 'user_masters.job_code')
                      ->where('user_masters.status', 'Current'); // เช่น เฉพาะพนักงานที่ยังอยู่
             })
             ->where('commissions_id', $commission->id)
             ->when($search, function ($query) use ($search) {
                 $query->where(function ($q) use ($search) {
                     $q->where('commissions_ars.account', 'like', "%$search%")
                       ->orWhere('commissions_ars.name', 'like', "%$search%")
                       ->orWhere('commissions_ars.sales_rep', 'like', "%$search%")
                       ->orWhere('commissions_ars.reference_key', 'like', "%$search%");
                 });
             })
             ->orderBy('commissions_ars.id', 'desc')
             ->paginate(200)
             ->withQueryString();

             // ตรวจสอบก่อนดึง
             $schemaTable = [];
             $columns = ['0-30', '31-60', '61-90', '91-120', '121-150', '151-365'];

             if ($commission->schema_id) {
                 $schemaDetails = CommissionsSchemaDetail::where('commissions_schemas_id', $commission->schema_id)->get();

                 foreach ($schemaDetails as $detail) {
                     $division = $detail->division_name;
                     $range = $detail->ar_end > 150 ? '151-365' : "{$detail->ar_start}-{$detail->ar_end}";

                     if (!isset($schemaTable[$division])) {
                         $schemaTable[$division] = [];
                     }

                     $schemaTable[$division][$range] = number_format($detail->rate_percent, 2) . '%';
                 }
             }

         return view('pages.commissions.show', compact('commission', 'commissionArs', 'search', 'schemaTable', 'columns'));
     }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      // ดึงข้อมูลเฉพาะ commission นี้
      $entries = CommissionsAr::where('commissions_id', $id)->get();
      $commission = Commission::where('id', $id)->first();

      foreach ($entries as $entry) {
          $salesRep = $entry->sales_rep;

          if (!$salesRep || strlen($salesRep) < 4) {
              continue;
          }

          // ตัด 3 ตัวหน้า
          $jobCode = substr($salesRep, 3);

          $user = UserMaster::where('job_code', $jobCode)->where('status','Current')->first();
          if (!$user) {
              continue;
          }

          $division = $user->division;

          // เตรียมวันที่จาก record เดิม
          $docDate = $entry->document_date;
          $clearDate = $entry->clearing_date;

          // 🟡 เฉพาะ type 'CN' → ตรวจสอบ cn_billing_ref
          if ($entry->type === 'CN') {

              // พยายามหา reference_key ที่ตรงกันใน AR
              $arRef = CommissionsAr::where('type', 'AR')
                  ->where('reference_key', $entry->cn_billing_ref)
                  ->first();

              // หากหาไม่พบ → ข้ามรายการนี้
              if (!$arRef) continue;

              // ถ้าพบ → ใช้วันที่จาก AR
              $docDate = $arRef->document_date;
              $clearDate = $arRef->clearing_date;
          }

          // ตรวจสอบวันที่ให้ครบ
          if (!$docDate || !$clearDate) continue;

          $docDate = Carbon::parse($docDate);
          $clearDate = Carbon::parse($clearDate);
          $diffDays = $docDate->diffInDays($clearDate);

          // หาค่า commissions_schemas_id ล่าสุด
          //$latestSchemaId = CommissionsSchemaDetail::max('commissions_schemas_id');

          // ดึง schema โดยอิงจาก division และช่วง diffDays
          $schema = CommissionsSchemaDetail::where('commissions_schemas_id', $commission->schema_id)
              ->where('division_name', $division)
              ->where('ar_start', '<=', $diffDays)
              ->where('ar_end', '>=', $diffDays)
              ->first();

          if ($schema) {
            $ratePercent = (float) $schema->rate_percent;
            $amount = (float) $entry->amount_in_local_currency;
            $commissionAmount = $amount * $ratePercent / 100;

            $entry->ar_rate_percent = $ratePercent;
            $entry->ar_rate = $diffDays;
            $entry->commissions = round($commissionAmount, 2); // ปัดเศษ 2 ตำแหน่ง
            $entry->save();
          }
      }

      // ✅ อัปเดต status ของ Commission เป็น "Calculate"
      $commission = Commission::find($id);
      if ($commission) {
          $commission->status = 'calculate';
          $commission->save();
      }

      return back()->with('succes', 'คำนวณค่าคอมมิชชั่นสำเร็จแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Commission $commission)
     {
         // ตัวอย่าง: update flag delete = true
         $commission->update(['delete' => true]);

         return redirect()->route('commissions.index')->with('succes', 'ลบ Commission สำเร็จ');
     }
}
