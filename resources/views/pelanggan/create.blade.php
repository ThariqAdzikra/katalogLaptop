@extends('layouts.app')
@section('title', 'Tambah Pelanggan - Laptop Store')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/stok/style.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h1 class="form-title"><i class="bi bi-person-plus me-2"></i>Tambah Pelanggan Baru</h1>
                <p class="form-subtitle">Lengkapi form di bawah ini untuk menambahkan pelanggan</p>
            </div>

            <form method="POST" action="{{ route('pelanggan.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama <span class="required">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}" required>
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" rows="3" class="form-control">{{ old('alamat') }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between gap-3 mt-4">
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary-custom">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <button class="btn btn-primary-custom" type="submit">
                        <i class="bi bi-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
