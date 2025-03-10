<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    protected $table = "detail_pembelian";
    protected $fillable = [
        "pembelian_id",
        "buku_id",
        "harga_beli",
        "jumlah",
        "subtotal"
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }
}
