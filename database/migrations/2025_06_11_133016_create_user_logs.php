<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // null pour les visiteurs
            $table->string('action'); //  'login', 'logout', 'comment_created', 'post_liked',...
            $table->string('route_name')->nullable(); // nom de la route
            $table->string('method'); // GET, POST, PUT, DELETE ...
            $table->string('url'); // URL complète
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->json('request_data')->nullable(); // données de la requête (sans mots de passe)
            $table->json('response_data')->nullable(); // données de réponse importantes
            $table->string('status_code')->nullable(); // code de statut HTTP
            $table->string('description')->nullable(); // description lisible de l'action
            $table->timestamp('created_at')->useCurrent();
            $table->index(['user_id', 'created_at']);
            $table->index(['action', 'created_at']);
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_logs');
    }
};