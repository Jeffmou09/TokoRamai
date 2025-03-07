@extends('layouts.sidebar')

@section('content')
<div class="container mt-4">
    <div class="p-4 rounded" style="background-color: #3B4256;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-light">Detail Pergerakan Stok: {{ $stok->produk->nama_produk }}</h2>
            <a href="{{ route('inputstok') }}" class="btn btn-dark">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Informasi Produk -->
        <div class="card mb-4 text-dark">
            <div class="card-header">
                <h5>Informasi Produk</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless text-light">
                            <tr>
                                <td>Nama Produk</td>
                                <td>: {{ $stok->produk->nama_produk }}</td>
                            </tr>
                            <tr>
                                <td>Satuan Utama</td>
                                <td>: {{ $stok->produk->satuan }} ({{ $stok->stok_satuan_utama }})</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless text-light">
                            <tr>
                                <td>Jenis Isi</td>
                                <td>: {{ $stok->produk->jenis_isi }} ({{ $stok->stok_satuan_isi }})</td>
                            </tr>
                            <tr>
                                <td>Isi Per Satuan</td>
                                <td>: {{ $stok->produk->isi_per_satuan }} {{ $stok->produk->jenis_isi }}/{{ $stok->produk->satuan }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pergerakan Stok -->
        <div class="card text-dark">
            <div class="card-header">
                <h5>Riwayat Pergerakan Stok</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-light">
                        <thead class="text-light" style="background-color: #3B4256;">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis Perubahan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stokOpname as $index => $opname)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $opname->created_at->format('d-m-Y H:i') }}</td>
                                    <td>
                                        @if($opname->jenis_perubahan == 'Penambahan')
                                            <span class="badge bg-success">{{ $opname->jenis_perubahan }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $opname->jenis_perubahan }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $opname->jumlah_perubahan }}</td>
                                    <td>{{ $opname->satuan }}</td>
                                </tr>
                            @endforeach
                            @if(count($stokOpname) == 0)
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data pergerakan stok</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection