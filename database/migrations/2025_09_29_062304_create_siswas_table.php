<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('siswas', function (Blueprint $table) {
        $table->id();
        $table->string('nis')->unique();
        $table->string('nisn')->unique();
        $table->string('nama_lengkap');
        $table->string('tempat_lahir');
        $table->date('tanggal_lahir');
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
        $table->string('agama');
        $table->string('nama_orang_tua');
        $table->text('alamat_siswa');
        $table->string('kelas');
        $table->string('jurusan');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
