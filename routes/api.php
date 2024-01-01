<?php

use App\Http\Controllers\FakturController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdukController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/tampil-data-faktur', [FakturController::class, 'tampil_data_faktur']);
Route::get('/cari-data-faktur', [FakturController::class, 'cari_data_faktur']);
Route::get('/baru-data-faktur', [FakturController::class, 'baru_data_faktur']);
Route::get('/tampil-data-pelanggan', [PelangganController::class, 'tampil_data_pelanggan']);
Route::get('/tampil-data-produk', [ProdukController::class, 'tampil_data_produk']);
Route::post('/tambah-data-faktur', [FakturController::class, 'tambah_data_faktur']);
Route::get('/faktur-detail/{id}', [FakturController::class, 'faktur_detail']);
Route::get('/list-barang-faktur/{faktur_id}', [FakturController::class, 'list_barang_faktur']);
