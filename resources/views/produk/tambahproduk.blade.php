@extends('layouts.sidebar')

@section('content')
<div class="container mt-4">
    <div class="p-4 rounded" style="background-color: #3B4256;">
        <h2 class="text-light">Tambah Produk</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('daftarproduk.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label text-light">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Satuan</label>
                <select name="satuan" class="form-control" required>
                    <option value="">-- Pilih Satuan --</option>
                    <option value="SAK">SAK</option>
                    <option value="DUS">DUS</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Isi per Satuan</label>
                <input type="number" name="isi_per_satuan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Jenis Isi</label>
                <select name="jenis_isi" class="form-control" required>
                    <option value="">-- Pilih Jenis Isi --</option>
                    <option value="PCS">PCS</option>
                    <option value="KG">KG</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Harga Beli per Satuan</label>
                <input type="number" name="harga_beli_per_satuan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Harga Jual per Satuan</label>
                <input type="number" name="harga_jual_per_satuan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Harga Jual per Isi</label>
                <input type="number" name="harga_jual_per_isi" class="form-control" required>
            </div>

            <h4 class="text-light">Stok Awal</h4>

            <div class="mb-3">
                <label class="form-label text-light">Stok Satuan Utama</label>
                <input type="number" name="stok_satuan_utama" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Tambah Produk</button>
            <a href="{{ route('daftarproduk') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div> 
</div>
@endsection
