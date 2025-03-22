<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk menyimpan detail pembelian.
 */
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


    /**
     * Relasi ke model Buku (Many to One).
     * Setiap detail pembelian terkait dengan satu buku.
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    /**
     * Relasi ke model Pembelian (Many to One).
     * Setiap detail pembelian terkait dengan satu transaksi pembelian.
     */
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }
}
