<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use PDF; // Dompdf

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

        $siswas = $query->orderBy('nama_lengkap')->paginate(10)->withQueryString();

        return view('.kartu_pelajar.index', compact('siswas','q'));
    }

    // optional ajax search to return html rows
    public function search(Request $request)
    {
        $q = $request->query('q');
        $siswas = Siswa::when($q, fn($q2) => $q2->where('nama_lengkap','like',"%{$q}%"))
                      ->orderBy('nama_lengkap')->limit(50)->get();

        // return partial view rows
        return view('admin.kartu_pelajar._rows', compact('siswas'));
    }

    // Print single siswa -> render PDF and stream/download
    public function printSingle($id)
    {
        $siswa = Siswa::findOrFail($id);
        $pdf = PDF::loadView('admin.kartu_pelajar.kartu', compact('siswa'));
        // stream to browser
        return $pdf->stream("kartu_{$siswa->nis}.pdf");
        // or return $pdf->download("kartu_{$siswa->nis}.pdf");
    }

    // Print mass: menerima array id (checkbox) atau 'all' flag
    public function printMass(Request $request)
    {
        $ids = $request->input('ids'); // array
        if ($ids && is_array($ids)) {
            $siswas = Siswa::whereIn('id', $ids)->get();
        } else {
            // fallback: semua siswa (batasi jumlah sesuai kebutuhan)
            $siswas = Siswa::orderBy('nama_lengkap')->limit(200)->get();
        }

        $pdf = PDF::loadView('admin.kartu_pelajar.kartu_mass', compact('siswas'));
        return $pdf->stream("kartu_mass.pdf");
    }
}
