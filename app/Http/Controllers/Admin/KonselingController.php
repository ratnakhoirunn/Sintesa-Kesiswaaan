<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KonselingController extends Controller
{
   public function index()
{
    $konselings = Konseling::with('siswa')->orderBy('tanggal', 'desc')->paginate(10);

    return view('admin.konseling.index', compact('konselings'));
}


    public function create()
    {
        // ambil daftar siswa untuk dropdown
        $siswas = Siswa::orderBy('nama_lengkap', 'asc')->get();
        return view('admin.konseling.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_nis' => 'required|string',
            'tanggal' => 'required|date',
            'rombel' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        Konseling::create([
            'siswa_nis' => $request->siswa_nis,
            'tanggal' => $request->tanggal,
            'rombel' => $request->rombel,
            'status' => 'Selesai', // default sesuai migration
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.konseling.index')
                         ->with('success', 'Data konseling berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $konseling = Konseling::findOrFail($id);
        $siswas = Siswa::orderBy('nama_lengkap','asc')->get();
        return view('admin.konseling.edit', compact('konseling', 'siswas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_nis' => 'required|string',
            'tanggal' => 'required|date',
            'rombel' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $konseling = Konseling::findOrFail($id);

        $konseling->update([
            'siswa_nis' => $request->siswa_nis,
            'tanggal' => $request->tanggal,
            'rombel' => $request->rombel,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.konseling.index')
                         ->with('success', 'Data konseling berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $konseling = Konseling::findOrFail($id);
        $konseling->delete();

        return redirect()->route('admin.konseling.index')
                         ->with('success', 'Data berhasil dihapus.');
    }
}
