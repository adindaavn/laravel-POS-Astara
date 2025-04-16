<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Model untuk menyimpan log aktivitas di aplikasi.
 */
class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_name',
        'action',
        'user_id',
        'data',
        'ip_address',
    ];

    protected $casts = [
        'data' => 'array', // Data otomatis dikonversi ke array saat diakses
    ];

    /**
     * Fungsi untuk menyimpan log dengan data otomatis.
     * 
     * @param string $tableName
     * @param string $action
     * @param array $data
     * @return void
     */
    public static function createLog($tableName, $action, $data = [])
    {
        // Ambil user_id dari session (jika ada) atau set null jika tidak ada user
        $userId = Auth::id();

        // Ambil IP Address pengguna
        $ipAddress = Request::ip();

        // Simpan log ke dalam database
        self::create([
            'table_name' => $tableName,
            'action' => $action,
            'user_id' => $userId,
            'data' => $data,
            'ip_address' => $ipAddress,
        ]);
    }
}
