@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h3>Laporan Penjualan</h3>

  <form method="GET" action="{{ route('penjualan.laporan') }}" class="row g-3 mb-4">
    <div class="col-md-3">
      <label class="form-label">Dari Tanggal</label>
      <input type="date" name="dari_tanggal" class="form-control" value="{{ request('dari_tanggal') }}">
    </div>
    <div class="col-md-3">
      <label class="form-label">Sampai Tanggal</label>
      <input type="date" name="sampai_tanggal" class="form-control" value="{{ request('sampai_tanggal') }}">
    </div>
    <div class="col-md-3">
      <label class="form-label">Metode Pembayaran</label>
      <select name="metode_pembayaran" class="form-select">
        <option value="">Semua</option>
        <option value="cash" {{ request('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
        <option value="transfer" {{ request('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer</option>
        <option value="qris" {{ request('metode_pembayaran') == 'qris' ? 'selected' : '' }}>QRIS</option>
      </select>
    </div>
    <div class="col-md-3 align-self-end">
      <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
  </form>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Pelanggan</th>
        <th>Metode Pembayaran</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @forelse($penjualan as $p)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $p->tanggal_penjualan }}</td>
        <td>{{ $p->pelanggan->nama ?? '-' }}</td>
        <td>{{ ucfirst($p->metode_pembayaran) }}</td>
        <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="5" class="text-center text-muted">Tidak ada data penjualan</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div class="text-end mt-3">
    <h5>Total Semua: <strong>Rp {{ number_format($total_semua, 0, ',', '.') }}</strong></h5>
  </div>
</div>
@endsection
