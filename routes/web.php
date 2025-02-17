<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/customer', function () {
    return view('customer');
})->name('customer');
