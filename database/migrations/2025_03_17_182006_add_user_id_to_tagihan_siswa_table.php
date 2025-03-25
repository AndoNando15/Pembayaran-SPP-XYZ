<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToTagihanSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tagihan_siswa', function (Blueprint $table) {
            // Add the user_id column
            $table->unsignedBigInteger('user_id')->nullable();

            // Add the foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
            // Drop the foreign key and the column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}