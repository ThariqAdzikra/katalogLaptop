@extends('layouts.app')

@section('title', 'Data Pembelian - Laptop Store')

@push('styles')
{{-- Anda bisa gunakan salah satu, tapi stok/style.css sepertinya yang Anda inginkan --}}
<link rel="stylesheet" href="{{ asset('css/manajemen/style.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('css/pembelian/style.css') }}"> --}}
@endpush

@section('content')
<div class="container py-4">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="bi bi-cart-check me-2"></i>Data Pembelian
                </h1>
                <p class="page-subtitle">Kelola data pembelian dari supplier</p>
            </div>
            <a href="{{ route('pembelian.create') }}" class="btn btn-primary-custom">
                <i class="bi bi-plus-circle me-2"></i>Tambah Pembelian
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

    {{-- Table Section --}}
    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">
                <i class="bi bi-table me-2"></i>Daftar Pembelian
            </h3>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembelian as $p)
                    <tr>
                        <td>
                            <span class="badge-number">
                                {{ $loop->iteration + ($pembelian->currentPage() - 1) * $pembelian->perPage() }}
                            </span>
                        </td>
                        <td class="fw-semibold">
                            {{ \Carbon\Carbon::parse($p->tanggal_pembelian)->format('d M Y') }}
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $p->supplier->nama_supplier ?? '-' }}</div>
                        </td>
                        <td>
                            <span class="price-highlight fs-5">
                                Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('pembelian.edit', $p->id_pembelian) }}" 
                                   class="btn-action btn-edit"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('pembelian.destroy', $p->id_pembelian) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data pembelian ini?')">
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
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h4>Tidak Ada Data Pembelian</h4>
                                <p>Belum ada transaksi pembelian yang tercatat.</p>
                                <a href="{{ route('pembelian.create') }}" class="btn btn-primary-custom mt-3">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Pembelian Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ✅ PAGINATION DIPERBAIKI (menggunakan text-center) --}}
        @if($pembelian->hasPages())
            <div class="p-4 text-center">
                {{ $pembelian->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>
</div>
@endsection