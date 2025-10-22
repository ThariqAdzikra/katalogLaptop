@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/pembelian-style.css') }}">

<div class="pembelian-container form-view">
    <div class="header-card">
        <h3><i class="fas fa-plus-circle"></i> Tambah Pembelian</h3>
    </div>

    <div class="form-card">
        <form action="{{ route('pembelian.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label">
                    <i class="fas fa-building"></i> Supplier
                </label>
                <select name="id_supplier" class="form-select" required>
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($supplier as $s)
                        <option value="{{ $s->id_supplier }}">{{ $s->nama_supplier }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">
                    <i class="fas fa-calendar"></i> Tanggal Pembelian
                </label>
                <input type="date" name="tanggal_pembelian" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <hr class="section-divider">
            
            <h5 class="section-title">
                <i class="fas fa-box"></i> Daftar Produk
            </h5>

            <div id="produk-wrapper">
                <div class="row g-3 align-items-center produk-row">
                    <div class="col-md-4">
                        <label class="form-label">Produk</label>
                        <select name="produk[]" class="form-select" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produk as $p)
                                <option value="{{ $p->id_produk }}">{{ $p->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah[]" class="form-control" placeholder="0" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Harga Satuan</label>
                        <input type="number" step="0.01" name="harga_satuan[]" class="form-control" placeholder="0" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label d-block">&nbsp;</label>
                        <button type="button" class="btn btn-remove remove-row">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>

            <button type="button" id="add-row" class="btn btn-add-row">
                <i class="fas fa-plus"></i> Tambah Produk
            </button>

            <div class="mt-4">
                <a href="{{ route('pembelian.index') }}" class="btn btn-cancel">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-save"></i> Simpan Pembelian
                </button>
            </div>
        </form>
    </div>
</div>

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
@endsection