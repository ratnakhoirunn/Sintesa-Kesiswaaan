<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // Kolom $fillable disesuaikan persis dengan yang Anda berikan.
    protected $fillable = [
        'nis',
        'nama_lengkap',
        'rombel',
        'jurusan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'nama_ortu',
        'alamat',
        'foto',
    ];

    /**
     * Definisi relasi One-to-One ke model OrangTua.
     * Baris ini harus ada agar $siswa->orangTua di Controller/View berfungsi.
     */
    public function orangTua()
    {
        // Relasi hasOne: Siswa memiliki satu data OrangTua (melalui siswa_id di tabel orang_tua)
        return $this->hasOne(OrangTua::class, 'siswa_id', 'id');
    }
}