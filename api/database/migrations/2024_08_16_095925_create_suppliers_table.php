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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('supplierID');
            $table->unsignedBigInteger('accountID');
            $table->string('supplierName');
            $table->string('supplierAddress');
            $table->string('supplierContactNum');
            $table->string('supplierContactPerson');
            $table->string('supplierType');
            $table->string('supplierStatus');
            $table->timestamps();

            $table->foreign('accountID')->references('accountID')->on('accounts')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            // Drop the foreign key before dropping the table
            $table->dropForeign(['accountID']);
        });

        Schema::dropIfExists('suppliers');
    }
};
