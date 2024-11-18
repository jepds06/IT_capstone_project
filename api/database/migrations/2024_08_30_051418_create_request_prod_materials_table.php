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
        Schema::create('requestProdMaterials', function (Blueprint $table) {
            $table->bigIncrements('reqProdMatsID');
            $table->unsignedBigInteger('prodtnMtrlID');
            $table->unsignedBigInteger('reqID');
            $table->integer('qtyRequested');

            $table->Foreign('prodtnMtrlID')->references('prodtnMtrlID')->on('productionMaterials')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('reqID')->references('reqID')->on('requests')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requestProdMaterials', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['prodtnMtrlID']);
            $table->dropForeign(['reqID']);
        });
        Schema::dropIfExists('requestProdMaterials');
    }
};
