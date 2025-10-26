<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Ajouter le champ reported à la table article_comments
        if (!Schema::hasColumn('article_comments', 'reported')) {
            Schema::table('article_comments', function (Blueprint $table) {
                $table->boolean('reported')->default(false)->after('content');
            });
        }

        // Ajouter le champ reported à la table article_comment_replies
        if (!Schema::hasColumn('article_comment_replies', 'reported')) {
            Schema::table('article_comment_replies', function (Blueprint $table) {
                $table->boolean('reported')->default(false)->after('content');
            });
        }
    }

    public function down()
    {
        Schema::table('article_comments', function (Blueprint $table) {
            if (Schema::hasColumn('article_comments', 'reported')) {
                $table->dropColumn('reported');
            }
        });

        Schema::table('article_comment_replies', function (Blueprint $table) {
            if (Schema::hasColumn('article_comment_replies', 'reported')) {
                $table->dropColumn('reported');
            }
        });
    }
};