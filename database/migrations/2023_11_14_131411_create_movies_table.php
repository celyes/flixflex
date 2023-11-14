<?php

use App\Enums\MovieType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('genre');
            $table->string('plot');
            $table->string('language');
            $table->string('country');
            $table->string('poster_image_url');
            $table->string('trailer_url');
            $table->unsignedInteger('duration')->comment('Length in seconds');
            $table->year('released_in');
            $table->unsignedDouble('rating');
            $table->enum('type', MovieType::values());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
