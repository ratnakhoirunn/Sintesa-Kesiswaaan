<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\Konseling;
use Carbon\Carbon;


class KonselingSiswaController extends Controller
{
     public function index()
{
    $siswa = Auth::guard('siswa')->user();

    // Ambil data dari tabel konselings sesuai NIS siswa yang login
    $konselings = Konseling::where('nis', $siswa->nis)
                    ->orderBy('created_at', 'desc')
                    ->get();

    return view('siswa.konseling.index', compact('siswa', 'konselings'));
}


    public function create()
    {
        $siswa = Auth::guard('siswa')->user();

        // Ambil data orang tua berdasarkan relasi
        $orangtua = OrangTua::where('nis', $siswa->nis)->first();

        return view('siswa.konseling.create', compact('siswa', 'orangtua'));
    }

   public function store(Request $request)
{
    $request->validate([
        'alasan' => 'nullable|string',
        'topik' => 'required|string',
        'latar_belakang' => 'required|string',
        'kegiatan_layanan' => 'required|string',
    ]);

    $siswa = Auth::guard('siswa')->user();

    // Ambil data orang tua dari tabel orang_tuas
    $orangtua = OrangTua::where('nis', $siswa->nis)->first();

    // Simpan data ke tabel konselings
    Konseling::create([
        'nis' => $siswa->nis,
        'nama_siswa' => $siswa->nama_lengkap,
        'kelas' => $siswa->rombel,
        'nama_ortu' => $siswa->nama_ortu ?? '-',
        'alamat_ortu' => $siswa->alamat ?? '-',
        'no_telp_ortu' => $orangtua->no_telp_ayah ?? '-',
        'alasan' => $request->alasan,
        'topik' => $request->topik,
        'latar_belakang' => $request->latar_belakang,
        'kegiatan_layanan' => $request->kegiatan_layanan,
        'status' => 'Menunggu', // optional, kalau kamu punya kolom status
        'tanggal' => Carbon::now()->toDateString(),
    ]);

     return redirect()->route('siswa.konseling.index')
        ->with('success', 'Pengajuan konseling berhasil dikirim. Harap menunggu admin untuk memproses.');

}

public function show($id)
{
    $siswa = Auth::guard('siswa')->user(); // ambil data siswa login
    $konseling = Konseling::where('id', $id)
        ->where('nis', $siswa->nis) // biar siswa hanya bisa lihat miliknya sendiri
        ->firstOrFail();

    return view('siswa.konseling.show', compact('siswa', 'konseling'));
}


public function edit($id)
{
    $siswa = Auth::guard('siswa')->user();
    $konseling = $siswa->konselings()->findOrFail($id);
    return view('siswa.konseling.edit', compact('konseling'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'tanggal' => 'required|date',
        'topik' => 'required|string|max:255',
        'latar_belakang' => 'required|string',
        'kegiatan_layanan' => 'required|string',
    ]);

    $siswa = Auth::guard('siswa')->user();
    $konseling = $siswa->konselings()->findOrFail($id);

    // hanya bisa edit kalau status masih Menunggu
    if ($konseling->status !== 'Menunggu') {
        return redirect()->route('siswa.konseling.index')->with('error', 'Pengajuan tidak dapat diedit karena sudah diproses.');
    }

    $konseling->update([
        'tanggal' => $request->tanggal,
        'topik' => $request->topik,
        'latar_belakang' => $request->latar_belakang,
        'kegiatan_layanan' => $request->kegiatan_layanan,
    ]);

    return redirect()->route('siswa.konseling.index')->with('success', 'Data konseling berhasil diperbarui.');
}


}
