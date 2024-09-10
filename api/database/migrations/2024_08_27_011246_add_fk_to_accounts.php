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
        Schema::table('accounts', function (Blueprint $table) {
            //foreign key constraint
            $table->foreign('acc_type_ID')->references('acc_type_ID')->on('account_types')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            // Drop the foreign key before dropping the table
            $table->dropForeign(['acc_type_ID']);
            $table->dropColumn('acc_type_ID');
        });
    }
};
