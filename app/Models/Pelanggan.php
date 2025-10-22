<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $fillable = ['nama', 'no_hp', 'email', 'alamat'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_pelanggan');
    }
}
