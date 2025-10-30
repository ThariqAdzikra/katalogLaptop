<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     */
    protected $table = 'kategori';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_kategori';

    /**
     * Atribut yang dapat diisi
     */
    protected $fillable = [
        'nama_kategori',
        'slug',
    ];

    /**
     * Relasi one-to-many ke Produk.
     * Satu kategori memiliki banyak produk.
     */
    public function produk()
    {
        // hasMany(NamaModel, foreign_key, local_key)
        return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
    }
}