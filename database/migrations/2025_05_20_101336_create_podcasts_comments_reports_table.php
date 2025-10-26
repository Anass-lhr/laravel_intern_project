<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('podcasts_comments_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('comment_id')->nullable()->constrained('podcast_comments')->onDelete('cascade');
            $table->foreignId('reply_id')->nullable()->constrained('podcast_comment_replies')->onDelete('cascade');
            $table->string('reason_category');
            $table->text('reason_details');
            $table->enum('status', ['pending', 'reviewed', 'dismissed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('podcasts_comments_reports');
    }
};