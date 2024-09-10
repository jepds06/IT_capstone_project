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
        Schema::create('supplier_material_quotations', function (Blueprint $table) {
            $table->bigIncrements('suppMats_quote_ID');
            $table->unsignedBigInteger('quote_ID');
            $table->unsignedBigInteger('supp_matrl_ID');
            $table->integer('quantity');
            $table->decimal('quotation_price', 10, 2);
            $table->timestamps();

            $table->Foreign('quote_ID')->references('quote_ID')->on('quotations')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('supp_matrl_ID')->references('supp_matrl_ID')->on('supplier_materials')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplier_material_quotations', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['quote_ID']);
            $table->dropForeign(['supp_matrl_ID']);
        });
        Schema::dropIfExists('supplier_material_quotations');
    }
};
