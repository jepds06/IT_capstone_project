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
        Schema::create('adminDeliveries', function (Blueprint $table) {
            $table->bigIncrements('adminDlvrID');
            $table->unsignedBigInteger('adminOrdID');
            $table->date('deliveryDate');
            $table->string('deliveryStatus');
            $table->integer('qtyReceived');

            $table->foreign('adminOrdID')->references('adminOrdID')->on('adminOrders')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adminDeliveries', function (Blueprint $table) {
            $table->dropForeign(['adminOrdID']);
        });
        Schema::dropIfExists('adminDeliveries');
    }
};
