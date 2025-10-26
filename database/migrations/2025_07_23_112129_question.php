<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->boolean('is_answered')->default(false);
            $table->foreignId('answered_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('answered_at')->nullable();
            $table->longText('answer_content')->nullable();
            $table->json('answer_images')->nullable(); // Store image filenames
            $table->json('answer_videos')->nullable(); // Store video filenames
            $table->boolean('is_public')->default(true);
            $table->enum('status', ['pending', 'answered', 'archived'])->default('pending');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'created_at']);
            $table->index(['is_answered', 'is_public']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
};