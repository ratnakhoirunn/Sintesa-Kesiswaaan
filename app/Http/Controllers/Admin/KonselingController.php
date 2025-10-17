<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use Illuminate\Http\Request;

class KonselingController extends Controller
{
    public function index()
    {
        $konselings = Konseling::orderBy('tanggal', 'desc')->get();
        return view('admin.konseling.index', compact('konselings'));
    }

    public function create()
    {
        return view('admin.konseling.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:100',
            'kelas' => 'required|string|max:50',
            'jenis_konseling' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        Konseling::create($request->all());

        return redirect()->route('admin.konseling.index')->with('success', 'Data konseling berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $konseling = Konseling::findOrFail($id);
        return view('admin.konseling.edit', compact('konseling'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:100',
            'kelas' => 'required|string|max:50',
            'jenis_konseling' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $konseling = Konseling::findOrFail($id);
        $konseling->update($request->all());

        return redirect()->route('admin.konseling.index')->with('success', 'Data konseling berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $konseling = Konseling::findOrFail($id);
        $konseling->delete();

        return redirect()->route('admin.konseling.index')->with('success', 'Data berhasil dihapus.');
    }
}
