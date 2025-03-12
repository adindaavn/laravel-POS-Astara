<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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
        "metode_bayar",
        "no_rekening"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id');
    }

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
            
            $model->tgl = now();
            $model->user_id = Auth::id();
        });
    }
}
