@extends('layouts.sidebar')
@section('content')
<div class="container-fluid pt-4">
<div class="row mb-4">
    <!-- Total Produk Card -->
    <div class="col-md-4">
        <div class="card border-0 rounded-lg mb-3" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <div class="card-body text-center py-4">
                <h1 class="display-4 text-dark">{{ number_format($totalProduk) }}</h1>
                <p class="lead text-muted">Total Produk</p>
            </div>
        </div>
    </div>
    <!-- Total Customer Card -->
    <div class="col-md-4">
        <div class="card border-0 rounded-lg mb-3" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <div class="card-body text-center py-4">
                <h1 class="display-4 text-dark">{{ number_format($totalCustomer) }}</h1>
                <p class="lead text-muted">Total Customer</p>
            </div>
        </div>
    </div>
    <!-- Today's Total Income Card -->
    <div class="col-md-4">
        <div class="card border-0 rounded-lg mb-3" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <div class="card-body text-center py-4">
                <h1 class="display-4 text-primary">Rp {{ number_format($todayIncome) }}</h1>
                <p class="lead text-muted">Total Income Hari Ini</p>
            </div>
        </div>
    </div>
</div>
<!-- Income Chart -->
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 rounded-lg" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <div class="card-body py-4">
                <h5 class="card-title text-dark mb-4">Income Per Hari Dalam Bulan Ini</h5>
                <div style="position: relative; height: 300px;">
                    <canvas id="incomeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
window.onload = function() {
    console.log("Dates:", {!! json_encode($dates) !!});
    console.log("Incomes:", {!! json_encode($incomes) !!});
    const dates = {!! json_encode($dates) !!};
    const incomes = {!! json_encode($incomes) !!};
    if (dates.length === 0 || incomes.length === 0) {
        console.warn("Data kosong: Chart tidak akan ditampilkan.");
        return;
    }
    const ctx = document.getElementById('incomeChart')?.getContext('2d');
    if (!ctx) {
        console.error("Canvas 'incomeChart' tidak ditemukan.");
        return;
    }
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Income (dalam Juta)',
                data: incomes,
                borderColor: '#4361ee',
                backgroundColor: 'rgba(67, 97, 238, 0.1)',
                tension: 0.4,
                borderWidth: 2,
                fill: true,
                pointBackgroundColor: '#4361ee'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#6c757d',
                        callback: function(value) {
                            return value.toFixed(2);
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        color: '#6c757d'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#343a40'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toFixed(2) + ' Juta';
                        }
                    }
                }
            }
        }
    });
};
</script>
@endsection