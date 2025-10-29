@extends('layouts.app')

@section('title', 'Manajemen Pelanggan - Laptop Store')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/stok/style.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"><i class="bi bi-people me-2"></i>Manajemen Pelanggan</h1>
            <p class="page-subtitle">Kelola data pelanggan yang terdaftar dalam sistem</p>
        </div>
        <a href="{{ route('pelanggan.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-circle me-2"></i>Tambah Pelanggan
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-custom mt-3">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
    @endif

    <div class="filter-card mt-4">
        <form method="GET" action="{{ route('pelanggan.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-10">
                    <label class="form-label">
                        <i class="bi bi-search me-2"></i>Cari Pelanggan
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Cari berdasarkan nama, email, atau nomor HP...">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-search w-100" type="submit">
                        <i class="bi bi-search me-2"></i>Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-card mt-4">
        <div class="table-header">
            <h3 class="table-title"><i class="bi bi-table me-2"></i>Daftar Pelanggan</h3>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama Pelanggan</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggan as $p)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + ($pelanggan->currentPage() - 1) * $pelanggan->perPage() }}</td>
                        <td><strong>{{ $p->nama }}</strong></td>
                        <td>{{ $p->no_hp ?? '-' }}</td>
                        <td>{{ $p->email ?? '-' }}</td>
                        <td>{{ $p->alamat ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('pelanggan.edit', $p->id_pelanggan) }}" 
                                   class="btn-action btn-edit"
                                   title="Edit Pelanggan">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan {{ $p->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action btn-delete" type="submit" title="Hapus Pelanggan">
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
                                <h4>Belum Ada Data Pelanggan</h4>
                                <p>Tambahkan pelanggan pertama untuk memulai pengelolaan data pelanggan.</p>
                                <a href="{{ route('pelanggan.create') }}" class="btn btn-primary-custom mt-2">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Pelanggan
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pelanggan->hasPages())
        <div class="d-flex justify-content-center align-items-center p-4">
            {{ $pelanggan->links() }}
        </div>
        @endif
    </div>
</div>
@endsection