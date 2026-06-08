<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disputes', function (Blueprint $table) {
            $table->foreignId('claim_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('disputes')) {
            Schema::table('disputes', function (Blueprint $table) {
                $table->dropForeign(['claim_id']);
                $table->dropColumn('claim_id');
            });
        }
    }
};