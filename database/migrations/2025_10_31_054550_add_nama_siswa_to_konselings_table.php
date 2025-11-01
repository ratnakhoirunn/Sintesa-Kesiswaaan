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
    Schema::table('konselings', function (Blueprint $table) {
        $table->string('nama_siswa')->after('siswa_nis');
    });
}
public function down()
{
    Schema::table('konselings', function (Blueprint $table) {
        $table->dropColumn('nama_siswa');
    });
}

};
