@extends('layouts.app')

@section('title', 'Edit Produk - Laptop Store')

@push('styles')
{{-- Memanggil file CSS eksternal --}}
<link rel="stylesheet" href="{{ asset('css/stok/style.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h1 class="form-title">
                    <i class="bi bi-pencil-square me-2"></i>Edit Produk
                </h1>
                <p class="form-subtitle">Perbarui informasi produk: <strong>{{ $stok->nama_produk }}</strong></p>
            </div>

            <form action="{{ route('stok.update', $stok->id_produk) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Informasi Produk --}}
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="bi bi-info-circle"></i>Informasi Produk
                    </h3>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                Nama Produk <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   name="nama_produk" 
                                   class="form-control @error('nama_produk') is-invalid @enderror" 
                                   value="{{ old('nama_produk', $stok->nama_produk) }}"
                                   placeholder="Contoh: ASUS ROG Strix G15"
                                   required>
                            @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Merk <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   name="merk" 
                                   class="form-control @error('merk') is-invalid @enderror" 
                                   value="{{ old('merk', $stok->merk) }}"
                                   placeholder="Contoh: ASUS"
                                   required>
                            @error('merk')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 
                        ==================================================
                        DITAMBAHKAN: Dropdown Kategori (dengan data terpilih)
                        ==================================================
                        --}}
                        <div class="col-md-12">
                            <label class="form-label">
                                Kategori <span class="required">*</span>
                            </label>
                            <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                                <option value="" disabled>-- Pilih Kategori --</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}" 
                                        {{ old('id_kategori', $stok->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">
                                Spesifikasi <span class="required">*</span>
                            </label>
                            <textarea name="spesifikasi" 
                                      rows="4" 
                                      class="form-control @error('spesifikasi') is-invalid @enderror" 
                                      placeholder="Contoh: Intel Core i7-11800H, RTX 3060, 16GB RAM, 512GB SSD, 15.6 FHD 144Hz"
                                      required>{{ old('spesifikasi', $stok->spesifikasi) }}</textarea>
                            @error('spesifikasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Harga dan Stok --}}
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="bi bi-currency-dollar"></i>Harga & Stok
                    </h3>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">
                                Harga Beli <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text input-group-icon">Rp</span>
                                <input type="number" 
                                       name="harga_beli" 
                                       class="form-control @error('harga_beli') is-invalid @enderror" 
                                       value="{{ old('harga_beli', $stok->harga_beli) }}"
                                       placeholder="0"
                                       min="0"
                                       required>
                            </div>
                            @error('harga_beli')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                Harga Jual <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text input-group-icon">Rp</span>
                                <input type="number" 
                                       name="harga_jual" 
                                       class="form-control @error('harga_jual') is-invalid @enderror" 
                                       value="{{ old('harga_jual', $stok->harga_jual) }}"
                                       placeholder="0"
                                       min="0"
                                       required>
                            </div>
                            @error('harga_jual')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                Stok <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text input-group-icon">
                                    <i class="bi bi-box"></i>
                                </span>
                                <input type="number" 
                                       name="stok" 
                                       class="form-control @error('stok') is-invalid @enderror" 
                                       value="{{ old('stok', $stok->stok) }}"
                                       placeholder="0"
                                       min="0"
                                       required>
                            </div>
                            @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Gambar Produk --}}
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="bi bi-image"></i>Gambar Produk
                    </h3>
                    
                    <div class="row">
                        <div class="col-12">
                            @if($stok->gambar)
                            <div class="mb-3">
                                <span class="badge-info">
                                    <i class="bi bi-image me-2"></i>Gambar Saat Ini
                                </span>
                                <div class="image-preview-container mt-2">
                                    <img src="{{ asset('storage/' . $stok->gambar) }}" alt="Current Image">
                                </div>
                            </div>
                            @endif

                            <label class="form-label">
                                Upload Gambar Baru (Opsional)
                            </label>
                            <input type="file" 
                                   name="gambar" 
                                   class="form-control @error('gambar') is-invalid @enderror"
                                   accept="image/*"
                                   id="imageInput"
                                   onchange="previewImage(event)">
                            <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</small>
                            @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="image-preview-container mt-2" id="imagePreview" style="display: none;">
                                <div class="image-placeholder">
                                    <i class="bi bi-image"></i>
                                    <p>Preview gambar baru</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between gap-3 mt-4">
                    <a href="{{ route('stok.index') }}" class="btn btn-secondary-custom">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-save me-2"></i>Update Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Memanggil file JS eksternal --}}
<script src="{{ asset('js/stok/image-preview.js') }}"></script>
@endpush