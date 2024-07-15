<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductPackCode;
use App\Models\ProductNewPriceList;
use Illuminate\Pagination\Paginator;
use DB;
use App\Exports\CheckStocHwwExport;
use App\Imports\ProductNewPriceListImport;
use Maatwebsite\Excel\Facades\Excel;

class CheckStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function __construct()
     {
         $this->middleware('permission:checkstockrsa view', ['only' => ['index']]);
     }

    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $paginate = $request->perpage ?? 5;

        $q = Product::where(function($query){
          $query->whereRaw("ITEM_STATUS IN ('8_PHASED OUT','9_OBSOLETE') AND (FREE_STOCK - PENDING_SO) > 0 ");
          $query->orWhereRaw("ITEM_STATUS NOT IN ('8_PHASED OUT','9_OBSOLETE')");
          $query->where('ITEM_TYPE','!=','3_PICK&PACK');
        })
        ->where('products.ITEM_TYPE','!=','3_PICK&PACK')
        ->where('ITEM_CODE','like','%'.$search.'%');

        $products = $q->paginate($paginate);

        return view('pages.checkstock.index', compact('products'));
    }

    public function export()
    {
        return Excel::download(new CheckStocHwwExport, 'CheckStockHWW.xlsx');
    }

    public function import(Request $request)
    {

        ProductNewPriceList::truncate();
        Excel::import(new ProductNewPriceListImport,request()->file('file'));

        return back()->with('succes','Import successfully');;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::where('products.id', $id)->leftJoin('product_new_price_lists','products.ITEM_CODE','product_new_price_lists.ITEM_CODE')
        ->select('products.*','product_new_price_lists.PRICE')
        ->first();

        //product orther
        $substr_item_code = substr($product->ITEM_CODE, 0,-1);
        $ppc = ProductPackCode::where('IP_ITEM_CODE',$product->ITEM_CODE)->get();
        $product_other = Product::where('ITEM_CODE','LIKE', $substr_item_code.'%')->paginate(20);

        return view('pages.checkstock.show',compact('product','product_other','ppc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
