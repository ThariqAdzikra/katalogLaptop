@extends('layouts.app')

@section('title', 'Tambah Pembelian - Laptop Store')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/manajemen/style.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h1 class="form-title">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Pembelian Baru
                </h1>
                <p class="form-subtitle">Lengkapi form di bawah ini untuk mencatat pembelian dari supplier</p>
            </div>

            <form action="{{ route('pembelian.store') }}" method="POST">
                @csrf

                {{-- Informasi Pembelian --}}
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="bi bi-info-circle"></i>Informasi Pembelian
                    </h3>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                Supplier <span class="required">*</span>
                            </label>
                            <select name="id_supplier" class="form-select @error('id_supplier') is-invalid @enderror" required>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($supplier as $s)
                                    <option value="{{ $s->id_supplier }}" {{ old('id_supplier') == $s->id_supplier ? 'selected' : '' }}>
                                        {{ $s->nama_supplier }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Tanggal Pembelian <span class="required">*</span>
                            </label>
                            <input type="date" 
                                   name="tanggal_pembelian" 
                                   class="form-control @error('tanggal_pembelian') is-invalid @enderror" 
                                   value="{{ old('tanggal_pembelian', date('Y-m-d')) }}"
                                   required>
                            @error('tanggal_pembelian')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Daftar Produk --}}
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="bi bi-box-seam"></i>Daftar Produk
                    </h3>

                    <div id="produk-wrapper">
                        <div class="produk-row">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label">Produk <span class="required">*</span></label>
                                    <select name="produk[]" class="form-select" required>
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach($produk as $p)
                                            <option value="{{ $p->id_produk }}">{{ $p->nama_produk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Jumlah <span class="required">*</span></label>
                                    <input type="number" 
                                           name="jumlah[]" 
                                           class="form-control" 
                                           placeholder="0" 
                                           min="1" 
                                           required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Harga Satuan <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-icon">Rp</span>
                                        <input type="number" 
                                               step="0.01" 
                                               name="harga_satuan[]" 
                                               class="form-control" 
                                               placeholder="0" 
                                               min="0" 
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-remove remove-row">
                                        <i class="bi bi-trash me-2"></i>Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-row" class="btn btn-add-row">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Produk
                    </button>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between gap-3 mt-4">
                    <a href="{{ route('pembelian.index') }}" class="btn btn-secondary-custom">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-save me-2"></i>Simpan Pembelian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('add-row').addEventListener('click', () => {
    const wrapper = document.getElementById('produk-wrapper');
    const clone = wrapper.firstElementChild.cloneNode(true);
    clone.querySelectorAll('input, select').forEach(el => el.value = '');
    wrapper.appendChild(clone);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
        const rows = document.querySelectorAll('#produk-wrapper .produk-row');
        if (rows.length > 1) {
            e.target.closest('.produk-row').remove();
        } else {
            alert('Minimal harus ada satu produk!');
        }
    }
});
</script>
@endpush