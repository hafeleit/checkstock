<?php

namespace App\Http\Controllers;

use App\Models\ITAsset;
use App\Models\ITAssetOwn;
use App\Models\ITAssetSpec;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use App\Exports\ITAssetExport;
use Maatwebsite\Excel\Facades\Excel;

class ITAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $itassets = ITAsset::where('i_t_assets.delete','0')
                    ->leftjoin('i_t_asset_owns','i_t_assets.computer_name','i_t_asset_owns.computer_name')
                    ->leftjoin('user_masters','i_t_asset_owns.user','user_masters.job_code')
                    ->select(DB::raw("i_t_assets.*,i_t_asset_owns.user,user_masters.name_en"))
                    ->groupBy('i_t_assets.computer_name')
                    ->orderBy('i_t_assets.id','desc')
                    ->get();
        //dd($itassets[0]->id);

        return view('pages.itasset.index',compact('itassets'));
    }

    public function export()
    {
        return Excel::download(new ITAssetExport, 'ITAsset.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.itasset.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

      $validatedData = $request->validate([
          'computer_name' => 'required|unique:i_t_assets',
          'type' => 'required',
          'model' => 'required',
          'status' => 'required',
      ]);

      $user = Auth::user();
      $request['create_by'] = $user->username;

      ITAsset::create($request->all());

      // insert Owner computer
      foreach ($request->user as $key => $value) {
        $own[] = ['computer_name' => $request->computer_name, 'user' => $value, 'main' => $request->own_main[$key]];
      }
      ITAssetOwn::insert($own);

      //insert Spec computer
      $spec = ['computer_name' => $request->computer_name, 'cpu' => $request->cpu, 'ram' => $request->ram, 'storage' => $request->storage];
      ITAssetSpec::create($spec);

      return redirect()->route('itasset.create')->with('success','Asset created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(ITAsset $itasset)
    {
        $itassetspec = ITAssetSpec::where('computer_name',$itasset->computer_name)->first();
        $itassetown = ITAssetOwn::where('computer_name',$itasset->computer_name)->leftJoin('user_masters','i_t_asset_owns.user','=','user_masters.job_code')->get();

        return view('pages.itasset.show',compact('itasset','itassetspec','itassetown'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ITAsset $itasset)
    {
        $itassetspec = ITAssetSpec::where('computer_name',$itasset->computer_name)->first();
        $itassetown = ITAssetOwn::where('computer_name',$itasset->computer_name)->get();

        return view('pages.itasset.edit',compact('itasset','itassetspec','itassetown'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ITAsset $itasset)
    {

      $request->validate([
          'computer_name' => 'required',
          'type' => 'required',
          'model' => 'required',
          'status' => 'required',
      ]);

      $request['updated_at'] = date('Y-m-d H:i:s');
      $itasset->update($request->all());

      //update spec
      ITAssetSpec::updateOrCreate(
          [
            'computer_name' => $request->computer_name,
          ],
          [
            'cpu' => $request->cpu,
            'ram' => $request->ram,
            'storage' => $request->storage,
          ]
      );

      //delete and new insert owner computer
      ITAssetOwn::where('computer_name', $request->computer_name)->delete();
      if(count($request->user) > 0){
        foreach ($request->user as $key => $value) {
          $own[] = ['computer_name' => $request->computer_name, 'user' => $value, 'main' => $request->own_main[$key]];
        }
        ITAssetOwn::insert($own);
      }

      return redirect()->route('itasset.show',$itasset->id)->with('success','Asset updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ITAsset $itasset)
    {
        ITAsset::where('id', $itasset->id)->update(['delete' => 1]);
        return redirect()->route('itasset.index')->with('success','Asset deleted successfully');
    }
}
