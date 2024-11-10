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
        Schema::create('supplierMaterialQuotations', function (Blueprint $table) {
            $table->bigIncrements('suppMatsQuoteID');
            $table->unsignedBigInteger('quoteID');
            $table->unsignedBigInteger('suppMatrlID');
            $table->integer('quantity');
            $table->decimal('quotationPrice', 10, 2);

            $table->Foreign('quoteID')->references('quoteID')->on('quotations')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('suppMatrlID')->references('suppMatrlID')->on('supplierMaterials')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplierMaterialQuotations', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['quoteID']);
            $table->dropForeign(['suppMatrlID']);
        });
        Schema::dropIfExists('supplierMaterialQuotations');
    }
};
