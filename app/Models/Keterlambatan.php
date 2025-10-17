<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keterlambatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'siswa_id',
        'tanggal',
        'jam_datang',
        'menit_terlambat',
        'keterangan',
    ];

    // relasi ke model Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
