@extends('layouts.sidebar')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="font-weight-bold mb-0">Laporan Penjualan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- List Transaksi Card -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-left-primary">
                                <div class="card-header bg-white py-3">
                                    <h6 class="font-weight-bold mb-0">List Transaksi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle bg-primary text-white">
                                            <i class="fas fa-file-invoice"></i>
                                        </div>
                                        <p class="card-text text-muted ml-3 mb-0">
                                            Menampilkan seluruh transaksi berdasarkan periode yang dipilih
                                        </p>
                                    </div>
                                    
                                    <!-- Filter Transaksi -->
                                    <form id="formTransaksi" method="GET" action="{{ route('laporan.transaksi') }}">
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal_awal_transaksi">Tanggal Awal</label>
                                                    <input type="date" class="form-control" id="tanggal_awal_transaksi" name="tanggal_awal" value="{{ date('Y-m-01') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal_akhir_transaksi">Tanggal Akhir</label>
                                                    <input type="date" class="form-control" id="tanggal_akhir_transaksi" name="tanggal_akhir" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    <button type="button" id="btnLihatTransaksi" class="btn btn-primary btn-sm btn-block">
                                        Lihat Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Produk Terjual Card -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-left-success">
                                <div class="card-header bg-white py-3">
                                    <h6 class="font-weight-bold mb-0">Produk Terjual</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle bg-success text-white">
                                            <i class="fas fa-box"></i>
                                        </div>
                                        <p class="card-text text-muted ml-3 mb-0">
                                            Menampilkan data produk yang terjual beserta jumlah dan total penjualannya
                                        </p>
                                    </div>
                                    
                                    <!-- Filter Produk -->
                                    <form id="formProduk" method="GET" action="{{ route('laporan.produk') }}">
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal_awal_produk">Tanggal Awal</label>
                                                    <input type="date" class="form-control" id="tanggal_awal_produk" name="tanggal_awal" value="{{ date('Y-m-01') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal_akhir_produk">Tanggal Akhir</label>
                                                    <input type="date" class="form-control" id="tanggal_akhir_produk" name="tanggal_akhir" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    <button type="button" id="btnLihatProduk" class="btn btn-success btn-sm btn-block">
                                        Lihat Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Container for displaying results -->
                    <div class="row mt-4" id="resultContainer" style="display: none;">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h6 class="font-weight-bold mb-0" id="resultTitle">Laporan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="resultTable">
                                            <!-- Table content will be inserted here -->
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Button references
    const btnLihatTransaksi = document.getElementById('btnLihatTransaksi');
    const btnLihatProduk = document.getElementById('btnLihatProduk');
    
    // Form references
    const formTransaksi = document.getElementById('formTransaksi');
    const formProduk = document.getElementById('formProduk');
    
    // Date input references
    const tanggalAwalTransaksi = document.getElementById('tanggal_awal_transaksi');
    const tanggalAkhirTransaksi = document.getElementById('tanggal_akhir_transaksi');
    const tanggalAwalProduk = document.getElementById('tanggal_awal_produk');
    const tanggalAkhirProduk = document.getElementById('tanggal_akhir_produk');
    
    // Update action URL untuk form
    formTransaksi.setAttribute('action', '{{ route("laporan.transaksi.pdf") }}');
    formProduk.setAttribute('action', '{{ route("laporan.produk.pdf") }}');
    
    // Function to validate dates
    function validateDates(startDateInput, endDateInput) {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        
        if (endDate < startDate) {
            alert('Tanggal akhir harus berada setelah tanggal awal.');
            return false;
        }
        return true;
    }
    
    // Event listener for Transaksi button with date validation
    btnLihatTransaksi.addEventListener('click', function(e) {
        if (validateDates(tanggalAwalTransaksi, tanggalAkhirTransaksi)) {
            formTransaksi.submit(); // Ini akan mendownload PDF langsung
        }
    });
    
    // Event listener for Produk button with date validation
    btnLihatProduk.addEventListener('click', function(e) {
        if (validateDates(tanggalAwalProduk, tanggalAkhirProduk)) {
            formProduk.submit(); // Ini akan mendownload PDF produk
        }
    });
});
</script>
@endsection