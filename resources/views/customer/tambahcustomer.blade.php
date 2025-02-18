@extends('layouts.sidebar')

@section('content')
<div class="container mt-4">
    <div class="p-4 rounded" style="background-color: #3B4256;">
        <h2 class="text-light">Tambah Customer</h2>
        <form action="{{ route('customer') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label text-light">Nama Customer</label>
                <input type="text" name="nama_customer" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-light">Alamat</label>
                <input type="text" name="alamat" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-light">No. HP</label>
                <input type="text" name="no_hp" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-dark">Tambah</button>
        </form>
    </div>
</div>
@endsection