<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration
   {
       public function up()
       {
           Schema::dropIfExists('likes'); 

           Schema::create('post_votes', function (Blueprint $table) {
               $table->id();
               $table->foreignId('post_id')->constrained()->onDelete('cascade');
               $table->foreignId('user_id')->constrained()->onDelete('cascade');
               $table->boolean('is_upvote')->default(true);
               $table->timestamps();

               $table->unique(['post_id', 'user_id']);
           });
       }

       public function down()
       {
           Schema::dropIfExists('post_votes');
       }
   };