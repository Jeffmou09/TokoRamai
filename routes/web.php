<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokProdukController;
use App\Http\Controllers\TransaksiController;

Route::get('/inputstok', [StokProdukController::class, 'index'])->name('inputstok');
Route::post('/inputstok/store', [StokProdukController::class, 'store'])->name('inputstok.store');

Route::get('/daftarproduk', [ProdukController::class, 'index'])->name('daftarproduk');
Route::post('/daftarproduk/store', [ProdukController::class, 'store'])->name('daftarproduk.store');
Route::get('/daftarproduk/create', [ProdukController::class, 'create'])->name('produk.tambahproduk');
Route::get('/daftarproduk/{id}/edit', [ProdukController::class, 'edit'])->name('daftarproduk.editproduk');
Route::put('/daftarproduk/{id}', [ProdukController::class, 'update'])->name('daftarproduk.update');
Route::delete('/daftarproduk/{id}', [ProdukController::class, 'destroy'])->name('daftarproduk.destroy');

Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
Route::post('/customer', [CustomerController::class, 'store'])->name('customer');
Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.tambahcustomer');
Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.editcustomer');
Route::post('/customer/{id}/update', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/historytransaksi', function () {
    return view('historytransaksi');
})->name('historytransaksi');