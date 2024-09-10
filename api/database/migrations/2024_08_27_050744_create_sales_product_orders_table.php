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
        Schema::create('sales_product_orders', function (Blueprint $table) {
            $table->bigIncrements('sls_prd_ord_ID');
            $table->unsignedBigInteger('sales_ID');
            $table->unsignedBigInteger('prd_ord_ID');
            $table->timestamps();

            $table->foreign('sales_ID')->references('sales_ID')->on('sales')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('prd_ord_ID')->references('prd_ord_ID')->on('product_orders')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_product_orders', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['sales_ID']);
            $table->dropForeign(['prd_ord_ID']);
        });
        Schema::dropIfExists('sales_product_orders');
    }
};
