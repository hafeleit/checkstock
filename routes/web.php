<?php

use Illuminate\Support\Facades\Route;
use App\Exports\ProductitemsExport;
use App\Imports\ProductitemsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarrantyController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SoStatusController;
use App\Http\Controllers\SalesUSIController;
use App\Http\Controllers\ITAssetController;
use App\Http\Controllers\UserMasterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckStockController;
use App\Http\Controllers\Consumerlabel\ProductItemsController;
use App\Http\Controllers\ITAssetTypeController;
use App\Http\Controllers\InvRecordController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;

// public routes
Route::get('/', function () {
  return view('welcome');
});

// authentication
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');

// warranty routes
Route::get('warranty', function () {
  return Redirect::to(route('register-warranty.index'));
});
Route::resource('register-warranty', warrantycontroller::class);
Route::get('check-warranty', [warrantycontroller::class, 'check_warranty'])->name('check_warranty');
Route::get('warranty-search-ajax', [warrantycontroller::class, 'search_warranty'])->name('warranty.search_warranty');

// testing routes
Route::get('send-mail', [mailcontroller::class, 'index']);
Route::get('picking', [logincontroller::class, 'picking']);
Route::get('test_db_crm', [homecontroller::class, 'test_db']);

// protected routes (requires authentication and status check)
Route::middleware(['auth', 'check.status'])->group(function () {
  // dashboard & user profile
  Route::get('/clr_dashboard', [homecontroller::class, 'clr_dashboard'])->name('clr_dashboard');
  Route::get('/change-password', [changepassword::class, 'show'])->name('change-password');
  Route::put('/change-password', [changepassword::class, 'update'])->name('change.perform');
  Route::get('/profile', [userprofilecontroller::class, 'show'])->name('profile');
  Route::put('/profile', [userprofilecontroller::class, 'update'])->name('profile.update');
  Route::post('/logout', [logincontroller::class, 'logout'])->name('logout');

  // commissions
  Route::resource('commissions', CommissionController::class);
  Route::post('/commission/verify-password', [CommissionController::class, 'verifyPassword'])->name('commission.verify-password');
  Route::put('/commissions/{id}/status', [CommissionController::class, 'updateStatus'])->name('commissions.updateStatus');
  Route::post('/commissions/import', [CommissionController::class, 'importAll'])->name('commissions.import');
  Route::get('/commissions/{id}/export', [CommissionController::class, 'export'])->name('commissions.export');
  Route::get('/commissions/{id}/summary-export', [CommissionController::class, 'summary_export'])->name('commissions.summary-export');
  Route::post('/commissions/{id}/adjust', [CommissionController::class, 'adjust'])->name('commissions.adjust');
  Route::delete('/commissions/{id}/adjust', [CommissionController::class, 'adjust_delete'])->name('commissions.adjust.delete');
  Route::put('/commissions/adjust/{id}', [CommissionController::class, 'adjustUpdate'])->name('commissions.adjust.update');
  Route::get('/commissions/{id}/sales-summary', [CommissionController::class, 'salesSummary'])->name('commissions.sales-summary');
  Route::get('/commissions/{id}/check', [CommissionController::class, 'check'])->name('commissions.check');
  Route::get('/commissions/{id}/summary-sales-export', [CommissionController::class, 'summarySalesExport'])->name('commissions.summary-sales-export');

  // it assets
  Route::get('itasset-export', [ITAssetController::class, 'export'])->name('itasset-export');
  Route::resource('itasset', ITAssetController::class);
  Route::resource('asset_types', ITAssetTypeController::class);

  // inventory & stock
  Route::resource('inv-record', InvRecordController::class);
  Route::get('inv-record/export/{id}', [InvRecordController::class, 'export'])->name('inv-record.export');
  Route::resource('checkstock', CheckStockController::class);
  Route::get('checkstockhww-export', [CheckStockController::class, 'export'])->name('checkstockhww-export');
  Route::post('product-new-price-list-import', [CheckStockController::class, 'import'])->name('product-new-price-list-import');

  // user management & roles
  Route::get('/user-management', [pagecontroller::class, 'user_management'])->name('user-management');
  Route::resource('permissions',  PermissionController::class);
  Route::delete('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);
  Route::resource('roles',  RoleController::class);
  Route::delete('roles/{roleId}/delete', [RoleController::class, 'destroy']);
  Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
  Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);
  Route::post('users/import-users', [UserController::class, 'importUser'])->name('users.import-users');
  Route::resource('users', UserController::class)->only('index', 'create', 'store', 'edit', 'update');
  Route::post('usermaster-import', [UserMasterController::class, 'import'])->name('usermaster-import');

  // online orders
  Route::resource('onlineorder', OrderController::class);
  Route::get('onlineorder/download/{file}', [OrderController::class, 'download'])->name('onlineorder-download');
  Route::get('onlineorder-manual-get', [OrderController::class, 'onlineorder_manual_get'])->name('onlineorder-manual-get');

  // so status & sales usi
  Route::resource('sales-usi', SalesUSIController::class)->only('index');
  Route::get('search-usi', [SalesUSIController::class, 'search_usi'])->name('search_usi');
  Route::get('search-usi-inbound', [SalesUSIController::class, 'inbound'])->name('search_inbound');
  Route::get('search-usi-outbound', [SalesUSIController::class, 'outbound'])->name('search_outbound');
  Route::resource('so-status', SoStatusController::class);

  // consumerlabel
  Route::get('/barcode/{barcode}', [ProductItemsController::class, 'generateBarcode'])->name('generate-barcode');
  Route::get('/qrcode/{qrcode}', [ProductItemsController::class, 'generateQrcode'])->name('generate-qrcode');
  Route::resource('product-items', ProductItemsController::class);
  Route::get('/export-product-items', function () {
    return Excel::download(new ProductitemsExport, 'ProductItems.xlsx');
  })->name('productitems_export');
  Route::post('/import-product-items', function (Request $request) {
    $request->validate([
      'file' => 'required|mimes:xlsx,csv',
    ]);
    Excel::import(new ProductitemsImport, $request->file('file'));
    return back()->with('succes', 'Import ข้อมูลสำเร็จ!');
  })->name('productitems_import');
  Route::get('consumerlabel-barcode', [ProductItemsController::class, 'pdfbarcode'])->name('pdfbarcode');
});
