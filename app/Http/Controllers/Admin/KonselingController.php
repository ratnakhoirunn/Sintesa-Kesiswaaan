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
        // Ambil semua data konseling terbaru
        $konselings = Konseling::orderBy('tanggal', 'desc')->paginate(10);

        return view('admin.konseling.index', compact('konselings'));
    }

    public function create()
    {
        // Ambil daftar siswa untuk dropdown
        $siswas = Siswa::orderBy('nama_lengkap', 'asc')->get();

        return view('admin.konseling.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
            'nama_siswa' => 'required|string',
            'kelas' => 'required|string',
            'nama_ortu' => 'required|string',
            'alamat_ortu' => 'required|string',
            'no_telp_ortu' => 'required|string',
            'tanggal' => 'required|date',
            'topik' => 'required|string',
            'latar_belakang' => 'nullable|string',
            'kegiatan_layanan' => 'nullable|string',
            'status' => 'required|string|in:Menunggu,Disetujui,Ditolak',
            'tanggapan_admin' => 'nullable|string',
        ]);

        Konseling::create($request->all());

        return redirect()->route('admin.konseling.index')
                         ->with('success', 'Data konseling berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $konseling = Konseling::findOrFail($id);
        return view('admin.konseling.edit', compact('konseling'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|string',
            'nama_siswa' => 'required|string',
            'kelas' => 'required|string',
            'nama_ortu' => 'required|string',
            'alamat_ortu' => 'required|string',
            'no_telp_ortu' => 'required|string',
            'tanggal' => 'required|date',
            'topik' => 'required|string',
            'latar_belakang' => 'nullable|string',
            'kegiatan_layanan' => 'nullable|string',
            'status' => 'required|string|in:Menunggu,Disetujui,Ditolak',
            'tanggapan_admin' => 'nullable|string',
        ]);

        $konseling = Konseling::findOrFail($id);
        $konseling->update($request->all());

        return redirect()->route('admin.konseling.index')
                         ->with('success', 'Data konseling berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $konseling = Konseling::findOrFail($id);
        $konseling->delete();

        return redirect()->route('admin.konseling.index')
                         ->with('success', 'Data konseling berhasil dihapus.');
    }

    public function show($id)
    {
        $konseling = Konseling::findOrFail($id);
        return view('admin.konseling.show', compact('konseling'));
    }

    public function proses(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Disetujui,Ditolak',
        'tanggapan_admin' => 'nullable|string'
    ]);

    $konseling = Konseling::findOrFail($id);
    $konseling->status = $request->status;
    $konseling->tanggapan_admin = $request->tanggapan_admin;
    $konseling->save();

    return redirect()->route('admin.konseling.index')->with('success', 'Status konseling berhasil diperbarui.');
}

}
