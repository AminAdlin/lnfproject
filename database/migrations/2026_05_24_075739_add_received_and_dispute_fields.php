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
    Schema::table('items', function (Blueprint $table) {
        // Penanda pengesahan dari kedua-dua belah pihak
        $table->boolean('finder_confirmed')->default(false);
        $table->boolean('claimant_confirmed')->default(false);
        $table->timestamp('finder_confirmed_at')->nullable();
        
        // Untuk kes dispute (barang tak dapat / bermasalah)
        $table->boolean('is_disputed')->default(false);
        $table->text('dispute_reason')->nullable();
    });
}

public function down(): void
{
    Schema::table('items', function (Blueprint $table) {
        $table->dropColumn(['finder_confirmed', 'claimant_confirmed', 'finder_confirmed_at', 'is_disputed', 'dispute_reason']);
    });
}
};
