<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
      $paginate = 20;
      $query = new Product();

      if($request->search != ''){
        $query = $query->where('item_code','like','%'.$request->search.'%');
        $query = $query->orWhere('item_name','like','%'.$request->search.'%');
        $products = $query->paginate($paginate);
        return view('pages.products.search',compact('products'))
                    ->with('i', (request()->input('page', 1) - 1) * $paginate);
      }

      $products = $query->paginate($paginate);
      return view('pages.products.index',compact('products'))
                  ->with('i', (request()->input('page', 1) - 1) * $paginate);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('pages.products.create');
    }

    public function search_ajax(Request $request)
    {
      if ($request->search != '') {
          $products = Product::where('item_code', 'like', '%' . $request->search . '%')->paginate(20);
      } else {
          $products = Product::latest()->paginate(20);
      }
      return view('pages.products.search')->with('products', $products);
    }

    public function import()
    {
        ini_set('max_execution_time', 0); // 0 = Unlimited

        Excel::import(new ProductsImport,request()->file('file'));

        return redirect()->back()->with('message', 'IMPORT SUCCESS');
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
    public function show($product)
    {
        $product = Product::where('item_code',$product)->first();
        return view('pages.products.detail',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
