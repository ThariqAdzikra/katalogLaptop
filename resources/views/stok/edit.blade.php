@extends('layouts.app')

@section('title', 'Edit Produk - Laptop Store')

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

    body {
        background: var(--cream-bg);
        min-height: 100vh;
        padding-top: 80px;
    }

    .form-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        padding: 3rem;
        box-shadow: var(--shadow-soft);
        margin-bottom: 2rem;
        border-top: 4px solid var(--primary-wood);
    }

    .form-header {
        text-align: center;
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid var(--border-soft);
    }

    .form-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 0.5rem;
    }

    .form-subtitle {
        color: var(--text-medium);
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-label .required {
        color: #dc3545;
    }

    .form-control, .form-select, textarea {
        border-radius: 8px;
        border: 2px solid var(--border-soft);
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus, textarea:focus {
        border-color: var(--primary-wood);
        box-shadow: 0 0 0 0.2rem rgba(141, 111, 86, 0.15);
        outline: none;
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: block;
    }

    .image-preview-container {
        width: 100%;
        height: 250px;
        border: 2px dashed var(--border-soft);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 1rem;
        overflow: hidden;
        background: var(--cream-bg);
        position: relative;
        transition: all 0.3s ease;
    }

    .image-preview-container:hover {
        border-color: var(--primary-wood);
    }

    .image-preview-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .image-placeholder {
        text-align: center;
        color: var(--text-medium);
    }

    .image-placeholder i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .btn-primary-custom {
        background: var(--primary-wood);
        border: none;
        padding: 0.875rem 2.5rem;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        background: var(--primary-main);
        transform: translateY(-2px);
        box-shadow: var(--shadow-soft);
        color: white;
    }

    .btn-secondary-custom {
        background: var(--cream-bg);
        border: none;
        padding: 0.875rem 2.5rem;
        border-radius: 8px;
        color: var(--text-dark);
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary-custom:hover {
        background: var(--border-soft);
    }

    .input-group-icon {
        background: var(--primary-wood);
        border: none;
        color: white;
        border-radius: 8px 0 0 8px;
        padding: 0.75rem 1rem;
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 8px 8px 0;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid var(--border-soft);
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 0.75rem;
        color: var(--primary-wood);
    }

    .current-image {
        position: relative;
        display: inline-block;
    }

    .badge-info {
        background: var(--primary-wood);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }

    .text-muted {
        color: var(--text-medium) !important;
        font-size: 0.85rem;
    }
</style>
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
<script>
    function previewImage(event) {
        const reader = new FileReader();
        const imagePreview = document.getElementById('imagePreview');
        
        reader.onload = function() {
            imagePreview.style.display = 'flex';
            imagePreview.innerHTML = `<img src="${reader.result}" alt="Preview">`;
        }
        
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        } else {
            imagePreview.style.display = 'none';
        }
    }
</script>
@endpush