<?php

namespace App\Http\Controllers;

use App\Exports\WarrantyExport;
use App\Models\Warranty;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Image;
use Maatwebsite\Excel\Facades\Excel;

class WarrantyController extends Controller
{
  public function __construct()
  {
    $this->middleware('permission:warranty view list', ['only' => ['warrantyList']]);
    $this->middleware('permission:warranty export', ['only' => ['warrantyExport']]);
    $this->middleware('permission:warranty edit', ['only' => ['warrantyEdit', 'update']]);
  }

  public function index()
  {
    return view('pages.warranty.index');
  }

  public function checkWarranty(Request $request)
  {
    $results = null;
    $searched = false;

    if ($request->filled('search')) {
      $searched = true;
      $search = trim($request->search);
      $results = Warranty::query()
        ->where('tel', $search)
        ->orWhere('serial_no', $search)
        ->orWhere('order_number', $search)
        ->orWhere('name', 'like', '%' . $search . '%')
        ->latest()
        ->get();
    }

    return view('pages.warranty.check', compact('results', 'searched'));
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

  public function warrantyList(Request $request)
  {
    $warranties = Warranty::query()
      ->when($request->filled('name'), function ($query) use ($request) {
        $query->where('name', 'like', '%' . trim($request->name) . '%');
      })
      ->when($request->filled('tel'), function ($query) use ($request) {
        $query->where('tel', trim($request->tel));
      })
      ->when($request->filled('serial_no'), function ($query) use ($request) {
        $query->where('serial_no', trim($request->serial_no));
      })
      ->when($request->filled('order_number'), function ($query) use ($request) {
        $query->where('order_number', trim($request->order_number));
      })
      ->latest()
      ->paginate(10)
      ->withQueryString();

    return view('pages.warranty.list', [
      'warranties' => $warranties,
      'filters' => $request->only(['name', 'tel', 'serial_no', 'order_number']),
    ]);
  }

  public function warrantyExport(Request $request)
  {
    $filters = $request->only(['name', 'tel', 'serial_no', 'order_number']);
    $fileName = 'warranties_' . now()->format('Ymd_His') . '.xlsx';

    $download = Excel::download(new WarrantyExport($filters), $fileName);

    AuditLog::create([
      'user_id'        => auth()->id(),
      'event'          => 'exported',
      'auditable_type' => 'warranty',
      'auditable_id'   => 0,
      'status'         => 'pass',
      'new_values'     => json_encode(array_filter($filters) ?: null),
      'file_name'      => $fileName,
    ]);

    return $download;
  }

  public function warrantyEdit(Warranty $warranty)
  {
    return view('pages.warranty.edit', compact('warranty'));
  }

  public function update(Request $request, Warranty $warranty)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'tel' => 'required|string|max:20',
      'email' => 'nullable|email|max:255',
      'addr' => 'required|string',
      'article_no' => 'required|string|max:100',
      'serial_no' => 'nullable|string|max:100|unique:warranties,serial_no,' . $warranty->id,
      'order_number' => 'required|string|max:100',
      'order_channel' => 'required|string|max:255',
    ], [
      'serial_no.unique' => 'Serial No. has already been taken.',
    ]);

    $fields = ['name', 'tel', 'email', 'addr', 'article_no', 'serial_no', 'order_number', 'order_channel'];
    $oldValues = $warranty->only($fields);

    try {
      \DB::beginTransaction();

      Warranty::where('id', $warranty->id)->update(
        array_merge($request->only($fields), ['updated_by' => auth()->id()])
      );

      AuditLog::create([
        'user_id'        => auth()->id(),
        'event'          => 'updated',
        'auditable_type' => 'warranty',
        'auditable_id'   => $warranty->id,
        'status'         => 'pass',
        'old_values'     => json_encode($oldValues),
        'new_values'     => json_encode($request->only($fields)),
      ]);

      \DB::commit();
      return redirect()->route('warranty.list')->with('updated', 'Warranty record has been updated successfully.');
    } catch (\Throwable $th) {
      \DB::rollBack();
      return back()->withErrors('An error occurred while updating the warranty record. Please try again.');
    }
  }

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
      'file.required' => 'กรุณาอัปโหลดไฟล์รูปภาพ',
      'name.required' => 'กรุณากรอกชื่อ-นามสกุล',
      'addr.required' => 'กรุณากรอกที่อยู่',
      'tel.required' => 'กรุณากรอกเบอร์โทรศัพท์',
      'article_no.required' => 'กรุณากรอกรหัสสินค้า (Article No.)',
      'order_channel.required' => 'กรุณาเลือกช่องทางการสั่งซื้อ',
      'order_number.required' => 'กรุณากรอกหมายเลขคำสั่งซื้อ',
      'unique' => 'หมายเลขซีเรียลได้ถูกนำไปใช้แล้ว',
      'other_channel.required_if' => 'กรุณากรอกช่องทางการสั่งซื้ออื่นๆ',
      'is_consent_policy.in' => 'กรุณายอมรับเงื่อนไขเพื่อดำเนินการต่อ',
      'is_consent_policy.required' => 'กรุณายอมรับเงื่อนไขเพื่อดำเนินการต่อ'
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
      'order_channel' => $this->getChannelName($validatedData['order_channel']) ?? null,
      'file_name' => $fileNames['file'] ?? null,
      'file_name2' => $fileNames['file2'] ?? null,
      'file_name3' => $fileNames['file3'] ?? null,
      'file_name4' => $fileNames['file4'] ?? null,
      'file_name5' => $fileNames['file5'] ?? null,
      'updated_by' => auth()->id(),
    ]);

    Warranty::create($warrantyData);

    return back()->with('success', 'You have successfully applied for a warranty.');
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
