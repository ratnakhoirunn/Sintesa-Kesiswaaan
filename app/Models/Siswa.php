<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis', 'nisn', 'nama_lengkap', 'email', 'no_whatsapp', 'rombel', 'jurusan',
        'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'agama', 'nama_ortu', 'alamat', 'foto'
    ];

    public function detailSiswa()
{
    return $this->hasOne(DetailSiswa::class, 'siswa_id', 'id');
}

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'siswa_id', 'id');
    }
}