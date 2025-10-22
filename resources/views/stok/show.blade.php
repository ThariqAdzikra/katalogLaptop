@extends('layouts.app')

@section('title', 'Detail Produk - Laptop Store')

@push('styles')
{{-- Memanggil file CSS eksternal --}}
<link rel="stylesheet" href="{{ asset('css/stok/style.css') }}">
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
                            <span class="badge-merk show-page">{{ $stok->merk }}</span>
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