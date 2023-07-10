<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
      $paginate = 20;
      $query = new Product();
      $products = $query->inRandomOrder()->limit(100)->get();
      return view('pages.products.index',compact('products'))
                  ->with('i', (request()->input('page', 1) - 1) * $paginate);

    }

    public function sync_products(){
      exit;
      ini_set('max_execution_time', 0); // 0 = Unlimited
      try {

        $filename = storage_path('/csv/ONLINE_PRODUCT.csv');
        $file = fopen($filename, "r");
        $all_data = array();
        $num = 0;

        while ( ($data = fgetcsv($file, 200, ",")) !==FALSE ) {

            if($num == 0){
                $num++;
            }
            else{
                $all_data[] =
                  [
                    'ITEM_CODE' => $data[0],
                    'ITEM_NAME' => $data[1],
                    'ITEM_STATUS' => $data[2],
                    'ITEM_INVENTORY_CODE' => $data[3],
                    'ITEM_REPL_TIME' => $data[4],
                    'ITEM_GRADE_CODE_1' => $data[5],
                    'ITEM_UOM_CODE' => $data[6],
                    'STOCK_IN_HAND' => $data[7],
                    'AVAILABLE_STOCK' => $data[8],
                    'PENDING_SO' => $data[9],
                    'PROJECT_ITEM' => $data[10],
                    'RATE' => $data[11],
                    'NEW_ITEM' => $data[12],
                  ];
            }
        }

        DB::beginTransaction();

        Product::query()->delete();
        Product::insert($all_data);

        DB::commit();

        return "Success";

      } catch (\Exception $e) {
          DB::rollback();
          return $e->getMessage();
      }

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

        $query = new Product();

        $query = $query->where('item_code','like','%'.$request->search.'%');
        $query = $query->orWhere('item_name','like','%'.$request->search.'%');
        //$products = $query->paginate($paginate);
        $products = $query->limit(100)->get();
        return view('pages.products.search',compact('products'));


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
        $product = Product::where('item_code',$product)->get();
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
