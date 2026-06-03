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
    DB::statement("ALTER TABLE items MODIFY COLUMN status ENUM('active','claimed','awaiting_payment','awaiting_appointment','returned_by_finder','returned','disputed') DEFAULT 'active'");
}

public function down(): void
{
    DB::statement("ALTER TABLE items MODIFY COLUMN status ENUM('active','claimed','returned_by_finder','returned','disputed') DEFAULT 'active'");
}
};
