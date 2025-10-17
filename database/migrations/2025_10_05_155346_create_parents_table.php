<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orang_tuas', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->string('nis'); // foreign key baru
=======

            // PERBAIKAN UTAMA: Menggunakan foreignId()
            // Ini otomatis membuat kolom siswa_id sebagai UNSIGNED BIGINT, 
            // menambahkan index, dan foreign key constraint ke siswas(id).

            $table->foreignId('siswa_id')
                  ->constrained('siswas') 
                  ->onDelete('cascade');


>>>>>>> 0e04958bc84014f889a4e2fdb735b09a43749507
            // Data Ayah
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->string('tahun_lahir_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();
            $table->string('status_hidup_ayah')->nullable();
            $table->string('no_telp_ayah')->nullable();

            // Data Ibu
            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('tahun_lahir_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();
            $table->string('status_hidup_ibu')->nullable();
            $table->string('no_telp_ibu')->nullable();

            // Data Wali
            $table->string('nama_wali')->nullable();
            $table->string('nik_wali')->nullable();
            $table->string('tahun_lahir_wali')->nullable();
            $table->string('pendidikan_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('penghasilan_wali')->nullable();
            $table->string('status_hidup_wali')->nullable();
            $table->string('no_telp_wali')->nullable();

            $table->foreign('nis')->references('nis')->on('siswas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        // Hapus foreign key sebelum menghapus tabel untuk menghindari potensi error
        Schema::table('orang_tua', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
        });
        
        Schema::dropIfExists('orang_tua');
    }
};