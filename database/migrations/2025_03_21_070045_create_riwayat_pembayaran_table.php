<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatPembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_pembayaran', function (Blueprint $table) {
            $table->id();  // Auto-incrementing primary key
            $table->string('nisn_id');  // Student's NISN ID
            $table->string('nama_lengkap_id');  // Full name of the student
            $table->string('tagihan');  // The bill name
            $table->date('tanggal');  // The date of the bill
            $table->date('batas_waktu');  // The deadline for the bill
            $table->string('kelas');  // Class of the student
            $table->integer('nominal');  // Nominal amount of the bill
            $table->text('keterangan')->nullable();  // Description or notes
            $table->date('terdaftar')->nullable();  // Registration date
            $table->string('bukti_pembayaran')->nullable();  // Path to payment proof file
            $table->decimal('cash', 15, 2)->nullable();  // Amount paid in cash
            $table->timestamps();  // Created and updated timestamps
            $table->string('user');  // User who created the record
            $table->string('pembayaran');  // Payment method (Transfer, etc.)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayat_pembayaran');
    }
}