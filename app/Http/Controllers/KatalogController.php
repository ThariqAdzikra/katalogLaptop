<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('merk', 'like', "%{$search}%")
                    ->orWhere('spesifikasi', 'like', "%{$search}%");
            });
        }

        // Category filter (opsional, jika ada kolom kategori di tabel produk)
        if ($request->filled('kategori')) {
            // Bisa filter berdasarkan merk atau kategori lain
            $query->where('merk', 'like', '%' . $request->kategori . '%');
        }

        // Paginate results
        $produk = $query->latest()->paginate(9);

        return view('katalog.index', compact('produk'));
    }
}