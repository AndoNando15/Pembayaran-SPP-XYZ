<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJatuhTempoToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('jatuh_tempo')->default(0);  // Menambahkan kolom jatuh_tempo dengan nilai default 0
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('jatuh_tempo');  // Menghapus kolom jatuh_tempo jika rollback
        });
    }
}