@extends('layouts.app')

@section('title', 'Manajemen Stok - Laptop Store')

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

    /* Page Header */
    .page-header {
        background: #ffffff;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-soft);
        border-left: 4px solid var(--primary-wood);
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: var(--text-medium);
        font-size: 0.95rem;
    }

    /* Stats Cards */
    .stats-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        border-top: 3px solid var(--primary-wood);
    }

    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        background: var(--cream-bg);
        color: var(--primary-wood);
    }

    .stats-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 0.25rem;
    }

    .stats-label {
        color: var(--text-medium);
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.75rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-soft);
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        border: 2px solid var(--border-soft);
        border-radius: 8px;
        padding: 0.625rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-wood);
        box-shadow: 0 0 0 0.2rem rgba(141, 111, 86, 0.15);
    }

    /* Table Card */
    .table-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 0;
        box-shadow: var(--shadow-soft);
        overflow: hidden;
    }

    .table-header {
        background: var(--cream-bg);
        padding: 1.25rem 1.5rem;
        border-bottom: 2px solid var(--border-soft);
    }

    .table-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin: 0;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: var(--primary-wood);
        color: #ffffff;
        border: none;
        padding: 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .table tbody tr {
        border-bottom: 1px solid var(--border-soft);
        transition: background 0.2s ease;
    }

    .table tbody tr:hover {
        background: var(--cream-bg);
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: var(--text-dark);
    }

    .product-img-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--border-soft);
    }

    /* Badges */
    .badge-stock {
        padding: 0.4rem 0.875rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
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

    .badge-merk {
        background: var(--primary-wood);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* Buttons */
    .btn-primary-custom {
        background: var(--primary-wood);
        border: none;
        padding: 0.65rem 1.5rem;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-primary-custom:hover {
        background: var(--primary-main);
        transform: translateY(-2px);
        box-shadow: var(--shadow-soft);
        color: white;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.3s ease;
        margin: 0 2px;
        font-size: 0.875rem;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-detail {
        background: #17a2b8;
        color: white;
    }

    .btn-detail:hover {
        background: #138496;
    }

    .btn-edit {
        background: #ffc107;
        color: #000;
    }

    .btn-edit:hover {
        background: #e0a800;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #c82333;
    }

    .btn-search, .btn-reset {
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        font-size: 0.95rem;
    }

    .btn-search {
        background: var(--primary-wood);
        color: white;
    }

    .btn-search:hover {
        background: var(--primary-main);
        color: white;
    }

    .btn-reset {
        background: var(--cream-bg);
        color: var(--text-dark);
    }

    .btn-reset:hover {
        background: var(--border-soft);
    }

    /* Alert */
    .alert-custom {
        border-radius: 10px;
        border: none;
        padding: 1rem 1.25rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-soft);
        border-left: 4px solid;
    }

    .alert-success {
        background: #d4edda;
        border-left-color: #28a745;
        color: #155724;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--text-medium);
        opacity: 0.5;
        margin-bottom: 1.5rem;
    }

    .empty-state h4 {
        color: var(--text-dark);
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: var(--text-medium);
    }

    /* Pagination */
    .pagination {
        margin-top: 2rem;
    }

    .page-link {
        border-radius: 6px;
        margin: 0 3px;
        border: 2px solid var(--border-soft);
        color: var(--primary-wood);
        padding: 0.5rem 0.875rem;
    }

    .page-link:hover {
        background: var(--primary-wood);
        color: white;
        border-color: var(--primary-wood);
    }

    .page-item.active .page-link {
        background: var(--primary-wood);
        border-color: var(--primary-wood);
    }
</style>
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

    {{-- Statistics Cards --}}
    <div class="row">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="bi bi-archive"></i>
                </div>
                <div class="stats-value">{{ $produk->total() }}</div>
                <div class="stats-label">Total Produk</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #d4edda; color: #28a745;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stats-value">{{ $produk->where('stok', '>', 5)->count() }}</div>
                <div class="stats-label">Stok Tersedia</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #fff3cd; color: #fd7e14;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stats-value">{{ $produk->where('stok', '>', 0)->where('stok', '<=', 5)->count() }}</div>
                <div class="stats-label">Stok Menipis</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #f8d7da; color: #dc3545;">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stats-value">{{ $produk->where('stok', 0)->count() }}</div>
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
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Produk</th>
                        <th>Merk</th>
                        <th>Spesifikasi</th>
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
                        <td>
                            <small class="text-muted">{{ Str::limit($item->spesifikasi, 40) }}</small>
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