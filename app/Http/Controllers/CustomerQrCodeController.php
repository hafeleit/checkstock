<?php

namespace App\Http\Controllers;

use App\Exports\TemplateExport;
use App\Imports\CustomerQrCodeImport;
use App\Models\CustomerQrCode;
use App\Models\FileImportLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Milon\Barcode\DNS2D;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class CustomerQrCodeController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:qrcode view')->only(['index', 'generatePng']);
        $this->middleware('permission:qrcode create')->only(['create', 'store', 'generateQrCode', 'generatePdf']);
        $this->middleware('permission:qrcode import')->only(['import', 'exportTemplate']);
        $this->middleware('permission:qrcode delete')->only(['destroy']);
    }

    public function index()
    {
        $customers = CustomerQrCode::query()
            ->when(request()->search, function ($q) {
                $search = strtolower(request()->search);
                $q->whereRaw('LOWER(customer_name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(customer_code) LIKE ?', ["%{$search}%"]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('pages.customer-qrcode.index', [
            'customers' => $customers,
            'params' => request()->all()
        ]);
    }

    public function create()
    {
        return view('pages.customer-qrcode.create');
    }

    public function store()
    {
        request()->validate([
            'customer_name' => 'required|string|max:18',
            'customer_code' => 'required|string|max:18',
            'amount' => 'required|numeric',
            'payload' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            CustomerQrCode::create([
                'customer_name' => request()->customer_name,
                'customer_code' => request()->customer_code,
                'amount' => request()->amount,
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
        $ref2 = null;
        $amount = request()->input('amount', 0.00);

        $taxId = '0105537076950';
        $suffix = '00';
        $amount = (float) $amount;

        $payload = $this->generatePayload($taxId, $suffix, $ref1, $ref2, $amount);

        $qrCodeMarkup = QrCode::size(200)
            ->style('round')
            ->margin(1)
            ->generate($payload);

        return view('pages.customer-qrcode.create', [
            'qrCode' => $qrCodeMarkup,
            'customer_name' => $customerName,
            'customer_code' => $ref1,
            'amount' => $amount,
            'payload' => $payload
        ]);
    }

    public function generatePdf($id)
    {
        $customer = CustomerQrCode::findOrFail($id);
        $fileName = 'QR_Code_' . $customer->customer_code . '.pdf';

        $dns2d = new DNS2D();
        $qrBase64 = $dns2d->getBarcodePNG($customer->qr_payload, 'QRCODE', 10, 10);

        $pdf = PDF::loadView('pages.customer-qrcode.pdf', [
            'customer' => $customer,
            'qrCode' => $qrBase64,
        ]);

        return $pdf->stream($fileName);
    }

    public function generatePng($id)
    {
        $customer = CustomerQrCode::findOrFail($id);
        $dns2d = new DNS2D();

        $qrBase64 = $dns2d->getBarcodePNG($customer->qr_payload, 'QRCODE', 10, 10);
        $image = base64_decode($qrBase64);

        return response()->make($image, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="qr-' . $id . '.png"'
        ]);
    }

    public function destroy($id)
    {
        $customer = CustomerQrCode::findOrFail($id);
        $customer->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }

    public function import()
    {
        request()->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = request()->file('file');
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $fileImportLog = null;

        DB::beginTransaction();

        try {
            $fileImportLog = FileImportLog::create([
                'file_name'     => $fileName,
                'file_size'     => $fileSize,
                'type'          => 'customer_qr_code',
                'status'        => 'pending',
                'created_by'    => auth()->id()
            ]);

            Excel::import(new CustomerQrCodeImport($fileImportLog->id), request()->file('file'));
            $fileImportLog->update(['status' => 'processed']);

            DB::commit();
            return response()->json(['message' => 'Updated successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function exportTemplate()
    {
        $fileName = "Customer_QR_Code_Template" . now()->format('Ymd') . ".xlsx";

        return Excel::download(new TemplateExport('qr-code'), $fileName);
    }

    private function generatePayload($taxId, $suffix, $ref1, $ref2 = null, $amount)
    {
        // remove all whitespace characters
        $ref1 = preg_replace('/\s+/', '', $ref1);

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
