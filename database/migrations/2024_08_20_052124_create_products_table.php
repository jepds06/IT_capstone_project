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
            $table->bigIncrements('product_ID');
            $table->string('product_name');
            $table->string('specifications');
            $table->decimal('unit_price', 10, 2);
            $table->unsignedBigInteger('prodCat_ID');

            $table->foreign('prodCat_ID')->references('prodCat_ID')->on('product_categories')
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
            $table->dropForeign(['prodCat_ID']);
        });

        Schema::dropIfExists('products');
    }
};
