<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konselings', function (Blueprint $table) {
            $table->id();
            // ubah siswa_id menjadi string dan referensikan ke nis
            $table->string('siswa_nis');
            $table->foreign('siswa_nis')->references('nis')->on('siswas')->onDelete('cascade');
            
            $table->date('tanggal');
            $table->string('rombel');
            $table->string('jurusan');
            $table->string('status')->default('Selesai');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konselings');
    }
};
