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
        Schema::create('adminOrderDetails', function (Blueprint $table) {
            $table->bigIncrements('adminOrdDetailID');
            $table->unsignedBigInteger('adminOrdID');
            $table->unsignedBigInteger('prodtnMtrlID');
            $table->integer('qtyOrdered');
            $table->decimal('amount', 10, 2);
            $table->boolean('isDropped');

            $table->foreign('adminOrdID')->references('adminOrdID')->on('adminOrders')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('prodtnMtrlID')->references('prodtnMtrlID')->on('productionMaterials')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adminOrderDetails', function (Blueprint $table) {
            $table->dropForeign(['adminOrdID']);
            $table->dropForeign(['prodtnMtrlID']);
        });
        Schema::dropIfExists('adminOrderDetails');
    }
};
