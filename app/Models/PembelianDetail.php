<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
}
