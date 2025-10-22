@extends('layouts.app')

@section('title', 'Detail Produk - Laptop Store')

@push('styles')
<style>
    :root {
        --primary-dark: #3d2817;
        --primary-main: #7a5c47;
        --primary-wood: #8d6f56;
        --primary-accent: #6b7e4a;
        --primary-highlight: #e8c77d;
        --cream-bg: #f5f1e8;
        --text-dark: #2d2520;
        --text-medium: #5d5349;
        --border-soft: #e5dfd5;
        --shadow-soft: 0 2px 8px rgba(61, 40, 23, 0.08);
        --shadow-hover: 0 8px 24px rgba(61, 40, 23, 0.12);
    }

    body {
        background: var(--cream-bg);
        min-height: 100vh;
        padding-top: 80px;
    }

    .detail-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .detail-card {
        background: white;
        border-radius: 12px;
        padding: 0;
        box-shadow: var(--shadow-soft);
        margin-bottom: 2rem;
        overflow: hidden;
        border-top: 4px solid var(--primary-wood);
    }

    .detail-header {
        background: var(--primary-wood);
        padding: 2.5rem;
        color: white;
    }

    .detail-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .detail-subtitle {
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .detail-body {
        padding: 2.5rem;
    }

    .product-image-section {
        background: var(--cream-bg);
        border-radius: 12px;
        padding: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 400px;
        margin-bottom: 2rem;
        border: 2px solid var(--border-soft);
    }

    .product-image-section img {
        max-width: 100%;
        max-height: 400px;
        object-fit: contain;
        border-radius: 8px;
    }

    .product-image-placeholder {
        text-align: center;
        color: var(--text-medium);
    }

    .product-image-placeholder i {
        font-size: 8rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .info-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border-soft);
    }

    .section-title i {
        margin-right: 0.75rem;
        color: var(--primary-wood);
    }

    .info-row {
        display: flex;
        padding: 1rem 0;
        border-bottom: 1px solid var(--cream-bg);
    }

    .info-label {
        font-weight: 600;
        color: var(--text-medium);
        width: 200px;
        flex-shrink: 0;
    }

    .info-value {
        color: var(--text-dark);
        flex-grow: 1;
        font-weight: 500;
    }

    .price-highlight {
        font-size: 1.5rem;
        font-weight: 700;
        color: #28a745;
    }

    .badge-stock-detail {
        padding: 0.75rem 1.5rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 1rem;
        display: inline-block;
    }

    .badge-habis {
        background: #dc3545;
        color: white;
    }

    .badge-menipis {
        background: #fd7e14;
        color: white;
    }

    .badge-tersedia {
        background: #28a745;
        color: white;
    }

    .btn-action-detail {
        padding: 0.875rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-edit-detail {
        background: #ffc107;
        color: #000;
    }

    .btn-edit-detail:hover {
        background: #e0a800;
        transform: translateY(-2px);
        box-shadow: var(--shadow-soft);
    }

    .btn-delete-detail {
        background: #dc3545;
        color: white;
    }

    .btn-delete-detail:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: var(--shadow-soft);
    }

    .btn-back-detail {
        background: var(--cream-bg);
        color: var(--text-dark);
    }

    .btn-back-detail:hover {
        background: var(--border-soft);
    }

    .profit-card {
        background: var(--primary-wood);
        color: white;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: var(--shadow-soft);
    }

    .profit-label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }

    .profit-value {
        font-size: 1.75rem;
        font-weight: 700;
    }

    .badge-merk {
        background: var(--primary-wood);
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 20px;
        font-size: 1rem;
        font-weight: 600;
    }

    .price-box {
        background: var(--cream-bg);
        border-radius: 12px;
        padding: 1.5rem;
        border: 2px solid var(--border-soft);
    }

    .price-label {
        font-size: 0.9rem;
        color: var(--text-medium);
        margin-bottom: 0.5rem;
    }

    .price-amount {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .price-buy {
        color: #dc3545;
    }

    .price-sell {
        color: #28a745;
    }

    code {
        background: var(--cream-bg);
        padding: 0.25rem 0.75rem;
        border-radius: 5px;
        color: var(--primary-dark);
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="detail-container">
        <div class="detail-card">
            <div class="detail-header">
                <h1 class="detail-title">
                    <i class="bi bi-info-circle-fill me-2"></i>Detail Produk
                </h1>
                <p class="detail-subtitle">Informasi lengkap produk</p>
            </div>

            <div class="detail-body">
                {{-- Product Image --}}
                <div class="product-image-section">
                    @if($stok->gambar)
                        <img src="{{ asset('storage/' . $stok->gambar) }}" alt="{{ $stok->nama_produk }}">
                    @else
                        <div class="product-image-placeholder">
                            <i class="bi bi-laptop"></i>
                            <p>Tidak ada gambar</p>
                        </div>
                    @endif
                </div>

                {{-- Basic Information --}}
                <div class="info-section">
                    <h3 class="section-title">
                        <i class="bi bi-info-circle"></i>Informasi Dasar
                    </h3>
                    
                    <div class="info-row">
                        <div class="info-label">Nama Produk</div>
                        <div class="info-value">{{ $stok->nama_produk }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Merk</div>
                        <div class="info-value">
                            <span class="badge-merk">{{ $stok->merk }}</span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Spesifikasi</div>
                        <div class="info-value">{{ $stok->spesifikasi }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">ID Produk</div>
                        <div class="info-value">
                            <code>#{{ $stok->id_produk }}</code>
                        </div>
                    </div>
                </div>

                {{-- Pricing Information --}}
                <div class="info-section">
                    <h3 class="section-title">
                        <i class="bi bi-currency-dollar"></i>Informasi Harga
                    </h3>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="price-box">
                                <div class="price-label">Harga Beli</div>
                                <div class="price-amount price-buy">
                                    Rp {{ number_format($stok->harga_beli, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="price-box">
                                <div class="price-label">Harga Jual</div>
                                <div class="price-amount price-sell">
                                    Rp {{ number_format($stok->harga_jual, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="profit-card">
                                <div class="profit-label">Margin Keuntungan</div>
                                <div class="profit-value">
                                    Rp {{ number_format($stok->harga_jual - $stok->harga_beli, 0, ',', '.') }}
                                </div>
                                <small style="opacity: 0.9;">
                                    {{ $stok->harga_beli > 0 ? number_format((($stok->harga_jual - $stok->harga_beli) / $stok->harga_beli) * 100, 1) : 0 }}%
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Stock Information --}}
                <div class="info-section">
                    <h3 class="section-title">
                        <i class="bi bi-box-seam"></i>Informasi Stok
                    </h3>

                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Jumlah Stok</div>
                                <div class="info-value">
                                    <span style="font-size: 2rem; font-weight: 700; color: var(--primary-wood);">
                                        {{ $stok->stok }}
                                    </span>
                                    <span class="text-muted">Unit</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Status Stok</div>
                                <div class="info-value">
                                    @if($stok->stok == 0)
                                        <span class="badge-stock-detail badge-habis">
                                            <i class="bi bi-x-circle me-2"></i>Stok Habis
                                        </span>
                                    @elseif($stok->stok <= 5)
                                        <span class="badge-stock-detail badge-menipis">
                                            <i class="bi bi-exclamation-triangle me-2"></i>Stok Menipis
                                        </span>
                                    @else
                                        <span class="badge-stock-detail badge-tersedia">
                                            <i class="bi bi-check-circle me-2"></i>Stok Tersedia
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Total Nilai Stok</div>
                        <div class="info-value">
                            <span class="price-highlight">
                                Rp {{ number_format($stok->harga_jual * $stok->stok, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Timestamps --}}
                <div class="info-section">
                    <h3 class="section-title">
                        <i class="bi bi-clock-history"></i>Riwayat
                    </h3>

                    <div class="info-row">
                        <div class="info-label">Ditambahkan Pada</div>
                        <div class="info-value">
                            <i class="bi bi-calendar-check me-2"></i>
                            {{ $stok->created_at ? $stok->created_at->format('d M Y, H:i') : '-' }}
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Terakhir Diubah</div>
                        <div class="info-value">
                            <i class="bi bi-calendar-event me-2"></i>
                            {{ $stok->updated_at ? $stok->updated_at->format('d M Y, H:i') : '-' }}
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between gap-3 mt-4 pt-4 border-top">
                    <a href="{{ route('stok.index') }}" class="btn btn-action-detail btn-back-detail">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <div class="d-flex gap-3">
                        <a href="{{ route('stok.edit', $stok->id_produk) }}" class="btn btn-action-detail btn-edit-detail">
                            <i class="bi bi-pencil-square me-2"></i>Edit Produk
                        </a>
                        <form action="{{ route('stok.destroy', $stok->id_produk) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-action-detail btn-delete-detail">
                                <i class="bi bi-trash me-2"></i>Hapus Produk
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection