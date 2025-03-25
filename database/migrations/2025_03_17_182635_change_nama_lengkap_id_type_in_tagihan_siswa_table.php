<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNamaLengkapIdTypeInTagihanSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tagihan_siswa', function (Blueprint $table) {
            // Mengubah tipe data kolom 'nama_lengkap_id' menjadi unsignedBigInteger
            $table->unsignedBigInteger('nama_lengkap_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tagihan_siswa', function (Blueprint $table) {
            // Kembalikan tipe data kolom 'nama_lengkap_id' ke tipe sebelumnya jika diperlukan
            $table->string('nama_lengkap_id')->change();  // Ganti dengan tipe sebelumnya
        });
    }
}