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
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $paginate = $request->perpage ?? 5;


        /*$q = Product::where(function($query){
          $query->whereRaw("ITEM_STATUS IN ('8_PHASED OUT','9_OBSOLETE') AND (FREE_STOCK - PENDING_SO) > 0 ");
          $query->orWhereRaw("ITEM_STATUS NOT IN ('8_PHASED OUT','9_OBSOLETE')");
          $query->where('ITEM_TYPE','!=','3_PICK&PACK');
        })->where('ITEM_CODE','like','%'.$search.'%');*/

        $products = Product::where(function($query){
          $query->whereRaw("products.ITEM_STATUS IN ('8_PHASED OUT','9_OBSOLETE') AND (products.FREE_STOCK - products.PENDING_SO) > 0 ");
          $query->orWhereRaw("products.ITEM_STATUS NOT IN ('8_PHASED OUT','9_OBSOLETE')");
          //$query
        })->leftJoin('product_new_price_lists','product_new_price_lists.ITEM_CODE','products.ITEM_CODE')
          ->selectRaw("
            products.ID,
            products.ITEM_CODE,
          	products.ITEM_NAME,
          	products.ITEM_UOM_CODE,
          	CASE
          		WHEN products.ITEM_STATUS = '1_NEW' THEN 'Active'
          		WHEN products.ITEM_STATUS = '2_ACTIVE' THEN 'Active'
          		WHEN products.ITEM_STATUS = '3_INACTIVE' THEN 'Active'
          		ELSE 'Discontinued'
          	END AS Material_Status,
          	CASE
          		WHEN products.ITEM_INVENTORY_CODE = 'STOCK' THEN 'Stock'
          		ELSE 'Non-stock'
          	END AS Inventory_type,
          	(products.FREE_STOCK - products.PENDING_SO) AS Free_stock,

            CASE
          		WHEN product_new_price_lists.PRICE != '' THEN ROUND(product_new_price_lists.PRICE,2)
              WHEN products.CURRWAC + ((products.CURRWAC / 100) * 12 ) > 0 THEN ROUND(products.CURRWAC + ((products.CURRWAC / 100) * 12 ),2)
		          ELSE 'Please check with HTH'
          	END AS Estimated_tranfer_price,

            CASE
          		WHEN product_new_price_lists.PRICE != '' THEN ROUND((product_new_price_lists.PRICE/".env('USD', 0)."),4)
              WHEN products.CURRWAC + ((products.CURRWAC / 100) * 12 ) > 0 THEN ROUND((products.CURRWAC + ((products.CURRWAC / 100) * 12 )) / ".env('USD', 0).",4)
		          ELSE 'Please check with HTH'
          	END AS Estimated_tranfer_price_usd,

          	CASE
          		WHEN products.ITEM_TYPE = '0_NORMAL' THEN products.ITEM_REPL_TIME
          		ELSE 'Check with HTH'
          	END AS Supplier_lead_time,
            CASE
          		WHEN products.ITEM_TYPE = '0_NORMAL' THEN products.MOQ
          		ELSE 'Check with HTH'
          	END AS Moq,
          	products.ITEM_REMARK
          ")
          ->where('products.ITEM_TYPE','!=','3_PICK&PACK')
          ->where('products.ITEM_CODE','like','%'.$search.'%')
          ->limit(5)
          //->paginate($paginate);
          ->get();
          //dd($products);
        //$products = $q->paginate($paginate);

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
