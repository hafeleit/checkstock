<?php

namespace App\Http\Controllers;

use App\Models\CustomerQrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CustomerQrCodeController extends Controller
{
    public function index()
    {
        $customers = CustomerQrCode::orderBy('created_at', 'desc')->get();

        return view('pages.customer-qrcode.index', [
            'customers' => $customers
        ]);
    }

    public function create()
    {
        return view('pages.customer-qrcode.create');
    }

    public function store()
    {
        request()->validate([
            'customer_name' => 'required|string',
            'customer_code' => 'required|string',
            'payload' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            CustomerQrCode::create([
                'customer_name' => request()->customer_name,
                'customer_code' => request()->customer_code,
                'qr_payload' => request()->payload,
                'created_date' => Carbon::now(),
                'created_by' => auth()->id()
            ]);

            DB::commit();
            return response()->json(['message' => 'Updated successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function generateQrCode()
    {
        $customerName = request()->input('customer_name');
        $ref1 = request()->input('customer_code');

        // ข้อมูล Bill payment
        $taxId = '0105537076950';
        $suffix = '00';
        $ref2 = null;
        $amount = 0.00;

        // สร้าง Payload 62 หลัก
        $payload = $this->generatePayload($taxId, $suffix, $ref1, $ref2, $amount);

        // สร้าง QR Code
        $qrCode = QrCode::size(200)
            ->style('round')
            ->margin(1)
            ->generate($payload);

        return view('pages.customer-qrcode.create', [
            'qrCode' => $qrCode,
            'customer_name' => $customerName,
            'customer_code' => $ref1,
            'payload' => $payload
        ]);
    }

    public function generatePdf($id)
    {
        $customer = CustomerQrCode::findOrFail($id);

        $fileName = 'QR_Code_' . $customer->customer_code . '.pdf';
        $tempImageName = 'qr_' . $customer->customer_code . '.png';
        $tempPath = 'tmp/' . $tempImageName;

        // Generate QR Code as PNG
        $image = QrCode::format('png')
            ->size(250)
            ->margin(0)
            ->generate($customer->qr_payload);

        // Save temporary image to public disk
        Storage::disk('public')->put($tempPath, $image);

        // absolute path
        $fullPath = storage_path('app/public/' . $tempPath);

        // Configure and load PDF view
        $pdf = Pdf::setOption([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'chroot' => storage_path('app/public')
        ])
        ->loadView('pages.customer-qrcode.pdf', [
            'customer' => $customer,
            'qrCode' => base64_encode($image),
            'path' => $fullPath,
        ]);

        return $pdf->stream($fileName);
    }

    private function generatePayload($taxId, $suffix, $ref1, $ref2, $amount)
    {
        // 1. Prefix: 1 หลัก
        $prefix = "|";

        // 2. TAX ID + Suffix: 13 + 2 หลัก + CR
        $taxIdFormatted = str_pad($taxId, 13, "0", STR_PAD_LEFT);
        $suffixFormatted = str_pad($suffix, 2, "0", STR_PAD_LEFT);
        $field2 = $taxIdFormatted . $suffixFormatted . "\r";

        // 3. Reference No.1: 18 หลัก (สูงสุด) + CR
        $field3 = str_pad(substr($ref1, 0, 18), 18, "0", STR_PAD_LEFT) . "\r";

        // 4. Reference No.2: 18 หลัก (สูงสุด) + CR
        $field4 = str_pad(substr($ref2, 0, 18), 18, "0", STR_PAD_LEFT) . "\r";

        // 5. Amount: 10 หลัก
        $amountInSatangs = number_format($amount, 2, '', '');
        $field5 = str_pad($amountInSatangs, 10, "0", STR_PAD_LEFT);

        return $prefix . $field2 . $field3 . $field4 . $field5;
    }
}
