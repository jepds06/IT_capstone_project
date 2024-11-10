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
        Schema::create('returnProdOrders', function (Blueprint $table) {
            $table->bigIncrements('returnPrdOrdID');
            $table->unsignedBigInteger('slsPrdOrdID');
            $table->date('returnedDate');
            $table->integer('qtyReturned');
            $table->string('reason');
            $table->decimal('refundAmount', 10, 2);

            $table->Foreign('slsPrdOrdID')->references('slsPrdOrdID')->on('salesProductOrders')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('returnProdOrders', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['slsPrdOrdID']);
        });
        Schema::dropIfExists('returnProdOrders');
    }
};
