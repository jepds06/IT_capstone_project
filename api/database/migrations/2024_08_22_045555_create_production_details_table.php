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
        Schema::create('productionDetails', function (Blueprint $table) {
            $table->bigIncrements('prodtnDetailID');
            $table->unsignedBigInteger('productionID');
            $table->unsignedBigInteger('productID');
            $table->integer('quantity');
            $table->string('status');
            $table->string('remarks');

            $table->Foreign('productionID')->references('productionID')->on('productions')
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
        Schema::table('productionDetails', function (Blueprint $table) {
            $table->dropForeign(['productionID']);
            $table->dropForeign(['productID']);
        });
        Schema::dropIfExists('productionDetails');
    }
};
