<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keterlambatan;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class KeterlambatanController extends Controller
{
    // Tampilkan daftar keterlambatan
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $query = Keterlambatan::with('siswa')->orderBy('tanggal', 'desc');

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        $keterlambatans = $query->get();

        return view('admin.keterlambatan.index', compact('keterlambatans', 'tanggal'));
    }

    // Form tambah data
    public function create()
    {
        $siswas = Siswa::orderBy('nama_lengkap', 'asc')->get();
        return view('admin.keterlambatan.create', compact('siswas'));
    }

    // Simpan data keterlambatan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|exists:siswas,nis',
            'nama_siswa' => 'required|string|max:255',
            'tanggal' => 'nullable|date',
            'jam_datang' => 'nullable',
            'menit_terlambat' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'nis.required' => 'Silakan pilih siswa terlebih dahulu.',
            'nis.exists' => 'NIS siswa tidak ditemukan.',
            'menit_terlambat.required' => 'Menit keterlambatan wajib diisi.',
            'menit_terlambat.numeric' => 'Menit keterlambatan harus berupa angka.',
        ]);

        // Jika tanggal & jam tidak diisi, gunakan waktu real time
        $tanggalSekarang = $request->tanggal ?? Carbon::now()->format('Y-m-d');
        $jamSekarang = $request->jam_datang ?? Carbon::now()->format('H:i:s');

        try {
            Keterlambatan::create([
                'nis' => $validated['nis'],
                'nama_siswa' => $validated['nama_siswa'],
                'tanggal' => $tanggalSekarang,
                'jam_datang' => $jamSekarang,
                'menit_terlambat' => $validated['menit_terlambat'],
                'keterangan' => $validated['keterangan'] ?? '-',
            ]);

            return redirect()->route('admin.keterlambatan.index')
                ->with('success', '✅ Data keterlambatan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ Gagal menambahkan data keterlambatan: ' . $e->getMessage());
        }
    }

    // Cetak surat keterlambatan
    public function cetakSurat($id)
    {
        $data = Keterlambatan::with('siswa')->findOrFail($id);

        $pdf = Pdf::loadView('admin.keterlambatan.surat', compact('data'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('Surat_Keterlambatan_' . $data->siswa->nama_lengkap . '.pdf');
    }
    public function updateStatus(Request $request, $id)
{
    $keterlambatan = Keterlambatan::findOrFail($id);
    $keterlambatan->status = $request->status;
    $keterlambatan->save();

    return back()->with('success', 'Status pengajuan berhasil diperbarui!');
}

}
