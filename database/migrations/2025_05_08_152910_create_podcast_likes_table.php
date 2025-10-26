<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('podcast_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Lien vers l'utilisateur
            $table->string('video_id'); // ID de la vidéo YouTube
            $table->timestamps();

            // Index pour optimiser les recherches
            $table->index(['user_id', 'video_id']);
            // Contrainte d'unicité pour éviter les likes multiples par le même utilisateur sur la même vidéo
            $table->unique(['user_id', 'video_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('podcast_likes');
    }
};