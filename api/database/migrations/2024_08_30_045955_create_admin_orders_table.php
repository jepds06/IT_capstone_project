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
        Schema::create('adminOrders', function (Blueprint $table) {
            $table->bigIncrements('adminOrdID');
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('quoteID');
            $table->date('orderDate');
            $table->boolean('isApproved');

            $table->foreign('userID')->references('userID')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('quoteID')->references('quoteID')->on('quotations')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adminOrders', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['userID']);
            $table->dropForeign(['quoteID']);
        });

        Schema::dropIfExists('adminOrders');
    }
};
