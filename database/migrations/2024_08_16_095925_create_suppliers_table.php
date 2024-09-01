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
            $table->bigIncrements('supplier_ID');
            $table->unsignedBigInteger('account_ID');
            $table->string('supplier_name');
            $table->string('supplier_address');
            $table->string('supplier_email');
            $table->string('supplier_contact_num');
            $table->string('supplier_type');
            $table->string('supplier_status');
            $table->timestamps();

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
        Schema::table('suppliers', function (Blueprint $table) {
            // Drop the foreign key before dropping the table
            $table->dropForeign(['account_ID']);
        });

        Schema::dropIfExists('suppliers');
    }
};
