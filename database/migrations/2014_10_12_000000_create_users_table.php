<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('foto_profile')->nullable(); // Menyimpan path file foto
            $table->bigInteger('nisn')->unsigned();
            $table->bigInteger('nuptk')->unsigned();
            $table->string('jabatan');
            $table->string('nama_lengkap');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('kelas');
            $table->string('email')->unique();
            $table->string('nomor_telepon', 15);
            $table->date('terdaftar');
            $table->string('password');
            $table->enum('role', ['siswa', 'admin']); // Role yang bisa dipilih
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}