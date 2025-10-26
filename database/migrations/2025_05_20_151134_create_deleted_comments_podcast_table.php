<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deleted_comments_podcast', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('video_id'); // Changé de post_id à video_id pour correspondre au contexte des podcasts
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Auteur du commentaire
            $table->foreignId('parent_id')->nullable()->constrained('podcast_comments')->onDelete('cascade'); // Pour les réponses
            $table->timestamp('deleted_at')->useCurrent();
            $table->foreignId('deleted_by')->constrained('users')->onDelete('cascade'); // Utilisateur ayant supprimé
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('deleted_comments_podcast');
    }
};