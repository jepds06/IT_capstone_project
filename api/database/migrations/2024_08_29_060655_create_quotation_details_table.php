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
        Schema::create('quotationDetails', function (Blueprint $table) {
            $table->bigIncrements('qteDetailID');
            $table->unsignedBigInteger('quoteID');
            $table->unsignedBigInteger('materialID');
            $table->integer('quantity');
            $table->decimal('quotePrice', 10, 2);

            $table->Foreign('quoteID')->references('quoteID')->on('quotations')
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
        Schema::table('quotationDetails', function (Blueprint $table) {
            $table->dropForeign(['quoteID']);
            $table->dropForeign(['materialID']);
        });
        Schema::dropIfExists('quotationDetails');
    }
};
