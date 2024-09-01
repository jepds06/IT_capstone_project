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
        Schema::create('request_prod_materials', function (Blueprint $table) {
            $table->bigIncrements('req_prodmats_ID');
            $table->unsignedBigInteger('prodtn_mtrl_ID');
            $table->unsignedBigInteger('req_ID');
            $table->integer('qty_requested');
            $table->timestamps();

            $table->Foreign('prodtn_mtrl_ID')->references('prodtn_mtrl_ID')->on('production_materials')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('req_ID')->references('req_ID')->on('requests')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_prod_materials', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['prodtn_mtrl_ID']);
            $table->dropForeign(['req_ID']);
        });
        Schema::dropIfExists('request_prod_materials');
    }
};
