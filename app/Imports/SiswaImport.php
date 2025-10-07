<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
     * Setiap baris dari file Excel akan diproses ke model Siswa.
     */
    public function model(array $row)
    {
        return new Siswa([
            'nisn' => $row['nisn'] ?? null,
            'nama' => $row['nama'] ?? null,
            'rombel' => $row['rombel'] ?? null,
            'kompetensi_keahlian' => $row['kompetensi_keahlian'] ?? null,
        ]);
    }

    /**
     * Validasi data per baris.
     */
    public function rules(): array
    {
        return [
            '*.nisn' => ['required', 'numeric'],
            '*.nama' => ['required', 'string'],
        ];
    }
}
