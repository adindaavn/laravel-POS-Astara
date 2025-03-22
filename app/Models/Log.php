<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
