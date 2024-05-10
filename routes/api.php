<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\api\ProductController as APIProductController;
use App\Http\Controllers\api\GetOrderController;
use App\Http\Controllers\MailController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('sync_products', [ProductController::class, 'sync_products']);
Route::resource('products', APIProductController::class);
Route::resource('getorder', GetOrderController::class);
Route::get('hafeleline', [GetOrderController::class,'sendLine']);
Route::get('survey-mail', [MailController::class, 'survey']);

Route::get('get_redirect', [APIProductController::class, 'get_redirect']);
