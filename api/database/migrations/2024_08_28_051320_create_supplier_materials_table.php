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
        Schema::create('supplier_materials', function (Blueprint $table) {
            $table->bigIncrements('supp_matrl_ID');
            $table->unsignedBigInteger('supplier_ID');
            $table->unsignedBigInteger('material_ID');
            $table->decimal('unit_price', 10, 2);
            $table->timestamps();

            $table->Foreign('supplier_ID')->references('supplier_ID')->on('suppliers')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('material_ID')->references('material_ID')->on('materials')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplier_materials', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['supplier_ID']);
            $table->dropForeign(['material_ID']);
        });
        
        Schema::dropIfExists('supplier_materials');
    }
};
