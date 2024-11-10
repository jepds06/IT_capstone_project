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
        Schema::create('productionMaterials', function (Blueprint $table) {
            $table->bigIncrements('prodtnMtrlID');
            $table->unsignedBigInteger('productMatsID');
            $table->unsignedBigInteger('prodtnDetailID');
            $table->integer('qtyNeeded');
            $table->string('status');

            $table->Foreign('productMatsID')->references('productMatsID')->on('productMaterials')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('prodtnDetailID')->references('prodtnDetailID')->on('productionDetails')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productionMaterials', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['productMatsID']);
            $table->dropForeign(['prodtnDetailID']);
        });
        Schema::dropIfExists('productionMaterials');
    }
};
