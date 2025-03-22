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

    protected $table = "pengajuan_barang";
    protected $fillable = [
        "member_id",
        "tgl",
        "nama",
        "qty",
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

    /**
     * Auto-log setiap perubahan data.
     */
    protected static function boot()
    {
        parent::boot();


        static::creating(
            function ($model) {
                $model->tgl = now();
                $model->status = '0';
            }
        );
        static::created(function ($pengajuan) {
            Log::create([
                'table_name' => 'pengajuan_barang',
                'action' => 'create',
                'user_id' => Auth::id(),
                'data' => $pengajuan->toArray(),
                'ip_address' => request()->ip(),
            ]);
        });

        static::updated(function ($pengajuan) {
            Log::create([
                'table_name' => 'pengajuan_barang',
                'action' => 'update',
                'user_id' => Auth::id(),
                'data' => $pengajuan->toArray(),
                'ip_address' => request()->ip(),
            ]);
        });

        static::deleted(function ($pengajuan) {
            Log::create([
                'table_name' => 'pengajuan_barang',
                'action' => 'delete',
                'user_id' => Auth::id(),
                'data' => $pengajuan->toArray(),
                'ip_address' => request()->ip(),
            ]);
        });
    }
}
