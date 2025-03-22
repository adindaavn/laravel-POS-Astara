<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk menyimpan data member.
 */
class Member extends Model
{
    use HasFactory;
    protected $table = "member";
    protected $fillable = [
        "nama",
        "point",
        "email",
        "telp",
        "alamat"
    ];
}
