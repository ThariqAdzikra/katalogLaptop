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
        $supplierData = [
            ['nama_supplier' => 'ASUS Distributor', 'kontak' => '081234567890', 'alamat' => 'Jakarta', 'email' => 'asus@supplier.com'],
            ['nama_supplier' => 'Lenovo Partner', 'kontak' => '082112345678', 'alamat' => 'Bandung', 'email' => 'lenovo@supplier.com'],
            ['nama_supplier' => 'MSI Indonesia', 'kontak' => '085321998877', 'alamat' => 'Surabaya', 'email' => 'msi@supplier.com'],
            ['nama_supplier' => 'Acer Center', 'kontak' => '083355667788', 'alamat' => 'Medan', 'email' => 'acer@supplier.com'],
        ];
        DB::table('supplier')->insert($supplierData);

        // PRODUK
        $produkData = [
            ['nama_produk' => 'ASUS ROG Strix G15', 'merk' => 'ASUS', 'spesifikasi' => 'Ryzen 9, RTX 3070, 16GB RAM, 512GB SSD', 'harga_beli' => 18000000, 'harga_jual' => 22000000, 'stok' => 8],
            ['nama_produk' => 'Lenovo ThinkPad X1 Carbon', 'merk' => 'Lenovo', 'spesifikasi' => 'Intel i7, 16GB RAM, 512GB SSD', 'harga_beli' => 20000000, 'harga_jual' => 24500000, 'stok' => 6],
            ['nama_produk' => 'MacBook Air M2', 'merk' => 'Apple', 'spesifikasi' => 'M2 Chip, 8GB RAM, 256GB SSD', 'harga_beli' => 15000000, 'harga_jual' => 18500000, 'stok' => 10],
            ['nama_produk' => 'MSI Katana GF66', 'merk' => 'MSI', 'spesifikasi' => 'i7, RTX 4050, 16GB RAM, 512GB SSD', 'harga_beli' => 14000000, 'harga_jual' => 17500000, 'stok' => 5],
            ['nama_produk' => 'Acer Swift 3 SF314', 'merk' => 'Acer', 'spesifikasi' => 'Ryzen 7, 16GB RAM, 512GB SSD', 'harga_beli' => 8000000, 'harga_jual' => 10500000, 'stok' => 9],
            ['nama_produk' => 'HP Pavilion 15', 'merk' => 'HP', 'spesifikasi' => 'Intel i5, 8GB RAM, 512GB SSD', 'harga_beli' => 9000000, 'harga_jual' => 11500000, 'stok' => 12],
        ];
        DB::table('produk')->insert($produkData);

        // PELANGGAN
        $pelanggan = [];
        for ($i = 1; $i <= 30; $i++) {
            $pelanggan[] = [
                'nama' => "Pelanggan {$i}",
                'no_hp' => '08' . rand(1000000000, 9999999999),
                'email' => "pelanggan{$i}@example.com",
                'alamat' => 'Jl. Contoh No. ' . rand(1, 200) . ', Pekanbaru',
            ];
        }
        DB::table('pelanggan')->insert($pelanggan);

        // PEMBELIAN (stok masuk dari supplier selama seminggu)
        for ($i = 0; $i < 50; $i++) {
            $tanggal = Carbon::now()->subDays(rand(0, 6));
            $id = DB::table('pembelian')->insertGetId([
                'id_supplier' => rand(1, count($supplierData)),
                'id_user' => 1,
                'tanggal_pembelian' => $tanggal,
                'total_harga' => rand(30000000, 80000000),
                'created_at' => $tanggal,
                'updated_at' => $tanggal,
            ]);

            // Detail pembelian
            for ($d = 0; $d < rand(1, 3); $d++) {
                $jumlah = rand(1, 5);
                $harga = rand(10000000, 20000000);
                DB::table('pembelian_detail')->insert([
                    'id_pembelian' => $id,
                    'id_produk' => rand(1, count($produkData)),
                    'jumlah' => $jumlah,
                    'harga_satuan' => $harga,
                    'subtotal' => $jumlah * $harga,
                    'created_at' => $tanggal,
                    'updated_at' => $tanggal,
                ]);
            }
        }

        // PENJUALAN (100 transaksi acak selama seminggu)
        for ($i = 0; $i < 100; $i++) {
            $tanggal = Carbon::now()->subDays(rand(0, 6));
            $id = DB::table('penjualan')->insertGetId([
                'id_user' => 2,
                'id_pelanggan' => rand(1, 30),
                'tanggal_penjualan' => $tanggal,
                'total_harga' => rand(15000000, 40000000),
                'metode_pembayaran' => collect(['cash', 'transfer', 'qris'])->random(),
                'created_at' => $tanggal,
                'updated_at' => $tanggal,
            ]);

            // Detail penjualan (1–3 produk per transaksi)
            for ($d = 0; $d < rand(1, 3); $d++) {
                $jumlah = rand(1, 2);
                $harga = rand(10000000, 25000000);
                $subtotal = $jumlah * $harga;

                DB::table('penjualan_detail')->insert([
                    'id_penjualan' => $id,
                    'id_produk' => rand(1, count($produkData)),
                    'jumlah' => $jumlah,
                    'harga_satuan' => $harga,
                    'subtotal' => $subtotal,
                    'created_at' => $tanggal,
                    'updated_at' => $tanggal,
                ]);
            }
        }

        // GARANSI
        for ($i = 1; $i <= 100; $i++) {
            DB::table('garansi')->insert([
                'id_penjualan_detail' => $i,
                'tanggal_mulai' => Carbon::now()->subDays(rand(0, 6)),
                'tanggal_akhir' => Carbon::now()->addYear(),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Seeder sukses! 100+ transaksi acak seminggu terakhir berhasil dimasukkan.');
    }
}
