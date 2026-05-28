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
       Schema::table('claims', function (Blueprint $table) {
           $table->boolean('is_delivery_ready')->default(false);
           $table->string('bank_name')->nullable();
           $table->string('account_number')->nullable();
           $table->string('payment_receipt_image')->nullable();
       });
   }

   public function down()
   {
       Schema::table('claims', function (Blueprint $table) {
           $table->dropColumn(['is_delivery_ready', 'bank_name', 'account_number', 'payment_receipt_image']);
       });
   }
};
