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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('image')->nullable(); // pour audio
            $table->text('description')->nullable(); // pour podcast, vidéo
            $table->string('auteur')->nullable();
            $table->json('categorie')->nullable();
            $table->text('corps')->nullable(); // pour article
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
            $table->string('status')->default('published');
            
            // Ajout des colonnes pour la gestion de la suppression
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            // Ajout de la clé étrangère pour deleted_by
            $table->foreign('deleted_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
