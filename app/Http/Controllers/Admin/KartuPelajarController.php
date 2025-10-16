<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use PDF; // Dompdf
use Milon\Barcode\Facades\DNS1D;
use Milon\Barcode\Facades\DNS2D;


class KartuPelajarController extends Controller
{
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

        // ✅ Pastikan view kamu ada di: resources/views/admin/kartupelajar/index.blade.php
        return view('admin.kartupelajar.index', compact('siswas', 'q'));
    }

    // 🔍 Optional ajax search
    public function search(Request $request)
    {
        $q = $request->query('q');
        $siswas = Siswa::when($q, fn($q2) => $q2->where('nama_lengkap', 'like', "%{$q}%"))
                       ->orderBy('nama_lengkap')
                       ->limit(50)
                       ->get();

        // ✅ Pastikan view partial-nya ada di: resources/views/admin/kartupelajar/_rows.blade.php
        return view('admin.kartupelajar._rows', compact('siswas'));
    }

    // 🧾 Print single siswa (PDF)
    public function printSingle($id)
    {
        $siswa = Siswa::findOrFail($id);

        // ✅ View: resources/views/admin/kartupelajar/kartu.blade.php
        $pdf = PDF::loadView('admin.kartupelajar.kartu', compact('siswa'));

        return $pdf->stream("kartu_{$siswa->nis}.pdf");
        // return $pdf->download("kartu_{$siswa->nis}.pdf");
    }

    // 🧾 Print massal siswa (PDF)
    public function printMass(Request $request)
    {
        $ids = $request->input('ids'); // array

        if ($ids && is_array($ids)) {
            $siswas = Siswa::whereIn('id', $ids)->get();
        } else {
            $siswas = Siswa::orderBy('nama_lengkap')->limit(200)->get();
        }

        // ✅ View: resources/views/admin/kartupelajar/kartu_mass.blade.php
        $pdf = PDF::loadView('admin.kartupelajar.kartu_mass', compact('siswas'));

        return $pdf->stream("kartu_mass.pdf");
    }

    public function cetak($id)
{
    $siswa = Siswa::findOrFail($id);
    $pdf = Pdf::loadView('admin.kartupelajar.kartu', compact('siswa'))
        ->setPaper([0, 0, 243.78, 153.07], 'portrait'); // 8.6cm x 5.4cm

    return $pdf->stream('kartu_pelajar_'.$siswa->nama_lengkap.'.pdf');
}
}
