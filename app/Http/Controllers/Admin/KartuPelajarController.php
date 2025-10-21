<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Milon\Barcode\Facades\DNS1D;

class KartuPelajarController extends Controller
{
    // 🧭 Menampilkan daftar siswa
    public function index(Request $request)
    {
        $q = $request->query('q');
        $query = Siswa::query();

        if ($q) {
            $query->where(function ($w) use ($q) {
                $w->where('nama_lengkap', 'like', "%{$q}%")
                    ->orWhere('nis', 'like', "%{$q}%")
                    ->orWhere('nisn', 'like', "%{$q}%")
                    ->orWhere('rombel', 'like', "%{$q}%")
                    ->orWhere('jurusan', 'like', "%{$q}%");
            });
        }

        $siswas = $query->orderBy('nama_lengkap')
                        ->paginate(10)
                        ->withQueryString();

        return view('admin.kartupelajar.index', compact('siswas', 'q'));
    }

    // 🔍 Ajax search (opsional)
    public function search(Request $request)
    {
        $q = $request->query('q');
        $siswas = Siswa::when($q, fn($query) => 
                        $query->where('nama_lengkap', 'like', "%{$q}%"))
                        ->orderBy('nama_lengkap')
                        ->limit(50)
                        ->get();

        return view('admin.kartupelajar._rows', compact('siswas'));
    }

    // 🧾 Cetak satu kartu pelajar (PDF)
    public function cetak($nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();

        // ✅ Pastikan ukuran sesuai (8.6cm x 5.4cm) dan layout tetap satu halaman
        $pdf = Pdf::loadView('admin.kartupelajar.kartu', compact('siswa'))
            ->setPaper([0, 0, 243.78, 153.07], 'portrait') // ukuran cm ke point
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('isCssBackgroundEnabled', true);

        // ✅ Stream hasil PDF
        return $pdf->stream('Kartu_Pelajar_' . $siswa->nama_lengkap . '.pdf');
    }

    // 🧾 Cetak banyak kartu pelajar (massal)
    public function printMass(Request $request)
    {
        $ids = $request->input('ids');

        if ($ids && is_array($ids)) {
            $siswas = Siswa::whereIn('id', $ids)->get();
        } else {
            $siswas = Siswa::orderBy('nama_lengkap')->limit(200)->get();
        }

       $pdf = Pdf::loadView('admin.kartupelajar.kartu', compact('siswa'))
            ->setPaper([0, 0, 243.78, 153.07], 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('isCssBackgroundEnabled', true)
            ->setOption('dpi', 150)
            ->setOption('defaultFont', 'Arial');


        return $pdf->stream('Kartu_Pelajar_Massal.pdf');
    }
}
