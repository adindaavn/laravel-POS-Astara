<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Pembelian extends Model
{
    protected $table = "pembelian";
    protected $fillable = [
        "pemasok_id",
        "user_id",
        "tgl",
        "total",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'pemasok_id');
    }

    public function detailPembelian()
    {
        return $this->hasMany(PembelianDetail::class, 'pembelian_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->tgl = now();
            $model->user_id = Auth::id();
        });
    }
}
