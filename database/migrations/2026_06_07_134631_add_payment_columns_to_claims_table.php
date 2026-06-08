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
Schema::table('claims', function (Blueprint $table) {
$table->string('bill_code')->nullable();
$table->string('transaction_id')->nullable();
$table->string('payment_method')->nullable(); // 'online' or 'manual'
$table->string('payment_status')->nullable(); // 'paid', 'pending', 'failed'
});
}
public function down(): void
{
Schema::table('claims', function (Blueprint $table) {
$table->dropColumn(['bill_code', 'transaction_id', 'payment_method', 'payment_status']);
});
}
};
