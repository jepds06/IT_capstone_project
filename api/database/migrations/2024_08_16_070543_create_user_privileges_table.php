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
        Schema::create('userPrivileges', function (Blueprint $table) {
            $table->bigIncrements('privilegeID');
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('moduleID');
            $table->boolean('create');
            $table->boolean('update');
            $table->boolean('view');
            $table->boolean('cancel');

            $table->Foreign('userID')->references('userID')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->Foreign('moduleID')->references('moduleID')->on('modules')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('userPrivileges', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['userID']);
            $table->dropForeign(['moduleID']);
        });
        Schema::dropIfExists('userPrivileges');
    }
};
