<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa; // Pastikan model Siswa sudah ada

class SiswaController extends Controller
{
    public function index()
    {
        // nanti ganti pakai database
        return view('admin.datasiswa.index');
    }

    public function read($id)
    {
        // sementara dummy
        $siswa = (object)[
            'nis' => '2510175'.$id,
            'nama_lengkap' => 'Adinata Royyan Alfarobby',
            'rombel' => 'X DKV 1',
            'jurusan' => 'Desain Komunikasi Visual',
            'email' => 'adinata'.$id.'@gmail.com',
            'no_hp' => '08123456789'
        ];

        return view('admin.datasiswa.read', compact('siswa'));
    }

}
