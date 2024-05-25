<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContentToHelpsTable extends Migration
{
    public function up()
    {
        Schema::table('helps', function (Blueprint $table) {
            $table->text('content')->nullable(false);
        });
    }

    public function down()
    {
        Schema::table('helps', function (Blueprint $table) {
            $table->dropColumn('content');
        });
    }
}
