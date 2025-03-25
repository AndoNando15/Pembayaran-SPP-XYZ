<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanTable extends Migration
{
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->string('tagihan');
            $table->date('tanggal');
            $table->date('batas_waktu');
            $table->string('kelas');
            $table->integer('nominal');
            $table->string('status');
            $table->string('keterangan');
            $table->date('terdaftar');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihan');
    }
}