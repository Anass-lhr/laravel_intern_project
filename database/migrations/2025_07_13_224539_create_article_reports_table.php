<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->enum('reason_category', ['spam', 'inappropriate', 'misinformation', 'hate_speech', 'violence', 'other']);
            $table->text('reason_details')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'resolved', 'dismissed'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            // Prevent duplicate reports from same user for same article
            $table->unique(['article_id', 'reporter_id']);
            
            // Indexes for better performance
            $table->index(['status', 'priority']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_reports');
    }
};