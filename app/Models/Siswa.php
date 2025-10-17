<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // === Gunakan NIS sebagai primary key ===
    protected $primaryKey = 'nis';
    public $incrementing = false; // karena NIS bukan auto-increment
    protected $keyType = 'string'; // tipe data NIS biasanya string

    protected $fillable = [
        'nis', 'nisn', 'nama_lengkap', 'email', 'no_whatsapp',
        'rombel', 'jurusan', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'agama', 'nama_ortu', 'alamat', 'foto'
    ];

    // === Relasi ke tabel detail_siswas ===
    public function detailSiswa()
    {
        return $this->hasOne(DetailSiswa::class, 'nis', 'nis');
    }

    // === Relasi ke tabel orang_tuas ===
    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'nis', 'nis');
    }
}