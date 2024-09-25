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
        Schema::create('productions', function (Blueprint $table) {
            $table->bigIncrements('productionID');
            $table->unsignedBigInteger('userID');
            $table->date('dateEncoded');
            $table->date('year');
            $table->date('month');
            $table->string('remarks');
            $table->string('status');
            $table->timestamps();

            $table->Foreign('userID')->references('userID')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropForeign(['userID']);
        });
        Schema::dropIfExists('productions');
    }
};
