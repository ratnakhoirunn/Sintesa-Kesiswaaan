<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->string('jenis_kelamin', 10)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp_siswa', 20)->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('tinggi_badan', 10)->nullable();
            $table->string('berat_badan', 10)->nullable();
            $table->string('hobby', 255)->nullable();
            $table->string('cita_cita', 255)->nullable();
            $table->string('nama_sekolah_asal')->nullable();
            $table->string('nomor_seri_ijazah_smp')->nullable();
            $table->string('nama_jalan')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('dusun')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('tinggal_dengan')->nullable();
            $table->string('jarak_rumah', 50)->nullable();
            $table->string('transportasi', 100)->nullable();
            $table->string('waktu_tempuh', 50)->nullable();
            $table->integer('jumlah_saudara')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu', 50)->nullable();
            $table->string('tahun_lahir_ibu', 10)->nullable();
            $table->string('pendidikan_ibu', 50)->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();
            $table->string('status_hidup_ibu', 50)->nullable();
            $table->string('no_hp_ibu', 20)->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah', 50)->nullable();
            $table->string('tahun_lahir_ayah', 10)->nullable();
            $table->string('pendidikan_ayah', 50)->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();
            $table->string('status_hidup_ayah', 50)->nullable();
            $table->string('no_hp_ayah', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_siswas');
    }
};