<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'NIS',
        'nama_lengkap',
        'NISN',
        'kelas',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'email',
        'nomor_wa',
        'foto',
        'riwayat_kesehatan',
        // Tambahkan kolom dari tbl_detail_siswa jika diperlukan
        'berat_badan',
        'tinggi_badan',
        'hobi',
        'cita_cita',
        'anak_ke',
        'jumlah_saudara_kandung',
        'nama_jalan',
        'rt',
        'rw',
        'dusun',
        'desa',
        'kode_pos',
        'tinggal_dengan',
        'jarak_rumah_km',
        'waktu_tempuh_menit',
        'transportasi_sekolah'
    ];
}