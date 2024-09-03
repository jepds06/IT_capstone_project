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
            $table->bigIncrements('admin_ID');
            $table->unsignedBigInteger('account_ID');
            $table->string('admin_first_name');
            $table->string('admin_last_name');
            $table->string('contact_num');
            $table->string('admin_address');
            $table->timestamps();

            //foreign key constraint
            $table->foreign('account_ID')->references('account_ID')->on('accounts')
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
            $table->dropForeign(['account_ID']);
        });

        Schema::dropIfExists('administrators');
    }
};
