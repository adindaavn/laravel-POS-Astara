<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk menyimpan data pemasok.
 */
class Pemasok extends Model
{
    use HasFactory;
    protected $table = "pemasok";
    protected $fillable = [
        "nama",
        "email",
        "telp",
        "alamat"
    ];

    public function buku()
    {
        return $this->hasMany(Buku::class);
    }

    public function pembelian()
    {
        return $this->hasManyThrough(PembelianDetail::class, Buku::class, 'pemasok_id', 'buku_id');
    }
}
