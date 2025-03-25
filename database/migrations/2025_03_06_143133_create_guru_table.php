<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuruTable extends Migration
{
    public function up()
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->string('foto_profile')->nullable();
            $table->bigInteger('nuptk')->unsigned();
            $table->string('nama_guru');
            $table->string('email')->unique();
            $table->string('nomor_telepon', 15);
            $table->date('terdaftar');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guru');
    }
}