<?php

namespace App\Http\Controllers;

use App\Models\ITAssetType;
use Illuminate\Http\Request;


class ITAssetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

      try {
          $assetTypes = ITAssetType::all();
          return view('pages.itasset.type.index', compact('assetTypes')); // ส่งข้อมูลไปที่ View
      } catch (Exception $e) {
          return back()->withErrors('Failed to fetch asset types: ' . $e->getMessage());
      }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      try {
          return view('pages.itasset.type.create'); // แสดงฟอร์มสำหรับเพิ่มข้อมูล
      } catch (Exception $e) {
          return back()->withErrors('Failed to load create form: ' . $e->getMessage());
      }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      try {
          $validated = $request->validate([
              'type_desc' => 'required|string|max:100',
          ]);

          $lastType = ITAssetType::orderBy('id', 'desc')->first();
          $lastCode = $lastType ? intval(substr($lastType->type_code, 1)) : 0;
          $newCode = 'T' . str_pad($lastCode + 1, 2, '0', STR_PAD_LEFT);

          // เพิ่มข้อมูลใหม่
          $validated['type_code'] = $newCode;
          $validated['type_status'] = 'Active';

          ITAssetType::create($validated);

          return redirect()->route('asset_types.index')->with('success', 'Asset type created successfully!');
      } catch (Exception $e) {
          return back()->withErrors('Failed to create asset type: ' . $e->getMessage())->withInput();
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
      try {
          $assetType = ITAssetType::findOrFail($id);
          return view('asset_types.show', compact('assetType'));
      } catch (ModelNotFoundException $e) {
          return redirect()->route('asset_types.index')->withErrors('Asset type not found!');
      } catch (Exception $e) {
          return back()->withErrors('Failed to fetch asset type: ' . $e->getMessage());
      }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
      try {
          $assetType = ITAssetType::findOrFail($id);
          return view('asset_types.edit', compact('assetType'));
      } catch (ModelNotFoundException $e) {
          return redirect()->route('asset_types.index')->withErrors('Asset type not found!');
      } catch (Exception $e) {
          return back()->withErrors('Failed to load edit form: ' . $e->getMessage());
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
      try {
          $validated = $request->validate([
              'type_code' => 'required|string|max:10',
              'type_desc' => 'required|string|max:100',
              'type_status' => 'required|string|max:20',
          ]);

          $assetType = ITAssetType::findOrFail($id);
          $assetType->update($validated);

          return redirect()->route('asset_types.index')->with('success', 'Asset type updated successfully!');
      } catch (ModelNotFoundException $e) {
          return redirect()->route('asset_types.index')->withErrors('Asset type not found!');
      } catch (Exception $e) {
          return back()->withErrors('Failed to update asset type: ' . $e->getMessage())->withInput();
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
      try {
          $assetType = ITAssetType::findOrFail($id);
          $assetType->delete();

          return redirect()->route('asset_types.index')->with('success', 'Asset type deleted successfully!');
      } catch (ModelNotFoundException $e) {
          return redirect()->route('asset_types.index')->withErrors('Asset type not found!');
      } catch (Exception $e) {
          return back()->withErrors('Failed to delete asset type: ' . $e->getMessage());
      }
    }
}
