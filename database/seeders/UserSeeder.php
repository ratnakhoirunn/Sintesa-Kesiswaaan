<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pengguna Admin
        User::create([
            'name' => 'Admin Utama',
            'username' => '99999999',
            'email' => 'admin@sintesa.id', // Perbaikan: Tambahkan email
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Pengguna Siswa
        User::create([
            'name' => 'Siswa Contoh',
            'username' => '12345678',
            'email' => 'siswa@sintesa.id', // Perbaikan: Tambahkan email
            'password' => Hash::make('siswa123'),
            'role' => 'siswa',
        ]);

        // Pengguna Guru BK
        User::create([
            'name' => 'Guru BK Contoh',
            'username' => '11223344',
            'email' => 'gurubk@sintesa.id', // Perbaikan: Tambahkan email
            'password' => Hash::make('gurubk123'),
            'role' => 'guru_bk',
        ]);

        // Pengguna Kesiswaan
        User::create([
            'name' => 'Kesiswaan Contoh',
            'username' => '55667788',
            'email' => 'kesiswaan@sintesa.id', // Perbaikan: Tambahkan email
            'password' => Hash::make('kesiswaan123'),
            'role' => 'kesiswaan',
        ]);
    }
}