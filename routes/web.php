<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
Route::post('/customer', [CustomerController::class, 'store'])->name('customer');
Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.tambahcustomer');
Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.editcustomer');
Route::post('/customer/{id}/update', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/daftarproduk', function () {
    return view('daftarproduk');
})->name('daftarproduk');

Route::get('/inputstok', function () {
    return view('inputstok');
})->name('inputstok');

Route::get('/stok', function () {
    return view('stok');
})->name('stok');

Route::get('/transaksi', function () {
    return view('transaksi');
})->name('transaksi');

Route::get('/historytransaksi', function () {
    return view('historytransaksi');
})->name('historytransaksi');