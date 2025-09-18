<?php

use Illuminate\Support\Facades\Route;
use App\Exports\ProductitemsExport;
use App\Imports\ProductitemsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});


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
use App\Http\Controllers\UserController;
use App\Models\AuditLog;

Route::get('/', function () {
  //abort(404);
  return view('welcome');
});

//warranty
Route::get('warranty', function () {
  return Redirect::to(route('register-warranty.index'));
});
Route::resource('register-warranty', WarrantyController::class);
Route::get('check-warranty', [WarrantyController::class, 'check_warranty'])->name('check_warranty');
Route::get('warranty-search-ajax', [WarrantyController::class, 'search_warranty'])->name('warranty.search_warranty');

//dashboard
Route::get('ass_dashboard', [HomeController::class, 'ass_dashboard'])->name('ass_dashboard');
Route::get('clr_dashboard', [HomeController::class, 'clr_dashboard'])->name('clr_dashboard');

//check stock
//Route::resource('products', ProductController::class);
//Route::post('products-import', [ProductController::class, 'import'])->name('products.import');
//Route::get('products-search-ajax', [ProductController::class, 'search_ajax'])->name('products.search-ajax');

//so status


//sales usi

Route::get('search-usi', [SalesUSIController::class, 'search_usi'])->name('search_usi');
Route::get('search-usi-inbound', [SalesUSIController::class, 'inbound'])->name('search_inbound');
Route::get('search-usi-outbound', [SalesUSIController::class, 'outbound'])->name('search_outbound');
//test
Route::get('send-mail', [MailController::class, 'index']);
Route::get('picking', [LoginController::class, 'picking']);
Route::get('test_db_crm', [HomeController::class, 'test_db']);

Route::get('/itservice-rating/{task_id}', [RegisterController::class, 'itservice_rating'])->name('itservice-rating');
Route::post('/itservice-rating/{task_id}', [RegisterController::class, 'save_itservice_rating'])->name('save-itservice-rating');

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
/*Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');*/
Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::middleware(['auth', 'check.status'])->group(function () {
  //Route::group(['middleware' => ['role:super-admin|admin|staff|supplier|user']], function() {
  Route::get('/change-password', [ChangePassword::class, 'show'])->name('change-password');
  Route::post('/change-password', [ChangePassword::class, 'update'])->name('change.perform');

  Route::resource('inv-record', InvRecordController::class);
  Route::get('inv-record/export/{id}', [InvRecordController::class, 'export'])->name('inv-record.export');

  Route::resource('sales-usi', SalesUSIController::class);
  Route::resource('so-status', SoStatusController::class);
  Route::resource('permissions',  App\Http\Controllers\PermissionController::class);
  Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);
  Route::resource('roles',  App\Http\Controllers\RoleController::class);
  Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
  Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
  Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);
  Route::post('users/import-users', [UserController::class, 'importUser'])->name('users.import-users');
  Route::resource('users', App\Http\Controllers\UserController::class);
  Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);
  Route::post('usermaster-import', [UserMasterController::class, 'import'])->name('usermaster-import');
  Route::get('itasset-export', [ITAssetController::class, 'export'])->name('itasset-export');
  Route::resource('itasset', ITAssetController::class);
  Route::resource('asset_types', ITAssetTypeController::class);
  Route::resource('onlineorder', OrderController::class);
  Route::resource('checkstock', CheckStockController::class);
  
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

  Route::get('checkstockhww-export', [CheckStockController::class,'export'])->name('checkstockhww-export');
  Route::post('product-new-price-list-import', [CheckStockController::class,'import'])->name('product-new-price-list-import');
  Route::get('onlineorder/download/{file}', [OrderController::class,'download'])->name('onlineorder-download');
  Route::get('onlineorder-manual-get', [OrderController::class,'onlineorder_manual_get'])->name('onlineorder-manual-get');

  //Consumerlabel
  Route::resource('product-items', ProductItemsController::class);
  Route::get('/export-product-items', function () {
    return Excel::download(new ProductitemsExport, 'ProductItems.xlsx');
  })->name('productitems_export');
  Route::post('/import-product-items', function (Request $request) {
    $request->validate([
      'file' => 'required|mimes:xlsx,csv', // ตรวจสอบชนิดไฟล์
    ]);

    // Import ไฟล์
    Excel::import(new ProductitemsImport, $request->file('file'));

    return back()->with('succes', 'Import ข้อมูลสำเร็จ!');
  })->name('productitems_import');
  Route::get('consumerlabel-barcode', [ProductItemsController::class, 'pdfbarcode'])->name('pdfbarcode');
  //routes template
  Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
  Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
  Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
  Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
  Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
  Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
  Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
  //Route::get('/{page}', [PageController::class, 'index'])->name('page');
  Route::get('/user-management', [PageController::class, 'user_management'])->name('user-management');
  Route::get('/tables', [PageController::class, 'tables'])->name('tables');
  Route::get('/billing', [PageController::class, 'billing'])->name('billing');
  Route::post('logout', [LoginController::class, 'logout'])->name('logout');

  // Audit log
  Route::get('/audit-logs', function () {
    $logs = AuditLog::latest()->paginate(50);
    // return response()->json($logs);
    return view('audit_log.index', [
      'logs' => $logs
    ]);
  });
});
