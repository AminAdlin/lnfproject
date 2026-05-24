<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Tukar enum/varchar terhad sebelum ni kepada string biasa (VARCHAR 255)
            $table->string('status')->default('active')->change();
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->enum('status', ['active', 'claimed', 'returned'])->default('active')->change();
        });
    }
};