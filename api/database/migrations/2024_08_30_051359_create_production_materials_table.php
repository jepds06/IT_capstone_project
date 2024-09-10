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
            $table->unsignedBigInteger('productionID');
            $table->timestamps();

            $table->Foreign('productMatsID')->references('productMatsID')->on('productMaterials')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('productionID')->references('productionID')->on('productions')
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
            $table->dropForeign(['productionID']);
        });
        Schema::dropIfExists('productionMaterials');
    }
};
