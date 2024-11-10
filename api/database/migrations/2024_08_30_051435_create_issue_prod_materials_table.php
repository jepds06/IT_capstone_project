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
        Schema::create('issueProdMaterials', function (Blueprint $table) {
            $table->bigIncrements('issueProdMatsID');
            $table->unsignedBigInteger('issueID');
            $table->unsignedBigInteger('reqProdMatsID');
            $table->integer('qtyIssued');

            $table->Foreign('issueID')->references('issueID')->on('issuances')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('reqProdMatsID')->references('reqProdMatsID')->on('requestProdMaterials')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issueProdMaterials', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['issueID']);
            $table->dropForeign(['reqProdMatsID']);
        });
        Schema::dropIfExists('issueProdMaterials');
    }
};
