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
        $table->softDeletes(); // Ini yang akan tambah kolum 'deleted_at' otomatik
    });
}

public function down(): void
{
    Schema::table('items', function (Blueprint $table) {
        $table->dropSoftDeletes(); // Ini untuk buang balik kolum kalau rollback
    });
}
};
