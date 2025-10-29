<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Ambil input dari form filter
    $search = $request->input('search');
    $metode = $request->input('metode');
    $sort = $request->input('sort', 'tanggal'); // default: urut berdasarkan tanggal

    // Query dasar
    $query = Penjualan::with('pelanggan')->latest();

    // Filter berdasarkan nama pelanggan
    if ($search) {
        $query->whereHas('pelanggan', function ($q) use ($search) {
            $q->where('nama', 'like', '%' . $search . '%');
        });
    }

    // Filter berdasarkan metode pembayaran
    if ($metode) {
        $query->where('metode_pembayaran', $metode);
    }

    // Sorting
    switch ($sort) {
        case 'total':
            $query->orderBy('total_harga', 'desc');
            break;
        case 'nama':
            $query->join('pelanggan', 'pelanggan.id_pelanggan', '=', 'penjualan.id_pelanggan')
                  ->orderBy('pelanggan.nama', 'asc')
                  ->select('penjualan.*');
            break;
        default: // sort by tanggal
            $query->orderBy('tanggal_penjualan', 'desc');
    }

    $penjualan = Penjualan::with('pelanggan')
    ->when($request->search, fn($q) => $q->whereHas('pelanggan', fn($p) =>
        $p->where('nama', 'like', "%{$request->search}%")
    ))
    ->paginate(10) // ✅ tambahkan ini
    ->withQueryString();

    return view('penjualan.index', compact('penjualan'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggan = Pelanggan::all();
        $produk = Produk::all();
        return view('penjualan.create', compact('pelanggan', 'produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'id_pelanggan' => 'required',
            'tanggal_penjualan' => 'required|date',
            'metode_pembayaran' => 'required|in:cash,transfer,qris',
            'produk.*' => 'required',
            'jumlah.*' => 'required|integer|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
        ]);

        $penjualan = Penjualan::create([
            'id_user' => Auth::id(),
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_harga' => 0
        ]);

        $total = 0;
        foreach ($request->produk as $i => $id_produk) {
            $jumlah = $request->jumlah[$i];
            $harga = $request->harga_satuan[$i];
            $subtotal = $jumlah * $harga;

            PenjualanDetail::create([
                'id_penjualan' => $penjualan->id_penjualan,
                'id_produk' => $id_produk,
                'jumlah' => $jumlah,
                'harga_satuan' => $harga,
                'subtotal' => $subtotal,
            ]);

            $produk = Produk::find($id_produk);
            $produk->stok -= $jumlah;
            $produk->save();

            $total += $subtotal;
        }

        $penjualan->update(['total_harga' => $total]);

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil disimpan');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penjualan = Penjualan::with('detail')->findOrFail($id);
        $pelanggan = Pelanggan::all();
        $produk = Produk::all();
        return view('penjualan.edit', compact('penjualan', 'pelanggan', 'produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_pelanggan' => 'required',
            'tanggal_penjualan' => 'required|date',
            'metode_pembayaran' => 'required|in:cash,transfer,qris',
            'produk.*' => 'required',
            'jumlah.*' => 'required|integer|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
        ]);

        $penjualan = Penjualan::findOrFail($id);

        // Kembalikan stok lama
        foreach ($penjualan->detail as $detail) {
            $produk = $detail->produk;
            $produk->stok += $detail->jumlah;
            $produk->save();
        }

        // Hapus detail lama
        $penjualan->detail()->delete();

        $penjualan->update([
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        $total = 0;
        foreach ($request->produk as $i => $id_produk) {
            $jumlah = $request->jumlah[$i];
            $harga = $request->harga_satuan[$i];
            $subtotal = $jumlah * $harga;

            $penjualan->detail()->create([
                'id_produk' => $id_produk,
                'jumlah' => $jumlah,
                'harga_satuan' => $harga,
                'subtotal' => $subtotal,
            ]);

            $produk = Produk::find($id_produk);
            $produk->stok -= $jumlah;
            $produk->save();

            $total += $subtotal;
        }

        $penjualan->update(['total_harga' => $total]);

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil diperbarui');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        foreach ($penjualan->detail as $detail) {
            $produk = $detail->produk;
            $produk->stok += $detail->jumlah;
            $produk->save();
        }

        $penjualan->detail()->delete();
        $penjualan->delete();

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus');
    }

    public function laporan(Request $request)
    {
        $query = Penjualan::with('pelanggan');

        if ($request->filled('dari_tanggal') && $request->filled('sampai_tanggal')) {
            $query->whereBetween('tanggal_penjualan', [$request->dari_tanggal, $request->sampai_tanggal]);
        }

        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        $penjualan = $query->orderBy('tanggal_penjualan', 'desc')->get();
        $total_semua = $penjualan->sum('total_harga');

        return view('penjualan.laporan', compact('penjualan', 'total_semua'));
    }

}
