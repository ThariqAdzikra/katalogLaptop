<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $produk = [
            [
                'nama_produk' => 'ASUS ROG Strix G15',
                'merk' => 'ASUS',
                'spesifikasi' => 'AMD Ryzen 9 5900HX, RTX 3070, 16GB RAM, 512GB SSD, 15.6" FHD 144Hz',
                'harga_beli' => 18000000,
                'harga_jual' => 22000000,
                'stok' => 5,
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Lenovo ThinkPad X1 Carbon Gen 11',
                'merk' => 'Lenovo',
                'spesifikasi' => 'Intel Core i7-1355U, 16GB RAM, 512GB SSD, 14" WUXGA IPS',
                'harga_beli' => 20000000,
                'harga_jual' => 24500000,
                'stok' => 3,
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'MacBook Air M2',
                'merk' => 'Apple',
                'spesifikasi' => 'Apple M2 Chip, 8GB RAM, 256GB SSD, 13.6" Liquid Retina Display',
                'harga_beli' => 15000000,
                'harga_jual' => 18500000,
                'stok' => 8,
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Dell XPS 15 9530',
                'merk' => 'Dell',
                'spesifikasi' => 'Intel Core i7-13700H, RTX 4060, 16GB RAM, 512GB SSD, 15.6" FHD+',
                'harga_beli' => 25000000,
                'harga_jual' => 30000000,
                'stok' => 2,
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'HP Pavilion Gaming 15',
                'merk' => 'HP',
                'spesifikasi' => 'Intel Core i5-12500H, RTX 3050, 8GB RAM, 512GB SSD, 15.6" FHD 144Hz',
                'harga_beli' => 10000000,
                'harga_jual' => 13000000,
                'stok' => 10,
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Acer Swift 3 SF314',
                'merk' => 'Acer',
                'spesifikasi' => 'AMD Ryzen 7 5700U, 16GB RAM, 512GB SSD, 14" FHD IPS',
                'harga_beli' => 8000000,
                'harga_jual' => 10500000,
                'stok' => 7,
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'MSI Katana GF66',
                'merk' => 'MSI',
                'spesifikasi' => 'Intel Core i7-12650H, RTX 4050, 16GB RAM, 512GB SSD, 15.6" FHD 144Hz',
                'harga_beli' => 14000000,
                'harga_jual' => 17500000,
                'stok' => 4,
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'ASUS VivoBook 14 X1404',
                'merk' => 'ASUS',
                'spesifikasi' => 'Intel Core i3-1215U, 8GB RAM, 256GB SSD, 14" FHD',
                'harga_beli' => 5000000,
                'harga_jual' => 6500000,
                'stok' => 15,
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('produk')->insert($produk);
    }
}