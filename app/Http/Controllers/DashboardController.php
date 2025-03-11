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
        // Count total products
        $totalProduk = Produk::count();

        // Count total customers
        $totalCustomer = Customer::count();

        // Calculate today's total income
        $todayIncome = Transaksi::whereDate('tanggal_transaksi', now()->toDateString())
            ->sum('total_transaksi');

        // Get income per day for the current month
        $incomePerDay = Transaksi::selectRaw('DATE(tanggal_transaksi) as date, SUM(total_transaksi) as total')
            ->whereBetween('tanggal_transaksi', [now()->startOfMonth(), now()->endOfMonth()])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // Format data for the chart (only dates with income)
        $dates = [];
        $incomes = [];

        foreach ($incomePerDay as $date => $total) {
            $dates[] = Carbon::parse($date)->format('j M'); // Example: "1 Mar"
            $incomes[] = $total / 1000000; // Convert to millions
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
