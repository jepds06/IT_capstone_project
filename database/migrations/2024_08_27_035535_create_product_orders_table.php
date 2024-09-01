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
        Schema::create('product_orders', function (Blueprint $table) {
            $table->bigIncrements('prd_ord_ID');
            $table->unsignedBigInteger('cstr_order_ID');
            $table->unsignedBigInteger('product_ID');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->timestamps();

            $table->foreign('cstr_order_ID')->references('cstr_order_ID')->on('customer_orders')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('product_ID')->references('product_ID')->on('products')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_orders', function (Blueprint $table) {
            // Drop the foreign key before dropping the table
            $table->dropForeign(['cstr_order_ID']);
            $table->dropForeign(['product_ID']);
        });
        
        Schema::dropIfExists('product_orders');
    }
};
