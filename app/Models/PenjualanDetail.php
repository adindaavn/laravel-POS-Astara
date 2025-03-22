<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk menyimpan detail transaksi penjualan.
 */
class PenjualanDetail extends Model
{
    protected $table = "detail_penjualan";
    protected $fillable = [
        "penjualan_id",
        "buku_id",
        "harga_jual",
        "jumlah",
        "subtotal"
    ];

    /**
     * Relasi ke model Buku (Many to One)
     * Setiap detail penjualan berhubungan dengan satu buku.
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    /**
     * Relasi ke model Penjualan (Many to One)
     * Setiap detail penjualan berhubungan dengan satu transaksi penjualan.
     */
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }
}
