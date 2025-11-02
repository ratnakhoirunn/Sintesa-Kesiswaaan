<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\DokumenSiswa;
use Illuminate\Support\Facades\Storage;

class DokumenSiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $dokumenFilter = $request->input('dokumen');
        $totalDokumenWajib = 5; // jumlah jenis dokumen wajib

        // Ambil semua siswa beserta dokumennya
        $query = \App\Models\Siswa::with('dokumenSiswa');

        // Filter pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Ambil data siswa (paginate)
        $siswa = $query->paginate(10);

        // Hitung total dokumen yang sudah diunggah per siswa
        foreach ($siswa as $s) {
            $uploadedCount = \App\Models\DokumenSiswa::where('nis', $s->nis)
                            ->whereNotNull('file_path')
                            ->count();
            $s->dokumen_siswa_count = $uploadedCount;
        }

        return view('admin.dokumensiswa.index', compact('siswa', 'totalDokumenWajib'));
    }

    public function show($nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();

        // Ambil semua dokumen milik siswa
        $dokumen = DokumenSiswa::where('nis', $nis)->get();

        // Daftar dokumen wajib
        $wajib = [
            'Kartu Keluarga',
            'Akte Kelahiran',
            'KPSPKH',
            'KIP',
            'Pas Foto'
        ];

        // Hitung total dokumen yang sudah diunggah
        $totalTerpenuhi = $dokumen->whereNotNull('file_path')->count();
        $totalWajib = count($wajib);

        // Kirim ke view
        return view('admin.dokumensiswa.show', compact(
            'siswa', 'dokumen', 'wajib', 'totalTerpenuhi', 'totalWajib'
        ));
    }

    public function edit($nis)
    {
        $siswa = Siswa::where('nis', $nis)->with('dokumen')->firstOrFail();

        $dokumenWajib = [
            'Kartu Keluarga',
            'Akte Kelahiran',
            'Ijazah',
            'KTP Orang Tua',
            'Pas Foto',
        ];

        return view('admin.dokumensiswa.edit', compact('siswa', 'dokumenWajib'));
    }

    public function update(Request $request, $nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();

        $validated = $request->validate([
            'dokumen' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'dokumen.required' => 'Jenis dokumen wajib dipilih.',
            'file.mimes' => 'File harus berupa PDF atau gambar (jpg, jpeg, png).',
            'file.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $dokumen = DokumenSiswa::where('nis', $nis)
            ->where('jenis_dokumen', $validated['dokumen'])
            ->first();

        if ($request->hasFile('file')) {
            if ($dokumen && $dokumen->file_path && Storage::exists('public/' . $dokumen->file_path)) {
                Storage::delete('public/' . $dokumen->file_path);
            }

            $filePath = $request->file('file')->store('dokumen_siswa', 'public');

            if ($dokumen) {
                $dokumen->update(['file_path' => $filePath]);
            } else {
                DokumenSiswa::create([
                    'nis' => $nis,
                    'jenis_dokumen' => $validated['dokumen'],
                    'file_path' => $filePath,
                ]);
            }
        } else {
            if (!$dokumen) {
                DokumenSiswa::create([
                    'nis' => $nis,
                    'jenis_dokumen' => $validated['dokumen'],
                    'file_path' => null,
                ]);
            }
        }

        return redirect()
            ->route('admin.dokumensiswa.index')
            ->with('success', 'Data dokumen siswa berhasil diperbarui.');
    }

    public function create()
    {
        $rombel = [
            'X DKV 1',
            'X DKV 2',
            'X SIJA 1',
            'X SIJA 2',
            'X TITL 1',
            'X TITL 2',
        ];
        return view('admin.dokumensiswa.create', compact('rombel'));
    }
}
