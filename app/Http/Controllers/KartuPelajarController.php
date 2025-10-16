<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KartuPelajarController extends Controller
{
    public function cetakSatu($id)
    {
        // ambil data siswa
        $siswa = Siswa::findOrFail($id);
        $siswas = collect([$siswa]); // untuk menyesuaikan view

        // ukuran kartu KTP (8.56 x 5.398 cm = 323 x 204 px)
        $customPaper = [0, 0, 323, 204];

        // 🔹 ini bagian penting yang kamu tanya
        $pdf = Pdf::loadView('kartu', compact('siswas'))
            ->setPaper($customPaper, 'landscape')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('isCssBackgroundEnabled', true); // penting supaya warna/gradient muncul

        // tampilkan PDF di browser
        return $pdf->stream('Kartu-Pelajar-'.$siswa->nama.'.pdf');
    }
}
