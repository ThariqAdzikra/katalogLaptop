<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            ['nama_kategori' => 'Gaming'],
            ['nama_kategori' => 'Office'],
            ['nama_kategori' => 'Ultrabook'],
            ['nama_kategori' => 'Workstation'],
        ];

        // Proses data untuk menambahkan slug dan timestamps
        $data = array_map(function ($item) {
            return [
                'nama_kategori' => $item['nama_kategori'],
                'slug' => Str::slug($item['nama_kategori']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $kategori);

        DB::table('kategori')->insert($data);
    }
}