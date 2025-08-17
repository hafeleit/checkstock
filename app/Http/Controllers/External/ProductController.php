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
                    ->table('ZHWWBCQUERYDIR')
                    ->leftJoin('ZORDPOSKONV_ZPL', 'ZHWWBCQUERYDIR.Material', '=', 'ZORDPOSKONV_ZPL.Material')
                    ->leftJoin('MB52', 'ZHWWBCQUERYDIR.Material', '=', 'MB52.material')
                    ->where('ZHWWBCQUERYDIR.Material', request()->item_code)
                    ->where('MB52.storage_location', 'TH02')
                    ->select('ZHWWBCQUERYDIR.*', 'ZORDPOSKONV_ZPL.*', 'MB52.*')
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
