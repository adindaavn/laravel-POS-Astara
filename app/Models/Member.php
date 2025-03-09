<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    protected $table = "member";
    protected $fillable = [
        "nama",
        "point",
        "email",
        "telp",
        "alamat"
    ];
}
