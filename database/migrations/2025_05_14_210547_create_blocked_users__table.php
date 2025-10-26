<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('blocked_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('blocked_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('blocked_at')->useCurrent();
            $table->timestamps();
        }, ['engine' => 'InnoDB', 'collation' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        Schema::dropIfExists('blocked_users');
    }
};