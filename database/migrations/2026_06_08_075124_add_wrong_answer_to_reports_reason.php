<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
DB::statement("ALTER TABLE reports MODIFY COLUMN reason ENUM('fake_suspicious','already_resolved','spam_duplicate','inappropriate','wrong_security_answer','other')");
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports_reason', function (Blueprint $table) {
            //
        });
    }
};
