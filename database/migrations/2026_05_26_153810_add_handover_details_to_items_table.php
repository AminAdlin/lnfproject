<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('items', function (Blueprint $table) {
        $table->string('handover_method')->nullable(); // 'pickup' atau 'delivery'
        $table->text('delivery_address')->nullable();  // Alamat Owner jika delivery
        $table->string('tracking_number')->nullable(); // No tracking daripada Finder
    });
}

public function down()
{
    Schema::table('items', function (Blueprint $table) {
        $table->dropColumn(['handover_method', 'delivery_address', 'tracking_number']);
    });
}
};
