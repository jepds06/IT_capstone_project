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
            $table->bigIncrements('customerID');
            $table->unsignedBigInteger('accountID');
            $table->string('cstrFirstName');
            $table->string('cstrLastName');
            $table->string('contactNum');
            $table->string('cstrAddress');
            $table->string('customerType');
            $table->string('prefContactMethod');
            $table->string('cstrStatus');
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
        Schema::table('customers', function (Blueprint $table) {
            // Drop the foreign key before dropping the table
            $table->dropForeign(['accountID']);
        });

        Schema::dropIfExists('customers');
    }
};
