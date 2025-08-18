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
        $last_update = Carbon::now()->subDay()->setHour(20)->setMinute(0)->setSecond(0);
        if (empty(request()->all()) || !is_array(request()->all())) {
            return view('external.products.index', [
                'date_now' => Carbon::now(),
                'user' => auth()->user(),
                'last_update' => $last_update
            ]);
        }

        //$product = Product::where('item_code', request()->item_code)->first();
        $product = DB::connection('external_mysql')
            ->table('ZHWWBCQUERYDIR')
            ->leftJoin('ZORDPOSKONV_ZPL', 'ZHWWBCQUERYDIR.Material', '=', 'ZORDPOSKONV_ZPL.Material')
            ->leftJoin('MB52', function ($join) {
                $join->on('ZHWWBCQUERYDIR.Material', '=', 'MB52.material')
                    ->where('MB52.storage_location', '=', 'TH02');
            })
            ->where('ZHWWBCQUERYDIR.Material', request()->item_code)
            ->select(
                'ZHWWBCQUERYDIR.Material',
                'ZHWWBCQUERYDIR.kurztext',
                DB::raw('ZORDPOSKONV_ZPL.Amount / NULLIF(ZORDPOSKONV_ZPL.per, 0) AS Amount'),
                'MB52.unrestricted',
                'ZHWWBCQUERYDIR.bun',
            )
            ->first();

        if ($product) {
            return view('external.products.index', [
                'product' => $product,
                'searched' => true,
                'item_code' => request()->item_code,
                'date_now' => Carbon::now(),
                'user' => auth()->user(),
                'last_update' => $last_update
            ]);
        }

        return view('external.products.index', [
            'product' => null,
            'searched' => true,
            'item_code' => request()->item_code,
            'date_now' => Carbon::now(),
            'user' => auth()->user(),
            'last_update' => $last_update
        ]);
    }
}
