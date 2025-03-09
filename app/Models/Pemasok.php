<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pemasok extends Model
{
    protected $table = "pemasok";
    protected $fillable = [
        "nama",
        "email",
        "telp",
        "alamat"
    ];
}
