<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ListproductController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth'
    ],
    function () {
        Route::post('login', [AuthController::class, 'login'])->name('login');
    }
);

Route::group([
    'middleware' => 'api'
], function () {
    Route::resources([
        'listproducts' => ListproductController::class,
        'clients' => ClientController::class,
        'transaksis' => TransaksiController::class,
    ]);

    Route::get('transaksi/dikonfirmasi', [TransaksiController::class, 'dikonfirmasi']);
    Route::get('transaksi/dikemas', [TransaksiController::class, 'dikemas']);
    Route::get('transaksi/dikirim', [TransaksiController::class, 'dikirim']);
    Route::get('transaksi/diterima', [TransaksiController::class, 'diterima']);
    Route::get('transaksi/selesai', [TransaksiController::class, 'selesai']);
    Route::post('transaksi/ubah_status/{transaksi}', [TransaksiController::class, 'ubah_status']);
});
