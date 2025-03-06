<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Customer;
use App\Models\Transaksi;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    public function index()
    {
        $customerList = Customer::all(); 
        $produkList = Produk::all(); 

        return view('transaksi', compact('customerList', 'produkList'));
    }
}
