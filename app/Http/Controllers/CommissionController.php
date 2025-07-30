<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;
use App\Models\CommissionsAr;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CommissionsArImport;
use App\Imports\CommissionsCnImport;
use Carbon\Carbon;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

         // สร้าง Commission แม่ก่อน
         $commission = Commission::create([
             'sub_id' => $subId,
             'status' => 'imported',
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
     public function show(Commission $commission, Request $request)
     {
         $search = $request->input('search');

         $commissionArs = CommissionsAr::where('commissions_id', $commission->id)
             ->when($search, function ($query) use ($search) {
                 $query->where(function ($q) use ($search) {
                     $q->where('account', 'like', "%$search%")
                       ->orWhere('name', 'like', "%$search%")
                       ->orWhere('sales_rep', 'like', "%$search%");
                 });
             })
             ->orderBy('id', 'desc')
             ->paginate(20)
             ->withQueryString();

         return view('pages.commissions.show', compact('commission', 'commissionArs', 'search'));
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
        //
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
