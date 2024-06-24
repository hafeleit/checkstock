<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductPackCode;

class CheckStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $paginate = $request->perpage ?? 5;
        $q = Product::where('ITEM_CODE','like','%'.$search.'%')
              ->orWhere('ITEM_NAME','like','%'.$search.'%');
        $products = $q->paginate($paginate);
        return view('pages.checkstock.index', compact('products'));
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
        $product = Product::where('id', $id)->first();

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
