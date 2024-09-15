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
        Schema::create('productOrders', function (Blueprint $table) {
            $table->bigIncrements('prdOrdID');
            $table->unsignedBigInteger('cstrOrderID');
            $table->unsignedBigInteger('productID');
            $table->integer('quantity');
            $table->decimal('unitPrice', 10, 2);
            $table->timestamps();

            $table->foreign('cstrOrderID')->references('cstrOrderID')->on('customerOrders')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('productID')->references('productID')->on('products')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productOrders', function (Blueprint $table) {
            // Drop the foreign key before dropping the table
            $table->dropForeign(['cstrOrderID']);
            $table->dropForeign(['productID']);
        });
        
        Schema::dropIfExists('productOrders');
    }
};