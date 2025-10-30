@extends('layouts.app')

@section('title', 'Manajemen Stok - Laptop Store')

@push('styles')
{{-- Memanggil file CSS eksternal --}}
<link rel="stylesheet" href="{{ asset('css/stok/style.css') }}">
@endpush

@section('content')
<div class="container py-4">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="bi bi-box-seam me-2"></i>Manajemen Stok
                </h1>
                <p class="page-subtitle">Kelola inventori dan stok produk laptop</p>
            </div>
            <a href="{{ route('stok.create') }}" class="btn btn-primary-custom">
                <i class="bi bi-plus-circle me-2"></i>Tambah Produk
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- 
    ==================================================
    DIPERBARUI: Statistik sekarang menggunakan var $stats dari controller
    ==================================================
    --}}
    <div class="row">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="bi bi-archive"></i>
                </div>
                <div class="stats-value">{{ $stats['total'] }}</div>
                <div class="stats-label">Total Produk</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #d4edda; color: #28a745;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stats-value">{{ $stats['tersedia'] }}</div>
                <div class="stats-label">Stok Tersedia</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #fff3cd; color: #fd7e14;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stats-value">{{ $stats['menipis'] }}</div>
                <div class="stats-label">Stok Menipis</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #f8d7da; color: #dc3545;">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stats-value">{{ $stats['habis'] }}</div>
                <div class="stats-label">Stok Habis</div>
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="filter-card">
        <form action="{{ route('stok.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">
                        <i class="bi bi-search me-2"></i>Cari Produk
                    </label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           class="form-control" 
                           placeholder="Cari nama produk, merk, atau spesifikasi...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">
                        <i class="bi bi-funnel me-2"></i>Status Stok
                    </label>
                    <select name="status_stok" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status_stok') == 'tersedia' ? 'selected' : '' }}>
                            Tersedia (> 5)
                        </option>
                        <option value="menipis" {{ request('status_stok') == 'menipis' ? 'selected' : '' }}>
                            Menipis (1-5)
                        </option>
                        <option value="habis" {{ request('status_stok') == 'habis' ? 'selected' : '' }}>
                            Habis (0)
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">
                        <i class="bi bi-sort-down me-2"></i>Urutkan
                    </label>
                    <select name="sort_by" class="form-select">
                        <option value="nama_produk">Nama</option>
                        <option value="stok" {{ request('sort_by') == 'stok' ? 'selected' : '' }}>Stok</option>
                        <option value="harga_jual" {{ request('sort_by') == 'harga_jual' ? 'selected' : '' }}>Harga</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-search flex-fill">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="{{ route('stok.index') }}" class="btn btn-reset flex-fill">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Table Section --}}
    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">
                <i class="bi bi-table me-2"></i>Daftar Produk
            </h3>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    {{-- 
                    ==================================================
                    DIPERBARUI: Kolom 'Spesifikasi' diganti 'Kategori'
                    ==================================================
                    --}}
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Produk</th>
                        <th>Merk</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $item)
                    <tr>
                        <td class="fw-semibold">{{ $loop->iteration + ($produk->currentPage() - 1) * $produk->perPage() }}</td>
                        <td>
                            @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" 
                                 alt="{{ $item->nama_produk }}" 
                                 class="product-img-thumb">
                            @else
                            <div class="product-img-thumb d-flex align-items-center justify-content-center bg-light">
                                <i class="bi bi-laptop" style="font-size: 1.5rem; color: #adb5bd;"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $item->nama_produk }}</div>
                        </td>
                        <td>
                            <span class="badge-merk">{{ $item->merk }}</span>
                        </td>
                        {{-- 
                        ==================================================
                        DIPERBARUI: Menampilkan nama kategori
                        ==================================================
                        --}}
                        <td>
                            {{ $item->kategori->nama_kategori ?? '-' }}
                        </td>
                        <td class="fw-semibold" style="color: #28a745;">
                            Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                        </td>
                        <td class="fw-semibold" style="color: #17a2b8;">
                            Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="fs-5 fw-bold">{{ $item->stok }}</span>
                        </td>
                        <td>
                            @if($item->stok == 0)
                            <span class="badge-stock badge-habis">
                                <i class="bi bi-x-circle me-1"></i>Habis
                            </span>
                            @elseif($item->stok <= 5)
                            <span class="badge-stock badge-menipis">
                                <i class="bi bi-exclamation-triangle me-1"></i>Menipis
                            </span>
                            @else
                            <span class="badge-stock badge-tersedia">
                                <i class="bi bi-check-circle me-1"></i>Tersedia
                            </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('stok.show', $item->id_produk) }}" 
                                   class="btn-action btn-detail"
                                   title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('stok.edit', $item->id_produk) }}" 
                                   class="btn-action btn-edit"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('stok.destroy', $item->id_produk) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn-action btn-delete"
                                            title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h4>Tidak Ada Data Produk</h4>
                                <p>Belum ada produk yang ditambahkan ke stok.</p>
                                <a href="{{ route('stok.create') }}" class="btn btn-primary-custom mt-3">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Produk Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($produk->hasPages())
        <div class="d-flex justify-content-center p-4">
            {{ $produk->links() }}
        </div>
        @endif
    </div>
</div>
@endsection