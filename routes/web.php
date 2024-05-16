<?php

use Illuminate\Support\Facades\Route;

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

  Route::get('/', function () {return redirect('/products');});

  //warranty
  Route::get('warranty', function(){ return Redirect::to(route('register-warranty.index')); });
  Route::resource('register-warranty', WarrantyController::class);
  Route::get('check-warranty', [WarrantyController::class, 'check_warranty'])->name('check_warranty');
  Route::get('warranty-search-ajax', [WarrantyController::class, 'search_warranty'])->name('warranty.search_warranty');

  //dashboard
  Route::get('ass_dashboard', [HomeController::class, 'ass_dashboard'])->name('ass_dashboard');
  Route::get('clr_dashboard', [HomeController::class, 'clr_dashboard'])->name('clr_dashboard');

  //check stock
  Route::resource('products', ProductController::class);
  Route::post('products-import', [ProductController::class, 'import'])->name('products.import');
  Route::get('products-search-ajax', [ProductController::class, 'search_ajax'])->name('products.search-ajax');

  //so status
  Route::resource('so-status', SoStatusController::class);

  //sales usi
  Route::resource('sales-usi', SalesUSIController::class);
  Route::get('search-usi', [SalesUSIController::class,'search_usi'])->name('search_usi');
  Route::get('search-usi-inbound', [SalesUSIController::class,'inbound'])->name('search_inbound');
  Route::get('search-usi-outbound', [SalesUSIController::class,'outbound'])->name('search_outbound');
  //test
  Route::get('send-mail', [MailController::class, 'index']);
  Route::get('picking', [LoginController::class, 'picking']);
  Route::get('test_db_crm', [HomeController::class, 'test_db']);











  Route::get('/itservice-rating/{task_id}', [RegisterController::class, 'itservice_rating'])->middleware('guest')->name('itservice-rating');
  Route::post('/itservice-rating/{task_id}', [RegisterController::class, 'save_itservice_rating'])->middleware('guest')->name('save-itservice-rating');

	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');


Route::group(['middleware' => 'auth'], function () {

  Route::resource('itasset', ITAssetController::class);
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

});
