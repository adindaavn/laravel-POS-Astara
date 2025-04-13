<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokBuku extends Model
{
    protected $table = "view_buku_stok";

    public function toExportArray()
    {
        return [
            'isbn' => $this->isbn,
            'judul' => $this->judul,
            'penulis' => $this->penulis,
            'kategori' => $this->kategori,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'penerbit' => $this->penerbit,
            'thn_terbit' => $this->thn_terbit,
            'gambar' => $this->gambar
        ];
    }
}
