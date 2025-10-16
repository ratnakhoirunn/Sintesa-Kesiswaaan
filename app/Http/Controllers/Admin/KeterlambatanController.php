<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keterlambatan;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KeterlambatanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter tanggal dari query string
        $tanggal = $request->input('tanggal');

        // Query dasar keterlambatan + relasi siswa
        $query = Keterlambatan::with('siswa')->orderBy('tanggal', 'desc');

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        // Ambil data dari database
        $keterlambatans = $query->get();

        // Kirim ke view
        return view('admin.keterlambatan.index', compact('keterlambatans', 'tanggal'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        return view('admin.keterlambatan.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'jam_datang' => 'required',
            'menit_terlambat' => 'required|numeric',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Keterlambatan::create($request->all());

        return redirect()->route('admin.keterlambatan.index')
            ->with('success', 'Data keterlambatan berhasil ditambahkan.');
    }

    public function cetakSurat($id)
    {
        $data = Keterlambatan::with('siswa')->findOrFail($id);
        $pdf = \PDF::loadView('admin.keterlambatan.surat', compact('data'));
        return $pdf->stream('Surat_Keterlambatan_'.$data->siswa->nama_lengkap.'.pdf');
    }
}
