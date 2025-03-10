@extends('layouts.sidebar')
@section('content')
<div class="container mt-4">
    <div class="p-4 rounded" style="background-color: #3B4256;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-light">Detail Transaksi</h2>
            <div>
                <a href="{{ route('transaksi.history') }}" class="btn btn-dark me-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('transaksi.cetak', $transaksi->id) }}" class="btn btn-primary" target="_blank">
                    <i class="bi bi-printer"></i> Cetak Nota
                </a>
            </div>
        </div>
        
        <div class="card mb-4" style="background-color: #2D334A;">
            <div class="card-body text-light">
                <h5 class="card-title">Informasi Transaksi</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID Transaksi:</strong> {{ $transaksi->id }}</p>
                        <p><strong>Customer:</strong> {{ $transaksi->customer ? $transaksi->customer->nama_customer : 'Umum' }}</p>
                        <p><strong>Tanggal Transaksi:</strong> {{ date('d-m-Y', strtotime($transaksi->tanggal_transaksi)) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Diskon:</strong> {{ $transaksi->diskon }}%</p>
                        <p><strong>Jumlah Produk Terjual:</strong> {{ $transaksi->jumlah_produk_terjual }}</p>
                        <p><strong>Total Transaksi:</strong> Rp {{ number_format($transaksi->total_transaksi, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <h4 class="text-light mb-3">Daftar Produk yang Dibeli</h4>
        <div class="table-responsive">
            <table class="table table-bordered text-light">
                <thead class="text-light" style="background-color: #3B4256;">
                    <tr>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->detailTransaksi as $detail)
                    <tr>
                        <td>{{ $detail->produk->nama_produk }}</td>
                        <td>{{ $detail->jumlah_barang }}</td>
                        <td>{{ $detail->jenis_satuan }}</td>
                        <td>Rp {{ number_format($detail->sub_total / $detail->jumlah_barang, 2, ',', '.') }}</td>
                        <td>Rp {{ number_format($detail->sub_total, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Sub Total</strong></td>
                        <td>Rp {{ number_format($transaksi->detailTransaksi->sum('sub_total'), 2, ',', '.') }}</td>
                    </tr>
                    @if($transaksi->diskon > 0)
                    <tr>
                        <td colspan="4" class="text-end"><strong>Diskon ({{ $transaksi->diskon }}%)</strong></td>
                        <td>Rp {{ number_format($transaksi->detailTransaksi->sum('sub_total') * $transaksi->diskon / 100, 2, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total Akhir</strong></td>
                        <td>Rp {{ number_format($transaksi->total_transaksi, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection