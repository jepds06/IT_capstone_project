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
        Schema::create('finishedProducts', function (Blueprint $table) {
            $table->bigIncrements('fnshProductID');
            $table->unsignedBigInteger('prodtnDetailID');
            $table->date('productionDate');
            $table->integer('quantity');
            $table->decimal('unitPrice', 10, 2);
            $table->string('status');
            $table->string('remarks');

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
        Schema::table('finishedProducts', function (Blueprint $table) {
            $table->dropForeign(['prodtnDetailID']);
        });
        Schema::dropIfExists('finishedProducts');
    }
};
