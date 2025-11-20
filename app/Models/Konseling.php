<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nama_siswa',
        'kelas',
        'nama_ortu',
        'alamat_ortu',
        'no_telp_ortu',
        'tanggal',
        'topik',
        'latar_belakang',
        'kegiatan_layanan',
        'status',
        'tanggapan_admin'
    ];

    public function orangTua()
{
    return $this->hasOne(OrangTua::class, 'nis', 'nis');
}

public function siswa()
{
    return $this->belongsTo(\App\Models\Siswa::class, 'siswa_id', 'id');
}


}
