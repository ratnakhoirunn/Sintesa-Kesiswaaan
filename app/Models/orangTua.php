<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;
    
    // Harus didefinisikan karena nama tabel bukan 'orang_tuas'
    protected $table = 'orang_tua';
    
    // Tambahkan semua kolom agar Mass Assignment (Create/Update) berfungsi
    protected $fillable = [
        'siswa_id',
        'nama_ayah','nik_ayah','tahun_lahir_ayah','pendidikan_ayah','pekerjaan_ayah','penghasilan_ayah','status_hidup_ayah','no_telp_ayah',
        'nama_ibu','nik_ibu','tahun_lahir_ibu','pendidikan_ibu','pekerjaan_ibu','penghasilan_ibu','status_hidup_ibu','no_telp_ibu',
        'nama_wali','nik_wali','tahun_lahir_wali','pendidikan_wali','pekerjaan_wali','penghasilan_wali','status_hidup_wali','no_telp_wali',
    ];

    /**
     * Relasi belongsTo kembali ke model Siswa.
     */
    public function siswa()
    {
        // Relasi belongsTo: OrangTua dimiliki oleh satu Siswa (melalui siswa_id)
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }
}