<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('category'); // Gadget, Keys, Wallet, etc
            $table->string('location');
            $table->date('date_reported');
            $table->string('contact');
            $table->string('image')->nullable();
            $table->enum('type', ['lost', 'found'])->default('lost');
            $table->enum('status', ['active', 'claimed', 'returned'])->default('active');
            $table->string('security_question')->nullable();
            $table->string('security_answer')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};