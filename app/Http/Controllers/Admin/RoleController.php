<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Tampilkan daftar (variabel dikirim sebagai $roles supaya sesuai view).
     */
    public function index(Request $request)
{
    $search = $request->search;
    $role = $request->role;

    // Jika role = siswa → ambil dari tabel siswa
    if ($role === 'Siswa') {
        $query = Siswa::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('nis', 'like', "%$search%");
            });
        }

        $roles = $query->orderBy('nama_lengkap')->get();
        return view('admin.role.index', compact('roles'));
    }

    // Selain siswa — admin, guru_bk, guru, kesiswaan → tabel guru
    $query = Guru::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('nip', 'like', "%$search%");
        });
    }

    if ($role) {
        $query->where('role', $role);
    }

    $roles = $query->orderBy('nama')->get();
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
        'nama_pengguna' => 'required|string|max:255',
        'nip_nis' => 'required',
        'email' => 'required|email',
        'role' => 'required',
    ]);

    // Jika role Siswa → simpan ke tabel siswa
    if ($request->role === 'Siswa') {

        Siswa::create([
            'nama_lengkap' => $request->nama_pengguna,
            'nis' => $request->nip_nis,   // ← perbaikan
            'email' => $request->email,
            'password' => bcrypt('siswa123'),
            'role' => 'siswa',
        ]);

    } else {

        Guru::create([
            'nama' => $request->nama_pengguna,
            'nip' => $request->nip_nis, // ← perbaikan
            'email' => $request->email,
            'password' => bcrypt('password123'),
            'role' => $request->role,
        ]);
    }

    return redirect()->route('admin.role.index')
        ->with('success', 'Data berhasil ditambahkan.');
}

    /**
     * Edit — terima id/nis, cari fleksibel (cari berdasarkan id dulu, kalau tidak ada pakai nis).
     */
public function edit($identifier)
{
    // cari siswa berdasarkan NIS
    $siswa = Siswa::where('nis', $identifier)->first();

    // kalau tidak ditemukan, cari guru berdasarkan NIP
    $guru = Guru::where('nip', $identifier)->first();

    if (!$siswa && !$guru) {
        abort(404, "Data tidak ditemukan.");
    }

    // pilih data mana yg ditemukan
    $role = $siswa ?? $guru;

    // 🔹 Ambil daftar rombel (tabel: siswas)
    $rombels = Siswa::select('rombel')->distinct()->get();

    return view('admin.role.edit', compact('role', 'rombels'));
}

    /**
     * Update role (menerima id/nis di route juga).
     */public function update(Request $request, $identifier)
{
    $request->validate([
        'role' => 'required|string',
        'walikelas' => 'nullable|string'  // tambahkan validasi wali kelas
    ]);

    // cari siswa berdasarkan NIS
    $siswa = Siswa::where('nis', $identifier)->first();

    // cari guru berdasarkan NIP
    $guru = Guru::where('nip', $identifier)->first();

    if ($siswa) {
        // siswa hanya update role
        $siswa->update([
            'role' => $request->role,
        ]);

    } elseif ($guru) {

        // update role dan wali kelas (khusus guru)
        $guru->update([
            'role' => $request->role,
            'walikelas' => $request->role === 'guru' ? $request->walikelas : null
        ]);

    } else {
        abort(404, "Data tidak ditemukan.");
    }

    return redirect()->route('admin.role.index')->with('success', 'Role berhasil diperbarui!');
}

}
