<?php

namespace App\Http\Controllers\Consumerlabel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductItem;
use App\Models\CMLColour;
use App\Models\CMLCountryCode;
use App\Models\CMLDefrosting;
use App\Models\CMLMethod;
use App\Models\CMLSuggestion;
use App\Models\CMLWarning;
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
    $this->middleware('permission:consumerlabel view', ['only' => ['index', 'show']]);
    $this->middleware('permission:consumerlabel create', ['only' => ['create', 'store']]);
    $this->middleware('permission:consumerlabel update', ['only' => ['update', 'edit']]);
    $this->middleware('permission:consumerlabel delete', ['only' => ['destroy']]);
  }

  public function pdfbarcode(Request $request)
  {

    $limit_product_name = 200;
    $productItems = ProductItem::where('item_code', $request->item_code)
      ->leftJoin('cml_suggestions', 'cml_suggestions.suggestion_code', 'product_items.suggest_text')
      ->leftJoin('cml_warnings', 'cml_warnings.warning_code', 'product_items.warning_text')
      ->leftJoin('cml_methods', 'cml_methods.method_code', 'product_items.how_to_text')
      ->leftJoin('cml_defrostings', 'cml_defrostings.defrosting_code', 'product_items.defrosting')
      ->leftJoin('cml_country_codes', 'cml_country_codes.country_code', 'product_items.country_code')
      ->leftJoin('cml_colours', 'cml_colours.colour_code', 'product_items.color')
      ->select(
        'product_items.*',
        'product_items.made_by as made_by2',
        'cml_suggestions.suggestion_description AS suggest_text',
        'cml_warnings.warning_description AS warning_text',
        'cml_methods.method_description AS how_to_text',
        'cml_defrostings.defrosting_description as defrosting',
        'cml_country_codes.country_name_in_thai as country_code',
        'cml_colours.colour_code as colour_code',
        'cml_country_codes.country_name_in_thai as made_by',
      )
      //->select(DB::raw("product_items.*, CONCAT(SUBSTRING(product_items.product_name, 1, $limit_product_name), '...') AS product_name"))
      ->first();

    if ($request->man_date != '') {
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
      case 'pair':
        //return view('pdf.barcode_pair', ['productItems' => $productItems]);
        $pdf = PDF::loadView('pdf.barcode_pair', ['productItems' => $productItems]);
        //$customPaper = array(0,0,440,500);
        $customPaper = array(0, 0, 440, 400);
        $pdf->setPaper($customPaper);
        break;
      case 'tis':
        //return view('pdf.barcode_tis', ['productItems' => $productItems]);
        $pdf = PDF::loadView('pdf.barcode_tis', ['productItems' => $productItems]);
        //$customPaper = array(0,0,282,302);
        $customPaper = array(0, 0, 282, 202);
        $pdf->setPaper($customPaper);
        break;
      case 'tis2':
        $pdf = PDF::loadView('pdf.barcode_tis2', ['productItems' => $productItems]);
        $customPaper = array(0, 0, 304, 440);
        $pdf->setPaper($customPaper);
        break;
      default:
        break;
    }

    //$customPaper = array(0,0,360,360);
    //$dompdf->setPaper($customPaper);
    //$pdf->setPaper('A4');
    //return $pdf->download('barcode.pdf');
    return $pdf->stream($request->item_code . ".pdf");
  }

  public function index(Request $request)
  {
    $supp_code = Auth::user()->supp_code ?? '';
    $search = $request->search ?? '';
    $paginate = $request->perpage ?? 25;
    $q = ProductItem::where('item_code', 'like', '%' . $search . '%');
    if ($supp_code != '') {
      //$q->join('supplier_items','product_items.item_code','supplier_items.sai_si_item_code')->where('sai_sa_supp_code',$supp_code);
      $q->where('supplier_code', $supp_code);
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
    //$productitem = ProductItem::find($id)
    $productitem = ProductItem::leftJoin('cml_suggestions', 'cml_suggestions.suggestion_code', 'product_items.suggest_text')
      ->leftJoin('cml_warnings', 'cml_warnings.warning_code', 'product_items.warning_text')
      ->leftJoin('cml_methods', 'cml_methods.method_code', 'product_items.how_to_text')
      ->leftJoin('cml_defrostings', 'cml_defrostings.defrosting_code', 'product_items.defrosting')
      ->leftJoin('cml_country_codes', 'cml_country_codes.country_code', 'product_items.country_code')
      ->leftJoin('cml_colours', 'cml_colours.colour_code', 'product_items.color')
      ->select(
        'product_items.*',
        'cml_suggestions.suggestion_description AS suggest_text',
        'cml_warnings.warning_description AS warning_text',
        'cml_methods.method_description AS how_to_text',
        'cml_defrostings.defrosting_description as defrosting',
        'cml_country_codes.country_name_in_thai as country_code',
        'cml_colours.colour_description as colour_code',
      )
      ->where('product_items.id', $id)
      ->first();
    return view('pages.consumerlabel.productitems.show', compact('productitem'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $productitem = ProductItem::where('id', $id)->first();
    $colors = CMLColour::All();
    $countrycodes = CMLCountryCode::All();
    $defrostings = CMLDefrosting::All();
    $methods = CMLMethod::All();
    $suggestions = CMLSuggestion::All();
    $warnings = CMLWarning::All();

    return view('pages.consumerlabel.productitems.edit', compact('productitem', 'colors', 'countrycodes', 'defrostings', 'methods', 'suggestions', 'warnings'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $request['status'] = ($request->status != '') ? $request->status : 'Inactive';
    $productitems = ProductItem::findOrFail($id);
    $productitems->update($request->all());
    return redirect()->route('product-items.show', $id)->with('succes', 'Product Item updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
