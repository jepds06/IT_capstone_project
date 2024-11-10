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
        Schema::create('customerPayments', function (Blueprint $table) {
            $table->bigIncrements('cstrPayID');
            $table->unsignedBigInteger('slsPrdOrdID');
            $table->date('paymentDate');
            $table->unsignedBigInteger('payMethodID');
            $table->string('paymentStatus');
            $table->date('dueDate');
            $table->decimal('amountToPay', 10, 2);
            $table->decimal('amountPaid', 10, 2);

            $table->Foreign('slsPrdOrdID')->references('slsPrdOrdID')->on('salesProductOrders')
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
        Schema::table('customerPayments', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['slsPrdOrdID']);
            $table->dropForeign(['payMethodID']);
        });
        Schema::dropIfExists('customerPayments');
    }
};
