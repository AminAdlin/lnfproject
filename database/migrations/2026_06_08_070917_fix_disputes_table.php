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
    Schema::table('disputes', function (Blueprint $table) {
        $table->renameColumn('user_id', 'raised_by');
        $table->text('message')->nullable()->after('reason');
    });
}

public function down(): void
{
    Schema::table('disputes', function (Blueprint $table) {
        $table->renameColumn('raised_by', 'user_id');
        $table->dropColumn('message');
    });
}
};
