<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk menyimpan absensi karyawan.
 */
class Absensi extends Model
{

    protected $table = "absensi";
    protected $fillable = [
        "nama_karyawan",
        "tgl_masuk",
        "jam_masuk",
        "jam_selesai",
        "status",
    ];

    public function toExportArray()
    {
        return [
            'nama_karyawan' => $this->nama_karyawan,
            'tgl_masuk' => $this->tgl_masuk,
            'jam_masuk' => $this->jam_masuk,
            'jam_selesai' => $this->jam_selesai,
            'status' => $this->status,
        ];
    }

    /**
     * Set jam_selesai 00:00:00 jika status sakit atau cuti
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->status === 'cuti' || $model->status === 'sakit') {
                $model->jam_selesai = '00:00:00';
            } 
        });

        static::updating(function ($model) {
            if ($model->status === 'cuti' || $model->status === 'sakit') {
                $model->jam_selesai = '00:00:00';
            }
        });
    }
}
