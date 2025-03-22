<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Model untuk menyimpan transaksi penjualan.
 */
class Penjualan extends Model
{
    protected $table = "penjualan";
    protected $fillable = [
        "no_transaksi",
        "member_id",
        "user_id",
        "tgl",
        "total_bayar",
        "total_bersih",
        "metode_bayar",
        "no_rekening"
    ];

    /**
     * Relasi ke User (Kasir/Admin yang mencatat transaksi)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Member (Jika transaksi dilakukan oleh member)
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    /**
     * Relasi ke Detail Penjualan (One to Many)
     */
    public function detailPenjualan()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id');
    }

    /**
     * Event: Auto-generate nomor transaksi saat membuat penjualan baru
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $tahun = now()->year;

            // Ambil nomor transaksi terakhir dengan locking untuk menghindari race condition
            $lastKode = DB::table('penjualan')
                ->where('no_transaksi', 'like', "TRX$tahun%")
                ->lockForUpdate()
                ->orderBy('no_transaksi', 'desc')
                ->value('no_transaksi');

            // Ambil angka terakhir dari no_transaksi
            $lastNum = $lastKode ? (int)substr($lastKode, -4) : 0;
            $newNum = $lastNum + 1;

            // Format nomor transaksi baru
            $model->no_transaksi = "TRX{$tahun}" . str_pad($newNum, 4, '0', STR_PAD_LEFT);

            // Set default user_id (hindari error di CLI seperti saat seeding)
            $model->user_id = request()->user()->id ?? null;
            $model->tgl = now();
        });
    }
}
