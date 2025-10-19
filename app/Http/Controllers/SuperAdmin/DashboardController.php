<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik ringkas
        $totalProduk = DB::table('produk')->count();
        $totalPelanggan = DB::table('pelanggan')->count();
        $totalPenjualan = DB::table('penjualan')->count();
        $totalPembelian = DB::table('pembelian')->count();

        // Total pendapatan minggu ini
        $pendapatanMingguan = DB::table('penjualan')
            ->whereBetween('tanggal_penjualan', [now()->subDays(7), now()])
            ->sum('total_harga');

        // Data grafik penjualan 7 hari terakhir
        $grafik = DB::table('penjualan')
            ->select(DB::raw('DATE(tanggal_penjualan) as tanggal'), DB::raw('SUM(total_harga) as total'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('superadmin.dashboard', compact(
            'totalProduk',
            'totalPelanggan',
            'totalPenjualan',
            'totalPembelian',
            'pendapatanMingguan',
            'grafik'
        ));
    }
}
