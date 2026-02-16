<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phumin\PromptParse\Generate\PromptPay;
use phumin\PromptParse\Parser;
use PromptPayQR\Builder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentController extends Controller
{
    public function generatePaymentQR(Request $request)
    {
        $amount = 1;
        $ref1   = "Customer Code";
        $ref2   = "Order Type";

        $billerIds = [
            'kbank' => '010553707695000',
        ];

        $ref1 = substr(preg_replace('/[^A-Za-z0-9]/', '', strtoupper($ref1)), 0, 20);
        $ref2 = substr(preg_replace('/[^A-Za-z0-9]/', '', strtoupper($ref2)), 0, 20);

        $targetBank = 'kbank';
        $billerId   = $billerIds[$targetBank];

        // ── Lib 1 : phumin/PromptParse ──────────────────────────────────────────
        $payload1  = PromptPay::billPayment($billerId, $ref1, $ref2, null, $amount);
        $svg1      = QrCode::format('svg')->size(300)->generate($payload1);
        $qrImage1  = 'data:image/svg+xml;base64,' . base64_encode($svg1);

        // ── Lib 2 : PromptPayQR/Builder ─────────────────────────────────────────
        $payload2  = Builder::dynamicQR()
                        ->billPayment()
                        ->setBillerIdentifier($billerId, $ref1, $ref2)
                        ->setAmount($amount)
                        ->build();
        $svg2      = QrCode::format('svg')->size(300)->generate($payload2);
        $qrImage2  = 'data:image/svg+xml;base64,' . base64_encode($svg2);

        return view('pages.payment.show', [
            'ref1'      => $ref1,
            'ref2'      => $ref2,
            'amount'    => $amount,
            // QR ชุดที่ 1 (phumin/PromptParse)
            'qrImage1'  => $qrImage1,
            'payload1'  => $payload1,
            // QR ชุดที่ 2 (PromptPayQR/Builder)
            'qrImage2'  => $qrImage2,
            'payload2'  => $payload2,
        ]);
        // $amount = 1;
        // $ref1 = "Customer Code";
        // $ref2 = "Order Type";
        
        // $billerIds = [
        //     'kbank'     => '010553707695000',
        // ];

        // $ref1 = substr(preg_replace('/[^A-Za-z0-9]/', '', strtoupper($ref1)), 0, 20);
        // $ref2 = substr(preg_replace('/[^A-Za-z0-9]/', '', strtoupper($ref2)), 0, 20);

        // $targetBank = 'kbank';
        // $billerId = $billerIds[$targetBank];

        // // Lib 1
        // $payload = PromptPay::billPayment($billerId, $ref1, $ref2, null, $amount);

        // // Lib 2
        // $payload2 = Builder::dynamicQR()
        //     ->billPayment()
        //     ->setBillerIdentifier($billerId, $ref1, $ref2)
        //     ->setAmount($amount)
        //     ->build();

        // // 1
        // $qrCode = QrCode::format('svg')->size(300)->generate($payload);
        // $base64Image = 'data:image/svg+xml;base64,' . base64_encode($qrCode);
        // // $base64Image = 'data:image/svg+xml;base64,' . base64_encode($qrCode);

        // // |0105537076950003925061359210008885822681732

        // // 2
        // // $qrCode2 = QrCode::format('svg')
        // //     ->size(300)
        // //     ->generate($payload2);

        // $qrCode2 = Builder::dynamicQR()->billPayment()
        //     ->setBillerIdentifier('099400015804189', 'Ref1', 'Ref2')
        //     ->setAmount(1999.99)->build();

        // // Generate QR Code SVG string
        // $svgString = Builder::staticMerchantPresentedQR('1-2345-67890-12-3')->toSvgString();
        // // Laravel example: respond with header Content-Type: image/svg+xml
        // $test = $this->svgQr($svgString);
        // dd($test);

        // $base64Image2 = 'data:image/svg+xml;base64,' . base64_encode($qrCode2);

        // return view('pages.payment.show', [
        //     'ref1' => $ref1,
        //     'ref2' => $ref2,
        //     'amount' => $amount,
        //     'base64Image' =>$base64Image,
        //     'base64Image2' =>$base64Image2
        // ]);
    }

    private function svgQr($svgStr)
    {
        return response($svgStr, 200)->header('Content-Type', 'image/svg+xml')->header('Cache-Control', 'no-store');
    }
}
