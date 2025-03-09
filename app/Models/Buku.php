<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Buku extends Model
{
    protected $table = "buku";
    protected $fillable = [
        "isbn",
        "judul",
        "penulis",
        "pemasok",
        "kategori_id",
        "harga",
        "stok",
        "thn_terbit"
    ];
}
