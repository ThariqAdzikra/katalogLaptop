<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Produk::query();

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%")
                  ->orWhere('spesifikasi', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status stok
        if ($request->filled('status_stok')) {
            switch ($request->status_stok) {
                case 'habis':
                    $query->where('stok', 0);
                    break;
                case 'menipis':
                    $query->where('stok', '>', 0)->where('stok', '<=', 5);
                    break;
                case 'tersedia':
                    $query->where('stok', '>', 5);
                    break;
            }
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'nama_produk');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $produk = $query->paginate(10)->withQueryString();

        return view('stok.index', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stok.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:150',
            'merk' => 'required|string|max:100',
            'spesifikasi' => 'required|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama_produk.required' => 'Nama produk harus diisi',
            'merk.required' => 'Merk harus diisi',
            'spesifikasi.required' => 'Spesifikasi harus diisi',
            'harga_beli.required' => 'Harga beli harus diisi',
            'harga_jual.required' => 'Harga jual harus diisi',
            'stok.required' => 'Stok harus diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create($validated);

        return redirect()->route('stok.index')
            ->with('success', 'Produk berhasil ditambahkan ke stok!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $stok = Produk::findOrFail($id);
        return view('stok.show', compact('stok'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $stok = Produk::findOrFail($id);
        return view('stok.edit', compact('stok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $stok = Produk::findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:150',
            'merk' => 'required|string|max:100',
            'spesifikasi' => 'required|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama_produk.required' => 'Nama produk harus diisi',
            'merk.required' => 'Merk harus diisi',
            'spesifikasi.required' => 'Spesifikasi harus diisi',
            'harga_beli.required' => 'Harga beli harus diisi',
            'harga_jual.required' => 'Harga jual harus diisi',
            'stok.required' => 'Stok harus diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($stok->gambar) {
                Storage::disk('public')->delete($stok->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $stok->update($validated);

        return redirect()->route('stok.index')
            ->with('success', 'Data produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stok = Produk::findOrFail($id);

        // Delete image if exists
        if ($stok->gambar) {
            Storage::disk('public')->delete($stok->gambar);
        }

        $stok->delete();

        return redirect()->route('stok.index')
            ->with('success', 'Produk berhasil dihapus dari stok!');
    }

    /**
     * Update stock quantity
     */
    public function updateStok(Request $request, $id)
    {
        $stok = Produk::findOrFail($id);

        $validated = $request->validate([
            'stok' => 'required|integer|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $stok->update(['stok' => $validated['stok']]);

        return redirect()->back()
            ->with('success', 'Stok berhasil diperbarui!');
    }
}