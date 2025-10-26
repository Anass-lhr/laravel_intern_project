<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('podcast_comment_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Lien vers l'utilisateur
            $table->foreignId('comment_id')->constrained('podcast_comments')->onDelete('cascade'); // Lien vers le commentaire parent
            $table->text('content'); // Contenu de la réponse
            $table->timestamps();

            // Index pour optimiser les recherches
            $table->index(['comment_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('podcast_comment_replies');
    }
};