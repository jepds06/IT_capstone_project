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
        Schema::create('salesDeliveries', function (Blueprint $table) {
            $table->bigIncrements('deliveryID');
            $table->unsignedBigInteger('salesID');
            $table->date('deliveryDate');
            $table->string('deliveryAddress');
            $table->string('deliveryStatus');

            $table->Foreign('salesID')->references('salesID')->on('sales')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salesDeliveries', function(Blueprint $table) {
            $table->dropForeign('salesID');
        });

        Schema::dropIfExists('salesDeliveries');
    }
};
