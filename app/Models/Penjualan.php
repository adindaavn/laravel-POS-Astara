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
        "diskon",
        "metode_bayar"
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
    // Dalam model Penjualan
    public function toExportArray()
    {
        return [
            'no_transaksi' => $this->no_transaksi,
            'kasir' => $this->user->name,
            'member' => optional($this->member)->nama ?? 'Non-Member',
            'detail_buku' => $this->detailPenjualan->map(function ($detail) {
                return sprintf(
                    "%s (%d x Rp. %s = Rp. %s)",
                    $detail->buku->judul,
                    $detail->jumlah,
                    number_format($detail->harga_jual, 0, ',', '.'),
                    number_format($detail->subtotal, 0, ',', '.')
                );
            })->implode("\n"),
            'total' => 'Rp. ' . number_format($this->total_bayar, 0, ',', '.'),
            'tgl' => $this->tgl,
        ];
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
