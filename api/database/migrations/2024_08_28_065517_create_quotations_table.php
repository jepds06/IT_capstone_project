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
        Schema::create('quotations', function (Blueprint $table) {
            $table->bigIncrements('quoteID');
            $table->date('quotationDate');
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('productionID');
            $table->string('remarks');
            $table->boolean('isCompleted');

            $table->Foreign('userID')->references('userID')->on('users')
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
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign(['userID']);
            $table->dropForeign(['productionID']);
        });
        Schema::dropIfExists('quotations');
    }
};
