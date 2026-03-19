<?php

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
        Schema::create('movie_casts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('tmdb_id')->unique();
            $table->string('name');
            $table->string('original_name');
            $table->float('popularity');
            $table->string('profile_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_casts');
    }
};
