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
        Schema::create('productMaterials', function (Blueprint $table) {
            $table->bigIncrements('productMatsID');
            $table->unsignedBigInteger('productID');
            $table->unsignedBigInteger('materialID');
            $table->integer('quantity');

            $table->Foreign('productID')->references('productID')->on('products')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('materialID')->references('materialID')->on('materials')
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
            $table->dropForeign(['productID']);
            $table->dropForeign(['materialID']);
        });

        Schema::dropIfExists('productMaterials');
    }
};
