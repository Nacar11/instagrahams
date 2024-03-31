<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('following_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('followed_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();

            // Ensure that a user can only follow another user once
            $table->unique(['following_id', 'followed_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
