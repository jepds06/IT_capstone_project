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
            $table->foreignId('userTypeID')->constrained()->onDelete('cascade');
            $table->foreignId('moduleID')->constrained()->onDelete('cascade');
            $table->boolean('canAccess');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userTypeModules');
    }
};
