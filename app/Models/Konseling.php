<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    use HasFactory;

    protected $fillable = [
    'siswa_nis',
    'tanggal',
    'rombel',
    'status',
    'catatan',
];

// relasi ke siswa
public function siswa()
{
    return $this->belongsTo(Siswa::class, 'siswa_nis', 'nis');
}
}
