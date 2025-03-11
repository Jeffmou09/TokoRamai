@extends('layouts.sidebar')

@section('content')
<div class="row mb-4">
    <!-- Total Produk Card -->
    <div class="col-md-4">
        <div class="card text-white" style="background-color: #3B4256;">
            <div class="card-body text-center py-4">
                <h1 class="display-4">{{ number_format($totalProduk) }}</h1>
                <p class="lead">Total Produk</p>
            </div>
        </div>
    </div>
    <!-- Total Customer Card -->
    <div class="col-md-4">
        <div class="card text-white" style="background-color: #3B4256;">
            <div class="card-body text-center py-4">
                <h1 class="display-4">{{ number_format($totalCustomer) }}</h1>
                <p class="lead">Total Customer</p>
            </div>
        </div>
    </div>
    <!-- Today's Total Income Card -->
    <div class="col-md-4">
        <div class="card text-white" style="background-color: #3B4256;">
            <div class="card-body text-center py-4">
                <h1 class="display-4">Rp {{ number_format($todayIncome) }}</h1>
                <p class="lead">Total Income</p>
            </div>
        </div>
    </div>
</div>
<!-- Income Chart -->
<div class="row">
    <div class="col-md-12">
        <div class="card text-white" style="background-color: #3B4256;">
            <div class="card-body py-4">
                <h5 class="card-title">Income Per Hari</h5>
                <div style="position: relative; height: 300px;">
                    <canvas id="incomeChart"></canvas>
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
                borderColor: '#4bc0c0',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.4,
                borderWidth: 3,
                fill: true,
                pointBackgroundColor: '#4bc0c0'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'white',
                        callback: function(value) {
                            return value.toFixed(2);
                        }
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                },
                x: {
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'white'
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
