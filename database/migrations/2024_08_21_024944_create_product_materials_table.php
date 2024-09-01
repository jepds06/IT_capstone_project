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
        Schema::create('product_materials', function (Blueprint $table) {
            $table->bigIncrements('product_mats_ID');
            $table->unsignedBigInteger('product_ID');
            $table->unsignedBigInteger('material_ID');
            $table->integer('quantity');
            $table->timestamps();

            $table->Foreign('product_ID')->references('product_ID')->on('products')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('material_ID')->references('material_ID')->on('materials')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_materials', function(Blueprint $table){
            $table->dropForeign(['product_ID']);
            $table->dropForeign(['material_ID']);
        });

        Schema::dropIfExists('product_materials');
    }
};
