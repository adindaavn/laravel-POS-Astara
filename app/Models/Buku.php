<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Buku extends Model
{
    use HasFactory;
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
}
