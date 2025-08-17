<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use App\Models\External\Product;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        if (!auth()->user()) {
            abort(404);
        }

        if (empty(request()->all()) || !is_array(request()->all())) {
            return view('external.products.index', [
                'date_now' => Carbon::now(),
                'user' => auth()->user(),
            ]);
        }

        //$product = Product::where('item_code', request()->item_code)->first();
        $product = DB::connection('external_mysql')
                    ->table('zhwwmm_mdm')
                    ->leftJoin('zpl', 'zhwwmm_mdm.Material', '=', 'zpl.Material')
                    ->leftJoin('mb52', 'zhwwmm_mdm.Material', '=', 'mb52.material')
                    ->where('zhwwmm_mdm.Material', request()->item_code)
                    ->where('mb52.storage_location', 'TH02')
                    ->select('zhwwmm_mdm.*', 'zpl.*', 'mb52.*')
                    ->first();


        if ($product) {
            return view('external.products.index', [
                'product' => $product,
                'searched' => true,
                'item_code' => request()->item_code,
                'date_now' => Carbon::now(),
                'user' => auth()->user(),
            ]);
        }

        return view('external.products.index', [
            'product' => null,
            'searched' => true,
            'item_code' => request()->item_code,
            'date_now' => Carbon::now(),
            'user' => auth()->user(),
        ]);
    }
}
