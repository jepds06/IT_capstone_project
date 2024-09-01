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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('customer_ID');
            $table->unsignedBigInteger('account_ID');
            $table->string('cstr_first_name');
            $table->string('cstr_last_name');
            $table->string('contact_num');
            $table->string('cstr_address');
            $table->string('customer_type');
            $table->string('pref_contact_method');
            $table->string('cstr_status');
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
        Schema::table('customers', function (Blueprint $table) {
            // Drop the foreign key before dropping the table
            $table->dropForeign(['account_ID']);
        });

        Schema::dropIfExists('customers');
    }
};
