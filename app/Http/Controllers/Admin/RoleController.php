<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Tampilkan daftar (variabel dikirim sebagai $roles supaya sesuai view).
     */
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // kirim sebagai $roles (sesuai view)
        $roles = $query->orderBy('nama_lengkap', 'asc')->get();

        return view('admin.role.index', compact('roles'));
    }

     public function create()
    {
        // Menampilkan form tambah role baru
        return view('admin.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required',
            'nis' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ]);

        Siswa::create([
            'nama_pengguna' => $request->nama_pengguna,
            'nis' => $request->nis,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.role.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Edit — terima id/nis, cari fleksibel (cari berdasarkan id dulu, kalau tidak ada pakai nis).
     */
    public function edit($identifier)
    {
        // coba cari by primary key 'id'
        $siswa = Siswa::find($identifier);

        // jika null, coba cari by nis
        if (!$siswa) {
            $siswa = Siswa::where('nis', $identifier)->firstOrFail();
        }

        // kirim ke view (view menunggu $role)
        $role = $siswa;
        return view('admin.role.edit', compact('role'));
    }

    /**
     * Update role (menerima id/nis di route juga).
     */
    public function update(Request $request, $identifier)
    {
        $request->validate([
            'role' => 'required|string',
        ]);

        $siswa = Siswa::find($identifier);
        if (!$siswa) {
            $siswa = Siswa::where('nis', $identifier)->firstOrFail();
        }

        $siswa->update([
            'role' => $request->role,
        ]);

        return redirect()->route('admin.role.index')->with('success', 'Role berhasil diperbarui!');
    }
}
