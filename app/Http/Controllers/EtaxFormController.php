<?php

namespace App\Http\Controllers;

use App\Models\ETaxForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EtaxFormController extends Controller
{
    public function index()
    {
        return view('pages.e_tax.form');
    }

    public function store()
    {
        try {
            request()->validate([
                'purchase_channel' => 'required|string|max:255',
                'other_channel' => 'nullable|string|max:255',
                'order_refs' => 'required|array',
                'order_refs.*' => 'required|string',
                'customer_name' => 'required|string|max:255',
                'phone' => 'required|string|max:10|regex:/^0[0-9]{9}$/',
                'tax_id' => 'required|string|max:13',
                'branch_id' => 'nullable|string|max:5',
                'email' => 'required|string|email|max:255',
                'address_line1' => 'required|string|max:255',
                'address_line2' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'zip_code' => 'required|string|max:5',
                'shipping_address_same' => 'required|string|in:yes,no',
                'shipping_address_line1' => 'nullable|string|max:255',
                'shipping_address_line2' => 'nullable|string|max:255',
                'shipping_province' => 'nullable|string|max:255',
                'shipping_zip_code' => 'nullable|string|max:5',
                'pdpa_consent' => 'required|string',
            ]);

            // DB::transaction(function() {
            //     foreach (request()->order_refs as $ref) {
            //         ETaxForm::create([
            //             'purchase_channel' => request()->purchase_channel,
            //             'other_channel' => request()->purchase_channel === "Other" ? request()->other_channel : null,
            //             'order_ref' => $ref,
            //             'customer_name' => request()->customer_name,
            //             'phone' => request()->phone,
            //             'tax_id' => request()->tax_id,
            //             'branch_id' => request()->branch_id ?? "00000",
            //             'email' => request()->email,
            //             'address_line1' => request()->address_line1,
            //             'address_line2' => request()->address_line2,
            //             'province' => request()->province,
            //             'zip_code' => request()->zip_code,
            //             'shipping_address_same' => request()->shipping_address_same,
            //             'shipping_address_line1' => request()->shipping_address_same === "no" ? request()->shipping_address_line1 : null,
            //             'shipping_address_line2' => request()->shipping_address_same === "no" ? request()->shipping_address_line2 : null,
            //             'shipping_province' => request()->shipping_address_same === "no" ? request()->shipping_province : null,
            //             'shipping_zip_code' => request()->shipping_address_same === "no" ? request()->shipping_zip_code : null,
            //             'pdpa_consent' => true,
            //         ]);
            //     }
            // });

            return redirect()->back()->with('success', 'แบบฟอร์มถูกส่งเรียบร้อยแล้ว');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการส่งข้อมูล');
        }
    }
}
