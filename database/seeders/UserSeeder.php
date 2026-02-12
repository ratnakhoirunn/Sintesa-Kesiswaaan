<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pengguna Admin
        Guru::create([
            'nip' => '99999999',
            'nama' => 'Admin Utama',
            'email' => 'admin@sintesa.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Pengguna Guru BK
        Guru::create([
            'nip' => '11223344',
            'nama' => 'Guru BK',
            'email' => 'gurubk@sintesa.id',
            'password' => Hash::make('gurubk123'),
            'role' => 'guru_bk',
        ]);

        // Pengguna Kesiswaan
        Guru::create([
            'nip' => '55667788',
            'nama' => 'Kesiswaan',
            'email' => 'kesiswaan@sintesa.id',
            'password' => Hash::make('kesiswaan123'),
            'role' => 'kesiswaan',
        ]);

        // Pengguna Guru
        Guru::create([
            'nip' => '6767676767',
            'nama' => 'Guru',
            'email' => 'guru@sintesa.id',
            'password' => Hash::make('guru123'),
            'role' => 'guru',
        ]);

        // Pengguna Siswa

            Siswa::create([
                'nis' => '343434343434',
                'nisn' => rand(1000000000, 9999999999),
                'nama_lengkap' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'no_whatsapp' => '08' . rand(1000000000, 9999999999),
                'rombel' => 'X-' . rand(1, 5),
                'jurusan' => fake()->randomElement(['RPL', 'TKJ', 'AKL', 'BDP']),
                'tempat_lahir' => fake()->city(),
                'tanggal_lahir' => fake()->date(),
                'jenis_kelamin' => fake()->randomElement(['L', 'P']),
                'agama' => fake()->randomElement(['Islam', 'Kristen', 'Hindu', 'Budha']),
                'nama_ortu' => fake()->name(),
                'alamat' => fake()->address(),
                'foto' => null,
                'password' => Hash::make('password123'),
                'is_default_password' => true,
            ]);
    }
}
