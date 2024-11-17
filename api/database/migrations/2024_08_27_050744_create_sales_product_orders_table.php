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
        Schema::create('salesProductOrders', function (Blueprint $table) {
            $table->bigIncrements('slsPrdOrdID');
            $table->unsignedBigInteger('salesID');
            $table->unsignedBigInteger('productID');
            $table->integer('qtyOrdered');
            $table->decimal('amount', 10, 2);

            $table->foreign('salesID')->references('salesID')->on('sales')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('productID')->references('productID')->on('products')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salesProductOrders', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['salesID']);
            $table->dropForeign(['productID']);
        });
        Schema::dropIfExists('salesProductOrders');
    }
};
