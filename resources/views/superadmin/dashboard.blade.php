@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Dashboard Super Admin</h2>
            <p class="text-muted mb-0">Monitoring dan Analisis Sistem</p>
        </div>
        <div class="text-end">
            <small class="text-muted d-block">Terakhir diperbarui</small>
            <strong>{{ now()->format('d M Y, H:i') }} WIB</strong>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm rounded h-100">
                <div class="card-body p-4 bg-primary bg-gradient text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-3 opacity-75">Total Produk</h6>
                            <h2 class="fw-bold mb-0">{{ number_format($totalProduk) }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-3 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                            </svg>
                        </div>
                    </div>
                    <small class="opacity-75">Total item dalam inventori</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm rounded-4 border-0 h-100">
                <div class="card-body p-4 bg-success bg-gradient text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-3 opacity-75">Total Pelanggan</h6>
                            <h2 class="fw-bold mb-0">{{ number_format($totalPelanggan) }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-3 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                            </svg>
                        </div>
                    </div>
                    <small class="opacity-75">Pelanggan terdaftar</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm rounded-4 border-0 h-100">
                <div class="card-body p-4 bg-warning bg-gradient text-dark">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-3 opacity-75">Total Penjualan</h6>
                            <h2 class="fw-bold mb-0">{{ number_format($totalPenjualan) }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-3 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart-check" viewBox="0 0 16 16">
                                <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                            </svg>
                        </div>
                    </div>
                    <small class="opacity-75">Transaksi penjualan</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm rounded-4 border-0 h-100">
                <div class="card-body p-4 bg-danger bg-gradient text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-3 opacity-75">Total Pembelian</h6>
                            <h2 class="fw-bold mb-0">{{ number_format($totalPembelian) }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-3 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-bag-check" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
                            </svg>
                        </div>
                    </div>
                    <small class="opacity-75">Transaksi pembelian</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <!-- Revenue Card -->
        <div class="col-lg-4">
            <div class="card shadow-sm rounded-4 border-0 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-graph-up-arrow me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
                        </svg>
                        Pendapatan Minggu Ini
                    </h5>
                    <h2 class="text-success fw-bold mb-2">Rp {{ number_format($pendapatanMingguan, 0, ',', '.') }}</h2>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                    </div>
                    <small class="text-muted mt-2 d-block">Target mingguan tercapai 75%</small>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-lg-8">
            <div class="card shadow-sm rounded-4 border-0 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Statistik Cepat</h5>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="border rounded-3 p-3 bg-light">
                                <small class="text-muted d-block mb-1">Transaksi Hari Ini</small>
                                <h4 class="fw-bold mb-0 text-primary">{{ $transaksiHariIni ?? 0 }}</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded-3 p-3 bg-light">
                                <small class="text-muted d-block mb-1">Produk Terlaris</small>
                                <h4 class="fw-bold mb-0 text-success">{{ $produkTerlaris ?? '-' }}</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded-3 p-3 bg-light">
                                <small class="text-muted d-block mb-1">Stok Menipis</small>
                                <h4 class="fw-bold mb-0 text-warning">{{ $stokMenipis ?? 0 }}</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded-3 p-3 bg-light">
                                <small class="text-muted d-block mb-1">User Aktif</small>
                                <h4 class="fw-bold mb-0 text-danger">{{ $userAktif ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row g-3">
        <div class="col-12">
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold mb-1">Grafik Penjualan</h5>
                            <small class="text-muted">7 Hari Terakhir</small>
                        </div>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary active">7 Hari</button>
                            <button type="button" class="btn btn-outline-secondary">30 Hari</button>
                            <button type="button" class="btn btn-outline-secondary">90 Hari</button>
                        </div>
                    </div>
                    <canvas id="chartPenjualan" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartPenjualan');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($grafik->pluck('tanggal')) !!},
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: {!! json_encode($grafik->pluck('total')) !!},
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: '#0d6efd',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID', {
                                notation: 'compact',
                                compactDisplay: 'short'
                            }).format(value);
                        }
                    },
                    grid: {
                        drawBorder: false,
                    }
                },
                x: {
                    grid: {
                        display: false,
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });
</script>
@endsection