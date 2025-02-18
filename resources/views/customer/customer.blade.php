@extends('layouts.sidebar')

@section('content')
<div class="container mt-4">
    <div class="p-4 rounded" style="background-color: #3B4256;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-light">Daftar Customer</h2>
            <a href="{{ route('customer.tambahcustomer') }}" class="btn btn-dark">
                <i class="fas fa-plus"></i> Tambah Customer
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
                        <th>Nama Customer</th>
                        <th>Alamat</th>
                        <th>No. HP</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer->nama_customer }}</td>
                            <td>{{ $customer->alamat }}</td>
                            <td>{{ $customer->no_hp }}</td>
                            <td class="text-center">
                            <a href="{{ route('customer.editcustomer', $customer->id) }}" class="btn btn-success btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="d-inline">
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