<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSiswa extends Model
{
    use HasFactory;
    protected $table = 'detail_siswa';
    protected $fillable = [
        'siswa_id','cita_cita','hobi','berat_badan','tinggi_badan','anak_ke',
        'jumlah_saudara','tinggal_dengan','jarak_rumah','waktu_tempuh',
        'nama_jalan','rt','rw','dusun','desa','kode_pos'
    ];
}

