<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Customer;
use App\Models\Transaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalProduk = Produk::count();
        $totalCustomer = Customer::count();
        $todayIncome = Transaksi::whereDate('tanggal_transaksi', now()->toDateString())
            ->sum('total_transaksi');

        $incomePerDay = Transaksi::selectRaw('DATE(tanggal_transaksi) as date, SUM(total_transaksi) as total')
            ->whereBetween('tanggal_transaksi', [now()->startOfMonth(), now()->endOfMonth()])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $dates = [];
        $incomes = [];

        foreach ($incomePerDay as $date => $total) {
            $dates[] = Carbon::parse($date)->format('j M'); 
            $incomes[] = $total / 1000000; 
        }

        return view('dashboard', compact(
            'totalProduk',
            'totalCustomer',
            'todayIncome',
            'dates',
            'incomes'
        ));
    }
}
