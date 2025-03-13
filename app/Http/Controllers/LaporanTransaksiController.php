<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanTransaksiController extends Controller
{
    public function generateTransaksiPDF(Request $request)
    {
        // Validasi request
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);

        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        $transaksi = Transaksi::whereBetween('tanggal_transaksi', [$tanggalAwal, $tanggalAkhir])
            ->with('customer', 'detailTransaksi')
            ->orderBy('tanggal_transaksi', 'asc')
            ->get();

        // Hitung total diskon secara akurat
        $totalDiskon = $transaksi->sum(function ($trx) {
            return $trx->diskon ?? 0;
        });

        // Data untuk view PDF
        $data = [
            'transaksi' => $transaksi,
            'tanggal_awal' => $tanggalAwal,
            'tanggal_akhir' => $tanggalAkhir,
            'judul' => 'Laporan Penjualan Toko Ramai',
            'total_penjualan' => $transaksi->sum('total_transaksi'),
            'total_produk_terjual' => $transaksi->sum('jumlah_produk_terjual'),
            'total_diskon' => $totalDiskon,
        ];

        // Generate PDF
        $pdf = PDF::loadView('laporan.listtransaksi', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-penjualan-' . date('Y-m-d') . '.pdf');
    }

    public function generateProdukPDF(Request $request)
    {
        // Validasi request
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);

        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        // Query produk terjual berdasarkan periode dengan pemisahan jenis satuan
        $produkTerjual = DB::table('detail_transaksi')
            ->join('transaksi', 'detail_transaksi.id_transaksi', '=', 'transaksi.id')
            ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id')
            ->select(
                'produk.id',
                'produk.nama_produk',
                'produk.satuan',
                'produk.jenis_isi',
                DB::raw('COALESCE(SUM(CASE WHEN detail_transaksi.jenis_satuan IN ("DUS", "SAK") THEN detail_transaksi.jumlah_barang ELSE 0 END), 0) as jumlah_satuan_besar'),
                DB::raw('COALESCE(SUM(CASE WHEN detail_transaksi.jenis_satuan IN ("PCS", "KG") THEN detail_transaksi.jumlah_barang ELSE 0 END), 0) as jumlah_satuan_kecil'),
                DB::raw('SUM(detail_transaksi.sub_total) as total_transaksi')
            )
            ->whereBetween('transaksi.tanggal_transaksi', [$tanggalAwal, $tanggalAkhir])
            ->groupBy('produk.id', 'produk.nama_produk', 'produk.satuan', 'produk.jenis_isi')
            ->orderBy('produk.nama_produk')
            ->get();

        // Set label satuan untuk setiap produk
        foreach ($produkTerjual as $item) {
            // Ambil data produk untuk mendapatkan informasi lengkap
            $produk = Produk::find($item->id);
            
            if ($produk) {
                // Set label satuan
                $item->satuan_besar_label = $produk->satuan;
                $item->satuan_kecil_label = $produk->jenis_isi ?: 'Pcs'; // Default ke 'Pcs' jika kosong
            } else {
                // Default jika produk tidak ditemukan
                $item->satuan_besar_label = 'Dus/Sak';
                $item->satuan_kecil_label = 'Pcs/Kg';
            }
        }

        // Hitung total untuk footer
        $totalSatuanBesar = $produkTerjual->sum('jumlah_satuan_besar');
        $totalSatuanKecil = $produkTerjual->sum('jumlah_satuan_kecil');
        $totalTransaksi = $produkTerjual->sum('total_transaksi');

        // Data untuk view PDF
        $data = [
            'produkTerjual' => $produkTerjual,
            'tanggal_awal' => $tanggalAwal,
            'tanggal_akhir' => $tanggalAkhir,
            'judul' => 'Laporan Produk Terjual Toko Ramai',
            'total_satuan_besar' => $totalSatuanBesar,
            'total_satuan_kecil' => $totalSatuanKecil,
            'total_transaksi' => $totalTransaksi,
        ];

        // Generate PDF
        $pdf = PDF::loadView('laporan.produkterjual', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-produk-terjual-' . date('Y-m-d') . '.pdf');
    }
}