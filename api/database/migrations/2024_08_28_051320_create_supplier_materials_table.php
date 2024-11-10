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
        Schema::create('supplierMaterials', function (Blueprint $table) {
            $table->bigIncrements('suppMatrlID');
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('materialID');
            $table->decimal('unitPrice', 10, 2);

            $table->Foreign('userID')->references('userID')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('materialID')->references('materialID')->on('materials')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplierMaterials', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['userID']);
            $table->dropForeign(['materialID']);
        });
        
        Schema::dropIfExists('supplierMaterials');
    }
};
