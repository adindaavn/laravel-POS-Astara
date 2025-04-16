<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Model untuk menyimpan pengajuan buku.
 */
class PengajuanBuku extends Model
{
    use HasFactory;

    protected $table = "pengajuan_buku";
    protected $fillable = [
        "member_id",
        "tgl",
        "judul",
        "penulis",
        "nama_pengaju",
        "no_telp",
        "qty",
        "catatan",
        "status",
    ];

    /**
     * Relasi ke model Member (Many to One).
     * Setiap pengajuan hanya bisa dibuat oleh satu member.
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function toExportArray()
    {
        return [
            'id' => $this->id,
            'nama_pengaju' => $this->nama_pengaju,
            'no_telp' => $this->no_telp,
            'member_id' => $this->member_id ?? '-',
            'judul' => $this->judul,
            'penulis' => $this->penulis,
            'qty' => $this->qty,
            'catatan' => $this->catatan,
            'status' => $this->status == 1 ? 'Terpenuhi' : 'Belum Terpenuhi',
            'tanggal' => $this->tgl
        ];
    }

    /**
     * Auto-log setiap perubahan data.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->tgl) $model->tgl = now();
            if (!$model->status) $model->status = '0';
        });
    }
}
