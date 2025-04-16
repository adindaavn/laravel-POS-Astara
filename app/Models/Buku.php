<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Picqer\Barcode\BarcodeGeneratorPNG;

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
        "thn_terbit",
        "barcode",
    ];

    /**
     * Relasi ke model Kategori (One to Many - Buku ke Kategori)
     * Setiap buku memiliki satu kategori.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    protected static function booted()
    {
        static::saving(function ($buku) {
            if ($buku->isbn && !$buku->barcode) {
                $generator = new BarcodeGeneratorPNG();
                $buku->barcode = base64_encode(
                    $generator->getBarcode($buku->isbn, $generator::TYPE_EAN_13)
                );
            }
        });
    }
}
