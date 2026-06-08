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
    if (!Schema::hasTable('disputes')) {
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('claim_id')->constrained()->onDelete('cascade');
            $table->foreignId('raised_by')->constrained('users')->onDelete('cascade');
            $table->enum('reason', ['item_not_received', 'fake_receipt']);
            $table->text('message')->nullable();
            $table->enum('status', ['open', 'investigating', 'resolved'])->default('open');
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
