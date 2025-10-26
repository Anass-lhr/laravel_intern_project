<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add reported column to article_comments table only if it doesn't exist
        if (!Schema::hasColumn('article_comments', 'reported')) {
            Schema::table('article_comments', function (Blueprint $table) {
                $table->boolean('reported')->default(false);
            });
        }

        // Add reported column to article_comment_replies table only if it doesn't exist
        if (!Schema::hasColumn('article_comment_replies', 'reported')) {
            Schema::table('article_comment_replies', function (Blueprint $table) {
                $table->boolean('reported')->default(false);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('article_comments', 'reported')) {
            Schema::table('article_comments', function (Blueprint $table) {
                $table->dropColumn('reported');
            });
        }

        if (Schema::hasColumn('article_comment_replies', 'reported')) {
            Schema::table('article_comment_replies', function (Blueprint $table) {
                $table->dropColumn('reported');
            });
        }
    }
};