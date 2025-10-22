@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/pembelian-style.css') }}">

<div class="pembelian-container">
    <div class="header-card">
        <div class="d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-shopping-cart"></i> Data Pembelian</h3>
            <a href="{{ route('pembelian.create') }}" class="btn btn-add">
                <i class="fas fa-plus"></i> Tambah Pembelian
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-card">
        @if($pembelian->count() > 0)
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
                @foreach ($pembelian as $p)
                    <tr>
                        <td>
                            <span class="badge-number">{{ $loop->iteration }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pembelian)->format('d M Y') }}</td>
                        <td>
                            <strong>{{ $p->supplier->nama_supplier ?? '-' }}</strong>
                        </td>
                        <td>
                            <strong style="color: var(--primary-accent);">
                                Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                            </strong>
                        </td>
                        <td class="action-cell">
                            <a href="{{ route('pembelian.edit', $p->id_pembelian) }}" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('pembelian.destroy', $p->id_pembelian) }}" method="POST" onsubmit="return confirm('Yakin hapus data pembelian ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-delete">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h5>Belum ada data pembelian</h5>
            <p>Klik tombol "Tambah Pembelian" untuk memulai</p>
        </div>
        @endif
    </div>
</div>
@endsection