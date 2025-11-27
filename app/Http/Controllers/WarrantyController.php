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
    request()->validate([
      'search' => 'required|string|max:50|regex:/^[a-z0-9\s\-\(\)\+]+$/i'
    ]);

    if ($request->search != '') {
      $query = Warranty::query()
        ->where('serial_no', $request->search)
        ->orWhere('tel', $request->search);

      $count = $query->count();
      $data = $query->get();

      return view('pages.warranty.search', ['data' => $data, 'count' => $count]);
    }
    return view('pages.warranty.search', ['data' => [], 'count' => 0]);
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
    $validatedData = $request->validate([
      'file' => 'required|image|mimes:jpeg,png,jpg|max:10048',
      'file2' => 'image|mimes:jpeg,png,jpg|max:10048',
      'file3' => 'image|mimes:jpeg,png,jpg|max:10048',
      'file4' => 'image|mimes:jpeg,png,jpg|max:10048',
      'file5' => 'image|mimes:jpeg,png,jpg|max:10048',
      'name' => 'required',
      'addr' => 'required',
      'tel' => 'required',
      'article_no' => 'required',
      'email' => 'nullable|email',
      'serial_no' => 'nullable|unique:warranties,serial_no',
      'order_channel' => 'required',
      'other_channel' => 'required_if:order_channel,other|nullable|string|max:255',
      'order_number' => 'required',
      'is_consent_policy' => 'required|in:true',
      'is_consent_marketing' => 'nullable|in:true,false',
    ], [
      'unique' => 'หมายเลขซีเรียลได้ถูกนำไปใช้แล้ว',
      'other_channel.required_if' => 'กรุณากรอกช่องทางการสั่งซื้ออื่นๆ',
      'is_consent_policy.in' => 'กรุณายอมรับเงื่อนไขเพื่อดำเนินการต่อ',
    ]);

    // หาก serial_no ว่างเปล่า จะใช้ชื่อไฟล์ที่สร้างจาก uniqid() แทน
    $baseFilename = $validatedData['serial_no'] ?? 'warranty-' . uniqid();

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
        $filename = $baseFilename . ($index > 0 ? '_' . ($index + 1) : '') . '.jpg';

        Image::make($image)->save($path . $filename, 60);
        $fileNames[$fileKey] = $filename;
      }
    }

    $warrantyData = array_merge($validatedData, [
      'is_consent_policy' => $validatedData['is_consent_policy'] == 'true' ? 'yes' : 'no',
      'is_consent_marketing' => request()->is_consent_marketing && $validatedData['is_consent_policy'] == 'true' ? 'yes' : 'no',
      'order_channel'  => $this->getChannelName($validatedData['order_channel']) ?? null,
      'file_name'  => $fileNames['file'] ?? null,
      'file_name2' => $fileNames['file2'] ?? null,
      'file_name3' => $fileNames['file3'] ?? null,
      'file_name4' => $fileNames['file4'] ?? null,
      'file_name5' => $fileNames['file5'] ?? null,
    ]);

    Warranty::create($warrantyData);

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

  private function getChannelName($channel)
  {
    switch ($channel) {
      case 'showroom':
        $message = 'โชว์รูม (Showroom)';
        break;
      case 'shopee':
        $message = 'ช้อปปี้ (Shopee Mall)';
        break;
      case 'lazada':
        $message = 'ลาซาด้า (Lazada Mall)';
        break;
      case 'website-hafele-home':
        $message = 'เว็บไซต์บริษัท (Website: Hafele Home)';
        break;
      case 'line-hafele-home':
        $message = 'LINE Official (LINE: Hafele Home)';
        break;
      case 'modern-trade':
        $message = 'ห้างโมเดิร์นเทรด (Modern Trade)';
        break;
      case 'dealer':
        $message = 'ร้านค้าวัสดุ / ร้านตัวแทนจำหน่าย (Dealer)';
        break;
      case 'project-contractor':
        $message = 'เซลล์โครงการ / งานโครงการ (Project) / ผู้รับเหมา (Contractor)';
        break;
      case 'other':
        $message = 'อื่นๆ (Other)';
        break;

      default:
        $message = null;
        break;
    }

    return $message;
  }
}
