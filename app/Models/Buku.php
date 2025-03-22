<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk menyimpan data buku.
 */
class Buku extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = "buku";

    protected $fillable = [
        "isbn",
        "judul",
        "penulis",
        "penerbit",
        "kategori_id",
        "harga",
        "gambar",
        "thn_terbit"
    ];

    /**
     * Relasi ke model Kategori (One to Many - Buku ke Kategori)
     * Setiap buku memiliki satu kategori.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
