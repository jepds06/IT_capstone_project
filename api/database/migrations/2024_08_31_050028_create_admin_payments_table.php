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
        Schema::create('adminPayments', function (Blueprint $table) {
            $table->bigIncrements('adminPayID');
            $table->unsignedBigInteger('adminOrdID');
            $table->unsignedBigInteger('payMethodID');
            $table->date('paymentDate');
            $table->decimal('amountToPay', 10, 2);
            $table->decimal('amountPaid', 10, 2);
            $table->string('paymentStatus');
            $table->string('remarks');

            $table->foreign('adminOrdID')->references('adminOrdID')->on('adminOrders')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('payMethodID')->references('payMethodID')->on('paymentMethods')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adminPayments', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['adminOrdID']);
            $table->dropForeign(['payMethodID']);
        });
        Schema::dropIfExists('adminPayments');
    }
};
