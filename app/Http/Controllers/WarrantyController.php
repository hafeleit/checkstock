<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Image;

class WarrantyController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('pages.warranty.index');
  }

  public function check_warranty()
  {
    return view('pages.warranty.check');
  }

  public function search_warranty(Request $request)
  {
    if ($request->search != '') {
      $query = Warranty::where('serial_no', $request->search)
        ->orWhere('tel', $request->search);
      $count = $query->count();
      $data = $query->get();
      return view('pages.warranty.search', ['data' => $data, 'count' => $count]);
    }
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {}

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'file' => 'required|image|mimes:jpeg,png,jpg|max:10048',
      'file2' => 'image|mimes:jpeg,png,jpg|max:10048',
      'file3' => 'image|mimes:jpeg,png,jpg|max:10048',
      'file4' => 'image|mimes:jpeg,png,jpg|max:10048',
      'file5' => 'image|mimes:jpeg,png,jpg|max:10048',
      'name' => 'required',
      'addr' => 'required',
      'tel' => 'required',
      'serial_no' => 'nullable|unique:warranties,serial_no',
      'order_channel' => 'required',
      'order_number' => 'required',
    ], [
      'unique' => 'หมายเลขซีเรียลได้ถูกนำไปใช้แล้ว'
    ]);

    // หาก serial_no ว่างเปล่า จะใช้ชื่อไฟล์ที่สร้างจาก uniqid() แทน
    $baseFilename = $request->serial_no ? $request->serial_no : 'warranty-' . uniqid();

    // สร้าง dir สำหรับเก็บไฟล์ (ถ้ายังไม่มี)
    $path = 'storage/img/warranty/';
    if (!File::isDirectory($path)) {
      File::makeDirectory($path, 0775, true);
    }

    $fileNames = [];
    $files = ['file', 'file2', 'file3', 'file4', 'file5'];
    foreach ($files as $index => $fileKey) {
      if ($request->hasFile($fileKey)) {
        $image = $request->file($fileKey);
        $extension = $image->getClientOriginalExtension();
        $filename = $baseFilename . ($index > 0 ? '_' . ($index + 1) : '') . '.' . $extension;

        Image::make($image)->save('storage/img/warranty/' . $filename, 60, 'jpg');
        $fileNames[$fileKey] = $filename;
      }
    }

    $warrantyData = $request->all();
    $warrantyData['file_name'] = $fileNames['file'] ?? '';
    $warrantyData['file_name2'] = $fileNames['file2'] ?? '';
    $warrantyData['file_name3'] = $fileNames['file3'] ?? '';
    $warrantyData['file_name4'] = $fileNames['file4'] ?? '';
    $warrantyData['file_name5'] = $fileNames['file5'] ?? '';

    unset($warrantyData['_token']);
    foreach ($files as $fileKey) {
      unset($warrantyData[$fileKey]);
    }

    Warranty::insert($warrantyData);

    return back()->with('success', 'You have successfully applied for a warranty.');
  }

  /**
   * Display the specified resource.
   */
  public function show(Warranty $warranty)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Warranty $warranty)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Warranty $warranty)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Warranty $warranty)
  {
    //
  }
}
