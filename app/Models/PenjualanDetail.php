<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
