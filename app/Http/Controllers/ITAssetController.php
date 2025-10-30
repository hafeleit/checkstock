<?php

namespace App\Http\Controllers;

use App\Events\FileExported;
use App\Models\ITAsset;
use App\Models\ITAssetType;
use App\Models\ITAssetOwn;
use App\Models\ITAssetSpec;
use App\Models\Softwares;
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
  public function __construct()
  {
    $this->middleware('permission:itasset view', ['only' => ['index', 'export', 'show']]);
    $this->middleware('permission:itasset create', ['only' => ['create', 'store']]);
    $this->middleware('permission:itasset update', ['only' => ['update', 'edit']]);
    $this->middleware('permission:itasset delete', ['only' => ['destroy']]);
  }

  public function index()
  {
    $itassets = ITAsset::where('i_t_assets.delete', '0')
      ->leftjoin('i_t_asset_owns', 'i_t_assets.computer_name', 'i_t_asset_owns.computer_name')
      ->leftJoin('user_masters', function ($join) {
        $join->on('i_t_asset_owns.user', '=', 'user_masters.job_code')
          ->where('user_masters.status', '=', 'Current');
      })
      ->leftjoin('softwares', 'softwares.computer_name', 'i_t_assets.computer_name')
      ->leftjoin('i_t_asset_types', 'i_t_asset_types.type_code', 'i_t_assets.type')
      ->select(DB::raw("
                      i_t_assets.*,
                      i_t_asset_owns.user,
                      user_masters.name_en,
                      GROUP_CONCAT(softwares.software_name ORDER BY softwares.software_name ASC SEPARATOR ', ') AS software_name,
                      i_t_asset_types.type_desc
                      "))
      ->groupBy('i_t_assets.computer_name')
      ->orderBy('i_t_assets.id', 'desc')
      ->get();

    $total_notebook = ITAsset::where('type', 'T01')->where('delete', '0')->count();
    $total_notebook_spare = ITAsset::where('type', 'T01')->where('status', 'SPARE')->where('delete', '0')->count();
    $total_pc_spare = ITAsset::where('type', 'T02')->where('status', 'SPARE')->where('delete', '0')->count();
    $total_pc = ITAsset::where('type', 'T02')->where('delete', '0')->count();
    $total_spare = ITAsset::where('status', 'SPARE')->where('delete', '0')->count();
    $itassets_cnt = count($itassets);

    return view('pages.itasset.index', compact('itassets', 'itassets_cnt', 'total_notebook', 'total_notebook_spare', 'total_pc', 'total_pc_spare', 'total_spare'));
  }

  public function export()
  {
    $fileName = 'ITAsset.xlsx';
    $fileSize = null;

    try {
      event(new FileExported('App\Models\ITAsset', auth()->id(), 'export', 'pass', $fileName, $fileSize));
      return Excel::download(new ITAssetExport, $fileName);
    } catch (\Throwable $th) {
      event(new FileExported('App\Models\ITAsset', auth()->id(), 'export', 'fail', $fileName, $fileSize, $th->getMessage()));
      return back()->with('error', 'An error occurred while exporting the file: ' . $th->getMessage());
    }
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('pages.itasset.create', ['types' => ITAssetType::where('type_status', 'Active')->get()]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    DB::beginTransaction();

    try {

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
      if ($request->user[0] != '') {
        foreach ($request->user as $key => $value) {
          $own[] = ['computer_name' => $request->computer_name, 'user' => $value, 'main' => 'Y'];
        }
        ITAssetOwn::insert($own);
      }

      //Softwares add
      if (isset($request->software_name[0])) {
        if ($request->software_name[0] != '') {
          foreach ($request->software_name as $key => $value) {
            $softwares[] = [
              'computer_name' => $request->computer_name,
              'software_name' => $value,
              'license_type' => $request->license_type[$key],
              'license_expire_date' => $request->license_expiry_date[$key],
            ];
          }
          Softwares::insert($softwares);
        }
      }

      //insert Spec computer
      if ($request->cpu != '' || $request->ram != '' || $request->storage != '') {
        $spec = ['computer_name' => $request->computer_name, 'cpu' => $request->cpu, 'ram' => $request->ram, 'storage' => $request->storage];
        ITAssetSpec::create($spec);
      }


      DB::commit();
      return redirect()->route('itasset.create')->with('success', 'Asset created successfully.');
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $itasset = ITAsset::where('i_t_assets.id', $id)->leftJoin('i_t_asset_types', 'i_t_asset_types.type_code', 'i_t_assets.type')
      ->select('i_t_assets.*', 'i_t_asset_types.type_desc', 'i_t_asset_types.type_code')->first();

    $itassetspec = ITAssetSpec::where('computer_name', $itasset->computer_name)->first();

    $itassetown = ITAssetOwn::where('computer_name', $itasset->computer_name)
      ->leftJoin('user_masters', function ($join) {
        $join->on('i_t_asset_owns.user', '=', 'user_masters.job_code')
          ->where('user_masters.status', '=', 'Current');
      })
      ->get();

    $softwares = Softwares::where('computer_name', $itasset->computer_name)->get();

    return view('pages.itasset.show', compact('itasset', 'itassetspec', 'itassetown', 'softwares'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(ITAsset $itasset)
  {
    $itassetspec = ITAssetSpec::where('computer_name', $itasset->computer_name)->first();
    $itassetown = ITAssetOwn::where('computer_name', $itasset->computer_name)->get();
    $softwares = Softwares::where('computer_name', $itasset->computer_name)->get();
    $types = ITAssetType::where('type_status', 'Active')->get();

    return view('pages.itasset.edit', compact('itasset', 'itassetspec', 'itassetown', 'softwares', 'types'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, ITAsset $itasset)
  {

    DB::beginTransaction();

    try {

      $request->validate([
        'computer_name' => 'required|unique:i_t_assets,computer_name,' . $itasset->id,
        'type' => 'required',
        'model' => 'required',
        'status' => 'required',
      ]);

      $user = Auth::user();
      $request['updated_at'] = date('Y-m-d H:i:s');
      $request['update_by'] = $user->username;

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
      if ($request->user[0] != '') {
        foreach ($request->user as $key => $value) {
          $own[] = ['computer_name' => $request->computer_name, 'user' => $value, 'main' => 'Y'];
        }
        ITAssetOwn::insert($own);
      }

      //Softwares delete and add new
      Softwares::where('computer_name', $request->computer_name)->delete();
      if (isset($request->software_name[0])) {
        if ($request->software_name[0] != '') {
          foreach ($request->software_name as $key => $value) {
            $softwares[] = [
              'computer_name' => $request->computer_name,
              'software_name' => $value,
              'license_type' => $request->license_type[$key],
              'license_expire_date' => $request->license_expiry_date[$key],
            ];
          }
          Softwares::insert($softwares);
        }
      }


      DB::commit();
      return redirect()->route('itasset.show', $itasset->id)->with('success', 'Asset updated successfully');
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(ITAsset $itasset)
  {
    $itasset->delete();

    return redirect()->route('itasset.index')
      ->with('success', 'Asset deleted successfully');
  }
}
