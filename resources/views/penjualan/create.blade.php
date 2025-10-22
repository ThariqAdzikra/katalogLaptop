@extends('layouts.app')

@section('title', 'Kasir Penjualan - Laptop Store')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/stok/style.css') }}">
@endpush

@section('content')
<div class="container-fluid px-4 py-4" style="max-width: 100% !important;">
  <div class="form-container">
    <div class="form-card">
      <div class="form-header">
        <h1 class="form-title">
          <i class="bi bi-cash-register me-2"></i>Kasir Penjualan
        </h1>
        <p class="form-subtitle">Catat transaksi dengan cepat dan mudah</p>
      </div>

      <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf
        <div class="row g-4">
          {{-- ==================== KIRI: INPUT PRODUK ==================== --}}
          <div class="col-md-8">
            <div class="form-section">
              <h3 class="section-title"><i class="bi bi-person"></i>Informasi Pelanggan</h3>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label">Pelanggan</label>
                  <select name="id_pelanggan" class="form-select" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($pelanggan as $p)
                      <option value="{{ $p->id_pelanggan }}">{{ $p->nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Tanggal Penjualan</label>
                  <input type="datetime-local" name="tanggal_penjualan" class="form-control" required>
                </div>
              </div>
            </div>

            <div class="form-section">
              <h3 class="section-title"><i class="bi bi-cart4"></i>Tambah Produk</h3>

              <div id="produk-wrapper">
                <div class="row g-3 align-items-end mb-3 produk-row">
                  <div class="col-md-5">
                    <label class="form-label">Produk</label>
                    <select name="produk[]" class="form-select produk-select" required>
                      <option value="">-- Pilih Produk --</option>
                      @foreach($produk as $pr)
                        <option value="{{ $pr->id_produk }}" data-harga="{{ $pr->harga_jual }}" data-stok="{{ $pr->stok }}">
                          {{ $pr->nama_produk }}
                        </option>
                      @endforeach
                    </select>
                    <small class="text-muted stok-info d-block"></small>
                  </div>

                  <div class="col-md-2">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" placeholder="0" required>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label">Harga</label>
                    <div class="input-group">
                      <span class="input-group-text">Rp</span>
                      <input type="number" name="harga_satuan[]" step="0.01" class="form-control harga-input" placeholder="0" required readonly>
                    </div>
                  </div>

                  <div class="col-md-2 d-flex gap-2">
                    <button type="button" class="btn btn-danger remove-row mt-4">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </div>
              </div>

              <button type="button" id="add-row" class="btn btn-secondary-custom btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Tambah Produk
              </button>
            </div>
          </div>

          {{-- ==================== KANAN: RINGKASAN ==================== --}}
          <div class="col-md-4">
            <div class="form-section">
              <h3 class="section-title"><i class="bi bi-receipt"></i>Ringkasan Transaksi</h3>
              
              <ul id="ringkasan-list" class="list-group mb-3">
                <li class="list-group-item text-muted text-center">Belum ada produk</li>
              </ul>

              <div class="mb-3">
                <label class="form-label">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                  <option value="">-- Pilih Metode Pembayaran --</option>
                  <option value="cash">Cash</option>
                  <option value="transfer">Transfer</option>
                  <option value="qris">QRIS</option>
                </select>
              </div>

              {{-- QRIS Preview --}}
              <div id="qris-preview" class="text-center mb-3 d-none">
                <p class="fw-semibold">Scan QRIS untuk pembayaran:</p>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Demo-QRIS"
                     alt="QRIS Code" class="img-thumbnail" style="width: 150px;">
                <p class="small text-muted mt-2">* QRIS dummy untuk demo</p>
              </div>

              <div class="total-section text-center mt-4">
                <h4 class="fw-bold mb-2">Total:</h4>
                <h2 id="total-display" class="text-primary fw-bolder">Rp 0</h2>
                <input type="hidden" name="total_harga" id="total_harga" value="0">
              </div>

              <button type="submit" class="btn btn-primary-custom w-100 mt-4">
                <i class="bi bi-check-circle me-2"></i>Selesaikan Transaksi
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function formatRupiah(angka) {
  return 'Rp ' + angka.toLocaleString('id-ID');
}

function updateTotal() {
  let total = 0;
  const ringkasanList = document.getElementById('ringkasan-list');
  ringkasanList.innerHTML = '';

  document.querySelectorAll('.produk-row').forEach(row => {
    const produkSelect = row.querySelector('.produk-select');
    const jumlahInput = row.querySelector('.jumlah-input');
    const hargaInput = row.querySelector('.harga-input');

    const namaProduk = produkSelect.options[produkSelect.selectedIndex]?.text || '-';
    const jumlah = parseInt(jumlahInput.value) || 0;
    const harga = parseFloat(hargaInput.value) || 0;
    const subtotal = jumlah * harga;

    if (namaProduk !== '-' && jumlah > 0) {
      total += subtotal;

      const li = document.createElement('li');
      li.className = 'list-group-item d-flex justify-content-between align-items-center';
      li.innerHTML = `<span>${namaProduk} x${jumlah}</span><strong>${formatRupiah(subtotal)}</strong>`;
      ringkasanList.appendChild(li);
    }
  });

  if (total === 0) {
    ringkasanList.innerHTML = '<li class="list-group-item text-muted text-center">Belum ada produk</li>';
  }

  document.getElementById('total_harga').value = total;
  document.getElementById('total-display').textContent = formatRupiah(total);
}

document.getElementById('add-row').addEventListener('click', () => {
  const wrapper = document.getElementById('produk-wrapper');
  const clone = wrapper.firstElementChild.cloneNode(true);
  clone.querySelectorAll('input, select').forEach(el => el.value = '');
  clone.querySelector('.stok-info').textContent = '';
  wrapper.appendChild(clone);
});

document.addEventListener('click', e => {
  if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
    const rows = document.querySelectorAll('.produk-row');
    if (rows.length > 1) e.target.closest('.produk-row').remove();
    updateTotal();
  }
});

// Auto set harga + stok info
document.addEventListener('change', e => {
  if (e.target.classList.contains('produk-select')) {
    const harga = e.target.selectedOptions[0].dataset.harga || 0;
    const stok = e.target.selectedOptions[0].dataset.stok || 0;

    const row = e.target.closest('.produk-row');
    const hargaInput = row.querySelector('.harga-input');
    const stokInfo = row.querySelector('.stok-info');

    hargaInput.value = harga;

    updateTotal();
  }
});

document.addEventListener('input', e => {
  if (e.target.classList.contains('jumlah-input')) updateTotal();
});

// QRIS preview toggle
document.getElementById('metode_pembayaran').addEventListener('change', e => {
  document.getElementById('qris-preview').classList.toggle('d-none', e.target.value !== 'qris');
});
</script>
@endpush
