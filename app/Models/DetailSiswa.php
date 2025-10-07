<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSiswa extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Memungkinkan mass assignment pada semua kolom kecuali 'id'

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}