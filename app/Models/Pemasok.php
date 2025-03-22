<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk menyimpan data pemasok.
 */
class Pemasok extends Model
{
    use HasFactory;
    protected $table = "pemasok";
    protected $fillable = [
        "nama",
        "email",
        "telp",
        "alamat"
    ];
}
