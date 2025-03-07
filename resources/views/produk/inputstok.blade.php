@extends('layouts.sidebar')

@section('content')
<div class="container mt-4">
    <div class="p-4 rounded" style="background-color: #3B4256;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-light">Daftar Stok</h2>
        </div>

        <!-- Form Input Stok -->
        <form action="{{ route('inputstok.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="row align-items-center">
                <div class="col-md-3">
                    <label class="text-light">Nama Produk</label>
                    <input type="hidden" name="produk_id" id="produk_id">
                    <input type="text" id="nama_produk" class="form-control" list="produkList" placeholder="Cari produk...">
                    <datalist id="produkList">
                        @foreach($produkList as $produk)
                            <option data-id="{{ $produk->id }}" value="{{ $produk->nama_produk }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-2">
                    <label class="text-light">Aksi Stok</label>
                    <select name="aksi_stok" class="form-control">
                        <option value="tambah">Tambah</option>
                        <option value="kurang">Kurang</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="text-light">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="text-light">Satuan</label>
                    <select name="satuan" class="form-control">
                        <option value="DUS">Dus</option>
                        <option value="PCS">Pcs</option>
                        <option value="SAK">Sak</option>
                        <option value="KG">Kg</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="text-light">Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" required>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-dark">Simpan</button>
                </div>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Daftar Stok -->
        <div class="table-responsive">
            <table class="table table-bordered text-light">
                <thead class="text-light" style="background-color: #3B4256;">
                    <tr>
                        <th>Nama Produk</th>
                        <th>Stok Satuan</th>
                        <th>Satuan (Sak / Dus)</th>
                        <th>Isi</th>
                        <th>Jenis Isi (Kg / Pcs)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stokProduk as $stok)
                        <tr>
                            <td>{{ $stok->produk->nama_produk ?? 'Produk Tidak Ditemukan' }}</td>
                            <td>{{ $stok->stok_satuan_utama }}</td>
                            <td>{{ $stok->produk->satuan }}</td>
                            <td>{{ $stok->stok_satuan_isi }}</td>
                            <td>{{ $stok->produk->jenis_isi }}</td>
                            <td class="text-center">
                                <a href="{{ route('produk.stokdetail', $stok->id) }}" class="btn btn-sm btn-info" title="Lihat Detail Stok">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> 
</div>

<script>
    document.getElementById('nama_produk').addEventListener('input', function() {
        let input = this.value;
        let options = document.getElementById('produkList').options;
        for (let i = 0; i < options.length; i++) {
            if (options[i].value === input) {
                document.getElementById('produk_id').value = options[i].getAttribute('data-id');
                break;
            }
        }
    });
</script>
@endsection