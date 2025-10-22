@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h3>Edit Penjualan</h3>

  <form action="{{ route('penjualan.update', $penjualan->id_penjualan) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label">Pelanggan</label>
      <select name="id_pelanggan" class="form-select" required>
        @foreach($pelanggan as $p)
          <option value="{{ $p->id_pelanggan }}" {{ $p->id_pelanggan == $penjualan->id_pelanggan ? 'selected' : '' }}>
            {{ $p->nama }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Tanggal Penjualan</label>
      <input type="datetime-local" name="tanggal_penjualan" value="{{ $penjualan->tanggal_penjualan }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
      <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
        <option value="cash" {{ $penjualan->metode_pembayaran == 'cash' ? 'selected' : '' }}>Cash</option>
        <option value="transfer" {{ $penjualan->metode_pembayaran == 'transfer' ? 'selected' : '' }}>Transfer</option>
        <option value="qris" {{ $penjualan->metode_pembayaran == 'qris' ? 'selected' : '' }}>QRIS</option>
      </select>
    </div>

    <hr>
    <h5>Daftar Produk</h5>

    <div id="produk-wrapper">
      @foreach($penjualan->detail as $detail)
      <div class="row g-2 align-items-center mb-2">
        <div class="col-md-4">
          <select name="produk[]" class="form-select" required>
            <option value="">-- Pilih Produk --</option>
            @foreach($produk as $pr)
              <option value="{{ $pr->id_produk }}" {{ $pr->id_produk == $detail->id_produk ? 'selected' : '' }}>
                {{ $pr->nama_produk }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <input type="number" name="jumlah[]" value="{{ $detail->jumlah }}" class="form-control" required>
        </div>
        <div class="col-md-3">
          <input type="number" step="0.01" name="harga_satuan[]" value="{{ $detail->harga_satuan }}" class="form-control" required>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-danger remove-row">Hapus</button>
        </div>
      </div>
      @endforeach
    </div>

    <button type="button" id="add-row" class="btn btn-secondary btn-sm">+ Tambah Produk</button>
    <br><br>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
  </form>
</div>

<script>
document.getElementById('add-row').addEventListener('click', () => {
  const wrapper = document.getElementById('produk-wrapper');
  const clone = wrapper.firstElementChild.cloneNode(true);
  clone.querySelectorAll('input, select').forEach(el => el.value = '');
  wrapper.appendChild(clone);
});

document.addEventListener('click', e => {
  if (e.target.classList.contains('remove-row')) {
    const rows = document.querySelectorAll('#produk-wrapper .row');
    if (rows.length > 1) e.target.closest('.row').remove();
  }
});
</script>
@endsection
