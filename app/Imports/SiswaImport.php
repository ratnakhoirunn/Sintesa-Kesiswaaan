<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\DetailSiswa;
use App\Models\OrangTua;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Pakai transaksi biar aman, kalau 1 gagal, semua rollback
        return DB::transaction(function () use ($row) {
            // --- 1️⃣ Buat data siswa utama
            $siswa = Siswa::updateOrCreate(
                ['nis' => $row['nis']],
                [
                    'nisn'           => $row['nisn'] ?? null,
                    'nama_lengkap'   => $row['nama_lengkap'] ?? null,
                    'jenis_kelamin'  => $row['jenis_kelamin'] ?? null,
                    'email'          => $row['email'] ?? null,
                    'no_whatsapp'    => $row['no_whatsapp'] ?? null,
                    'rombel'         => $row['rombel'] ?? null,
                    'jurusan'        => $row['jurusan'] ?? null,
                    'tempat_lahir'   => $row['tempat_lahir'] ?? null,
                    'tanggal_lahir'  => $this->parseDate($row['tanggal_lahir'] ?? null),
                    'agama'          => $row['agama'] ?? null,
                    'alamat_lengkap' => $row['alamat_lengkap'] ?? null,
                ]
            );

            // --- 2️⃣ Buat detail siswa (relasi by nis)
            DetailSiswa::updateOrCreate(
                ['nis' => $row['nis']],
                [
                    'cita_cita'      => $row['cita_cita'] ?? null,
                    'hobi'           => $row['hobi'] ?? null,
                    'berat_badan'    => $row['berat_badan'] ?: null,
                    'tinggi_badan'   => $row['tinggi_badan'] ?: null,
                    'anak_ke'        => $row['anak_ke'] ?: null,
                    'jumlah_saudara' => $row['jumlah_saudara'] ?: null,
                    'tinggal_dengan' => $row['tinggal_dengan'] ?? null,
                    'jarak_rumah'    => $row['jarak_rumah'] ?: null,
                    'waktu_tempuh'   => $row['waktu_tempuh'] ?: null,
                    'nama_jalan'     => $row['nama_jalan'] ?? null,
                    'rt'             => $row['rt'] ?: null,
                    'rw'             => $row['rw'] ?: null,
                    'dusun'          => $row['dusun'] ?? null,
                    'desa'           => $row['desa_kelurahan'] ?? null,
                    'kode_pos'       => $row['kode_pos'] ?: null,
                ]
            );

            // --- 3️⃣ Buat data orang tua (relasi by nis)
            OrangTua::updateOrCreate(
                ['nis' => $row['nis']],
                [
                    'nama_ortu'   => $row['nama_orang_tua_(utama)'] ?? $row['nama_orang_tua_utama'] ?? null,
                    'pekerjaan'   => $row['pekerjaan_ortu'] ?? null,
                    'no_hp_ortu'  => $row['no_hp_ortu'] ?? null,
                    'alamat_ortu' => $row['alamat_ortu'] ?? null,
                ]
            );

            return $siswa;
        });
    }

    private function parseDate($value)
    {
        if (!$value) return null;

        if (is_numeric($value)) {
            try {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Throwable $e) {
                return null;
            }
        }

        try {
            return date('Y-m-d', strtotime($value));
        } catch (\Exception $e) {
            return null;
        }
    }

    public function rules(): array
    {
        return [
            '*.nis'           => ['required'],
            '*.nama_lengkap'  => ['required'],
            '*.email'         => ['nullable', 'email'],
        ];
    }
}
