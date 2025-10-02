<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Menggunakan header sebagai key
use Maatwebsite\Excel\Concerns\WithValidation; // Contoh jika butuh validasi
use Illuminate\Support\Facades\Log;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Abaikan baris yang kosong atau tidak memiliki NIS
        if (empty($row['nis'])) {
            return null;
        }

        // Logika untuk memproses kolom 'ttl' yang digabung
        $ttl = explode(', ', $row['ttl'] ?? '');
        $tempatLahir = $ttl[0] ?? null;
        $tanggalLahir = isset($ttl[1]) ? date('Y-m-d', strtotime(str_replace('/', '-', $ttl[1]))) : null;
    
        // Perbaikan: Menggunakan $row['jk'] untuk memetakan jenis_kelamin
        $jenisKelamin = ($row['jk'] === 'L') ? 'Laki-laki' : 'Perempuan';
        dd($row);

        // Mengembalikan instance model Siswa dengan data yang sudah dipetakan
        return new Siswa([
            'NIS' => $row['nis'],
            'NISN' => $row['nisn'],
            'nama' => $row['nama'],
            'kelas' => $row['kelas'],
            'jurusan' => $row['jurusan'],
            'jenis_kelamin' => $jenisKelamin, // Menggunakan variabel yang sudah diproses
            'tempat_lahir' => $tempatLahir,
            'tanggal_lahir' => $tanggalLahir,
            'agama' => $row['agama'],
            'nama_ayah' => $row['ayah'] ?? null, // Menggunakan null coalescing untuk menghindari error
            'nama_ibu' => $row['ibu'] ?? null,
            'alamat_siswa' => $row['alamat'],
        ]);
    }
}