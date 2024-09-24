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
        Schema::create('customerOrders', function (Blueprint $table) {
            $table->bigIncrements('cstrOrderID');
            $table->unsignedBigInteger('userID');
            $table->date('orderDate');
            $table->string('orderStatus');
            $table->string('orderRemarks');
            $table->timestamps();

            $table->foreign('userID')->references('userID')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customerOrders', function (Blueprint $table) {
            // Drop the foreign key before dropping the table
            $table->dropForeign(['userID']);
        });
        
        Schema::dropIfExists('customerOrders');
    }
};
