<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations (Menambahkan kolom).
     */
    public function up(): void
    {
        Schema::table('orang_tua', function (Blueprint $table) {
            
            // 1. TAMBAHKAN KOLOM SISWA_ID
            // Menggunakan foreignId() untuk memastikan tipe data (UNSIGNED BIGINT) yang benar.
            // Gunakan nullable() karena data lama tidak memiliki nilai siswa_id.
            $table->foreignId('siswa_id')
                  ->nullable() 
                  ->constrained('siswas') // Membuat Foreign Key ke tabel 'siswas' kolom 'id'
                  ->onDelete('cascade')
                  // Tambahkan after('id') agar kolom ini berada di awal tabel (opsional, tapi rapi)
                  ->after('id'); 
        });
    }

    /**
     * Reverse the migrations (Menghapus kolom).
     */
    public function down(): void
    {
        Schema::table('orang_tua', function (Blueprint $table) {
            
            // 1. Hapus constraint Foreign Key terlebih dahulu
            // Laravel menamai constraint secara otomatis, tapi dropForeign dengan array kolom
            // lebih aman.
            $table->dropConstrainedForeignId('siswa_id'); 
            
            // Jika Anda menggunakan versi Laravel lama, gunakan: 
            // $table->dropForeign(['siswa_id']);
            
            // 2. Hapus kolom siswa_id
            // Laravel 9+ secara otomatis menghapus kolom setelah dropConstrainedForeignId.
            // Namun, untuk keamanan:
            // $table->dropColumn('siswa_id'); 
        });
    }
};