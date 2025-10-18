<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key check sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel tanpa melanggar FK
        User::truncate();

        // Aktifkan lagi
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Seed user default
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        $this->call([
            ProdukSeeder::class,
        ]);
    }
}
