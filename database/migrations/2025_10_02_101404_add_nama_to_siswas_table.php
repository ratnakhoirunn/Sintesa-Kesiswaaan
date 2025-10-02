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
    Schema::table('siswas', function (Blueprint $table) {
        $table->string('nama')->after('NIS');
    });
}

public function down()
{
    Schema::table('siswas', function (Blueprint $table) {
        $table->dropColumn('nama');
    });
}

};
