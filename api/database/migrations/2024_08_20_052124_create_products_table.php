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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('productID');
            $table->string('productName');
            $table->string('specifications');
            $table->decimal('unitPrice', 10, 2);
            $table->string('imagePath');
            $table->unsignedBigInteger('prodCatID');

            $table->foreign('prodCatID')->references('prodCatID')->on('productCategories')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign key before dropping the table
            $table->dropForeign(['prodCatID']);
        });

        Schema::dropIfExists('products');
    }
};
