@extends('layouts.sidebar')

@section('content')
<div class="container mt-4">
    <div class="p-4 rounded" style="background-color: #3B4256;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-light">History Transaksi</h2>
            <!-- Filter dropdown -->
            <form action="{{ route('transaksi.history') }}" method="GET" class="d-flex">
                <select name="periode" id="periode" class="form-select me-2" onchange="this.form.submit()">
                    <option value="today" {{ request('periode') == 'today' || !request('periode') ? 'selected' : '' }}>Hari Ini</option>
                    <option value="week" {{ request('periode') == 'week' ? 'selected' : '' }}>1 Minggu Terakhir</option>
                    <option value="month" {{ request('periode') == 'month' ? 'selected' : '' }}>1 Bulan Terakhir</option>
                    <option value="all" {{ request('periode') == 'all' ? 'selected' : '' }}>Semua Transaksi</option>
                </select>
            </form>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered text-light">
                <thead class="text-light" style="background-color: #3B4256;">
                    <tr>
                        <th>Tanggal Transaksi</th>
                        <th>Customer</th>
                        <th>Jumlah Produk</th>
                        <th>Diskon</th>
                        <th>Total Transaksi</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi as $trx)
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($trx->tanggal_transaksi)) }}</td>
                        <td>{{ $trx->customer ? $trx->customer->nama_customer : 'Umum' }}</td>
                        <td>{{ $trx->jumlah_produk_terjual }}</td>
                        <td>{{ $trx->diskon }}%</td>
                        <td>Rp {{ number_format($trx->total_transaksi, 2, ',', '.') }}</td>
                        <td class="text-center">
                            <!-- Tombol lihat detail -->
                            <a href="{{ route('transaksi.detail', $trx->id) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                            <!-- Tombol cetak nota -->
                            <a href="{{ route('transaksi.cetak', $trx->id) }}" class="btn btn-primary btn-sm" target="_blank">
                                <i class="bi bi-printer"></i>
                            </a>
                            <!-- Tombol hapus -->
                            <form action="{{ route('transaksi.destroy', $trx->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus transaksi ini?');">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection