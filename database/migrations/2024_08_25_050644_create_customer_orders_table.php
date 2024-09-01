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
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->bigIncrements('cstr_order_ID');
            $table->unsignedBigInteger('customer_ID');
            $table->date('order_date');
            $table->string('order_status');
            $table->string('order_remarks');
            $table->timestamps();

            $table->foreign('customer_ID')->references('customer_ID')->on('customers')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            // Drop the foreign key before dropping the table
            $table->dropForeign(['customer_ID']);
        });
        
        Schema::dropIfExists('customer_orders');
    }
};
