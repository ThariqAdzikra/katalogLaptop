<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $pembelian = Pembelian::with('supplier')
        ->when($request->search, function ($q) use ($request) {
            $q->whereHas('supplier', function ($s) use ($request) {
                $s->where('nama_supplier', 'like', "%{$request->search}%");
            });
        })
        ->when($request->filled('sort'), function ($q) use ($request) {
            if ($request->sort === 'tanggal') {
                $q->orderBy('tanggal_pembelian', 'desc');
            } elseif ($request->sort === 'total') {
                $q->orderBy('total_harga', 'desc');
            }
        })
        ->paginate(10)
        ->withQueryString();

    return view('pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $supplier = Supplier::all();
        $produk = Produk::all();
        return view('pembelian.create', compact('supplier', 'produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_supplier' => 'required',
            'tanggal_pembelian' => 'required|date',
            'produk.*' => 'required',
            'jumlah.*' => 'required|integer|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
        ]);

        // Simpan transaksi utama
        $pembelian = Pembelian::create([
            'id_supplier' => $request->id_supplier,
            'id_user' => Auth::id(),
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'total_harga' => 0
        ]);

        $total = 0;
        foreach ($request->produk as $index => $id_produk) {
            $jumlah = $request->jumlah[$index];
            $harga = $request->harga_satuan[$index];
            $subtotal = $jumlah * $harga;

            PembelianDetail::create([
                'id_pembelian' => $pembelian->id_pembelian,
                'id_produk' => $id_produk,
                'jumlah' => $jumlah,
                'harga_satuan' => $harga,
                'subtotal' => $subtotal,
            ]);

            // update stok produk
            $produk = Produk::find($id_produk);
            $produk->stok += $jumlah;
            $produk->save();

            $total += $subtotal;
        }

        $pembelian->update(['total_harga' => $total]);

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil disimpan');
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);

        foreach ($pembelian->detail as $detail) {
            $produk = $detail->produk;
            $produk->stok -= $detail->jumlah;
            $produk->save();
        }

        $pembelian->detail()->delete();
        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil dihapus');
    }

    public function edit($id)
    {
        $pembelian = Pembelian::with('detail')->findOrFail($id);
        $supplier = Supplier::all();
        $produk = Produk::all();
        return view('pembelian.edit', compact('pembelian', 'supplier', 'produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_supplier' => 'required',
            'tanggal_pembelian' => 'required|date',
            'produk.*' => 'required',
            'jumlah.*' => 'required|integer|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
        ]);

        $pembelian = Pembelian::findOrFail($id);
        $pembelian->update([
            'id_supplier' => $request->id_supplier,
            'tanggal_pembelian' => $request->tanggal_pembelian,
        ]);

        // Hapus detail lama
        $pembelian->detail()->delete();

        $total = 0;
        foreach ($request->produk as $i => $id_produk) {
            $jumlah = $request->jumlah[$i];
            $harga = $request->harga_satuan[$i];
            $subtotal = $jumlah * $harga;

            $pembelian->detail()->create([
                'id_produk' => $id_produk,
                'jumlah' => $jumlah,
                'harga_satuan' => $harga,
                'subtotal' => $subtotal,
            ]);

            $total += $subtotal;
        }

        $pembelian->update(['total_harga' => $total]);

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil diperbarui');
    }
}
