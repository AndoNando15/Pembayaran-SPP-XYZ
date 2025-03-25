<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanSiswaTable extends Migration
{
    public function up()
    {
        Schema::create('tagihan_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nisn_id')->constrained('users'); // Relasi dengan tabel users (nisn)
            $table->foreignId('nama_lengkap_id')->constrained('users'); // Relasi dengan tabel users (admin)
            $table->string('tagihan');
            $table->date('tanggal');
            $table->date('batas_waktu');
            $table->string('kelas');
            $table->integer('nominal');
            $table->string('keterangan');
            $table->date('terdaftar');
            $table->string('bukti_pembayaran')->nullable();
            $table->string('cash')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihan_siswa');
    }
}