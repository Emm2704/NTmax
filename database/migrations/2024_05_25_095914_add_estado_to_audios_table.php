<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoToAudiosTable extends Migration
{
    public function up()
    {
        Schema::table('audios', function (Blueprint $table) {
            $table->string('estado')->default('Activo');
        });
    }

    public function down()
    {
        Schema::table('audios', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
}
