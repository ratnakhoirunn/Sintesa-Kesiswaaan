<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_siswa',
        'kelas',
        'jenis_konseling',
        'deskripsi',
        'tanggal',
    ];
}
