<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('claims', function (Blueprint $blueprint) {
            $blueprint->dateTime('appointment_date')->nullable()->after('status');
            $blueprint->string('appointment_location')->nullable()->after('appointment_date');
        });
    }

    public function down()
    {
        Schema::table('claims', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['appointment_date', 'appointment_location']);
        });
    }
};