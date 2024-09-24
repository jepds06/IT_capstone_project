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
            $table->unsignedBigInteger('adminID');
            $table->unsignedBigInteger('suppMatrlID');
            $table->integer('qtyOrdered');
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('adminID')->references('adminID')->on('administrators')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('suppMatrlID')->references('suppMatrlID')->on('supplierMaterials')
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
            $table->dropForeign(['adminID']);
            $table->dropForeign(['suppMatrlID']);
        });

        Schema::dropIfExists('adminOrders');
    }
};
