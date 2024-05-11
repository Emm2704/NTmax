<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps(); // Esto creará automáticamente los campos created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
