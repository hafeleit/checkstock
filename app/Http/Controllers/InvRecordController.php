<?php

namespace App\Http\Controllers;

use App\Models\InvRecord;
use App\Models\InvRecordDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvRecordExport;

class InvRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $invRecords = DB::table('inv_records as a')
      ->select([
          'a.*',
          DB::raw("CASE
              WHEN MIN(COALESCE(d.approve, 0)) = 1 AND MAX(COALESCE(d.approve, 0)) = 1 THEN 'Finance Completed'
              ELSE 'Issue'
          END as sheet_status"),
          DB::raw("DATE_FORMAT(a.created_at, '%d-%m-%Y') as created_at"),
        ]
      )
      ->leftJoin('inv_record_details as d', 'd.inv_record_id', '=', 'a.id')
      ->where('a.status', '!=', 'delete')
      ->groupBy('a.sheet_id')
      ->get();

      // ส่งข้อมูลไปยัง view
      return view('pages.inv_record.index', compact('invRecords'));
    }

    public function export($id)
    {
        $invRecord = DB::table('inv_records as i')
        ->leftJoin('inv_record_details as d', 'd.inv_record_id', '=', 'i.id')
        ->select([
            DB::raw("DATE_FORMAT(i.created_at, '%d-%m-%Y') as created_at"),
            'i.sheet_id',
            'i.creator',

            'd.inv_number',
            'd.status as invoice_status',
            DB::raw("IF(d.approve = 1, 'Approve', '') as approve"),
            'd.approval',
            DB::raw("DATE_FORMAT(d.approve_date, '%d-%m-%Y') as approve_date"),
        ])
        ->where('i.id', $id)
        ->get();
        // ส่งข้อมูลทั้งสองตารางไปยัง Excel
        return Excel::download(new InvRecordExport($invRecord), 'inv-record-' . $id . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.inv_record.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ใช้การ validate ข้อมูล
        $request->validate([
            'invoice_number' => 'required|array',
            'invoice_number.*' => 'required|string'
        ]);

        // เริ่มต้น transaction
        DB::beginTransaction();

        try {
            // ดึงข้อมูล user ที่ล็อกอิน
            $creator = Auth::user()->username ?? 'anonymous';
            $today = now()->format('ymd');
            $prefix = 'SH' . $today;

            // นับจำนวน sheet_id ที่มีอยู่แล้ว
            $countToday = InvRecord::where('sheet_id', 'like', "$prefix%")->count();
            $sheetId = $prefix . str_pad($countToday + 1, 6, '0', STR_PAD_LEFT);

            // บันทึกข้อมูลลงใน InvRecord
            $invRecord = InvRecord::create([
                'sheet_id' => $sheetId,
                'creator' => $creator,
                'status' => '',
            ]);

            // เตรียมข้อมูลสำหรับการ insert ลงใน inv_record_details
            $invoiceDetails = [];
            foreach ($request->invoice_number as $number) {
                $invoiceDetails[] = [
                    'inv_record_id' => $invRecord->id, // ใช้ inv_record_id จาก InvRecord
                    'inv_number' => $number,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Insert ข้อมูลลงใน inv_record_details
            DB::table('inv_record_details')->insert($invoiceDetails);

            // หากทุกอย่างสำเร็จให้ commit การเปลี่ยนแปลง
            DB::commit();

            // ส่งกลับหน้าเดิมและแสดงข้อความ success
            return back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            // หากเกิดข้อผิดพลาดใดๆ ให้ยกเลิกทั้งหมด
            DB::rollback();

            // ส่งกลับพร้อมกับข้อความ error
            return back()->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InvRecord $invRecord)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvRecord $invRecord)
    {
        $invRecordDetail = InvRecordDetail::where('inv_record_id', $invRecord->id)->get();

        // ส่งข้อมูลไปยังหน้า edit
        return view('pages.inv_record.edit', compact('invRecord', 'invRecordDetail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvRecord $invRecord)
    {
      // รับค่าจากฟอร์ม ซึ่งในที่นี้คือ array ของ id ที่ถูกเลือก
      $approveIds = $request->input('approve'); // เป็น array ของ id ที่ได้รับจาก checkbox
      InvRecordDetail::where('inv_record_id',$invRecord->id)->update(['approve' => null,'approval' => null,'approve_date' => null]);
      if (!empty($approveIds)) {
        // อัปเดตสถานะ approve เป็น 1 สำหรับ InvRecordDetail ที่มี id ตรงกับที่ส่งมา
        InvRecordDetail::whereIn('id', $approveIds)
                       ->update(['approve' => 1,'approval'=>Auth::user()->username,'approve_date'=>date('Y-m-d H:i:s')]);
      }

      // ทำการ redirect หรือแสดงข้อความสำเร็จ
      return redirect()->route('inv-record.edit', $invRecord->id)
                     ->with('success', 'Approve status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvRecord $invRecord)
    {
        $invRecord->update(['status' => 'delete']);

        return back()->with('success', 'Deleted successfully.');
    }
}
