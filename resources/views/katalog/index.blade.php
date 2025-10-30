@extends('layouts.app')

@section('title', 'Katalog Laptop - Laptop Store')

@push('styles')
    {{-- Memuat CSS spesifik untuk halaman katalog --}}
    <link rel="stylesheet" href="{{ asset('css/katalog.css') }}">
@endpush

@section('content')
{{-- Hero Section with Warm Ambiance --}}
<div class="hero-section">
    <div class="hero-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="hero-title">
                        Temukan Laptop<br>
                        <span class="hero-highlight">Impian Anda</span>
                    </h1>
                    <p class="hero-subtitle">
                        Koleksi laptop terlengkap dengan spesifikasi terbaik untuk kebutuhan kerja, gaming, dan entertainment. Dapatkan harga terbaik dengan garansi resmi dan layanan purna jual terpercaya.
                    </p>
                    <a href="#katalog" class="btn btn-hero">
                        <i class="bi bi-arrow-down-circle me-2"></i>Jelajahi Katalog
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filter Section with Cozy Design --}}
<div class="container">
    <div class="filter-section" id="katalog">
        <div class="filter-card">
            <form action="{{ route('katalog.index') }}" method="GET">
                <div class="row g-4 align-items-end">
                    <div class="col-lg-6">
                        <label class="form-label">
                            <i class="bi bi-search me-2"></i>Cari Produk
                        </label>
                        <div class="position-relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   class="form-control" 
                                   placeholder="Ketik nama laptop atau spesifikasi...">
                            <i class="bi bi-search search-icon"></i>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">
                            <i class="bi bi-filter me-2"></i>Kategori
                        </label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->slug }}" {{ request('kategori') == $kat->slug ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('katalog.index') }}" class="btn btn-reset flex-fill">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                            <button type="submit" class="btn btn-search flex-fill">
                                <i class="bi bi-search me-2"></i>Cari
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Section Header --}}
    <div class="section-header mt-5 pt-5">
        <h2 class="section-title">Katalog Laptop Premium</h2>
        <div class="section-divider"></div>
        {{-- Pastikan $produk memiliki data total() dari pagination --}}
        <p class="section-subtitle">Menampilkan {{ $produk->total() }} produk berkualitas tinggi</p>
    </div>

    {{-- Product Grid --}}
    <div class="row g-4 pb-5">
        @forelse($produk as $item)
        <div class="col-md-6 col-lg-4">
            <div class="product-card">
                <div class="product-img-wrapper">
                    @if($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" 
                             alt="{{ $item->nama_produk }}" 
                             class="product-img">
                    @else
                        <i class="bi bi-laptop" style="font-size: 4.5rem; color: var(--border-soft);"></i>
                    @endif
                    
                    @if($item->stok > 0)
                        <span class="product-badge badge-success">
                            <i class="bi bi-check-circle me-1"></i>Stok: {{ $item->stok }}
                        </span>
                    @else
                        <span class="product-badge badge-danger">
                            <i class="bi bi-x-circle me-1"></i>Habis
                        </span>
                    @endif
                </div>

                <div class="product-body">
                    <div class="d-flex gap-2 mb-2">
                        <span class="badge-brand">{{ $item->merk }}</span>
                        <span class="badge-brand" style="background-color: var(--primary-wood); color: white;">
                            {{ $item->kategori->nama_kategori ?? '-' }}
                        </span>
                    </div>
                    
                    <h5 class="product-title">{{ $item->nama_produk }}</h5>
                    
                    <p class="product-desc">{{ $item->spesifikasi }}</p>
                    
                    <div class="product-price">
                        Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                    </div>
                    
                    <div class="d-flex">
                        <a href="{{ route('stok.show', $item->id_produk) }}" class="btn btn-detail flex-fill">
                            <i class="bi bi-eye me-2"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h3>Produk Tidak Ditemukan</h3>
                <p>Coba ubah kata kunci pencarian atau filter kategori Anda untuk menemukan produk yang sesuai</p>
                <a href="{{ route('katalog.index') }}" class="btn btn-search mt-4">
                    <i class="bi bi-arrow-clockwise me-2"></i>Lihat Semua Produk
                </a>
            </div>
        </div>
        @endforelse
    </div>

    {{-- ✅ PAGINATION (SUDAH DIPERBAIKI SESUAI PERMINTAAN) --}}
    @if($produk->hasPages())
    <div class="d-flex justify-content-center pb-5">
        {{-- 
          - appends(request()->query()) agar filter tetap aktif saat pindah halaman 
          - onEachSide(1) agar pagination ringkas (cth: 1, 2, [3], 4, 5, ...)
          - links('pagination::bootstrap-5') agar memakai gaya Bootstrap 5
        --}}
        {{ $produk->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection