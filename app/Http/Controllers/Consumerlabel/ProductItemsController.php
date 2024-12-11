<?php

namespace App\Http\Controllers\Consumerlabel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductItem;
use Auth;
use PDF;
use DB;
class ProductItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
       $this->middleware('permission:consumerlabel view', ['only' => ['index','show']]);
       $this->middleware('permission:consumerlabel create', ['only' => ['create','store']]);
       $this->middleware('permission:consumerlabel update', ['only' => ['update','edit']]);
       $this->middleware('permission:consumerlabel delete', ['only' => ['destroy']]);
    }

    public function pdfbarcode(Request $request){

      $limit_product_name = 200;
      $productItems = ProductItem::where('item_code', $request->item_code)
                      //->select(DB::raw("product_items.*, CONCAT(SUBSTRING(product_items.product_name, 1, $limit_product_name), '...') AS product_name"))
                      ->first();

      if($request->man_date != ''){
        $productItems['man_date'] = date('d/m/Y', strtotime($request->man_date));
      }

      switch ($request->barcode_type) {
        case '1pc':
          $pdf = PDF::loadView('pdf.barcode', ['productItems' => $productItems]);
          $pdf->setPaper('A4');
          break;
        case 'a4':
          $pdf = PDF::loadView('pdf.barcode_a4', ['productItems' => $productItems]);
          $pdf->setPaper('A4');
          break;
        case 'a4_nob':
          $pdf = PDF::loadView('pdf.barcode_a4_nob', ['productItems' => $productItems]);
          $pdf->setPaper('A4');
          break;
        case 'tis':
          //return view('pdf.barcode_tis', ['productItems' => $productItems]);
          $pdf = PDF::loadView('pdf.barcode_tis', ['productItems' => $productItems]);
          $customPaper = array(0,0,282,202);
          $pdf->setPaper($customPaper);
          break;
        case 'tis2':
          $pdf = PDF::loadView('pdf.barcode_tis2', ['productItems' => $productItems]);
          $customPaper = array(0,0,304,440);
          $pdf->setPaper($customPaper);
          break;
        default:
          break;
      }

      //$customPaper = array(0,0,360,360);
      //$dompdf->setPaper($customPaper);
      //$pdf->setPaper('A4');
      //return $pdf->download('barcode.pdf');
      return $pdf->stream($request->item_code.".pdf");

    }

    public function index(Request $request)
    {
        $supp_code = Auth::user()->supp_code ?? '';
        $search = $request->search ?? '';
        $paginate = $request->perpage ?? 25;
        $q = ProductItem::where('item_code','like','%'.$search.'%');
        if($supp_code != ''){
          $q->join('supplier_items','product_items.item_code','supplier_items.sai_si_item_code')->where('sai_sa_supp_code',$supp_code);
        }
        $productitems = $q->select('product_items.*')->paginate($paginate);

        return view('pages.consumerlabel.productitems.index', compact('productitems'));
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
    public function show(string $id)
    {
        $productitem = ProductItem::find($id);
        return view('pages.consumerlabel.productitems.show',compact('productitem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $productitem = ProductItem::where('id',$id)->first();
        return view('pages.consumerlabel.productitems.edit',compact('productitem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $productitems = ProductItem::findOrFail($id);
        $productitems->update($request->all());
        return redirect()->route('product-items.edit',$id)->with('success','Product Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
