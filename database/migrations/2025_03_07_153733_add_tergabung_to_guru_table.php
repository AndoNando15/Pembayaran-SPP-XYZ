<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTergabungToGuruTable extends Migration
{
    public function up()
    {
        Schema::table('guru', function (Blueprint $table) {
            // Add the 'tergabung' column
            $table->timestamp('tergabung')->nullable(); // Adjust the column type as needed
        });
    }

    public function down()
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->dropColumn('tergabung');
        });
    }
}