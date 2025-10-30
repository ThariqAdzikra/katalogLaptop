<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori; // DITAMBAHKAN: Import model Kategori
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        // =================================================================
        // DIPERBARUI: Eager load relasi 'kategori'
        // =================================================================
        $query = Produk::with('kategori');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('merk', 'like', "%{$search}%")
                    ->orWhere('spesifikasi', 'like', "%{$search}%");
            });
        }

        // =================================================================
        // DIPERBARUI: Logika filter kategori berdasarkan relasi
        // =================================================================
        if ($request->filled('kategori')) {
            $kategoriSlug = $request->kategori;
            $query->whereHas('kategori', function ($q) use ($kategoriSlug) {
                $q->where('slug', $kategoriSlug);
            });
        }

        // =================================================================
        // DITAMBAHKAN: Ambil daftar kategori untuk dropdown
        // =================================================================
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        // Paginate results
        // ✅ DISESUAIKAN: Angka 9 diubah menjadi 6 sesuai permintaan Anda
        $produk = $query->latest()->paginate(6)->withQueryString(); 

        // =================================================================
        // DIPERBARUI: Kirim data 'kategori' ke view
        // =================================================================
        return view('katalog.index', compact('produk', 'kategori'));
    }
}