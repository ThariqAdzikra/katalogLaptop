@extends('layouts.app')

@section('title', 'Manajemen Penjualan - Laptop Store')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/manajemen/style.css') }}">
@endpush

@section('content')
<div class="container py-4">

  {{-- Page Header --}}
  <div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h1 class="page-title">
          <i class="bi bi-cash-coin me-2"></i> Manajemen Penjualan
        </h1>
        <p class="page-subtitle">Kelola transaksi penjualan dan histori pelanggan</p>
      </div>
      <a href="{{ route('penjualan.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-circle me-2"></i>Tambah Penjualan
      </a>
    </div>
  </div>

  {{-- Alert --}}
  @if(session('success'))
  <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  {{-- Statistik Ringkas --}}
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="stats-card">
        <div class="stats-icon" style="background: #e9ecef; color: #0d6efd;">
          <i class="bi bi-receipt"></i>
        </div>
        <div class="stats-value">{{ $penjualan->total() ?? $penjualan->count() }}</div>
        <div class="stats-label">Total Transaksi</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-card">
        <div class="stats-icon" style="background: #e6ffed; color: #28a745;">
          <i class="bi bi-people"></i>
        </div>
        <div class="stats-value">{{ $penjualan->groupBy('id_pelanggan')->count() }}</div>
        <div class="stats-label">Total Pelanggan</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-card">
        <div class="stats-icon" style="background: #fff3cd; color: #fd7e14;">
          <i class="bi bi-wallet2"></i>
        </div>
        <div class="stats-value">
          Rp {{ number_format($penjualan->sum('total_harga'), 0, ',', '.') }}
        </div>
        <div class="stats-label">Total Pendapatan</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-card">
        <div class="stats-icon" style="background: #d1ecf1; color: #17a2b8;">
          <i class="bi bi-calendar3"></i>
        </div>
        <div class="stats-value">
          {{ $penjualan->where('tanggal_penjualan', '>=', now()->startOfMonth())->count() }}
        </div>
        <div class="stats-label">Transaksi Bulan Ini</div>
      </div>
    </div>
  </div>

  {{-- Filter Section --}}
  <div class="filter-card mb-4">
    <form method="GET" action="{{ route('penjualan.index') }}">
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label"><i class="bi bi-search me-2"></i>Cari Pelanggan</label>
          <input type="text" name="search" class="form-control" placeholder="Nama pelanggan..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
          <label class="form-label"><i class="bi bi-funnel me-2"></i>Metode Pembayaran</label>
          <select name="metode" class="form-select">
            <option value="">Semua</option>
            <option value="cash" {{ request('metode') == 'cash' ? 'selected' : '' }}>Cash</option>
            <option value="transfer" {{ request('metode') == 'transfer' ? 'selected' : '' }}>Transfer</option>
            <option value="qris" {{ request('metode') == 'qris' ? 'selected' : '' }}>QRIS</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label"><i class="bi bi-calendar me-2"></i>Urutkan Berdasarkan</label>
          <select name="sort" class="form-select">
            <option value="tanggal" {{ request('sort') == 'tanggal' ? 'selected' : '' }}>Tanggal</option>
            <option value="total" {{ request('sort') == 'total' ? 'selected' : '' }}>Total Harga</option>
            <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama Pelanggan</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-search w-100">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </div>
    </form>
  </div>

  {{-- Table Section --}}
  <div class="table-card">
    <div class="table-header d-flex justify-content-between align-items-center">
      <h3 class="table-title">
        <i class="bi bi-table me-2"></i>Daftar Penjualan
      </h3>
      <a href="{{ route('penjualan.laporan') }}" class="btn btn-outline-info btn-sm">
        <i class="bi bi-bar-chart-line"></i> Laporan
      </a>
    </div>

    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Metode</th>
            <th>Total Harga</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($penjualan as $p)
          <tr>
            {{-- Penomoran yang benar --}}
            <td>{{ $loop->iteration + ($penjualan->currentPage() - 1) * $penjualan->perPage() }}</td>
            <td>{{ \Carbon\Carbon::parse($p->tanggal_penjualan)->format('d M Y H:i') }}</td>
            <td>{{ $p->pelanggan->nama ?? '-' }}</td>
            <td>
              <span class="badge 
                {{ $p->metode_pembayaran == 'cash' ? 'bg-success' : 
                  ($p->metode_pembayaran == 'transfer' ? 'bg-primary' : 'bg-warning text-dark') }}">
                {{ strtoupper($p->metode_pembayaran) }}
              </span>
            </td>
            <td class="fw-semibold text-primary">
              Rp {{ number_format($p->total_harga, 0, ',', '.') }}
            </td>
            <td>
              <div class="d-flex gap-2">
                <a href="{{ route('penjualan.edit', $p->id_penjualan) }}" 
                   class="btn-action btn-edit" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('penjualan.destroy', $p->id_penjualan) }}" 
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-action btn-delete" title="Hapus">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6">
              <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h4>Tidak Ada Transaksi Penjualan</h4>
                <p>Belum ada transaksi yang tercatat dalam sistem.</p>
                <a href="{{ route('penjualan.create') }}" class="btn btn-primary-custom mt-3">
                  <i class="bi bi-plus-circle me-2"></i>Tambah Transaksi Pertama
                </a>
              </div>
            </td>
          </tr>
          @endForelse
        </tbody>
      </table>
    </div>

    {{-- ✅ PAGINATION (INI YANG DIPERBAIKI) --}}
    @if($penjualan->hasPages())
    <div class="d-flex justify-content-center p-4">
      {{-- 
        Gunakan .onEachSide(1) untuk membuatnya ringkas 
        (cth: ... 2 [3] 4 ...)
      --}}
      {{ $penjualan->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
    @endif
    
  </div>
</div>
@endsection