<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Model untuk menyimpan data voucher.
 */
class Voucher extends Model
{

    protected $table = "voucher";
    protected $fillable = [
        "kode",
        "diskon",
        "deskripsi",
        "expired"
    ];
    /**
     * Event model untuk menangani pembuatan kode voucher otomatis.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $tahun = now()->year;

            // Ambil kode voucher terakhir di tahun yang sama
            $lastKode = DB::table('voucher')
                ->where('kode', 'like', "VC$tahun%")
                ->orderBy('kode', 'desc')
                ->value('kode');

            // Jika ada, ambil angka terakhirnya, jika tidak, mulai dari 0
            $lastNum = $lastKode ? (int)substr($lastKode, -4) : 0;

            // Tambahkan 1 untuk kode baru
            $newNum = $lastNum + 1;

            // Format kode voucher baru: VC20250001, VC20250002, dst.
            $model->kode = sprintf("VC%s%04d", $tahun, $newNum);
        });
    }
}
