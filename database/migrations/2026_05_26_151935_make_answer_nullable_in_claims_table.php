<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('claims', function (Blueprint $table) {
            // Tukar column answer supaya boleh jadi nullable
            $table->text('answer')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->text('answer')->nullable(false)->change();
        });
    }
};