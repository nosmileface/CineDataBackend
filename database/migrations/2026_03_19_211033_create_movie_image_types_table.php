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
        Schema::create('movie_image_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('movie_image_types')->insert
        (
            [
                [
                    'name' => 'Backdrops',
                    'type' => 'backdrop',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Logos',
                    'type' => 'logo',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Poster',
                    'type' => 'poster',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_image_types');
    }
};
