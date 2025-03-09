<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pembelian extends Model
{
    protected $table = "pembelian";
    protected $fillable = [
        "pemasok_id",
        "user_id",
        "tgl",
        "total",
    ];
}
