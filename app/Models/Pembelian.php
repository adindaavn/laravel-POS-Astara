<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Model untuk menyimpan data pembelian.
 */
class Pembelian extends Model
{
    protected $table = "pembelian";
    protected $fillable = [
        "pemasok_id",
        "user_id",
        "tgl",
        "total",
    ];

    /**
     * Relasi ke model User (Many to One).
     * Setiap pembelian dicatat oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model Pemasok (Many to One).
     * Setiap pembelian berasal dari satu pemasok.
     */
    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'pemasok_id');
    }

    /**
     * Relasi ke model PembelianDetail (One to Many).
     * Satu pembelian bisa punya banyak detail pembelian.
     */
    public function detailPembelian()
    {
        return $this->hasMany(PembelianDetail::class, 'pembelian_id');
    }
    public function toExportArray()
    {
        return [
            'user' => $this->user->name,
            'pemasok' => $this->pemasok->nama,
            'detail_buku' => $this->detailPembelian->map(function ($detail) {
                return sprintf(
                    "%s (%d x Rp. %s = Rp. %s)",
                    $detail->buku->judul,
                    $detail->jumlah,
                    number_format($detail->harga_beli, 0, ',', '.'),
                    number_format($detail->subtotal, 0, ',', '.')
                );
            })->implode("\n"),
            'total' => 'Rp. ' . number_format($this->total, 0, ',', '.'),
            'tgl' => $this->tgl,
        ];
    }
    /**
     * Event model: Set tanggal & user_id otomatis saat pembelian dibuat.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->tgl = now();
            $model->user_id = Auth::id();
        });
    }
}
