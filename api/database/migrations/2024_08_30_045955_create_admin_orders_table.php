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
        Schema::create('admin_orders', function (Blueprint $table) {
            $table->bigIncrements('admin_ord_ID');
            $table->unsignedBigInteger('admin_ID');
            $table->unsignedBigInteger('supp_matrl_ID');
            $table->integer('qty_ordered');
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('admin_ID')->references('admin_ID')->on('administrators')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('supp_matrl_ID')->references('supp_matrl_ID')->on('supplier_materials')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_orders', function(Blueprint $table){
            // Drop the foreign key before dropping the table
            $table->dropForeign(['admin_ID']);
            $table->dropForeign(['supp_matrl_ID']);
        });

        Schema::dropIfExists('admin_orders');
    }
};
