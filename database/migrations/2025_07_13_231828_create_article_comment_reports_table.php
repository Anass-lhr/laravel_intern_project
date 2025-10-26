<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_comment_reports', function (Blueprint $table) {
            $table->id();
            $table->string('comment_id'); // ID du commentaire signalé
            $table->unsignedBigInteger('article_id'); // ID de l'article
            $table->text('comment_content'); // Contenu du commentaire signalé
            $table->string('comment_author'); // Auteur du commentaire
            $table->string('reported_by'); // Nom de celui qui signale
            $table->unsignedBigInteger('reporter_id'); // ID de celui qui signale
            $table->enum('comment_type', ['comment', 'reply'])->default('comment');
            $table->enum('reason_category', ['inappropriate', 'spam', 'harassment', 'hate_speech', 'violence', 'other']);
            $table->text('reason_details')->nullable(); // Détails de la raison
            $table->enum('status', ['pending', 'reviewing', 'resolved', 'dismissed'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('action_taken', ['none', 'comment_deleted', 'user_warned', 'user_blocked', 'comment_edited'])->default('none');
            $table->unsignedBigInteger('handled_by')->nullable(); // ID de l'admin qui a traité
            $table->timestamp('handled_at')->nullable(); // Date de traitement
            $table->text('admin_notes')->nullable(); // Notes de l'admin
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('handled_by')->references('id')->on('users')->onDelete('set null');
            
            // Index pour optimiser les requêtes (with custom names to avoid length issues)
            $table->index(['status', 'created_at'], 'acr_status_created_idx');
            $table->index(['reporter_id', 'comment_id', 'comment_type'], 'acr_reporter_comment_idx');
            $table->index(['article_id', 'status'], 'acr_article_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_comment_reports');
    }
};