<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('podcast_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Lien vers l'utilisateur
            $table->string('video_id'); // ID de la vidéo YouTube
            $table->text('content'); // Contenu du commentaire
            $table->timestamps();

            // Index pour optimiser les recherches
            $table->index(['video_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('podcast_comments');
    }
};