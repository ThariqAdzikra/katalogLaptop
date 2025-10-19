<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // USERS
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pegawai 1',
                'email' => 'pegawai@example.com',
                'password' => Hash::make('password'),
                'role' => 'pegawai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // SUPPLIER
        DB::table('supplier')->insert([
            ['nama_supplier' => 'ASUS Distributor', 'kontak' => '081234567890', 'alamat' => 'Jakarta', 'email' => 'asus@supplier.com'],
            ['nama_supplier' => 'Lenovo Partner', 'kontak' => '082112345678', 'alamat' => 'Bandung', 'email' => 'lenovo@supplier.com'],
            ['nama_supplier' => 'MSI Indonesia', 'kontak' => '085321998877', 'alamat' => 'Surabaya', 'email' => 'msi@supplier.com'],
        ]);

        // PRODUK
        DB::table('produk')->insert([
            ['nama_produk' => 'ASUS ROG Strix G15', 'merk' => 'ASUS', 'spesifikasi' => 'Ryzen 9, RTX 3070, 16GB RAM, 512GB SSD', 'harga_beli' => 18000000, 'harga_jual' => 22000000, 'stok' => 8],
            ['nama_produk' => 'Lenovo ThinkPad X1 Carbon', 'merk' => 'Lenovo', 'spesifikasi' => 'Intel i7, 16GB RAM, 512GB SSD', 'harga_beli' => 20000000, 'harga_jual' => 24500000, 'stok' => 6],
            ['nama_produk' => 'MacBook Air M2', 'merk' => 'Apple', 'spesifikasi' => 'M2 Chip, 8GB RAM, 256GB SSD', 'harga_beli' => 15000000, 'harga_jual' => 18500000, 'stok' => 10],
            ['nama_produk' => 'MSI Katana GF66', 'merk' => 'MSI', 'spesifikasi' => 'i7, RTX 4050, 16GB RAM, 512GB SSD', 'harga_beli' => 14000000, 'harga_jual' => 17500000, 'stok' => 5],
            ['nama_produk' => 'Acer Swift 3 SF314', 'merk' => 'Acer', 'spesifikasi' => 'Ryzen 7, 16GB RAM, 512GB SSD', 'harga_beli' => 8000000, 'harga_jual' => 10500000, 'stok' => 9],
        ]);

        // PELANGGAN
        DB::table('pelanggan')->insert([
            ['nama' => 'Alya Refina Putri', 'no_hp' => '081234567899', 'email' => 'alya@example.com', 'alamat' => 'Jl. Bangau Sakti, Pekanbaru'],
            ['nama' => 'Budi Santoso', 'no_hp' => '082233445566', 'email' => 'budi@example.com', 'alamat' => 'Jl. Soebrantas, Panam'],
            ['nama' => 'Citra Aulia', 'no_hp' => '081234567800', 'email' => 'citra@example.com', 'alamat' => 'Jl. Garuda Sakti, Pekanbaru'],
            ['nama' => 'Doni Saputra', 'no_hp' => '085277663388', 'email' => 'doni@example.com', 'alamat' => 'Jl. Karya I, Marpoyan'],
            ['nama' => 'Eka Nurhaliza', 'no_hp' => '083344556677', 'email' => 'eka@example.com', 'alamat' => 'Jl. Manyar Sakti, Panam'],
        ]);

        // PEMBELIAN (stok masuk dari supplier selama seminggu)
        for ($i = 0; $i < 5; $i++) {
            $tanggal = Carbon::now()->subDays(6 - $i)->toDateString();
            DB::table('pembelian')->insert([
                'id_supplier' => rand(1, 3),
                'id_user' => 1,
                'tanggal_pembelian' => $tanggal,
                'total_harga' => rand(30000000, 80000000),
                'created_at' => $tanggal,
                'updated_at' => $tanggal,
            ]);
        }

        // PEMBELIAN DETAIL
        for ($i = 1; $i <= 5; $i++) {
            DB::table('pembelian_detail')->insert([
                'id_pembelian' => $i,
                'id_produk' => rand(1, 5),
                'jumlah' => rand(2, 5),
                'harga_satuan' => rand(10000000, 20000000),
                'subtotal' => rand(20000000, 60000000),
                'created_at' => Carbon::now()->subDays(6 - $i),
                'updated_at' => Carbon::now()->subDays(6 - $i),
            ]);
        }

        // PENJUALAN (transaksi harian selama seminggu)
        for ($i = 0; $i < 7; $i++) {
            $tanggal = Carbon::now()->subDays(6 - $i);
            DB::table('penjualan')->insert([
                'id_user' => 2,
                'id_pelanggan' => rand(1, 5),
                'tanggal_penjualan' => $tanggal,
                'total_harga' => rand(15000000, 40000000),
                'metode_pembayaran' => collect(['cash', 'transfer', 'qris'])->random(),
                'created_at' => $tanggal,
                'updated_at' => $tanggal,
            ]);
        }

        // PENJUALAN DETAIL
        for ($i = 1; $i <= 7; $i++) {
            DB::table('penjualan_detail')->insert([
                'id_penjualan' => $i,
                'id_produk' => rand(1, 5),
                'jumlah' => rand(1, 2),
                'harga_satuan' => rand(10000000, 25000000),
                'subtotal' => rand(15000000, 40000000),
                'created_at' => Carbon::now()->subDays(7 - $i),
                'updated_at' => Carbon::now()->subDays(7 - $i),
            ]);
        }

        // GARANSI
        for ($i = 1; $i <= 7; $i++) {
            DB::table('garansi')->insert([
                'id_penjualan_detail' => $i,
                'tanggal_mulai' => Carbon::now()->subDays(rand(0, 6)),
                'tanggal_akhir' => Carbon::now()->addYear(),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Seeder sukses! Data transaksi seminggu terakhir sudah dimasukkan.');
    }
}
