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
        Schema::create('sales_deliveries', function (Blueprint $table) {
            $table->bigIncrements('delivery_ID');
            $table->unsignedBigInteger('sales_ID');
            $table->date('delivery_date');
            $table->string('delivery_address');
            $table->string('delivery_status');
            $table->timestamps();

            $table->Foreign('sales_ID')->references('sales_ID')->on('sales')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_deliveries', function(Blueprint $table) {
            $table->dropForeign('sales_ID');
        });

        Schema::dropIfExists('sales_deliveries');
    }
};
