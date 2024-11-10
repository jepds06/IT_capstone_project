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
        Schema::create('userTypeModules', function (Blueprint $table) {
            $table->bigIncrements('userTypeModID');
            $table->unsignedBigInteger('userTypeID');
            $table->unsignedBigInteger('moduleID');
            $table->boolean('canAccess');

            $table->Foreign('userTypeID')->references('userTypeID')->on('userTypes')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('moduleID')->references('moduleID')->on('modules')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('userTypeModules', function (Blueprint $table) {
            $table->dropForeign(['userTypeID']);
            $table->dropForeign(['moduleID']);
        });
        Schema::dropIfExists('userTypeModules');
    }
};
