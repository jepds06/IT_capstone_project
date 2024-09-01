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
        Schema::create('issue_prod_materials', function (Blueprint $table) {
            $table->bigIncrements('issue_prodmats_ID');
            $table->unsignedBigInteger('issue_ID');
            $table->unsignedBigInteger('req_prodmats_ID');
            $table->integer('qty_requested');
            $table->timestamps();

            $table->Foreign('issue_ID')->references('issue_ID')->on('issuances')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('req_prodmats_ID')->references('req_prodmats_ID')->on('request_prod_materials')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issue_prod_materials', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['issue_ID']);
            $table->dropForeign(['req_prodmats_ID']);
        });
        Schema::dropIfExists('issue_prod_materials');
    }
};
