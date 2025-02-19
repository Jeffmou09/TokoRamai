@extends('layouts.sidebar')

@section('content')
<div class="container mt-4">
    <div class="p-4 rounded" style="background-color: #3B4256;">
        <h2 class="text-light">Edit Produk</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('daftarproduk.update', $produk->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label text-light">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Satuan</label>
                <select name="satuan" class="form-control" required>
                    <option value="SAK" {{ $produk->satuan == 'SAK' ? 'selected' : '' }}>SAK</option>
                    <option value="DUS" {{ $produk->satuan == 'DUS' ? 'selected' : '' }}>DUS</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Isi per Satuan</label>
                <input type="number" name="isi_per_satuan" class="form-control" value="{{ $produk->isi_per_satuan }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Jenis Isi</label>
                <select name="jenis_isi" class="form-control" required>
                    <option value="PCS" {{ $produk->jenis_isi == 'PCS' ? 'selected' : '' }}>PCS</option>
                    <option value="KG" {{ $produk->jenis_isi == 'KG' ? 'selected' : '' }}>KG</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Harga Beli per Satuan</label>
                <input type="number" name="harga_beli_per_satuan" class="form-control" value="{{ $produk->harga_beli_per_satuan }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Harga Jual per Satuan</label>
                <input type="number" name="harga_jual_per_satuan" class="form-control" value="{{ $produk->harga_jual_per_satuan }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Harga Jual per Isi</label>
                <input type="number" name="harga_jual_per_isi" class="form-control" value="{{ $produk->harga_jual_per_isi }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Produk</button>
            <a href="{{ route('daftarproduk') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div> 
</div>
@endsection
