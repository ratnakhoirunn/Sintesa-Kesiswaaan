<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keterlambatan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class KeterlambatanSiswaController extends Controller
{
    public function index()
    {
        $siswa = Auth::guard('siswa')->user();

        // Hitung total keterlambatan
        $jumlah = Keterlambatan::where('nis', $siswa->nis)->count();
        // Poin bisa disesuaikan logikanya
        $poin = $jumlah * 5; 

        // Ambil data keterlambatan milik siswa
        $riwayat = Keterlambatan::where('nis', $siswa->nis)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('siswa.keterlambatan.index', compact('siswa', 'jumlah', 'poin', 'riwayat'));
    }

    public function ajukan(Request $request)
    {
        // 1. VALIDASI INPUT (Termasuk File)
        $request->validate([
            'tanggal'    => 'required|date',
            'jam_datang' => 'required',
            'keterangan' => 'required|string|max:255',
            'dokumen'    => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048', // Maks 2MB
        ]);

        $siswa = Auth::guard('siswa')->user();
        $filename = null;

        // 2. LOGIKA UPLOAD FILE
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            
            // Buat nama file unik: TAHUNBULANTANGGAL_JAMMENITDETIK_NAMAASLI
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Simpan ke folder: public/uploads/dokumen_izin
            $file->move(public_path('uploads/dokumen_izin'), $filename);
        }

        // 3. SIMPAN KE DATABASE
        Keterlambatan::create([
            'nis'             => $siswa->nis,
            'nama_siswa'      => $siswa->nama_lengkap,
            // Gunakan data dari input form, bukan Carbon::now()
            'tanggal'         => $request->tanggal, 
            'jam_datang'      => $request->jam_datang,
            'menit_terlambat' => 0, // Default 0, nanti admin yang set atau hitung otomatis
            'keterangan'      => $request->keterangan,
            'dokumen'         => $filename, // Simpan nama file di sini
            'status'          => 'menunggu',
        ]);

        return back()->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    public function cetakSIT($id)
    {   
        $siswa = Auth::guard('siswa')->user();

        // Ambil data (Pastikan punya siswa tersebut dan statusnya terima)
        $data = Keterlambatan::where('id', $id)
                        ->where('nis', $siswa->nis)
                        ->where('status', 'terima')
                        ->firstOrFail();

        // Load PDF
        $pdf = Pdf::loadView('siswa.keterlambatan.cetak_sit', compact('data'))
                      ->setPaper('A4', 'portrait');

        return $pdf->stream('SIT.pdf');
    }
}