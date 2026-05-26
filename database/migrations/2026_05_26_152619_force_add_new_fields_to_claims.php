<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('claims', function (Blueprint $table) {
            if (!Schema::hasColumn('claims', 'message')) {
                $table->text('message')->nullable()->after('answer');
            }
            if (!Schema::hasColumn('claims', 'contact')) {
                $table->string('contact')->nullable()->after('message');
            }
            if (!Schema::hasColumn('claims', 'proof_image')) {
                $table->string('proof_image')->nullable()->after('contact');
            }
        });
    }

    public function down()
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dropColumn(['message', 'contact', 'proof_image']);
        });
    }
};