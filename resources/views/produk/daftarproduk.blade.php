@extends('layouts.sidebar')

@section('content')
<div class="container mt-4">
    <div class="p-4 rounded" style="background-color: #3B4256;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-light">Daftar Produk</h2>
            <a href="{{ route('produk.tambahproduk') }}" class="btn btn-dark">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
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
                        <th>Nama Produk</th>
                        <th>Satuan</th>
                        <th>Isi per Satuan</th>
                        <th>Jenis Isi</th>
                        <th>Harga Beli per Satuan</th>
                        <th>Harga Beli per Isi</th>
                        <th>Harga Jual per Satuan</th>
                        <th>Harga Jual per Isi</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $produk)
                        <tr>
                            <td>{{ $produk->nama_produk }}</td>
                            <td>{{ $produk->satuan }}</td>
                            <td>{{ $produk->isi_per_satuan }}</td>
                            <td>{{ $produk->jenis_isi }}</td>
                            <td>Rp {{ number_format($produk->harga_beli_per_satuan, 2, ',', '.') }}</td>
                            <td>Rp {{ number_format($produk->harga_beli_per_isi, 2, ',', '.') }}</td>
                            <td>Rp {{ number_format($produk->harga_jual_per_satuan, 2, ',', '.') }}</td>
                            <td>Rp {{ number_format($produk->harga_jual_per_isi, 2, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('daftarproduk.editproduk', $produk->id) }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('daftarproduk.destroy', $produk->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">
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
