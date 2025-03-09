<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    protected $table = "penjualan";
    protected $fillable = [
        "no_transaksi",
        "member_id",
        "user_id",
        "tgl",
        "total_bayar",
        "pembayaran"
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $tahun = now()->year;

            $lastKode = DB::table('penjualan')
                ->where('no_transaksi', 'like', "TRX$tahun%")
                ->orderBy('no_transaksi', 'desc')
                ->value('no_transaksi');

            $lastNum = $lastKode ?
                (int)substr($lastKode, -4) : 0;

            $newNum = $lastNum + 1;

            $model->no_transaksi = sprintf("TRX%s%04d", $tahun, $newNum);
            
            $model->tgl_transaksi = now();
        });
    }
}
