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
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('salesID');
            $table->unsignedBigInteger('userID');
            $table->date('salesDate');

            $table->Foreign('userID')->references('userID')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['userID']);
        });

        Schema::dropIfExists('sales');
    }
};
