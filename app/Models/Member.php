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
    ];

    public function toExportArray()
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'point' => $this->point,
            'telp' => $this->telp,
            'email' => $this->email,
        ];
    }
}
