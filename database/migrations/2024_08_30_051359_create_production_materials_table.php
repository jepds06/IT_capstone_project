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
        Schema::create('production_materials', function (Blueprint $table) {
            $table->bigIncrements('prodtn_mtrl_ID');
            $table->unsignedBigInteger('product_mats_ID');
            $table->unsignedBigInteger('production_ID');
            $table->timestamps();

            $table->Foreign('product_mats_ID')->references('product_mats_ID')->on('product_materials')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('production_ID')->references('production_ID')->on('productions')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('production_materials', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['product_mats_ID']);
            $table->dropForeign(['production_ID']);
        });
        Schema::dropIfExists('production_materials');
    }
};
