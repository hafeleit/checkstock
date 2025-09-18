<?php

namespace App\Http\Controllers;

use App\Events\CommissionPasswordVerified;
use App\Events\CommissionStatusUpdated;
use App\Events\FileExported;
use App\Events\FileImported;
use App\Events\RecordDeleted;
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
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use App\Exports\CommissionsExport;
use Illuminate\Support\Facades\Session;
use App\Mail\CommissionStatusMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:Commissions Summary-View', ['only' => ['salesSummary']]);
        $this->middleware('permission:Commissions AR-View', ['only' => ['show']]);
    }

    public function export($id)
    {
        $filename = '';

        try {
            $commission = Commission::findOrFail($id);
            $subId = $commission->sub_id ?? 'NOID';
            $date = Carbon::now()->format('dmY'); // รูปแบบ วดป เช่น 040825
            $filename = "{$subId}_{$date}.xlsx";

            event(new FileExported('App\Models\CommissionsAr', auth()->id(), 'export', 'pass', $filename, null));
            return Excel::download(new CommissionExport($id), $filename);
        } catch (\Throwable $th) {
            event(new FileExported('App\Models\CommissionsAr', auth()->id(), 'export', 'fail', $filename, null, $th->getMessage()));
            return back()->with('error', '❌ An error occurred during export: ' . $th->getMessage());
        }
    }

    public function summarySalesExport($id)
    {
        $filename = 'commissions-summary-sales.xlsx';

        try {
            $users = DB::table('user_masters')
                ->where('employee_code', Auth::user()->emp_code)
                ->select('job_code', 'division')
                ->first();

            if ($users) {
                $sales_rep = 'HTH' . $users->job_code;
            } else {
                $sales_rep = null;
            }

            event(new FileExported('App\Models\CommissionsAr', auth()->id(), 'export_summary_salses', 'pass', $filename, null));
            return Excel::download(new CommissionsExport($id, $sales_rep), $filename);
        } catch (\Throwable $th) {
            event(new FileExported('App\Models\CommissionsAr', auth()->id(), 'export_summary_salses', 'fail', $filename, null, $th->getMessage()));
            return back()->with('error', '❌ An error occurred during export: ' . $th->getMessage());
        }
    }

    public function summary_export($id)
    {
        $filename = '';
        try {
            $commission = Commission::findOrFail($id);
            $subId = $commission->sub_id ?? 'NOID';
            $date = Carbon::now()->format('dmY'); // รูปแบบ วดป เช่น 040825
            $filename = "summary_{$subId}_{$date}.xlsx";

            event(new FileExported('App\Models\CommissionsAr', auth()->id(), 'export_summary', 'pass', $filename, null));
            return Excel::download(new CommissionSummaryExport($id), $filename);
        } catch (\Throwable $th) {
            event(new FileExported('App\Models\CommissionsAr', auth()->id(), 'export_summary', 'fail', $filename, null, $th->getMessage()));
            return back()->with('error', '❌ An error occurred during export: ' . $th->getMessage());
        }
    }

    public function importAll(Request $request)
    {
        // $insertedAr = 0;
        // $insertedCn = 0;
        // $now = now();
        //$prefix = $now->format('Ym'); // เช่น 202507

        $file = $request->file('file1');
        $fileName = $file ? $file->getClientOriginalName() : '';
        $fileSize = $file ? $file->getSize() : null;

        try {
            if (!$file) {
                event(new FileImported('App\Models\CommissionsAr', auth()->id(), 'import', 'fail', $fileName, $fileSize, 'Invalid file.'));
                return redirect()->back()->with('error', '❌ กรุณาเลือกไฟล์ก่อนนำเข้า');
            }

            // ✅ check ว่าเป็น .xlsx เท่านั้น
            if ($file->getClientOriginalExtension() !== 'xlsx') {
                event(new FileImported('App\Models\CommissionsAr', auth()->id(), 'import', 'fail', $fileName, $fileSize, 'Wrong file format.'));
                return back()->with('error', '❌ กรุณาเลือกไฟล์ที่เป็น .xlsx เท่านั้น');
            }

            // ✅ โหลดแค่แถวที่ 2 โดยใช้ PhpSpreadsheet โดยตรง
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $cellValue = trim($sheet->getCell('A2')->getValue() ?? '');
            if (empty($cellValue)) {
                event(new FileImported('App\Models\CommissionsAr', auth()->id(), 'import', 'fail', $fileName, $fileSize, 'Missing data in column a, row 2.'));
                return back()->with('error', '❌ ไม่พบข้อมูลใน Column A ของแถวที่ 2');
            }
            $prefix = $cellValue;

            // หา column สูงสุดจริง
            //$highestColumn = $sheet->getHighestColumn(); // เช่น "AU"
            //$highestColumnIndex = Coordinate::columnIndexFromString($highestColumn); // แปลงเป็นเลข
            /*$expectedColumns = 47;
            if ($highestColumnIndex != $expectedColumns) {
                return redirect()->back()->with('error', "❌ จำนวน column ของ Row 1 ไม่ถูกต้อง ต้องเป็น $expectedColumns คอลัมน์ แต่เจอ $highestColumnIndex");
            }*/

            $commissionsThisMonth = Commission::where('sub_id', 'like', "$prefix-%")->get();
            if ($commissionsThisMonth->isNotEmpty()) {
                $allDeleted = $commissionsThisMonth->every(fn($c) => $c->delete == true);
                if (!$allDeleted) {
                    event(new FileImported('App\Models\CommissionsAr', auth()->id(), 'import', 'fail', $fileName, $fileSize, 'Data has been imported this month.'));
                    return back()->with('error', 'มีการ import เดือนนี้แล้ว หากต้องการ Import กรุณาลบข้อมูลเก่า');
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

            event(new FileImported('App\Models\CommissionsAr', auth()->id(), 'import', 'pass', $fileName, $fileSize));
            return back()->with('succes', 'Import สำเร็จ!');
        } catch (\Throwable $th) {
            event(new FileImported('App\Models\CommissionsAr', auth()->id(), 'import', 'fail', $fileName, $fileSize, $th->getMessage()));
            return redirect()->back()->with('error', 'An error occurred. Please check the file.');
        }
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

        $subUser = DB::table('user_masters as u1')
            ->select(
                'u1.job_code',
                DB::raw('u1.name_en as name_en'),
                DB::raw('u1.division as division'),
                DB::raw('u1.effecttive_date as effecttive_date'),
                DB::raw('u1.status as emp_status'),
                DB::raw('u1.position as emp_position')
            )
            ->whereRaw("
                 NOT EXISTS (
                     SELECT 1
                     FROM user_masters u2
                     WHERE u2.job_code = u1.job_code
                     AND (
                         CASE u2.status
                             WHEN 'Current' THEN 1
                             WHEN 'Probation' THEN 2
                             WHEN 'Resign' THEN 3
                             ELSE 4
                         END
                         < CASE u1.status
                             WHEN 'Current' THEN 1
                             WHEN 'Probation' THEN 2
                             WHEN 'Resign' THEN 3
                             ELSE 4
                         END
                         OR (
                             CASE u2.status
                                 WHEN 'Current' THEN 1
                                 WHEN 'Probation' THEN 2
                                 WHEN 'Resign' THEN 3
                                 ELSE 4
                             END
                             = CASE u1.status
                                 WHEN 'Current' THEN 1
                                 WHEN 'Probation' THEN 2
                                 WHEN 'Resign' THEN 3
                                 ELSE 4
                             END
                             AND u2.effecttive_date > u1.effecttive_date
                         )
                     )
                 )
             ");

        $summary = CommissionsAr::select(
            'commissions_ars.sales_rep',
            'commissions_ars.status',
            'user_masters.name_en',
            'user_masters.division',
            'user_masters.effecttive_date',
            'user_masters.emp_status',
            'user_masters.emp_position',
            DB::raw('SUM(commissions_ars.commissions) as total_commissions'),
            DB::raw("SUM(CASE WHEN commissions_ars.type = 'Adjust' THEN commissions_ars.commissions ELSE 0 END) AS total_adjust"),
            DB::raw("SUM(CASE WHEN commissions_ars.type != 'Adjust' THEN commissions_ars.commissions ELSE 0 END) AS total_initial")
        )
            ->leftJoinSub($subUser, 'user_masters', function ($join) {
                $join->on(DB::raw("SUBSTRING(commissions_ars.sales_rep, 4)"), '=', 'user_masters.job_code');
            })
            ->where('commissions_ars.commissions_id', $id)
            ->whereNotNull('commissions_ars.commissions')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('commissions_ars.sales_rep', 'like', "%$search%")
                        ->orWhere('user_masters.name_en', 'like', "%$search%");
                });
            })
            ->groupBy(
                'commissions_ars.sales_rep',
                'commissions_ars.status',
                'user_masters.name_en',
                'user_masters.division',
                'user_masters.effecttive_date'
            )
            ->orderBy('commissions_ars.sales_rep', 'asc')
            ->get();


        $totalInitial = CommissionsAr::where('commissions_id', $id)->where('type', '!=', 'Adjust')->where('status', 'Approve')->sum('commissions');
        $totalAdjustment = CommissionsAr::where('commissions_id', $id)->where('type', 'Adjust')->where('status', 'Approve')->sum('commissions');
        $totalCommissions = CommissionsAr::where('commissions_id', $id)->where('status', 'Approve')->sum('commissions');


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
        try {
            $request->validate([
                'status' => 'required|string|max:50',
                'selected_sales' => 'nullable|string' // ค่า sales_rep ที่ส่งมาเป็นคอมมา
            ]);

            $commission = Commission::findOrFail($id);
            $oldStatus = $commission->status;

            $commission->status = $request->status;

            if ($request->filled('hr_comment')) {
                $commission->hr_comment = $request->hr_comment;
            }

            if ($request->filled('fin_comment')) {
                $commission->fin_comment = $request->fin_comment;
            }

            if (empty($request->hr_comment) && empty($request->fin_comment) && !empty($request->selected_sales)) {

                $salesReps = explode(',', $request->selected_sales);
                // อัปเดตเป็น Approve สำหรับ sales ที่ติ๊ก
                CommissionsAr::where('commissions_id', $commission->id)
                    ->whereIn('sales_rep', $salesReps)
                    ->update(['status' => 'Approve']);

                // เอาคนที่ไม่ได้ติ๊กออกจาก Approve
                CommissionsAr::where('commissions_id', $commission->id)
                    ->whereNotIn('sales_rep', $salesReps)
                    ->where('status', 'Approve')
                    ->update(['status' => null]); // หรือ 'Pending'
            }

            $commission->save();

            event(new CommissionStatusUpdated(auth()->id(), $commission->id, 'pass', $oldStatus, $commission->status, $salesReps));

            $to = [];
            $cc = [auth()->user()->email]; // cc ตัวเองเสมอ

            switch ($request->status) {
                case 'AR Approved':
                    $to = ['warisara@hafele.co.th', 'pimnada@hafele.co.th']; //warisara, pimnada
                    $cc = array_merge($cc, [
                        'apirak@hafele.co.th',
                        'chanida@hafele.co.th',
                        'nattawan@hafele.co.th',
                    ]);
                    break;

                case 'Summary Rejected':
                    $to = ['sarunya@hafele.co.th']; //sarunya
                    $cc = array_merge($cc, [
                        'apirak@hafele.co.th',
                        'chanida@hafele.co.th',
                        'nattawan@hafele.co.th',
                    ]);
                    break;

                case 'Summary Confirmed':
                    $to = ['chanida@hafele.co.th']; //chanida
                    $cc = array_merge($cc, [
                        'apirak@hafele.co.th',
                        'warisara@hafele.co.th',
                        'pimnada@hafele.co.th'
                    ]);
                    break;

                case 'Summary Rejected(Manager)':
                    $to = ['warisara@hafele.co.th', 'pimnada@hafele.co.th']; //warisara, pimnada
                    $cc = array_merge($cc, [
                        'apirak@hafele.co.th',
                    ]);
                    break;

                case 'Summary Approved':
                    $to = ['nattawan@hafele.co.th']; //nattawan
                    $cc = array_merge($cc, [
                        'apirak@hafele.co.th',
                        'warisara@hafele.co.th',
                        'pimnada@hafele.co.th'
                    ]);
                    break;

                case 'Final Rejected':
                    $to = ['chanida@hafele.co.th']; //chanida
                    $cc = array_merge($cc, [
                        'apirak@hafele.co.th',
                        'sarunya@hafele.co.th'
                    ]);
                    break;

                case 'Final Approved':
                    $to = ['chanida@hafele.co.th'];
                    $cc = array_merge($cc, [
                        'apirak@hafele.co.th',
                        'warisara@hafele.co.th',
                        'pimnada@hafele.co.th',
                        'sarunya@hafele.co.th',
                    ]);
                    break;
            }

            Mail::to($to)
                ->cc($cc)
                ->send(new CommissionStatusMail($commission->sub_id, $request->status));

            return back()->with('succes', "✅ Commission #{$commission->sub_id} เปลี่ยนสถานะเป็น {$request->status} และส่งอีเมลแจ้งแล้ว");
        } catch (\Throwable $th) {
            event(new CommissionStatusUpdated(auth()->id(), $commission->id, 'fail', $oldStatus, $commission->status, $salesReps, $th->getMessage()));
            return back()->with('error', "❌ เกิดข้อผิดพลาดในการเปลี่ยนสถานะ: " . $th->getMessage());
        }
    }

    public function verifyPassword(Request $request)
    {
        $user = Auth::user();

        try {
            $request->validate([
                'password' => 'required',
            ]);

            if (!\Hash::check($request->password, $user->password)) {
                event(new CommissionPasswordVerified($user->id, 'fail', 'รหัสผ่านไม่ถูกต้อง'));
                return response()->json(['error' => 'รหัสผ่านไม่ถูกต้อง'], 422);
            }

            event(new CommissionPasswordVerified($user->id, 'pass'));

            // สร้าง session ว่า verified
            $request->session()->put('commission_verified', true);

            return response()->json(['success' => true]);
        } catch (ValidationException $e) {
            event(new CommissionPasswordVerified($user->id, 'fail', $e->getMessage()));
            return response()->json(['error' => 'กรุณากรอกรหัสผ่าน'], 422);
        } catch (\Throwable $th) {
            event(new CommissionPasswordVerified($user->id, 'fail', $th->getMessage()));
            return response()->json(['error' => 'เกิดข้อผิดพลาดในการตรวจสอบ'], 500);
        }
    }

    public function index(Request $request)
    {

        $commissions = Commission::where('delete', false)
            ->with('creator')
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
        // ถ้า session ยังไม่ verified → redirect ไป modal (หรือแสดง modal จาก frontend)
        if (!$request->session()->get('commission_verified')) {
            return view('pages.user-profile');
        }
        Session::forget('commission_verified');

        if (empty(Auth::user()->emp_code)) {
            return back()->with('error', 'ไม่พบรหัสพนักงาน (emp code) ของคุณ');
        }

        $users = DB::table('user_masters')
            ->where('employee_code', Auth::user()->emp_code)
            ->select('job_code', 'division')
            ->first();

        if ($users) {
            $sales_rep   = 'HTH' . $users->job_code;
            $division  = $users->division;
        } else {
            $jobCode   = null;
            $division  = null;
        }


        $search = $request->input('search');
        $commission = Commission::findOrFail($id);
        $commissionArs = CommissionsAr::where('commissions_id', $id)
            ->where('sales_rep', $sales_rep)
            ->where('status', 'Approve')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->Where('commissions_ars.reference_key', 'like', "%$search%");
                });
            })
            ->orderBy('document_date', 'asc')
            ->get();
        // ตรวจสอบก่อนดึง
        $schemaTable = [];
        $columns = ['0-30', '31-60', '61-90', '91-120', '121-150', '> 150'];

        if ($commission->schema_id) {
            $schemaDetails = CommissionsSchemaDetail::where('commissions_schemas_id', $commission->schema_id)
                ->where('division_name', $division)
                ->get();

            foreach ($schemaDetails as $detail) {
                $division = $detail->division_name;
                $range = $detail->ar_end > 150 ? '> 150' : "{$detail->ar_start}-{$detail->ar_end}";

                if (!isset($schemaTable[$division])) {
                    $schemaTable[$division] = [];
                }

                $schemaTable[$division][$range] = number_format($detail->rate_percent, 2) . '%';
            }
        }

        $totalInitial = CommissionsAr::where('commissions_id', $id)->where('sales_rep', $sales_rep)->where('type', '!=', 'Adjust')->where('status', 'Approve')->sum('commissions');
        $totalAdjustment = CommissionsAr::where('commissions_id', $id)->where('sales_rep', $sales_rep)->where('type', 'Adjust')->where('status', 'Approve')->sum('commissions');
        $totalCommissions = CommissionsAr::where('commissions_id', $id)->where('sales_rep', $sales_rep)->where('status', 'Approve')->sum('commissions');

        return view('pages.commissions.check', compact('commissionArs', 'commission', 'schemaTable', 'columns', 'totalInitial', 'totalAdjustment', 'totalCommissions'));
    }

    public function show(Commission $commission, Request $request)
    {

        $search = $request->input('search');

        $subUser = DB::table('user_masters as u1')
            ->select(
                'u1.job_code as job_code',
                'u1.name_en as name_en',
                'u1.division as division',
                'u1.effecttive_date as effecttive_date'
            )
            ->whereRaw("
                 NOT EXISTS (
                     SELECT 1
                     FROM user_masters u2
                     WHERE u2.job_code = u1.job_code
                     AND (
                         CASE u2.status
                             WHEN 'Current' THEN 1
                             WHEN 'Probation' THEN 2
                             WHEN 'Resign' THEN 3
                             ELSE 4
                         END
                         < CASE u1.status
                             WHEN 'Current' THEN 1
                             WHEN 'Probation' THEN 2
                             WHEN 'Resign' THEN 3
                             ELSE 4
                         END
                         OR (
                             CASE u2.status
                                 WHEN 'Current' THEN 1
                                 WHEN 'Probation' THEN 2
                                 WHEN 'Resign' THEN 3
                                 ELSE 4
                             END
                             = CASE u1.status
                                 WHEN 'Current' THEN 1
                                 WHEN 'Probation' THEN 2
                                 WHEN 'Resign' THEN 3
                                 ELSE 4
                             END
                             AND u2.effecttive_date > u1.effecttive_date
                         )
                     )
                 )
             ");


        $commissionArs = CommissionsAr::select(
            'commissions_ars.*',
            'user_masters.*'
        )
            ->leftJoinSub($subUser, 'user_masters', function ($join) {
                $join->on(DB::raw("SUBSTRING(commissions_ars.sales_rep, 4)"), '=', 'user_masters.job_code');
            })
            ->where('commissions_id', $commission->id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('commissions_ars.account', 'like', "%$search%")
                        ->orWhere('commissions_ars.name', 'like', "%$search%")
                        ->orWhere('commissions_ars.sales_rep', 'like', "%$search%")
                        ->orWhere('commissions_ars.reference_key', 'like', "%$search%")
                        ->orWhere('user_masters.name_en', 'like', "%$search%");
                });
            })
            ->orderBy('commissions_ars.id', 'desc')
            ->paginate(50)
            ->withQueryString();

        // ตรวจสอบก่อนดึง
        $schemaTable = [];
        $columns = ['0-30', '31-60', '61-90', '91-120', '121-150', '> 150'];

        if ($commission->schema_id) {
            $schemaDetails = CommissionsSchemaDetail::where('commissions_schemas_id', $commission->schema_id)->get();

            foreach ($schemaDetails as $detail) {
                $division = $detail->division_name;
                $range = $detail->ar_end > 150 ? '> 150' : "{$detail->ar_start}-{$detail->ar_end}";

                if (!isset($schemaTable[$division])) {
                    $schemaTable[$division] = [];
                }

                $schemaTable[$division][$range] = number_format($detail->rate_percent, 2) . '%';
            }
        }

        $salesReps = CommissionsAr::select('sales_rep')->groupBy('sales_rep')->orderBy('sales_rep')->get();

        $totalInitial = CommissionsAr::where('commissions_id', $commission->id)->where('type', '!=', 'Adjust')->sum('commissions');
        $totalAdjustment = CommissionsAr::where('commissions_id', $commission->id)->where('type', 'Adjust')->sum('commissions');
        $totalCommissions = CommissionsAr::where('commissions_id', $commission->id)->sum('commissions');

        $previousRemarks = CommissionsAr::select('remark')
            ->groupBy('remark')
            ->orderBy('remark', 'asc')
            ->pluck('remark') // เอาเฉพาะ column remark เป็น array
            ->toArray();
        return view('pages.commissions.show', compact('commission', 'commissionArs', 'search', 'schemaTable', 'columns', 'salesReps', 'totalInitial', 'totalAdjustment', 'totalCommissions', 'previousRemarks'));
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
        // ดึง Commission
        $commission = Commission::where('id', $id)->first();

        // ดึงข้อมูล commissions_ars พร้อม diffDays ที่คำนวณจาก SQL
        $entries = CommissionsAr::select(
            'commissions_ars.*',
            DB::raw('DATEDIFF(clearing_date, document_date) as diffDays')
        )
            ->where('commissions_id', $id)
            ->get();

        foreach ($entries as $entry) {
            $salesRep = $entry->sales_rep;

            if (!$salesRep || strlen($salesRep) < 4) {
                continue;
            }

            // ตัด 3 ตัวหน้า
            $jobCode = substr($salesRep, 3);

            $user = UserMaster::where('job_code', $jobCode)
                ->orderByRaw("
                     CASE
                         WHEN status = 'Current' THEN 1
                         WHEN status = 'Probation' THEN 2
                         WHEN status = 'Resign' THEN 3
                         ELSE 4
                     END
                 ")
                ->orderByDesc('effecttive_date')
                ->first();

            if (!$user) {
                continue;
            }

            $division = $user->division;

            // ข้ามถ้า docDate หรือ clearDate ว่าง
            if (!$entry->document_date || !$entry->clearing_date) continue;

            $diffDays = (int) $entry->diffDays;

            // หา schema
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
                $entry->commissions = round($commissionAmount, 2);
                $entry->save();
            }
        }

        // ✅ อัปเดต status ของ Commission เป็น "calculated"
        $commission = Commission::find($id);

        if ($commission) {
            $commission->status = 'calculated';
            $commission->save();

            // หา commission id เก่า (ล่าสุด - 1)
            $latestId = Commission::where('delete', 0)->max('id');

            $oldCommissionId = Commission::where('delete', 0)
                ->where('id', '<', $latestId)
                ->max('id');

            $ars = DB::table('commissions_ars')
                ->select(
                    'account',
                    'name',
                    'document_type',
                    'reference',
                    'reference_key',
                    'document_date',
                    'clearing_date',
                    'amount_in_local_currency',
                    'local_currency',
                    'clearing_document',
                    'text',
                    'posting_key',
                    'sales_rep',
                    'ar_rate',
                    'ar_rate_percent',
                    'commissions'
                )
                ->where('commissions_id', $oldCommissionId)
                ->where('commissions', '!=', '')
                ->whereNull('status')
                ->get();

            if ($ars->isNotEmpty()) {
                $insertData = $ars->map(function ($ar) use ($id) {
                    return [
                        'type'                     => 'AR Old',
                        'commissions_id'           => $id,
                        'account'                  => $ar->account,
                        'name'                     => $ar->name,
                        'document_type'            => $ar->document_type,
                        'reference'                => $ar->reference,
                        'reference_key'            => $ar->reference_key,
                        'document_date'            => $ar->document_date,
                        'clearing_date'            => $ar->clearing_date,
                        'amount_in_local_currency' => $ar->amount_in_local_currency,
                        'local_currency'           => $ar->local_currency,
                        'clearing_document'        => $ar->clearing_document,
                        'text'                     => $ar->text,
                        'posting_key'              => $ar->posting_key,
                        'sales_rep'                => $ar->sales_rep,
                        'ar_rate'                  => $ar->ar_rate,
                        'ar_rate_percent'          => $ar->ar_rate_percent,
                        'commissions'              => $ar->commissions,
                        'status'                   => null,
                        'created_at'               => now(),
                        'updated_at'               => now(),
                    ];
                })->toArray();

                DB::table('commissions_ars')->insert($insertData);
            }
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

    public function adjust_delete($id)
    {
        try {
            $ar = CommissionsAr::find($id);

            if (!$ar) {
                event(new RecordDeleted('App\Models\CommissionsAr', auth()->id(), 'fail', $id, 'Record Not Found'));
                return redirect()->back()->with('error', 'ไม่พบรายการนี้');
            }

            $ar->delete();

            event(new RecordDeleted('App\Models\CommissionsAr', auth()->id(), 'pass', $id));
            return redirect()->back()->with('success', 'ลบรายการเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            event(new RecordDeleted('App\Models\CommissionsAr', auth()->id(), 'fail', $id, $e->getMessage()));
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }
}
