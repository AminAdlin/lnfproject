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
        $table->string('bank_name')->nullable();
        $table->string('bank_account')->nullable();
        $table->string('bank_qr')->nullable(); // Simpan path gambar QR
    });

    Schema::table('claims', function (Blueprint $table) {
        $table->string('payment_receipt')->nullable(); // Simpan bukti resit
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
