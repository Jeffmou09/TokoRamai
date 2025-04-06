@extends('layouts.sidebar')

@section('content')
<div class="container-fluid pt-4">
    <div class="card border-0 rounded-lg mb-4" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title text-dark m-0">Detail Pergerakan Stok: {{ $stok->produk->nama_produk }}</h4>
                <a href="{{ route('inputstok') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <!-- Informasi Produk -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title m-0">Informasi Produk</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td width="40%" class="border-0">Nama Produk</td>
                                    <td class="border-0">: {{ $stok->produk->nama_produk }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0">Satuan Besar</td>
                                    <td class="border-0">: {{ $stok->produk->satuan }} ({{ $stok->stok_satuan_utama }})</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td width="40%" class="border-0">Satuan Kecil</td>
                                    <td class="border-0">: {{ $stok->produk->jenis_isi }} ({{ $stok->stok_satuan_isi }})</td>
                                </tr>
                                <tr>
                                    <td class="border-0">Isi Satuan Kecil</td>
                                    <td class="border-0">: {{ $stok->produk->isi_per_satuan }} {{ $stok->produk->jenis_isi }}/{{ $stok->produk->satuan }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pergerakan Stok -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title m-0">Riwayat Pergerakan Stok</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="bg-light">
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
                                        <td colspan="5" class="text-center py-3">Tidak ada data pergerakan stok</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection