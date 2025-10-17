<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan ini benar
use Milon\Barcode\Facades\DNS1D;
use Milon\Barcode\Facades\DNS2D;

class KartuPelajarController extends Controller
{
    // 🧭 Menampilkan daftar siswa
    public function index(Request $request)
    {
        $q = $request->query('q');
        $query = Siswa::query();

        if ($q) {
            $query->where(function($w) use ($q) {
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

        // ✅ Pastikan view: resources/views/admin/kartupelajar/index.blade.php
        return view('admin.kartupelajar.index', compact('siswas', 'q'));
    }

    // 🔍 Ajax search (opsional)
    public function search(Request $request)
    {
        $q = $request->query('q');
        $siswas = Siswa::when($q, fn($query) => $query->where('nama_lengkap', 'like', "%{$q}%"))
                       ->orderBy('nama_lengkap')
                       ->limit(50)
                       ->get();

        // ✅ Pastikan partial view: resources/views/admin/kartupelajar/_rows.blade.php
        return view('admin.kartupelajar._rows', compact('siswas'));
    }

    // 🧾 Cetak satu kartu pelajar (PDF)
    public function cetak($id)
    {
        $siswa = Siswa::findOrFail($id);

        // ukuran kartu pelajar: 8.6cm x 5.4cm
        $pdf = Pdf::loadView('admin.kartupelajar.kartu', compact('siswa'))
            ->setPaper([0, 0, 243.78, 153.07], 'portrait');

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

        // ✅ View: resources/views/admin/kartupelajar/kartu_mass.blade.php
        $pdf = Pdf::loadView('admin.kartupelajar.kartu_mass', compact('siswas'))
            ->setPaper([0, 0, 323, 204], 'landscape')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('isCssBackgroundEnabled', true);

        return $pdf->stream('Kartu_Pelajar_Massal.pdf');
    }
}
