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
        Schema::create('article_comment_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comment_id');
            $table->unsignedBigInteger('article_id');
            $table->text('comment_content'); // Store the comment content at time of report
            $table->string('comment_author'); // Store the author name at time of report
            $table->string('reported_by'); // Store the reporter name at time of report
            $table->unsignedBigInteger('reporter_id');
            $table->enum('comment_type', ['comment', 'reply'])->default('comment');
            $table->enum('reason_category', [
                'inappropriate', 
                'spam', 
                'harassment', 
                'hate_speech', 
                'violence', 
                'other'
            ]);
            $table->text('reason_details')->nullable();
            $table->enum('status', ['pending', 'reviewing', 'resolved', 'dismissed'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->string('action_taken')->nullable(); // What action was taken (if any)
            $table->text('admin_notes')->nullable(); // Admin notes about the report
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->unsignedBigInteger('resolved_by')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('resolved_by')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index(['status', 'created_at']);
            $table->index(['article_id', 'status']);
            $table->index(['reporter_id', 'created_at']);
            $table->index(['comment_id', 'comment_type']);
            $table->index('reason_category');
            $table->index('priority');

            // Unique constraint to prevent duplicate reports
            $table->unique(['comment_id', 'comment_type', 'reporter_id'], 'unique_comment_report_per_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_comment_reports');
    }
};