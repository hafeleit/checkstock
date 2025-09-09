<?php

use App\Http\Controllers\DeliverController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\InvTrackingController;
use App\Http\Controllers\ReturnController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:super-admin|delivery admin|delivery'])
    ->prefix('invoice-trackings')
    ->name('invoice-trackings.')
    ->group(function () {
        Route::get('/details', [InvTrackingController::class, 'detail'])->name('details');
        Route::get('/export-overall', [InvTrackingController::class, 'exportOverall'])->name('export-overall');
        Route::get('/export-pending', [InvTrackingController::class, 'exportPending'])->name('export-pending');

        Route::get('/delivers/export', [DeliverController::class, 'export'])->name('delivers.export');
        Route::get('/delivers/export-rtt', [DeliverController::class, 'exportRTT'])->name('delivers.export-rtt');
        Route::resource('/delivers', DeliverController::class)->only('index', 'store');

        Route::get('/returns/export', [ReturnController::class, 'export'])->name('returns.export');
        Route::resource('/returns', ReturnController::class)->only('index', 'store');

        Route::resource('/imports', ImportController::class)->only('index', 'store');
    });

Route::resource('invoice-trackings', InvTrackingController::class)->except(['create']);
