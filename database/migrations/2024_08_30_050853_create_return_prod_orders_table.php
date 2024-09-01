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
        Schema::create('return_prod_orders', function (Blueprint $table) {
            $table->bigIncrements('return_prd_ord_ID');
            $table->unsignedBigInteger('sls_prd_ord_ID');
            $table->date('returned_date');
            $table->integer('qty_returned');
            $table->string('reason');
            $table->decimal('refund_amount', 10, 2);
            $table->timestamps();

            $table->Foreign('sls_prd_ord_ID')->references('sls_prd_ord_ID')->on('sales_product_orders')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('return_prod_orders', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['sls_prd_ord_ID']);
        });
        Schema::dropIfExists('return_prod_orders');
    }
};
