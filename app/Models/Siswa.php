<?php 

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Authenticatable
{
    use HasFactory, Notifiable;

    // Tabel
    protected $table = 'siswas';

    // Primary key NIS
    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';

    // Kolom yang bisa diisi
    protected $fillable = [
        'nis', 'nisn', 'nama_lengkap', 'email', 'no_whatsapp',
        'rombel', 'jurusan', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'agama', 'nama_ortu', 'alamat', 'foto', 
        'password' // ✅ penting untuk login siswa
    ];

    // Sembunyikan password di output
    protected $hidden = [
        'password',
    ];

    // Relasi Detail Siswa
    public function detailSiswa()
    {
        return $this->hasOne(DetailSiswa::class, 'nis', 'nis');
    }

    // Relasi Orang Tua
    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'nis', 'nis');
    }

    // Relasi Dokumen
    public function dokumen()
    {
        return $this->hasMany(DokumenSiswa::class, 'siswa_nis', 'nis');
    }

    // Custom attribute nama pengguna
    public function getNamaPenggunaAttribute()
    {
        return $this->nama_lengkap;
    }
}
