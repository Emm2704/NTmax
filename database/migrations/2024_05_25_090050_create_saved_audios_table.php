<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedAudiosTable extends Migration
{
    public function up()
    {
        Schema::create('saved_audios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audio_id')->constrained('audios')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('saved_audios');
    }
}
