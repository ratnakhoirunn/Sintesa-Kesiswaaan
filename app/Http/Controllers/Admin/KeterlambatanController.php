<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keterlambatan;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan ini ada di composer

class KeterlambatanController extends Controller
{
    /**
     * Tampilkan daftar keterlambatan siswa.
     */
    public function index(Request $request)
    {
        // Ambil filter tanggal dari query string (opsional)
        $tanggal = $request->input('tanggal');

        // Query keterlambatan dengan relasi siswa
        $query = Keterlambatan::with('siswa')->orderBy('tanggal', 'desc');

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        // Ambil semua data dari database
        $keterlambatans = $query->get();

        // Tampilkan ke view
        return view('admin.keterlambatan.index', compact('keterlambatans', 'tanggal'));
    }

    /**
     * Form tambah data keterlambatan.
     */
    public function create()
    {
        $siswas = Siswa::orderBy('nama_lengkap')->get();
        return view('admin.keterlambatan.create', compact('siswas'));
    }

    /**
     * Simpan data keterlambatan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'jam_datang' => 'required',
            'menit_terlambat' => 'required|numeric',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Keterlambatan::create([
            'siswa_id' => $request->siswa_id,
            'tanggal' => $request->tanggal,
            'jam_datang' => $request->jam_datang,
            'menit_terlambat' => $request->menit_terlambat,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.keterlambatan.index')
            ->with('success', 'Data keterlambatan berhasil ditambahkan.');
    }

    /**
     * Cetak surat keterlambatan dalam bentuk PDF.
     */
    public function cetakSurat($id)
    {
        $data = Keterlambatan::with('siswa')->findOrFail($id);

        // Pastikan view: resources/views/admin/keterlambatan/surat.blade.php
        $pdf = Pdf::loadView('admin.keterlambatan.surat', compact('data'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('Surat_Keterlambatan_' . $data->siswa->nama_lengkap . '.pdf');
    }
}
