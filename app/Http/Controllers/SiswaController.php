<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Siswa;
use Illuminate\Http\Request;
use PDF;
class SiswaController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        // Gunakan paginate agar bisa pakai links() di Blade
        $siswas = Siswa::orderBy('nama_lengkap', 'asc')->paginate(10); // 10 data per halaman
        return view('admin.datasiswa.index', compact('siswas'));
    }

    public function create()
    {
        return view('admin.datasiswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswas',
            'nama_lengkap' => 'required',
            'rombel' => 'required',
            'jurusan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'nama_ortu' => 'required',
            'alamat' => 'required',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto_siswa', 'public');
        }

        Siswa::create($validated);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil disimpan.');
    }

    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'required|unique:siswas,nis,'.$siswa->id,
            'nama_lengkap' => 'required',
            'rombel' => 'required',
            'jurusan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'nama_ortu' => 'required',
            'alamat' => 'required',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto_siswa', 'public');
        }

        $siswa->update($validated);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Siswa::destroy($id);
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function cetakKartu($id)
    {
        $siswa = Siswa::findOrFail($id);
        $pdf = PDF::loadView('admin.siswa.kartu', compact('siswa'))->setPaper('A7', 'landscape');
        return $pdf->download('Kartu_Pelajar_'.$siswa->nama_lengkap.'.pdf');
    }
