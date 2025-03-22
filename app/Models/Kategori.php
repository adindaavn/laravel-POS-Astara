<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk menyimpan data kategori.
 */
class Kategori extends Model
{
    use HasFactory;

    protected $table = "kategori";
    protected $fillable = ["nama"];

    /**
     * Relasi ke model Buku (One to Many - Kategori ke Buku)
     * Satu kategori dapat memiliki banyak buku.
     */
    public function buku()
    {
        return $this->hasMany(Buku::class);
    }
}
