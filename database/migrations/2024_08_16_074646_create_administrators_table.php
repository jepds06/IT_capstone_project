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
        Schema::create('administrators', function (Blueprint $table) {
            $table->bigIncrements('adminID');
            $table->unsignedBigInteger('accountID');
            $table->string('adminFirstName');
            $table->string('adminLastName');
            $table->string('contactNum');
            $table->string('adminAddress');
            $table->timestamps();

            //foreign key constraint
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
        Schema::table('administrators', function (Blueprint $table) {
            // Drop the foreign key before dropping the table
            $table->dropForeign(['accountID']);
        });

        Schema::dropIfExists('administrators');
    }
};
