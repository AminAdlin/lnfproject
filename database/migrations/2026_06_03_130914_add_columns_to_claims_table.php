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
        $table->string('bank_qr')->nullable();
        $table->text('shipping_address')->nullable();
    });
}

public function down(): void
{
    Schema::table('claims', function (Blueprint $table) {
        $table->dropColumn([
            'message', 'contact', 'proof_image', 'bank_name',
            'account_number', 'bank_qr', 'payment_receipt',
            'shipping_address', 'appointment_date', 'appointment_location',
        ]);
    });
}
};
