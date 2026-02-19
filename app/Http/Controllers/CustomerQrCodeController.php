<?php

namespace App\Http\Controllers;

use App\Models\CustomerQrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CustomerQrCodeController extends Controller
{
    public function index()
    {
        // $customers = ::orderBy('created_at', 'desc')->get();

        // -------- Mock data -------- //
        $MockCustomers = collect([
            new CustomerQrCode([
                'id' => 1,
                'customer_name' => 'Flynn Joyner',
                'customer_code' => '0999999999',
                'qr_payload' => '|0105537076950000000000009999999990000000000000000000000000000',
                'created_date' => now()
            ]),
            new CustomerQrCode([
                'id' => 2,
                'customer_name' => 'Colorado Vazquez',
                'customer_code' => '0123123123',
                'qr_payload' => '|0105537076950000000001231231231230000000000000000000000000000',
                'created_date' => now()->subDay()
            ])
        ]);
        // ---------------------------- //

        return view('pages.customer-qrcode.index', [
            'customers' => $MockCustomers
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
        // $customer = CustomerQrCode::findOrFail($id);

        // -------- Mock data -------- //
        $mockData = [
            1 => [
                'customer_name' => 'Flynn Joyner',
                'customer_code' => '0999999999',
                'qr_payload' => '|0105537076950000000000009999999990000000000000000000000000000'
            ],
            2 => [
                'customer_name' => 'Colorado Vazquez',
                'customer_code' => '0123123123',
                'qr_payload' => '|0105537076950000000001231231231230000000000000000000000000000'
            ]
        ];

        $data = $mockData[$id] ?? [
            'customer_name' => 'Guest User',
            'customer_code' => '0000000000'
        ];

        $customer = new CustomerQrCode();
        $customer->customer_name = $data['customer_name'];
        $customer->customer_code = $data['customer_code'];
        $customer->qr_payload = $data['qr_payload'];
        // ---------------------------- //

        $fileName = 'QR_Code_' . $customer->customer_code . '.pdf';

        $image = QrCode::format('png')
            ->size(250)
            ->margin(0)
            ->generate($customer->qr_payload);

        $base64Qr = 'data:image/png;base64,' . base64_encode($image);

        $pdf = Pdf::loadView('pages.customer-qrcode.pdf', [
            'customer' => $customer,
            'qrCode' => $base64Qr
        ]);

        $pdf->setPaper('a4', 'portrait')
            ->setOption([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'title' => $fileName
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
