<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nisn',
        'nama',
        'rombel',
        'kompetensi_keahlian',
    ];

    public function detail()
    {
        return $this->hasOne(DetailSiswa::class);
    }
}